<?php
include("./include.php"); 

$op=$_GET["op"];

$message = "";


if($op==1) //update
{
	$passwd=$_POST["passwd"];
	$passwd2=$_POST["passwd2"];
	
	if($passwd == $passwd2)
	{
		if(strlen($passwd) >= 4)
		{
			$username = $_SESSION['admin'];
			$sql = "UPDATE `users` SET `passwd` = '$passwd' WHERE `uname`= '$username' LIMIT 1 ";
			$rs = &$conn->Execute($sql);
			$message="密碼已更新！";
		}
		else
		{
			$message = "請輸入4個字元以上";
		}
	}
	else
	{
		$message = "請輸入相同的密碼";
	}
	

}
else //一般
{
	

}

//$newsList = getContent($conn);

$tpl->assign("message",$message);
$tpl->display('changpasswd.html');


/*======以下為function============*/
function getContent($conn)
{
	$content_result="";
	$sql = "SELECT * FROM `news`";
	$rs = &$conn->Execute($sql);
	if($rs)
	{
		$content_result = $rs->getArray();
//		print_r($content_result);

	}
	
	return $content_result;
}

?>