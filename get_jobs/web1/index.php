<?php
//header('Content-type: text/html; charset=iso-8859-1');
//header('Content-type: text/html; charset=utf-8');
include('../simple_html_dom.php');
include('../../include/connect.php');

set_time_limit(0);
?>
<!DOCTYPE html>
<html>
    <head>
    <!--<meta charset="UTF-8">-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Title of the document</title>
    </head>

    <body>
<?php
get_jobs1();
get_jobs2();
alert_line();
function get_jobs1() {
    global $database;
    $result = array();
    $mainurl = "http://www.xn--12clj3d7bc4c0cbcc.net/";
    //ภาคกลาง
    $url = "http://www.xn--12clj3d7bc4c0cbcc.net/%E0%B8%87%E0%B8%B2%E0%B8%99%E0%B8%A3%E0%B8%B2%E0%B8%8A%E0%B8%81%E0%B8%B2%E0%B8%A3-%E0%B8%A0%E0%B8%B2%E0%B8%84%E0%B8%81%E0%B8%A5%E0%B8%B2%E0%B8%87-4";
    $getContent = get_content($url);

    $fetchHtml = str_get_html($getContent);

    $i = 0;
    $arr_url = array();
    foreach ($fetchHtml->find('ul[class="nav navbar-nav"]') as $div_role_main) { //pr($div_role_main->plaintext);
        foreach ($div_role_main->find('li[class="dropdown"]') as $key_li => $li) {  
            if($key_li == 3){
                foreach ($li->find('li') as $key_li_sub => $li_sub) {       
                    foreach ($li_sub->find("a") as $key_a => $value_a) {
                        if($key_li_sub != 0){
                            $arr_url[$i]['city'] = trim($value_a->plaintext);
                            $arr_url[$i]['url'] = $mainurl.trim($value_a->href);
                            $i++;
                        }
                    }
                } 
                
            }
            
        }
    }
    
 
    
    pr('=========== all Url City ============ Start ');
    pr($arr_url);
    pr('=========== all Url City ============ End ');
//    exit;
    $k = 0;  
    foreach ($arr_url as $key => $value) {
        $getContent = get_content($value['url']);
        $fetchHtml = str_get_html($getContent);
        foreach ($fetchHtml->find('ul[class="table-view"]') as $div_role_main) {
            foreach ($div_role_main->find('li[class="table-view-cell"]') as $key_element => $element) {
                foreach ($element->find('a') as $key_a => $val_a) {
                    
                    foreach ($val_a->find('p[class="subDetail"]') as $key_sub => $var_sub) {
                        $result[$k]['city'] = $value['city'];
                        $result[$k]['url'] = $mainurl.trim($val_a->href);
                        $result[$k]['title'] = trim($var_sub->plaintext);
                        $k++;
                    }
                }
            }
        }
    }
    
   
//    pr($result);
    
    if(!empty($result)){
        foreach($result as $value){
            $row = $database->select("web1","where url='".$value['url']."'");
            if (empty($row)) {
                //insert
                $insert_data = array(
                    'city' => $value['city'],
                    'url' => addslashes($value['url']),
                    'title' => addslashes($value['title']),
                    'alert' => '0',  
                    'created' => date("Y-m-d H:i:s"),                    
                );
//                pr('insert new jobs' . $value['url']);
                $database->insert("web1",$insert_data);
            }
        }
    }
    
   
    pr('OK Good Jobs. !! ');
    
}


