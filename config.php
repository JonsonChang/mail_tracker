<?php
session_start();

//define('__SITE_ROOT','/var/www/vhosts/puperchang.myec.tw/httpdocs/greenphoenix/talk');
define('__SITE_URL','http://127.0.0.1/mailTrack/');
define('__SITE_ROOT','C:\AppServ\www\mailTrack');
include(__SITE_ROOT . "/include/public_functions.php");  
include(__SITE_ROOT . "/include/phpmailer/class.phpmailer.php");  

//=========smarty==================================================
//�w�q Smarty �Ҧb���|�I
include(__SITE_ROOT . "/include/smarty/Smarty.class.php");  

//�ŧi Smarty ����
 $tpl = new Smarty();


//�H�U������O�w�q�u��m�Ҫ��ɮת��ؿ��v�B�u�sĶ�X�����G��m�ؿ��v�B�u�]�w�ɩ�m�ؿ��v�B�u�֨��ɮש�m�ؿ��v�Ρu�Ÿ��v(���B�k)
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
// �榡�G$conn->Connect('�D��', '�ϥΪ�', '�K�X', '��Ʈw');
$conn->PConnect($DB_mch, $DB_user, $DB_pwd, $DB_database);
$conn->EXECUTE("set names 'utf8'"); 
$conn->EXECUTE("SET GLOBAL time_zone = 'Asia/Taipei'"); 
$conn->EXECUTE("SET time_zone = 'Asia/Taipei'"); 

//=======��L==========================================
putenv("TZ=Asia/Taipei"); 

$gid = $_SESSION["groupID"]; 
$groupObj = get_group_content($conn, $gid);
$tpl->assign("curr_group_name",$groupObj["gname"]);