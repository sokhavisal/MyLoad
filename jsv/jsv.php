<?php
//Accessを制限するヘッダー　（デバッグ用にコメント）
header("Access-Control-Allow-Origin:realmax.org");
header("Content-Type: application/json; charset=utf-8");

//デバッグ用にブラウザ表示できるようヘッダ設定する。
//header("Content-Type: text/javascript; charset=utf-8");

define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_LOGIN', 'root');
define('DB_PASSWORD', '123456');
define('DB_CHARSET', 'utf8');


//POST情報を取得する。
$request = filter_input_array(INPUT_POST);
if($request == null) {
	exit;
} else {
	$getSQL = array_key_exists('sql', $request)?$request['sql']:null;
	if($getSQL == null) exit;
	
	$getDB = array_key_exists('db', $request)?$request['db']:null;
	if($getDB == null) exit;

	$getFlg = array_key_exists('md', $request)?$request['md']:null;
	if($getFlg == null) exit;
}

//DB接続パスワードで復元キー作成
$key = md5(DB_PASSWORD);

//暗号化モジュール使用開始
$td  = mcrypt_module_open('des', '', 'ecb', '');
$key = substr($key, 0, mcrypt_enc_get_key_size($td));
$iv  = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);

//暗号化モジュール初期化
if (mcrypt_generic_init($td, $key, $iv) < 0) {
  exit('error.');
}

//データを復号化
$sql = rtrim(mdecrypt_generic($td, base64_decode($getSQL)));
$db = rtrim(mdecrypt_generic($td, base64_decode($getDB)));
$Flg = rtrim(mdecrypt_generic($td, base64_decode($getFlg)));

//暗号化モジュール使用終了
mcrypt_generic_deinit($td);
mcrypt_module_close($td);

//PDO接続
$pdo = null;
try {
    $pdo = new PDO(
        DB_DRIVER . ":host=" . DB_HOST . "; dbname=" . $db,
        DB_LOGIN,
        DB_PASSWORD,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo error_json($e->getMessage());
    exit;
}

try {
	//取得したSQLを発行
	if($Flg == 0) {
		$row = setquery($pdo,$sql);
	} else {
		$row = setexecute($pdo,$sql);
	}
    echo ok_json($row);
} catch (PDOException $e) {
    echo error_json($e->getMessage().":".$e->getCode().":".$Flg.$sql);
}

$pdo = null;
exit;

function error_json($message = "") {
    $status = array("status" => "fail");
    $error = array("error" => $message);
    return json_encode(array_merge($status, $error));
}

function ok_json($json) {
    $status = array("status" => "ok");
    return json_encode(array($status, $json));
}
function setexecute($pdo,$getSQL) {

	$row=null;
	$pdo->beginTransaction();
	try {
		$stmt = $pdo->prepare($getSQL);
		if (!$stmt->execute()) {
			$addmessage = analyzePDOMessage($stmt->errorInfo());
			if ($addmessage !== '') {
				$ax = explode(',', $addmessage);
				switch($ax[0]) {
					case PDOERROR_KEYIDPRIMARY:
						$ax[0] = IDXJ_PRIMARY;
						break;
					default:
						$ax[0] = 'キー';
				}
				$addmessage = "\n\n(".$ax[0].$ax[1].')';
			}
			throw new Exception(EMSG_CANNOTUPDATERECORD.$addmessage);
		}
	} catch (Exception $ex) {
		$pdo->rollback();
		throw new Exception($ex->getMessage());
	}
	$pdo->commit();
    return $row;
}
function setquery($pdo,$getSQL) {

	$row=null;
	$stmt = $pdo->query($getSQL);

	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $row[] = $result;
    }
	
	$stmt->closeCursor();
	$stmt = NULL;	
    return $row;
}