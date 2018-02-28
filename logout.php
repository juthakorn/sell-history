<?php
session_start();
session_destroy();	
//setcookie("username_log",$username,time()-3600*24*356);
header("location:index.php");
?> 
