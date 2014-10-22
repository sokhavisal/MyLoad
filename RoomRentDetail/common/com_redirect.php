<?php
/**
 * クライアントからのリクエスト内容をリダイレクト先へリダイレクトし、
 * リダイレクト先から取得した内容を返却する。
 * リダイレクト先の設定・変換ルールは、環境別設定ファイル(sys_const.php)で定義
 */
function UrlRedirect() {
	$url = URL_PREFIX.BACKEND_SERVER.mb_ereg_replace(URL_REDIRECT_PTN, URL_REDIRECT, $_SERVER[PHP_SELF]);

	if (isset($_COOKIE)) {
		$cookie = filter_input_array(INPUT_COOKIE);
		if (is_array($cookie)) {
			foreach ($cookie as $key => $val) {
				if ($key === 'XDEBUG_SESSION') { unset($cookie[$key]); break; }
			}
			if (count($cookie) === 0) {
				$cookie = '';
			} else {
				$cookie = http_build_query($cookie, "", ";");
			}
		}
	}
	
	switch ($_SERVER['REQUEST_METHOD']) {
		case 'GET':
			$request = filter_input_array(INPUT_GET);
			if (is_array($request)) { $request = http_build_query($request, "", "&"); }
			if ($request !== '') { $url .= '?'.$request; }
			$headers = array(
				'Accept-Language: ja-JP'
			);
			if ($cookie !== '') { $headers[] = 'Cookie: '.$cookie; }
			$opts = array(
				'http' => array(
					'method'		=> 'GET',
					'ignore_errors'	=> true,
					'header'		=> implode("\r\n", $headers)."\r\n"
				)
			);
			break;
 
		default: // POST
			$request = filter_input_array(INPUT_POST);
			if (is_array($request)) { $request = http_build_query($request, "", "&"); }
			$headers = array(
				'Accept-Language: ja-JP',
				'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
				'Content-Length: '.strlen($request)
			);
			if ($cookie !== '') { $headers[] = 'Cookie: '.$cookie; }
			$opts = array(
				'http' => array(
					'method'		=> 'POST',
					'ignore_errors'	=> true,
					'header'		=> implode("\r\n", $headers)."\r\n",
					'content'		=> $request
				)
			);
	}
	// ストリームコンテキストの作成
	$context = stream_context_create($opts);

	// 上で設定した HTTP ヘッダを使用してファイルをオープンします
	$file = file_get_contents($url, false, $context);
	echo $file;
}

/**
 * リクエスト元IPアドレス($_SERVER[REMOTE_ADDR])をgethostbyaddrし、
 * FRONTEND_SERVERS定数内にホスト名が含まれる場合はtrueを返す
 * 含まれない場合はdieする。
 * FRONTEND_SERVERS定数は、環境別設定ファイル(sys_const.php)で定義
 * @return boolean
 */
function CheckRequester() {
	$remotehost = gethostbyaddr($_SERVER[REMOTE_ADDR]);
	$allowservers = explode(',', FRONTEND_SERVERS);
	
	if (in_array($remotehost, $allowservers)) {
		return true;
	} else {
		die('Access denied');
	}
}