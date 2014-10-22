<?php
/**
 * Crypt - Encrypt and Decrypt.
 *
 * PHP version 5
 *
 * @copyright Copyright (C) UP!
 * @author    hijiri
 * @link      http://tkns.homelinux.net/
 * @license   http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @since     2010.07.25
 * @version   10.7.27
 */

/**
* Encrypt data
*
* @param  string $data
* @param  string $key
* @return string
*/
function dataEncrypt($data, $key)
{
	//データ　及びキーが無い場合は処理しない。
	if(strlen($data)<=0 || strlen($key)<=0) return null;
	
    // Open module
    $resource = mcrypt_module_open('rijndael-256', '',  'cbc', '');

    // Get key
    $keys = _getKey($resource, $key);

    // Create initial vector
    $initialVector = _createIVector($resource);

    // Encrypt data
    mcrypt_generic_init($resource, $keys, $initialVector);
    $data = mcrypt_generic($resource, $data);
    
    // Terminate decryption handle
    mcrypt_generic_deinit($resource);

    // Close module
    mcrypt_module_close($resource);

    return base64_encode($initialVector) . '@' . base64_encode($data);
}

/**
* Decrypt data
*
* @param  string $data
* @param  string $key
* @return string
*/
function dataDecrypt($data, $key)
{
	//データ　及びキーが無い場合は処理しない。
	if(strlen($data)<=0 || strlen($key)<=0) return null;
    // Open module
    $resource = mcrypt_module_open('rijndael-256', '',  'cbc', '');

    // Get key
    $keys = _getKey($resource, $key);

    // Get initial vector
    $initialVector = _getIVector($data);

    // Decrypt data
    $tmp = substr($data, strlen($initialVector)+1);
    mcrypt_generic_init($resource, $keys, base64_decode($initialVector));
	if(!$tmp){
		$data = "";		
	}else {
		$data = trim(mdecrypt_generic($resource, base64_decode($tmp)));
	}

    // Terminate decryption handle
    mcrypt_generic_deinit($resource);

    // Close module
    mcrypt_module_close($resource);

    return $data;
}

/**
* Get Key
*
* @param  string $resource
* @param  string $key
* @return key
*/
function _getKey($resource, $key)
{
    return substr(md5($key), 0, mcrypt_enc_get_key_size($resource));
}

/**
* Create initial vector
*
* @param  string $resource
* @return initial vector
*/
function _createIVector($resource)
{
    if (PHP_OS == 'WIN32' || PHP_OS == 'WINNT') {
        srand();
        return mcrypt_create_iv(mcrypt_enc_get_iv_size($resource), MCRYPT_RAND);
    } else {
        return mcrypt_create_iv(mcrypt_enc_get_iv_size($resource), MCRYPT_DEV_URANDOM);
    }
}

/**
* Get initial vector
*
* @param  string $data
* @return initial vector
*/
function _getIVector($data)
{
    return substr($data, 0, strpos($data, '@'));
}