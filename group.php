<?php
include("./include.php"); 

$op=$_GET["op"];

$message = "";

if($op==1) //get data
{
	$id = $_GET["id"];
	$sql = "SELECT * FROM `group` where id = $id";
	$rs = &$conn->Execute($sql);
	$group_list = $rs->getArray();
	echo json_encode($group_list[0]);
	exit;
}
else if($op==2) //update
{
	$gid=$_POST["gid"];
	$gname=$_POST["gname"];
	$SMTP_Host=$_POST["SMTP_Host"];
	$SMTP_user_account=$_POST["SMTP_user_account"];
	$SMTP_Password=$_POST["SMTP_Password"];
	$SMTP_username=$_POST["SMTP_username"];
	$SMTP_ReplyMail=$_POST["SMTP_ReplyMail"];
	$SMTP_ssl=$_POST["SMTP_ssl"];
	$desc_url=$_POST["desc_url"];
	$success_url=$_POST["success_url"];
	
	$sql ="UPDATE `group` SET `gname` = '$gname',
	`SMTP_Host` = '$SMTP_Host',
	`SMTP_user_account` = '$SMTP_user_account',
	`SMTP_Password` = '$SMTP_Password',
	`SMTP_username` = '$SMTP_username',
	`SMTP_ReplyMail` = '$SMTP_ReplyMail',
	`SMTP_ssl` = '$SMTP_ssl',
	`success_url` = '$success_url',
	`desc_url` = '$desc_url' 
	WHERE `group`.`id` =$gid LIMIT 1 ";
	
	$rs = &$conn->Execute($sql);
	exit;
}
else if($op==3) //use
{
	$gid=$_GET["gid"];
	echo $_SESSION["groupID"] = $gid;
	exit;
}
else if($op==4)
{
	$gname=$_POST["gname"];
	$SMTP_Host=$_POST["SMTP_Host"];
	$SMTP_user_account=$_POST["SMTP_user_account"];
	$SMTP_Password=$_POST["SMTP_Password"];
	$SMTP_username=$_POST["SMTP_username"];
	$SMTP_ReplyMail=$_POST["SMTP_ReplyMail"];
	$SMTP_ssl=$_POST["SMTP_ssl"];
	$desc_url=$_POST["desc_url"];
	$success_url=$_POST["success_url"];

	$sql = "INSERT INTO  `group` (
	`id` ,
	`gname` ,
	`SMTP_Host` ,
	`SMTP_user_account` ,
	`SMTP_Password` ,
	`SMTP_username` ,
	`SMTP_ReplyMail` ,
	`SMTP_ssl` ,
	`auth_mail` ,
	`checkMail` ,
	`checkTitle` ,
	`success_url` ,
	`desc_url`
	)
	VALUES (
	NULL ,  '$gname',  '$SMTP_Host',  '$SMTP_user_account',  '$SMTP_Password',  
	'$SMTP_username',  '$SMTP_ReplyMail',$SMTP_ssl, NULL , NULL , NULL ,  '$success_url',  '$desc_url'
	)";
	$rs = &$conn->Execute($sql);
	exit;
}
else if($op==5) //get data
{
	$id = $_GET["gid"];
	$sql = "DELETE FROM `group` where id = $id";
	$rs = &$conn->Execute($sql);
	exit;
}
else //一般
{
	

}

$sql = "SELECT * FROM `group` ";
$rs = &$conn->Execute($sql);
$group_list = $rs->getArray();

for($i=0;$i<count($group_list);$i++)
{
	$tmpgid = $group_list[$i]["id"];
	$sql = "SELECT count(*) as times  FROM `group` , `subscription_user` 
		WHERE `subscription_user`.gid = `group`.id and group.id = $tmpgid ";
	$rs = &$conn->Execute($sql);
	if($rs)
	{
		$rs = $rs->getArray();
		$group_list[$i]["usercount"] = $rs[0][0];
	}else
	{
		$group_list[$i]["usercount"] = 0;
	}
	
	$sql = "SELECT count(*) as times  FROM `group` , `blog_article` 
		WHERE `blog_article`.gid = `group`.id and group.id = $tmpgid ";
	$rs = &$conn->Execute($sql);
	if($rs)
	{
		$rs = $rs->getArray();
		$group_list[$i]["articlecount"] = $rs[0][0];
	}else
	{
		$group_list[$i]["articlecount"] = 0;
	}
}

$tpl->assign("group_list",$group_list);
$tpl->display('group.html');

?>