<?php
$db_username = 'root';
$db_password = '123456';
$db_name = 'load';
$db_host = 'localhost';
$item_per_page = 8;

$con = mysqli_connect($db_host, $db_username, $db_password,$db_name)or die('could not connect to database');
?>