<?php
include("./config.php"); 
$message = "";

$key = $_GET["key"];

$sql = "UPDATE `subscription_user` SET `user_disable` = '1' where `md5` = '$key'";
$rs = &$conn->Execute($sql);

$message = "取消訂閱完成";

$url = get_singlecontent($conn, "confirmOK_URL");

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="zh-TW">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<script type="text/javascript">
</script>
</head>
<body>
<br />
<p><?php echo($message)?></p>


</body>
</html>


