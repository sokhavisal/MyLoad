<?php

/**
 * 現在の環境パス(DOCUMENT_ROOTを'/'とした絶対パス)を返す
 * 定数'ROOTFOLDER'は、各環境の定数ファイル(sys_const.php)で定義する
 * ROOTFOLDERが未定義の場合は、このファイル(com_func.php)の設置パスを返す
 * @return string 環境パス
 */
function GetCurrentEnvironment() {
//    $docRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');
    $docRoot = (isset($_SERVER['DOCUMENT_ROOT'])) ? $_SERVER['DOCUMENT_ROOT'] : realpath(__DIR__.'/../');
    if (!defined('ROOTFOLDER')) {
        $absolutePath = realpath(__DIR__);
    } else {
        $absolutePath = realpath(ROOTFOLDER);
    }
    if (substr(PHP_OS,0,3) === 'WIN') {
        $absolutePath = mb_ereg_replace('\\\\', '/', $absolutePath);
    }
    return(mb_ereg_replace('^'.$docRoot, '', $absolutePath));
}