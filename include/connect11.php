<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "system_alert";
$dbname_hospital = "pppp";
$conn = mysql_connect($host,$user,$pass) or die ("ติดต่อ HOST ไม่ได้ครับ");
mysql_select_db($dbname,$conn) or die ("ติดต่อฐานข้อมูลไม่ได้ครับ");
mysql_query("SET NAMES utf8",$conn);
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");




?>