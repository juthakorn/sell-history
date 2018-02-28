<?php

function pr($arr){
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}
function message($type,$text){
    $_SESSION['message']['type']=$type;
    $_SESSION['message']['text']=$text;
}
function date_ddmmyyyy($date){    
    return date('d/m/Y', strtotime($date));
}
function dateddmmyy($date){
$part = explode("-", $date);
$redate = "$part[2]" . "/" . "$part[1]" . "/" . "$part[0]";
return $redate;
}

function dateyymmdd($date){
$part = explode("/", $date);
$redate = "$part[2]" . "-" . "$part[1]" . "-" . "$part[0]";
return $redate;
}

function DateTimeThai($strDate){ //$strDate เช่น 2014-10-07 17:30:31 (Datetime)
	$strYear = date("Y",strtotime($strDate))+543;
	$strMonth= date("n",strtotime($strDate));
	$strDay= date("j",strtotime($strDate));
	$strHour= date("H",strtotime($strDate));
	$strMinute= date("i",strtotime($strDate));
	$strSeconds= date("s",strtotime($strDate));
	$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$strMonthThai=$strMonthCut[$strMonth];
	return "$strDay $strMonthThai $strYear เวลา $strHour:$strMinute น.";
}
	
function strdateddmmyy($date){
$part = explode("/", $date);
if($part[1]=='1'){$m='มกราคม';}elseif($part[1]=='2'){$m='กุมภาพันธ์'; }elseif($part[1]=='3'){$m='มีนาคม'; }elseif($part[1]=='4'){$m='เมษายน'; }
                elseif($part[1]=='5'){$m='พฤษภาคม'; }elseif($part[1]=='6'){$m='มิถุนายน'; }elseif($part[1]=='7'){$m='กรกฏาคม'; }elseif($part[1]=='8'){$m='สิงหาคม'; }
                elseif($part[1]=='9'){$m='กันยายน'; }elseif($part[1]=='10'){$m='ตุลาคม'; }elseif($part[1]=='11'){$m='พฤศจิกายน'; }elseif($part[1]=='12'){$m='ธันวาคม'; }
  $redate = $part[0] . "  เดือน "  . $m . "  พ.ศ.  " . $part[2];
return $redate;
}
function strdateddmmyy1($date){
$part1 = explode("-", $date);
$dd = "$part1[2]" . "/" . "$part1[1]" . "/" . "$part1[0]";
$part = explode("/", $dd);
if($part[1]=='1'){$m='มกราคม';}elseif($part[1]=='2'){$m='กุมภาพันธ์'; }elseif($part[1]=='3'){$m='มีนาคม'; }elseif($part[1]=='4'){$m='เมษายน'; }
                elseif($part[1]=='5'){$m='พฤษภาคม'; }elseif($part[1]=='6'){$m='มิถุนายน'; }elseif($part[1]=='7'){$m='กรกฏาคม'; }elseif($part[1]=='8'){$m='สิงหาคม'; }
                elseif($part[1]=='9'){$m='กันยายน'; }elseif($part[1]=='10'){$m='ตุลาคม'; }elseif($part[1]=='11'){$m='พฤศจิกายน'; }elseif($part[1]=='12'){$m='ธันวาคม'; }
  $redate = $part[0] . "  เดือน "  . $m . "  พ.ศ.  " . $part[2];
return $redate;
}
//ลบวัน 
function DateDiff($strDate1,$strDate2){
	return (strtotime($strDate2) - strtotime($strDate1))/  ( 60 * 60 * 24 );  // 1 day = 60*60*24
}

function DThais($strDate){
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		//$strMonth= date("m",strtotime($strDate));
		$strDay= date("d",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		//$strMonthCut =Array('','มกราคม','กุมภาพันธุ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
		$strMonthThai=$strMonthCut[$strMonth];
		//return "$strDay $strMonthThai $strYear";
		return $strDay." ".$strMonthThai." ".$strYear;
	}

function DThai_long($strDate){
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		//$strHour= date("H",strtotime($strDate));
		//$strMinute= date("i",strtotime($strDate));
		//$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array('','มกราคม','กุมภาพันธุ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฏาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม');
		$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay $strMonthThai $strYear";
	}

function FullThdate(){
	$thaiweek=array("วัน อาทิตย์","วัน จันทร์","วัน อังคาร","วัน พุธ","วัน พฤหัสบดี","วัน ศุกร์","วัน เสาร์");
	$thaimonth=array("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","      มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	echo $thaiweek[date("w")] ," ที่",date(" j "), $thaimonth[date(" m ")-1] , " พ.ศ. ",date(" Y ")+543;
}

function add_date($givendate,$day=0,$mth=0,$yr=0) {
		$cd = strtotime($givendate);
		$newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),
		date('i',$cd), date('s',$cd), date('m',$cd)+$mth,
		date('d',$cd)+$day, date('Y',$cd)+$yr));
		return $newdate;
}
	 
