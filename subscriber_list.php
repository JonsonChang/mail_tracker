<?php
include("./include.php"); 

$op=$_GET["op"];

$content = "";


if($op==1) //add new
{
	$tpl->assign("catid",$catid);
	$tpl->display('subscriber_add.html');
}
else if($op==2) // do add new
{
	$name =$_POST["name"];
	$email =$_POST["email"];
	$active =$_POST["active"];  if(empty($active)){$active = 0;}
	$user_disable =$_POST["user_disable"]; if(empty($user_disable)){$user_disable = 0;}
	$md5str = md5( $name . $email . "abc");
	
	$sql ="INSERT INTO `subscription_user` (`name` ,`Email` ,`md5` ,`active` ,`activedate` ,`user_disable`, `gid`)
		VALUES ('$name', '$email', '$md5str', '$active', NOW() , '$user_disable',$gid)";
		
	$rs = &$conn->Execute($sql);
	display_main($conn,$tpl,$catid);
}
else if($op==3)  //del
{
	$id=$_GET["id"];
	$sql = "DELETE FROM `subscription_user` WHERE CONVERT(`subscription_user`.`Email` USING utf8) = '$id' and gid=$gid";
	$rs = &$conn->Execute($sql);
	
	$sql = "DELETE FROM `alread_sent` WHERE CONVERT(`alread_sent`.`email` USING utf8) = '$id' and gid=$gid";
	$rs = &$conn->Execute($sql);
	
	display_main($conn,$tpl,$catid);
}
else if($op==4)  //edit
{
	$id=$_GET["id"];
	
	$sql = "SELECT * FROM `subscription_user` where `Email` ='$id' and gid=$gid ";
	$rs = &$conn->Execute($sql);
	$subscriber = $rs->getArray();
	
	//print_r($subscriber);
	
	$tpl->assign("subscriber",$subscriber[0]);
	$tpl->display('subscriber_edit.html');
}
else if($op==5)  //do edit
{
	$id=$_POST["id"];
	$email=$_POST["email"];
	$name =$_POST["name"];
	$blog =$_POST["blog"];
	$address =$_POST["address"];
	$activedate =$_POST["activedate"];
	$active =$_POST["active"];  if(empty($active)){$active = 0;}
	$user_disable =$_POST["user_disable"]; if(empty($user_disable)){$user_disable = 0;}
	$md5str = md5( $name . $email . "abc");
	
	
	$sql = "UPDATE `subscription_user` SET `name` = '$name',`activedate` ='$activedate',
		`Email` = '$email',
		`blog` = '$blog',
		`address` = '$address',
		`md5` = '$md5str',
		`active` = '$active',
		`user_disable` = '$user_disable' WHERE CONVERT( `subscription_user`.`Email` USING utf8 ) = '$id' and gid=$gid LIMIT 1 ";
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
	$subscriber_list="";
	$sql = "SELECT * FROM `subscription_user` where gid=$gid ORDER BY `subscription_user`.`activedate` DESC";
	$rs = &$conn->Execute($sql);
	if($rs)
	{
		$subscriber_list = $rs->getArray();
	}

	//print_r($subscriber_list);

	$tpl->assign("subscriber_list",$subscriber_list);
	$tpl->display('subscriber_list.html');
}




?>