<?php
include("./include.php"); 

$op=$_GET["op"];

$content = "";


if($op==1) //add new
{
	$tpl->assign("catid",$catid);
	$tpl->display('blog_add.html');
}
else if($op==2) // do add new
{
	$subject =$_POST["subject"];
	$content =$_POST["editor1"];
	$sendday =$_POST["sendday"];
	$active =$_POST["active"]; if($active==""){$active=0;}
	
	$sql ="INSERT INTO `blog_article` (`id` ,`title` ,`content` ,`sendday`,`active`,`gid`)
				VALUES (NULL , '$subject', '$content', '$sendday',$active, $gid)";
	$rs = &$conn->Execute($sql);
	display_main($conn,$tpl,$catid);
}
else if($op==3)  //del
{
	$id=$_GET["id"];
	$sql = "DELETE FROM `blog_article` WHERE `blog_article`.`id` = $id ";
	$rs = &$conn->Execute($sql);
	
	$sql = "DELETE FROM `comments` WHERE `comments`.`aid` = $id";
	$rs = &$conn->Execute($sql);
	
	display_main($conn,$tpl,$catid);
}
else if($op==4)  //edit
{
	$id=$_GET["id"];
	
	$sql = "select * FROM `blog_article` WHERE `blog_article`.`id` = $id ";
	$rs = &$conn->Execute($sql);
	$article = $rs->getArray();
	
	//print_r($article);
	
	
	$tpl->assign("catid",$catid);
	$tpl->assign("id",$id);
	$tpl->assign("article",$article[0]);
	$tpl->display('blog_edit.html');
}
else if($op==5)  //do edit
{
	$id=$_GET["id"];
	$subject =$_POST["subject"];
	$content =$_POST["editor1"];
	$sendday =$_POST["sendday"];
	$active =$_POST["active"]; if($active!=1){ $active =0;}
	$sql = "UPDATE `blog_article` SET `active` =$active, `sendday`='$sendday' , `title` = '$subject', `content` = '$content' WHERE `blog_article`.`id` =$id";
	$rs = &$conn->Execute($sql);
	display_main($conn,$tpl,$catid);
}

else //一般
{
	display_main($conn,$tpl,$catid);
}


/*======以下為function============*/
function display_main($conn,$tpl,$catid)
{
	global $gid;
	$category_list="";
	$sql = "SELECT * FROM `blog_article` where gid=$gid ORDER BY `blog_article`.`sendday` ASC";
	$rs = &$conn->Execute($sql);
	if($rs)
	{
		$category_list = $rs->getArray();
	}

	//print_r($category_list);

	$tpl->assign("category_list",$category_list);
	$tpl->display('blog_list.html');
}




?>