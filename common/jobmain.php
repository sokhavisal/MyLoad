<?php
	
	//各フォルダのバッチ処理用ファイルを検索し、起動する。
	//ここから呼び出されるPHPは、別プロセスで並列起動されるが
	//同名PHPファイルに関しては、プロセスとして起動済みの場合無視される。

	//CRON対象ファイル
	const CRON_FILEPATH = '/dbs/job/jobsub.php';
	$CRONF = array('/dbs/job/jobsub.php','/mail/job_importOrder.php');
	
	//ディレクトリ・ハンドルをオープン
	$res_dir = opendir( __DIR__ .'/../' );
			
	while( $file_name = readdir( $res_dir ) ){
		for($i =0;count($CRONF) > $i;$i++){
			//ファイルが存在する場合
			if(file_exists(__DIR__ .'/../'.$file_name.$CRONF[$i])){
				//プロセスを確認する。
				$cmd    = "/bin/ps -e -o pid,args";
				$fp             = popen($cmd, "r");
				$ExecFlg = false;
				while( ($line = fgets($fp)) != false ){
					if( strpos($line, $file_name.$CRONF[$i]) === FALSE ) continue;
					$ExecFlg = true;
				}
				fclose($fp);
				//10秒遅延する。
				sleep(10);

				//プロセスに起動を確認できない場合
				if(!$ExecFlg) {
					//Execでバックグラウンド起動
					exec('/usr/bin/php5.5 -f '.__DIR__ .'/../'.$file_name.$CRONF[$i].' 0 > /dev/null &');
				} else {
					//Execでバックグラウンド起動
					exec('/usr/bin/php5.5 -f '.__DIR__ .'/../'.$file_name.$CRONF[$i].' 1 > /dev/null &');				
				}
			}
		}
	}
	//ディレクトリ・ハンドルをクローズ
	closedir( $res_dir );

	// メールマガジン配信
	exec('/usr/bin/php5.5 -f /home/rmdemo/realmax.org/public_html/dbs/admin/dbsmSendMailMagazine.php > /dev/null &');
?>