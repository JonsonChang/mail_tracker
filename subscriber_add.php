<?php
include("./config.php"); 
$message = "";

$uname = $_POST["uname"];
$mail = $_POST["mail"];
$blog = $_POST["blog"];
$address = $_POST["address"];
$gid = $_GET["gid"];

if(checkmail($mail)== true)
{
	
		$md5string = md5($uname . $mail .$gid. "adbcde");
		if(isSameMail($mail)==true)
		{ //用update，已有mail 資訊
			$sql ="UPDATE `subscription_user` SET `name` = '$uname',
				`md5` = '$md5string',
				`blog` = '$blog',
				`address` = '$address',
				`user_disable` = '0' WHERE CONVERT( `subscription_user`.`Email` USING utf8 ) = '$mail' and `subscription_user`.gid = $gid LIMIT 1 ";
			$rs = &$conn->Execute($sql);
		}
		else
		{ // 用add
			$sql ="INSERT INTO `subscription_user` (`name` ,`Email` ,`blog`,`address`,`md5` ,`active` ,`user_disable`,`gid`)
				VALUES ('$uname', '$mail','$blog','$address', '$md5string', '0', '0',$gid)";
			$rs = &$conn->Execute($sql);
		}
	
}
else
{
		$message = "E-mail填寫錯誤";
}


if($message=="") //沒有任何error 發送認證mail
{
	$groupObj = get_group_content($conn,$gid);
	$to = $mail;
	$authenticateURL = __SITE_URL . "authenticate.php?key=" . $md5string;
	$authenticateURL = "<a href=\"$authenticateURL\">$authenticateURL</a>";
	
	$body = $groupObj["checkMail"];
	$body = str_replace('{$uname}',$uname,$body);
	$body = str_replace('{$umail}',$mail,$body);
	$body = str_replace('{$url}',$authenticateURL,$body);
	$body = preg_replace('/\\\\/','', $body); //Strip backslashes
	
	$mailobj = get_mailobj_from_gid($conn,$gid);
	$mailobj->AddAddress($to);
	$mailobj->AddBCC("puperchang@gmail.com");
	$mailobj->Subject  = $groupObj["checkTitle"];
	$mailobj->MsgHTML($body);
	$mailobj->AltBody = $body;
	$mailobj->Send();

}

$desc_url = $groupObj["desc_url"];
header( "Location: $desc_url" ) ;

//=============================================

function checkmail($mail)
{
	if (!preg_match("/.*@.*..*/", $mail) | preg_match("/(<|>)/", $mail))
	{
		return false;
	}
	else
	{
		return true;
	}
}

function isSameActiveMail($mail) // true 有一樣的，false 沒有一樣的
{
	global $conn;
	$sql = "SELECT * FROM `subscription_user` where Email = '$mail' and active=1 and gid = $gid" ;
	$rs = &$conn->Execute($sql);
	$mailcontent = $rs->getArray();
	
	if(count($mailcontent)>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function isSameMail($mail) // true 有一樣的，false 沒有一樣的
{
	global $conn;
	global $gid;
	$sql = "SELECT * FROM `subscription_user` where Email = '$mail' and gid = $gid";
	$rs = &$conn->Execute($sql);
	$mailcontent = $rs->getArray();
	
	if(count($mailcontent)>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>


