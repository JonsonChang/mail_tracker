<?php
include("./include.php"); 
//$tpl->assign('no', "hello");
$op=$_GET["op"];

$content = "";


if($op==1) //update
{
	$NewContent=$_POST["editor1"];
	$title=$_POST["title"];
	
	$sql ="UPDATE  `group` SET  `checkMail` =  '$NewContent',
		`checkTitle` =  '$title' WHERE  `group`.`id` =$gid LIMIT 1 ";

	$rs = &$conn->Execute($sql);

}
else //一般
{
	

}

$sql = "SELECT * FROM `group` where id = $gid";
$rs = &$conn->Execute($sql);
$checkmail = $rs->getArray();

$checkmail_title = $checkmail[0]["checkTitle"];
$content = $checkmail[0]["checkMail"];

$tpl->assign("content",$content);
$tpl->assign("title",$checkmail_title);
$tpl->display('checkmail.html');

?>