function get_jobs2() {
    global $database;
    $result = array();
    $mainurl = "http://www.xn--12clj3d7bc4c0cbcc.net/";
    //ภาคกลาง
    $url = "http://www.xn--12clj3d7bc4c0cbcc.net/%E0%B8%87%E0%B8%B2%E0%B8%99%E0%B8%A3%E0%B8%B2%E0%B8%8A%E0%B8%81%E0%B8%B2%E0%B8%A3-%E0%B8%81%E0%B8%97%E0%B8%A1-%E0%B8%9B%E0%B8%A3%E0%B8%B4%E0%B8%A1%E0%B8%93%E0%B8%91%E0%B8%A5-1";
    $getContent = get_content($url);

    $fetchHtml = str_get_html($getContent);

    $i = 0;
    $arr_url = array();
    foreach ($fetchHtml->find('ul[class="nav navbar-nav"]') as $div_role_main) { //pr($div_role_main->plaintext);
        foreach ($div_role_main->find('li[class="dropdown"]') as $key_li => $li) {  
            if($key_li == 0){
                foreach ($li->find('li') as $key_li_sub => $li_sub) {       
                    foreach ($li_sub->find("a") as $key_a => $value_a) {
                        if($key_li_sub != 0){
                            $arr_url[$i]['city'] = trim($value_a->plaintext);
                            $arr_url[$i]['url'] = $mainurl.trim($value_a->href);
                            $i++;
                        }
                    }
                } 
                
            }
            
        }
    }
    
 
    
    pr('=========== all Url City ============ Start ');
    pr($arr_url);
    pr('=========== all Url City ============ End ');
//    exit;
    $k = 0;  
    foreach ($arr_url as $key => $value) {
        $getContent = get_content($value['url']);
        $fetchHtml = str_get_html($getContent);
        foreach ($fetchHtml->find('ul[class="table-view"]') as $div_role_main) {
            foreach ($div_role_main->find('li[class="table-view-cell"]') as $key_element => $element) {
                foreach ($element->find('a') as $key_a => $val_a) {
                    
                    foreach ($val_a->find('p[class="subDetail"]') as $key_sub => $var_sub) {
                        $result[$k]['city'] = $value['city'];
                        $result[$k]['url'] = $mainurl.trim($val_a->href);
                        $result[$k]['title'] = trim($var_sub->plaintext);
                        $k++;
                    }
                }
            }
        }
    }
    
   
//    pr($result);
    
    if(!empty($result)){
        foreach($result as $value){
            $row = $database->select("web1","where url='".$value['url']."'");
            if (empty($row)) {
                //insert
                $insert_data = array(
                    'city' => $value['city'],
                    'url' => addslashes($value['url']),
                    'title' => addslashes($value['title']),
                    'alert' => '0',  
                    'created' => date("Y-m-d H:i:s"),                    
                );
//                pr('insert new jobs' . $value['url']);
                $database->insert("web1",$insert_data);
            }
        }
    }
    
   
    pr('OK Good Jobs. !! ');
    
}


function alert_line(){
    global $database;
    $alerts = $database->selects("web1","where alert = 0 ORDER BY city asc");
    if(!empty($alerts)){
        $i = 1;
        $txt[0]['type'] = 'text';
        $txt[0]['text'] = "www.หางานราชการ.net (เฉพาะภาคกลาง)\nhttp://www.xn--12clj3d7bc4c0cbcc.net\nวันที่ ". date('d/m/Y')." มีงานใหม่ดังนี้";
        foreach ($alerts as $key_alert => $value_alert) {
            $txt[$i]['type'] = 'text';
            $txt[$i]['text'] = $value_alert['city']."\n\n".$value_alert['title'];
            $i++; 
        }
        $database->update("web1","alert = 1", "where alert = 0");
       
        
        pr($txt);
        $line_txt = array();
        $i=0;
        $k=0;
        foreach ($txt as $key => $value) {
            $line_txt[$k][$i] = $value;            
            if($i == 4){
                $i=0;
                $k++;
            }else{
                $i++;
            }            
        }
        pr($line_txt);
        
        
        //U6acc2bffa0cedbaf757459f5e0d78788 //ใหม่
        //Ue76f53cb455056a7e7962b9af013705e กูเอง
        $arr_user = array('Ue76f53cb455056a7e7962b9af013705e','U6acc2bffa0cedbaf757459f5e0d78788');
        //$arr_user = array('Ue76f53cb455056a7e7962b9af013705e');
        foreach ($arr_user as $keyarr_user => $value_user) {            
            foreach ($line_txt as $key => $value) {
                send_line($value,$value_user);
            }
        }
                
    }
    
    
    
}

?>
        <a href="" ></a>
    </body>

</html>
