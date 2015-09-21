<?php
include("./config.php"); 
$message = "";

$key = $_GET["key"];

$sql ="SELECT * FROM `subscription_user` where `md5` = '$key'";
$rs = &$conn->Execute($sql);
$content_result = $rs->getArray();

if(count($content_result)>0)
{
	$gid = $content_result[0]["gid"];
	$sql = "UPDATE `subscription_user` SET `active` = '1' ,`activedate`='" . date("Y.m.d H:i") . "' where `md5` = '$key'";
	$rs = &$conn->Execute($sql);
	$message = "認證完成";
}
else
{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>認證失敗</body></html>
<?php
	exit;
}

$groupObj = get_group_content($conn, $gid);
$url = $groupObj["success_url"];
header( "Location: $url" ) ;

?>