//แทรกข้อมูลลง db
function insert($field,$value,$table){
$sql = "insert into $table ($field) values ($value)";
$result= mysql_query($sql);
return $result;
}
//ลบข้อมูล
function del($table,$condition){
$sql ="delete from $table $condition";
$result = mysql_query($sql);
return $result;
}
//แก้ไขข้อมูล
function update($table,$command,$condition){
$sql = "UPDATE $table SET $command $condition";
$result = mysql_query($sql);
return $result;
}
//เลือกข้อมูล
function select($table,$condition){
$sql = "select * from $table $condition";
$dbquery = mysql_query($sql);
$result= mysql_fetch_array($dbquery);
return $result;
}
//เลือกหลายแถว
function selects($table,$condition){
$sql = "select * from $table $condition";
$dbquery = mysql_query($sql);
$rows = array();
while (($result = mysql_fetch_array($dbquery)) !== FALSE)
    $rows[] = $result;
	return $rows;
}
//สุ่มเลือกข้อมูล
function selectrand($table,$condition){
	$sql = "select * from $table $condition";
	$dbquery = mysql_query($sql);
	$result= mysql_fetch_array($dbquery);
	return $result;
}
# select Auto_increment last id
function auto_inc($table){
	$r = mysql_query("SHOW TABLE STATUS LIKE '$table'");
	$row = mysql_fetch_array($r);
	$auto_increment = $row['Auto_increment'];
	mysql_free_result($r);
	return $auto_increment;
}
#หากจะใช้ function selects ให้ใช้ foreach เอาข้อมูลออกมา
function num_rows($table,$condition){
$sql = "select * from $table $condition";
$dbquery = mysql_query($sql);
$num_rows = mysql_num_rows($dbquery);
return $num_rows;
}
#Close DB Connetion
function closedb() {
	global $connect;
		return mysql_close($connect);
		return false;
}
#select sum data
function selectsum($feild,$table, $condition = ''){
    $result = mysql_query ("SELECT sum($feild) as total_price FROM $table $condition");
    if ($result && mysql_num_rows($result) > 0) {
      $query_data=mysql_fetch_array($result);
      return  (float) $query_data["total_price"];
    }
    return  '';
}
#Select Max value
function selectMax($feild,$table, $condition = ''){
	$result = mysql_query ("SELECT Max($feild) as val_max FROM $table $condition");
    if ($result && mysql_num_rows($result) > 0) {
      $query_data=mysql_fetch_array($result);
      return  (int) $query_data["val_max"];
    }
    return  '';
}

function thainumDigit($num){
    return str_replace(array( '0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9' ),array( "o" , "๑" , "๒" , "๓" , "๔" , "๕" , "๖" , "๗" , "๘" , "๙" ),$num);
}



function avg($arr) {
	$array_size = count($arr);
	$total = 0;
	for ($i = 0; $i < $array_size; $i++) {
		$total += $arr[$i];
	}
	$average = (float)($total / $array_size);
	return $average;
}

function chk_login(){
	if($_SESSION['logon'] != 1){
		echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
		echo("<script>alert('ผิดพลาด! คุณไม่ได้รับอนุญาติให้เข้าใช้งานระบบ'); window.location='./';</script>");
		exit();
		}
}

function random_password($len){
	srand((double)microtime()*10000000);
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$ret_str = "";
	$num = strlen($chars);
	for($i = 0; $i < $len; $i++)
	{
		$ret_str.= $chars[rand()%$num];
		$ret_str.=""; 
	}
	return $ret_str; 
}

function isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

function random_user1($len){
	srand((double)microtime()*10000000);
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_@|$&";
	$ret_str = "";
	$num = strlen($chars);
	for($i = 0; $i < $len; $i++)
	{
		$ret_str.= $chars[rand()%$num];
		$ret_str.=""; 
	}
	return $ret_str; 
}

function encode($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i++) {
        $ordStr = ord(substr($string,$i,1));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
    }
    return $hash;
}

