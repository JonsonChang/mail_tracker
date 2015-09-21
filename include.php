<?php
//定義 Smarty 所在路徑！
include("./config.php");  


if($_SESSION['admin']==NULL) //檢查是否有登入
{
		$url="index.php";
		echo("<script>");
		echo("alert('帳號或密碼錯誤！');");
		echo("location.replace('$url');");  
		echo("</script>");  
		exit();	
}
 
?>