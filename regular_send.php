<?php
include("./config.php"); 
//找出需要送的文章和使用者
echo "<pre>";

$sql = "SELECT * FROM  `group`";
$rs = &$conn->Execute($sql);
$group_list = $rs->getArray();
for($i=0;$i<count($group_list);$i++)
{
	parse_group($group_list[$i]["id"]);
}

echo "</pre>";

function parse_group($gid)
{
	global $conn;
	global $mailobj;
	
	$sql = "SELECT id,active,sendday FROM `blog_article` where `active`=1 and `gid`=$gid";
	$rs = &$conn->Execute($sql);
	$article_list = $rs->getArray();
	//print_r($article_list);

	$sql = "SELECT * FROM `subscription_user` where `active`=1 and `user_disable`=0 and `gid`=$gid" ;
	$rs = &$conn->Execute($sql);
	$user_list = $rs->getArray();
	//print_r($user_list);

	$current = time();

	for($i=0;$i<count($article_list);$i++)
	{
		$afterday=$article_list[$i]["sendday"];
		for($j=0;$j<count($user_list);$j++)
		{
			$activetime = $user_list[$j]["activedate"];
			$activetime = strtotime($activetime); //轉成unix 時間
			//echo strtotime($activetime); echo "<br>";
			//echo ($current - $activetime) ;
			//echo ("<br>");
			//echo ($afterday *24*60*60);
			//echo ("<br>");
			
			
			if(($current - $activetime >= $afterday *24*60*60) && (alreaySent($user_list[$j]["Email"], $article_list[$i]["id"])==false))
			{
				sendmail($user_list[$j]["Email"] , $article_list[$i]["id"] , $user_list[$j]["name"],$user_list[$j]["md5"],$gid);
				break;
			}
		}
	}

}
function alreaySent($umail, $aid) // true 已送過，false 未送
{
	global $conn;
	$sql = "SELECT * FROM `alread_sent` where `aid`=$aid and `email`='$umail'";
	$rs = &$conn->Execute($sql);
	$already = $rs->getArray();
	
	if(count($already)>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function sendmail($umail, $aid,$uname,$md5string,$gid)
{
	//todo: 從group table 中讀出smtp的資訊
	
	global $conn;
	
	$sql = "SELECT * FROM `blog_article` where `id`=$aid";
	$rs = &$conn->Execute($sql);
	$rsdata = $rs->getArray();
	$article = $rsdata[0]["content"];
	$title = $rsdata[0]["title"];
	
	$to = $umail;
	$authenticateURL = __SITE_URL . "unregister.php?key=" . $md5string;
	$authenticateURL = "<a href=\"$authenticateURL\">$authenticateURL</a>";
	
	$title = str_replace('{$uname}',$uname,$title);
	$body =$article;
	$body = str_replace('{$uname}',$uname,$body);
	$body = str_replace('{$umail}',$umail,$body);
	$body = str_replace('{$url}',$authenticateURL,$body);
	$body = preg_replace('/\\\\/','', $body); //Strip backslashes
	
	$mailobj = get_mailobj_from_gid($conn,$gid);
	$mailobj->AddAddress($to);
	$mailobj->Subject  = $title;
	$mailobj->MsgHTML($body);
	$mailobj->AltBody = $body;
	$mailobj->Send();
	
	$sql ="INSERT INTO `alread_sent` (`aid` ,`email` , `gid`,`open`)VALUES ('$aid', '$umail',$gid ,'')";
	$rs = &$conn->Execute($sql);
	
	echo("send $umail, $aid,$gid <br><br>");
}



?>