function decode($string,$key) {
    $key = sha1($key);
    $strLen = strlen($string);
    $keyLen = strlen($key);
    for ($i = 0; $i < $strLen; $i+=2) {
        $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
        if ($j == $keyLen) { $j = 0; }
        $ordKey = ord(substr($key,$j,1));
        $j++;
        $hash .= chr($ordStr - $ordKey);
    }
    return $hash;
}

function time_ago($date,$granularity=2) {
    $date = strtotime($date);
    $difference = time() - $date;
    $periods = array('decade' => 315360000,
        'ปี' => 31536000,
        'เดือน' => 2628000,
        'สัปดาห์' => 604800, 
        'วัน' => 86400,
        'ชั่วโมง' => 3600,
        'นาที' => 60,
        'วินาที' => 1);
    if ($difference < 5) { // less than 5 seconds ago, let's say "just now"
        $retval = "ไม่กี่วินาทีที่แล้ว";
        return $retval;
    } else {                            
        foreach ($periods as $key => $value) {
            if ($difference >= $value) {
                $time = floor($difference/$value);
                $difference %= $value;
                $retval .= ($retval ? ' ' : '').$time.' ';
                //$retval .= (($time > 1) ? $key.'s' : $key);
                $retval .= (($time > 1) ? $key : $key);
                $granularity--;
            }
            if ($granularity == '0') { break; }
        }
        return $retval.' ที่ผ่านมา'; 
        //return ' posted '.$retval.' ago';      
    }
}

function Modal($mid,$type,$title,$text){
	if($type=='error'){
		$color="color:#cc0000;font-size:16px;";
	}
	if($type=='success'){
		$color="color:#009900;font-size:16px;";
	}
	echo "<div id='$mid' class='modal hide fade in'>
	<div class='modal-header'>
		<button type='button' class='close' data-dismiss='modal'>×</button>
		<h3 style='$color'>$title</h3>
	</div>
	<div class='modal-body'>
		<p>$text</p>
	</div>
	</div>";
}

function ModalN($mid,$type,$title,$text){
	if($type=='error'){
		$color="color:#cc0000;font-size:16px;";
	}
	if($type=='success'){
		$color="color:#009900;font-size:16px;";
	}
	echo "<div id='$mid' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' class='modal fade'>
	<div class='modal-dialog'>
         <div class='modal-content'>
            <div class='modal-header'>
               <button type='button' data-dismiss='modal' aria-hidden='true' class='close'>×</button>
               <h3 id='myModalLabel' class='modal-title'  style='$color'>$title</h3>
            </div>
            <div class='modal-body'><p>$text</p></div>            
         </div>
      </div>
   </div>";
}

function dayColor(){
	$day=date('N');
	if($day=='1'){
		$color="#ffff00";
	}else if($day=='2'){
		$color="#ffccff";
	}else if($day=='3'){
		$color="#009900";
	}else if($day=='4'){
		$color="#ff9900";
	}else if($day=='5'){
		$color="#0066ff";
	}else if($day=='6'){
		$color="#800080";
	}else if($day=='7'){
		$color="#cc0000";
	}
	return $color;
}

function sizeFilter($bytes){
    $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
    for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
    return( round( $bytes, 2 ) . " " . $label[$i] );
}

