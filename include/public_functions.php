<?php

function get_group_content($conn, $gid)
{
	$sql = "SELECT * FROM `group` where id ='$gid'";
	$rs = &$conn->Execute($sql);
	$group = $rs->getArray();
	return $group[0];
}

function get_mailobj_from_gid($conn, $gid)
{	
	echo $sql = "SELECT * FROM `group` where id ='$gid'";
	$rs = &$conn->Execute($sql);
	if($rs)
	{
		$group = $rs->getArray();
		
		$SMTP_Host= $group[0]["SMTP_Host"];
		$SMTP_user_account= $group[0]["SMTP_user_account"];
		$SMTP_Password= $group[0]["SMTP_Password"];
		$SMTP_username= $group[0]["SMTP_username"];
		$SMTP_ReplyMail = $group[0]["SMTP_ReplyMail"];
		$SMTP_ssl = $group[0]["SMTP_ssl"];
	}
	else
	{
		echo " get_mailobj_from_gid error \r\n";
	}

	try {
			$mailobj = new PHPMailer(true); //New instance, with exceptions enabled
			$mailobj->CharSet = "UTF-8";
			$mailobj->IsSMTP();
			$mailobj->Host = $SMTP_Host; // SMTP servers
			$mailobj->SMTPAuth = true; // turn on SMTP authentication
			$mailobj->Username = $SMTP_user_account; // SMTP username
			$mailobj->Password = $SMTP_Password; // SMTP password
			$mailobj->IsHTML(true); // send as HTML
			$mailobj->WordWrap   = 80; // set word wrap
			$mailobj->AddReplyTo($SMTP_ReplyMail, $SMTP_username);
			$mailobj->SetFrom($SMTP_ReplyMail, $SMTP_username);
			if($SMTP_ssl>0){
				$mailobj->SMTPSecure = "ssl";
				$mailobj->Port = 465;
			}
		} catch (phpmailerException $e) 
		{
		  echo( $e->errorMessage());
		}
		return $mailobj;
}

function get_singlecontent($conn, $title)
{
	$content_result="";

	$sql = "SELECT * FROM `singlecontent` where title ='$title'";
	$rs = &$conn->Execute($sql);
	if($rs)
	{
		$content_result = $rs->getArray();
		$content_result=$content_result[0]["content"];
	}
	
	return $content_result;
}


function set_singlecontent($conn,$title,$content)
{
	$sql = "UPDATE `singlecontent` SET `content` = '$content' WHERE `title` = '$title' LIMIT 1 ";
	$rs = &$conn->Execute($sql);
}


class ImageResize
{
	private $src_image;
	private $src_width;
	private $src_height;
	private $dest_image;
	private $dest_width;
	private $dest_height;

	function __construct(){}
	public function readImage($imgpath)
	{
		
		$imgInfo  = getimagesize($imgpath);	

		switch ($imgInfo[2]) 
		{
		  case 1: $this->src_image = imagecreatefromgif($imgpath); break;
		  case 2: $this->src_image = imagecreatefromjpeg($imgpath);  break;
		  case 3: $this->src_image = imagecreatefrompng($imgpath); break;
		  default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
		}

		$this->src_width = $imgInfo [0];
		$this->src_height = $imgInfo [1];
	}
	public function thumbnailImage($size)  //設定寬度
	{
//		if($this->src_width > $this->src_height)
//		{
			$this->dest_width = $size;
			$this->dest_height = ($this->src_height/$this->src_width)*$size;
//		}else{
//			$this->dest_height = $size;
//			$this->dest_width = ($this->src_width/$this->src_height)*$size;
//		}

		$this->dest_image = imagecreatetruecolor($this->dest_width,$this->dest_height);
		imagecopyresampled($this->dest_image,$this->src_image,0,0,0,0,$this->dest_width,$this->dest_height,$this->src_width,$this->src_height);
	}
	public function writeImage($imgpath)
	{
		imagejpeg($this->dest_image,$imgpath,100);
	}
	public function destory()
	{
		imagedestroy($this->src_image);
		imagedestroy($this->dest_image);
	}
}


?>