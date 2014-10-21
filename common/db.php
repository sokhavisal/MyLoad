<?php
/*fldr*/
/*
$dsn = array(
	'url'  => 'localhost',
	'user' => 'rmdemo_dbsdemo',
	'pass' => '8WK4C5i7pG6XkmQ2',
	'db'   => 'rmdemo_dbs'
);
*/
$dsn = array(
	'url'  => DB_HOST,
	'user' => DB_USER,
	'pass' => DB_PASS,
	'db'   => DB_NAME
);



//SQLインジェクション対策
function S($target) {
	return mysql_real_escape_string($target);
}
/*
---------------------------------------------
#Mysqlトランザクションの開始
t_begin();
---------------------------------------------
*/
function t_begin($link){
	//自動コミットをoffにする
	mysqli_query($link,"set autocommit=0");
	mysqli_query($link,"begin");
}
/*
---------------------------------------------
#Mysqlトランザクションエラー時のロールバック
t_rollBack();
---------------------------------------------
*/	
function t_rollBack($link){
	mysqli_query($link,"rollback");
}
/*
---------------------------------------------
#Mysqlトランザクションのコミット
t_commit();
---------------------------------------------
*/	
function t_commit($link){			
	mysqli_query($link,"commit");
}

//DBから取得した文字列をJson文字列に変換する。
function convertJsonEncode($result)
{
	//配列に詰め替える
	$rowarray = array();
	
	while($r = mysql_fetch_assoc($result)) {
		$rowarray[] = $r;
	}
	
	$rtnString = json_encode($rowarray);
}

//DBクラス
class MyDB extends PDO {

	public function __construct()
	{

/*fldr*/
/*
            $dsn = array(
				'url'  => 'mysql11.sixcore.ne.jp',
				'user' => 'realmaxsys_php',
				'pass' => 'realmax562392',
				'db'   => 'realmaxsys_area01'
		);
  */
              $dsn = array(
				'url'  => DB_HOST,
				'user' => DB_USER,
				'pass' => DB_PASS,
				'db'   => DB_NAME
		);
          
		try {
			parent::__construct('mysql:dbname='.$dsn['db'].';host=localhost', $dsn['user'], $dsn['pass']);
			parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->query('SET NAMES utf8');
		} catch (PDOException $e){
			var_dump($e->getMessage());
			die;
		}
	}
	public function getRows($sql, $vals = array())
	{
		return $this->_execute($sql, $vals)->fetchAll(PDO::FETCH_ASSOC);
	}
	public function getRow($sql, $vals = array())
	{
		return $this->_execute($sql, $vals)->fetch(PDO::FETCH_ASSOC);
	}
	public function getOne($sql, $vals = array())
	{
		return $this->_execute($sql, $vals)->fetchColumn();
	}
	public function getCols($sql, $vals = array())
	{
		return $this->_execute($sql, $vals)->fetchAll(PDO::FETCH_COLUMN, 0);
	}
	public function getPairs($sql, $vals = array())
	{
		return $this->_execute($sql, $vals)->fetchAll(PDO::FETCH_KEY_PAIR);
	}
	public function save($sql, $vals = array())
	{
		$this->_execute($sql, $vals);
	}
	public function truncate($table)
	{
		$this->query("TRUNCATE TABLE {$table}");
	}
	private function _execute($sql, $vals)
	{
		$vals = (array)$vals;
		if ($vals) {
			$stmt = $this->prepare($sql);
			$stmt->execute($vals);
		} else {
			$stmt = $this->query($sql);
		}
		return $stmt;
	}
}

?>