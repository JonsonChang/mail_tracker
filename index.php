<?php
session_start();
session_destroy();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>後台模組-登入頁</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<link href="css/menu_bule.css" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="All">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="189px" align="left" valign="top">
    <div id="Left">
		<div id="Logo">
        	<div class="CompanyLogo"><img src="images/Logo.png" /></div>
            <div class="MS"><b>公司管理平台</b></div>
        </div>
        <div id="Name"><div class="bule">範例網站管理後台</div>
        </div><!--網站名稱12字為限-->
        <!--Menu Start-->
   
        <!--Menu End-->
        <div id="Bottom"></div>
     </div>   
    </td>
    <td align="left" valign="top">
    <div id="Main">

        <!-- 內容區 Start-->
        
        <div id="Login">
        	<div class="bg">
        	<form name="f1" action="checkdata.php" method="post">
            	<p><span>帳號：</span><input name="account" type="text"  datatype="string" title="帳號" not_null="1"/></p>
                <p><span>密碼：</span><input name="pwd" type="password" datatype="string" title="密碼" not_null="1" /></p>
           
                <div class="clear"></div>
              
               <a href="#" onclick="Javascript:f1.submit()" class="enter" title="確定送出"><b>Enter</b></a>

            </form>
            </div>
        
        </div>
        <!-- 內容區 End-->
    </div>  
    </td>
  </tr>
</table>
</div>


</body>
</html>
