<?php
include("./include.php"); 

$mail=$_GET["mail"];

$sql = "SELECT *
FROM `blog_article`, `alread_sent` 
where `alread_sent`.email ='$mail' and `blog_article`.id = `alread_sent`.aid and `alread_sent`.gid = $gid
ORDER BY `blog_article`.`sendday` DESC";


	$rs = &$conn->Execute($sql); 
	$list = $rs->getArray();

	for($i=0;$i<count($list);$i++)
	{
		echo ($list[$i]["title"]);
		echo "<br />";
	}


	if(count($list)==0)
	{
		echo ("無資料");
	}




?>