function guPagination($query, $per_page = 10,$page = 1, $url = '?'){        
    	$query = "SELECT COUNT(*) as num FROM {$query}";
    	$row = mysql_fetch_array(mysql_query($query));
    	$total = $row['num'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
			//$pagination .= "<div style='margin-top:2%; width:20%;'>หน้าที่ $page จากทั้งหมด $lastpage หน้า</div>";
    		$pagination .= "<ul class='pagination pull-right'>";
                    $pagination .= "<li class='details_p'>หน้าที่ $page จากทั้งหมด $lastpage หน้า</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}subpage=$counter'>$counter</a></li>";					
    			}
    		}else if($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}subpage=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}subpage=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}subpage=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}subpage=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}subpage=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}subpage=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}subpage=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}subpage=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}subpage=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}subpage=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}subpage=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}subpage=$next'>หน้าถัดไป</a></li>";
                $pagination.= "<li><a href='{$url}subpage=$lastpage'>หน้าสุดท้าย</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>หน้าถัดไป</a></li>";
                $pagination.= "<li><a class='current'>หน้าสุดท้าย</a></li>";
            }
    		$pagination.= "</ul>\n";		
    	}
    
    
        return $pagination;
    } 

	function convFormatDate($startdate){
        list($ddate, $mdate, $ydate ) = explode("-", $startdate);
        if (strlen($mdate)==1){
           $mdate = "0".$mdate;
        }
        if (strlen($ddate)==1){
            $ddate = "0".$ddate;
        }
        //$ydate = $ydate - 543;
        return $fdate = $ydate."-".$mdate."-".$ddate;
    }

	function convFormatDateSAP($startdate){
        list($ddate, $mdate, $ydate ) = explode(".", $startdate);
        if (strlen($mdate)==1){
           $mdate = "0".$mdate;
        }
        if (strlen($ddate)==1){
            $ddate = "0".$ddate;
        }
        if (strlen($ydate)==2){
            $ydate = "20".$ydate;
        }
        return $fdate = $ydate."-".$mdate."-".$ddate;
    }

	function DThai($startdate){
		list($ydate,$mdate,$ddate) = explode("-", $startdate);
        if (strlen($mdate)==1){
           $mdate = "0".$mdate;
        }
        if (strlen($ddate)==1){
            $ddate = "0".$ddate;
        }
        //$ydate = $ydate + 543;
        return $fdate = $ddate."-".$mdate."-".$ydate;
	}


	function convDateTimeThai($strDate){
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("m",strtotime($strDate));
		$strDay= date("d",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		//$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		//$strMonthThai=$strMonthCut[$strMonth];
		return "$strDay-$strMonth-$strYear $strHour:$strMinute";
	}

function check_browser(){
$useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'IE';
}	elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
        $browser_version=$matched[1];
        $browser = 'Chrome';
}	elseif (preg_match( '|Opera ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
    $browser_version=$matched[1];
    $browser = 'Opera';
} 	elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
        $browser_version=$matched[1];
        $browser = 'Firefox';
} 	elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
        $browser_version=$matched[1];
        $browser = 'Safari';
}
	else {
    $browser_version = 0;
    $browser= 'other';
    }
    return $browser;
}

function setDisabledInput($level,$val){
	if($val != $level){
		return " disabled='disabled'";
	}
}

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}


function random_user() {
    $selc = rand(1, 13);
    if ($selc % 3 == 0) {
        $userAgent = 'Opera/9.00 (Windows NT 5.1; U; en)';
    } elseif ($selc % 5 == 0) {
        $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6';
    } elseif ($selc % 7 == 0) {
        $userAgent = 'Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)';
    } elseif ($selc % 11 == 0) {
        $userAgent = 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/522.11 (KHTML, like Gecko) Safari/3.0.2';
    } elseif ($selc % 13 == 0) {
        $userAgent = 'Googlebot-Image/1.0 ( http://www.googlebot.com/bot.html)';
    } else {
        $userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';
    }
    return $userAgent;
    /*

      Google � Googlebot/2.1 ( http://www.googlebot.com/bot.html)
      Google Image � Googlebot-Image/1.0 ( http://www.googlebot.com/bot.html)
      MSN Live � msnbot-Products/1.0 (+http://search.msn.com/msnbot.htm)
      Yahoo � Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)
      ask

      Browser User Agents

      Firefox (WindowsXP) � Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6
      IE 7 � Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)
      IE 6 � Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)
      Safari � Mozilla/5.0 (Macintosh; U; Intel Mac OS X; en) AppleWebKit/522.11 (KHTML, like Gecko) Safari/3.0.2
      Opera � Opera/9.00 (Windows NT 5.1; U; en)

     */
}

function get_content($url) {
    $userAgent = random_user();

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    if (preg_match('/https:/i', $url)) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    }
    
    $contentUrl = curl_exec($ch);
    
    if (!$contentUrl) {
        echo "<br />cURL error number:" . curl_errno($ch);
        echo "<br />cURL error:" . curl_error($ch);
        $contentUrl = 'error';
    }

    return $contentUrl;
}


function send_line($txt,$user_id = 'Ue76f53cb455056a7e7962b9af013705e'){
    if(!empty($txt)){
        $access_token = 'ASS7oydEPY40Cqwe68km/eCCIZSMS8yLFcRS+K/hkxgMYzPYa5CFOswBG+vfkXOYAmXjPIdlTtlXgaaCw6qAJ6UBJvGWggb/vjoHPC8qJZY3VXrbuHzo3TZUGRzwC3fDqHJUv3ECCP48eggvKIxvbAdB04t89/1O/w1cDnyilFU=';
        // Make a POST Request to Messaging API to push to sender
        $url = 'https://api.line.me/v2/bot/message/push';
        $data = [
                'to' => $user_id, //กูเอง
                'messages' =>$txt,
        ];
        $post = json_encode($data);
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        echo $result . "\r\n";
    }
}


?>