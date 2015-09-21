<?php
include("./config.php"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
</body>
<?php


	$title = $_POST["title"];
	$article = $_POST["editor1"];


	$sql = "SELECT * FROM `subscription_user` where active =1 and user_disable =0 and`gid`=$gid";
	$rs = &$conn->Execute($sql);
	$rsdata = $rs->getArray();
	
	for($i=0;$i<count($rsdata);$i++)
	{
		$to    = $rsdata[$i]["Email"];
		$uname = $rsdata[$i]["name"];
		$umail = $rsdata[$i]["Email"];
		$md5string = $rsdata[$i]["md5"];
		
		
		$title = str_replace('{$uname}',$uname,$title);
		$body =$article;
		$body = str_replace('{$uname}',$uname,$body);
		$body = str_replace('{$umail}',$umail,$body);
		$body = str_replace('{$url}',$authenticateURL,$body);
		$body = preg_replace('/\\\\/','', $body); //Strip backslashes
		
		$authenticateURL = __SITE_URL . "unregister.php?key=" . $md5string;
		$authenticateURL = "<a href=\"$authenticateURL\">$authenticateURL</a>";
		
		$mailobj = get_mailobj_from_gid($conn,$gid);
		$mailobj->AddAddress($to);
		$mailobj->Subject  = $title;
		$mailobj->MsgHTML($body);
		$mailobj->AltBody = $body;
		if($mailobj->Send())
		{
			echo "$uname \t $umail \t 發送成功 <br />" ;
		}
		else
		{
			echo "$uname \t $umail \t NG 失敗 <br />" ;
		}
		
	}
?>

</body>
</html>

