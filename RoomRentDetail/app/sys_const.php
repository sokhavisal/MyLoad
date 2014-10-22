<?php
/**
 * サーバー設置用定数ファイル
 * サーバーへこのファイルをアップし、sys_const.phpへリネーム 
 */

/**
 * ルートフォルダのフルパス
 */
if (!defined('ROOTFOLDER')) {
    define('ROOTFOLDER', __DIR__.'/../');
}

/**
 * DB設定
 */
    const DB_HOST = 'localhost';//'realmax.cny8kwjescun.ap-northeast-1.rds.amazonaws.com';
    const DB_USER = 'root';//'realmaxsystem';
    const DB_PASS = '123456';//'jW4DS8HJ';
    const DB_NAME = 'load';//'realmax_db';

    const JSV_HOST = 'http://localhost/wu2ui1.4/';
    const JSV_KEY = '123456';
    const JSV_DB = 'load';



//    const DB_HOST = 'mysql11.sixcore.ne.jp';
//    const DB_USER = 'realmaxsys_sys';
//    const DB_PASS = 'LJlL6duZ28OWkQiHgBtpfCFhtYUnYh6o';
//    const DB_NAME = 'realmaxsys_area01'; 
//    const JSV_HOST = 'https://realmaxsys-sixcore-jp.ssl-sixcore.jp/';
//    const JSV_KEY = 'h9MxVz64pw6p';
//    const JSV_DB = 'realmaxsys_area01';

/**
 * 組織設定
 */
    const ORGANIZATION_NAME     = '価格comエディタ';
    const ORGANIZATION_ENGLISH  = 'KaKaKu Com';
    const LOGO_IMG_PATH         = 'http://img1.kakaku.k-img.com/images/home/logo_home.gif';
    