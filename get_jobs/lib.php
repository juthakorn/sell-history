<?php

////CONNECTION
include('global.php');
error_reporting(E_ALL ^ E_DEPRECATED);
$bd = mysql_connect($server, $user, $psd) or die(mysql_error());
mysql_select_db($db, $bd) or die("erreur de connexion a la base de donnees");
mysql_query("SET NAMES utf8");

function set_conntect() {

    include('global.php');
    $bd = mysql_connect($server, $user, $psd) or die(mysql_error());
}

function insert($data,$table){
    $field = ""; 
    $value = "";
    foreach ($data as $key_data => $value_data) {
        $field .= $key_data.",";
        
        if($value_data == '' || $value_data == 'NULL' || $value_data == 'null'){
            $value .="NULL,";
        }else{
            $value .= "'".$value_data."',";
        }
    }
    
    $field = substr($field, 0,-1);
    $value = substr($value, 0,-1);
    $sql = "insert into $table ($field) values ($value)";    
    
    $result = mysql_query($sql) or die(mysql_error());
    return $result;
}

function update($table,$data,$condition){
    $command = "";
    foreach ($data as $key_data => $value_data) {
        
        if($value_data == '' || $value_data == 'NULL' || $value_data == 'null'){
            $command .= $key_data." = NULL,";  
        }else{
            $command .= $key_data." = '".$value_data."',";  
        }
        
    }
    $command = substr($command, 0,-1);
    $sql = "UPDATE $table SET $command $condition";
//    pr($sql);
    $result = mysql_query($sql);
    return $result;
}

function select($table,$condition){
    $sql = "select * from $table $condition";
    $dbquery = mysql_query($sql);
    $result= mysql_fetch_assoc($dbquery);
    return $result;
}

function selects($table,$condition,$field="*"){
    $sql = "select $field from $table $condition";
    $dbquery = mysql_query($sql);
    $rows = array();
    while (($result = mysql_fetch_assoc($dbquery)) !== FALSE)
        $rows[] = $result;
    return $rows;
}

function num_rows($table,$condition,$field="*"){
    $sql = "select $field from $table $condition";
    $dbquery = mysql_query($sql);
    $num_rows = mysql_num_rows($dbquery);
    return $num_rows;
}

function del($table,$condition){
    $sql ="delete from $table $condition";
    $result = mysql_query($sql);
    return $result;
}

function replace_multiple_space_to_single($str){ 
    $str = preg_replace("/[ ]{2,}|[\t]/", " ", $str);
    return trim($str);
}
function replace_multiple_space_to_single2($str){ 
    $output = preg_replace( "/\s+/", " ", $str );
    return $output;
}

function str_to_utf8($string) { 
    if (mb_detect_encoding($string, 'UTF-8', true) === false) { 
    $string = utf8_encode($string); 
    } 
    return $string; 
}


function set_format_date($date) {
    $date = split('/', $date);
    return trim($date[2]) . '-' . trim($date[1]) . '-' . trim($date[0]);
}


function get_number_5digic_from_string($data) {
    $number = '';
    if (preg_match('/([0-9]{5})/', $data, $match)) {
        $number = $match[1];
    }
    return $number;
}


function pr($array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function custom_unserialize($data){
    $data = preg_replace('!s:(\d+):"(.*?)";!e', "'s:'.strlen('$2').':\"$2\";'", $data);
    return unserialize($data);
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

function getWordBetweenThem($word, $start_tag, $end_tag) {
    $startpos = strpos($word, $start_tag) + strlen($start_tag);
    if ($startpos !== false) {
        $endpos = strpos($word, $end_tag, $startpos);
        if ($endpos !== false) {
            return substr($word, $startpos, $endpos - $startpos);
        }
    }
}

/**
 * substring start from tag input to end string
 * @return string
 */
function spite($word, $start_tag) {
    $startpos = strpos($word, $start_tag) + strlen($start_tag);
    return substr($word, $startpos - strlen($word));
}

/*
 * Back up table before get content new version.
 */


//======================= check robot ==================================
function checkRobot() {
    $data_robot = get_content('http://jobs-stages.letudiant.fr/robots.txt');
    $data_robot = '<pre>' . $data_robot . '</pre>';
//$data_robot=str_replace(' ','@',$data_robot);
//echo $data_robot;
    if (preg_match('/User-Agent:\s?(\*|stagebot)\s?(.+)\s?Disallow:\s?\/\s/i', $data_robot)) {
        echo "Robot Disallow:/ !! Stop Process";
        exit();
    }
}

/**
 * Get current micro time
 * @return float 
 */
function processtime() {
    $time = microtime();
    $time = explode(" ", $time);
    return $time[1] + $time[0];
}

function str_to_date($date_str){ //$date_str ex. November 25, 2015 => 25-11-2015
    if(!empty($date_str)){
         return date("Y-m-d", strtotime($date_str));
    }else{
        return "";
    }
}


function get_attribute_value($html,$tag,$attr){
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $tag_temp = $dom->getElementsByTagName($tag);                  
    $result = $tag_temp->item(0)->getAttribute($attr); 
    return $result;
}
?>