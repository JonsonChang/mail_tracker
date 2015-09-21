<?php 
	include("./config.php");  //include 上一層的，admin的include 檔，會先檢查是否有先登入。
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>帳號管理列表</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="css/menu_bule.css" rel="stylesheet" type="text/css" />
</head>
<?php
session_start();

$account=$_POST['account'];
$password=$_POST['pwd'];


$sql="SELECT * FROM `users` where `uname`='$account' and `passwd`='$password'";

	$rs = &$conn->Execute($sql);
	if($rs->_numOfRows > 0) //有資料
	{
		$_SESSION['admin']=$account;
		$url="group.php";
		echo("<script>");
		echo("location.replace('$url');");  
		echo("</script>");
	}
	else
	{
		$url="index.php";
		echo("<script>");
		echo("alert('帳號或密碼錯誤！');");
		echo("location.replace('$url');");  
		echo("</script>");  
		exit();	
	}







?>