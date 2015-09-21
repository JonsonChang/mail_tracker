<?php
session_start();

//define('__SITE_ROOT','/var/www/vhosts/puperchang.myec.tw/httpdocs/greenphoenix/talk');
define('__SITE_URL','http://127.0.0.1/mailTrack/');
define('__SITE_ROOT','C:\AppServ\www\mailTrack');
include(__SITE_ROOT . "/include/public_functions.php");  
include(__SITE_ROOT . "/include/phpmailer/class.phpmailer.php");  

//=========smarty==================================================
//定義 Smarty 所在路徑！
include(__SITE_ROOT . "/include/smarty/Smarty.class.php");  

//宣告 Smarty 物件
 $tpl = new Smarty();


//以下六行分別定義「放置模版檔案的目錄」、「編譯出的結果放置目錄」、「設定檔放置目錄」、「快取檔案放置目錄」及「符號」(左、右)
 $tpl->template_dir = __SITE_ROOT . "/templates/";
 $tpl->compile_dir = __SITE_ROOT . "/templates_c/";
 $tpl->cache_dir = __SITE_ROOT . "/cache/";
 $tpl->left_delimiter = '<{';
 $tpl->right_delimiter = '}>';


//=======adodb==========================================
include(__SITE_ROOT . '/include/adodb/adodb.inc.php');
$DB_mch="localhost";
$DB_user="root";
$DB_pwd="pppp";
$DB_database="mailtrack";
$conn = &ADONewConnection('mysql');
//$conn->debug=true;
// 格式：$conn->Connect('主機', '使用者', '密碼', '資料庫');
$conn->PConnect($DB_mch, $DB_user, $DB_pwd, $DB_database);
$conn->EXECUTE("set names 'utf8'"); 
$conn->EXECUTE("SET GLOBAL time_zone = 'Asia/Taipei'"); 
$conn->EXECUTE("SET time_zone = 'Asia/Taipei'"); 

//=======其他==========================================
putenv("TZ=Asia/Taipei"); 

$gid = $_SESSION["groupID"]; 
$groupObj = get_group_content($conn, $gid);
$tpl->assign("curr_group_name",$groupObj["gname"]);