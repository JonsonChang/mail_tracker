<?php
include("./include.php"); 

header('Content-Type: text/html; charset=utf-8'); 


?>


<form id="form1" name="form1" method="post" action="<? echo __SITE_URL ?>subscriber_add.php?gid=<? echo $gid ?>" target="_blank" >
  
  <p align="center">姓名：
    <input name="uname" type="text" id="uname" />
  </p>
  
  <p align="center" class="style1">
    Mail：
    <input type="text" name="mail" id="mail" />
  </p>
    
  <p align="center">
     <input type="submit" name="button" id="button" value="送出" />
    </p>
</form>
