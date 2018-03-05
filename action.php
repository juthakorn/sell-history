<?PHP

//error_reporting(E_ALL);
session_start();
require_once 'include/connect.php'; 

$go = $_GET['go'];
if ($go === 'add_sell') {
    add_sell();
} else if ($go === 'del_sell') {
    del_sell();
}else if ($go === 'edit_sell') {
    edit_sell();
}else if ($go === 'del_sell_all') {
    del_sell_all();
}


else if ($go === 'add_date') {
    add_datesell();
} else if ($go === 'del_date') {
    del_date();
} else if ($go === 'chk_date') {
    chk_date();
}else if ($go === 'edit_date') {
    edit_date();
}else if ($go === 'del_date_all') {
    del_date_all();
}


else if ($go === 'add_product') {
    add_product();
} else if ($go === 'del_product') {
    del_product();
}else if ($go === 'edit_product') {
    edit_product();
}

else if ($go === 'find_stock') {
    find_stock();
}
else if ($go === 'save_sell_temp') {
    save_sell_temp();
}
else if ($go === 'confirm') {
    confirm('CF1703010');
}
else if ($go === 'del_sell_bot') {
    del_sell_bot('DL1703010');
}
else if ($go === 'get_stock_by_size') {
    get_stock_by_size('size-D-M,M');
}
else if ($go === 'add_stock_bot') {
    add_stock_bot('add-D-M2,M5,D-L');
}

else if ($go === 'verify') {
    verify();
}
else if ($go === 'line_bot') {
    line_bot();
}
else if ($go === 'send_jobs') {
    send_jobs();
}else if ($go === 'order_pro') {
    order_pro();
}else if ($go === "testfacebook") {
    testfacebook();
}else if ($go === "fbapi") {
    fbapi();
}else if($go === "payment"){
    payment();
}

function add_sell() { 
    global $database;
//    pr($_POST);exit;
    
    $txt_err = "";
    foreach ($_POST['p_name'] as $key => $value) {
            if(!empty($_POST['p_name'][$key]) && $_POST['p_qty'][$key]){
                $chkp = $database->select("products","where name = '" .$_POST['p_name'][$key]."'");
                if(!empty($chkp)){
                    if($chkp['qty'] < $_POST['p_qty'][$key]){
                       	 
                        $txt_err .= $chkp['name']." จำนวนสต๊อกไม่พอครับ<br>";
                       //      
                    }
                }else{
                    $txt_err .= "ไม่พบ ". $chkp['name']." ครับ<br>";
                }
            }
        }
    if(!empty($txt_err)){  
        echo gen_alert($txt_err);   
        exit;
    }    
    $chk = $database->num_rows("sell","where customer_name='".$_POST['customer_name']."' and sell_date_id = '".$_POST['sell_date_id']."'  and status = 1");
    
    if($chk == 0){
        $arr = array(
            'sell_date_id'=> $_POST['sell_date_id'],
            'refer'=> $_POST['refer'],
            'name_refer'=> addslashes($_POST['name_refer']),
            'type_product'=> implode(", ", $_POST['type_product']),
            'customer_name'=> addslashes($_POST['customer_name']),
            'customer_address'=> addslashes($_POST['customer_address']),
            'customer_tumbon'=> $_POST['customer_tumbon'],
            'customer_umpher'=> $_POST['customer_umpher'],
            'customer_province'=> $_POST['customer_province'],
            'customer_postal'=> $_POST['customer_postal'],
            'customer_tel'=> $_POST['customer_tel'],
            'detail' => $_POST['detail'],
            'type_pay' => $_POST['type_pay'],
            'status_pay' => $_POST['status_pay'],
            'customer_pay' => $_POST['customer_pay'],            
            'profit' => $_POST['profit'],
            'partner' => implode(", ", $_POST['partner']),
            'created' =>date('Y-m-d h:i:s'),
            'modified' =>date('Y-m-d h:i:s'),
        );
        $add = $database->insert("sell",$arr);
        
        $sell_id = $database->lastid();
        
        foreach ($_POST['p_name'] as $key => $value) {
            if(!empty($_POST['p_name'][$key]) && !empty($_POST['p_qty'][$key])){
                $database->insert("sell_detail",array('sell_id'=>$sell_id,'p_name'=>$_POST['p_name'][$key],'p_qty'=>$_POST['p_qty'][$key]));
                 
                $database->update("products","qty = qty - ".$_POST['p_qty'][$key], "where name = '".$_POST['p_name'][$key]."'");
        
            }
        }
        
        if($add){
            $chk_sell_date = $database->select("sell_date","where sell_date_id='".$_POST['sell_date_id']."'");
    
            message("success","บันทึกข้อมูลเรียบร้อยแล้วครับ");
//            echo "<script> parent.location.reload(true);</script>";
            echo "<script>$(function(){window.location.href='detail.php?date=".$chk_sell_date['sell_date']."';});</script>";
        }else{           
           echo gen_alert('เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้งครับ'); 
        }
    }else{        
        echo gen_alert('ข้อมูลการขายซ้ำครับ');   
        exit;
    }
}

function edit_sell(){
    global $database;
    if(empty($_POST['type_product'])){
        echo gen_alert('กรุณาเลือกประเภทสินค้าครับ');
        exit;
    }
    if(empty($_POST['partner'])){
        echo gen_alert('กรุณาเลือกร้านที่ส่งครับ');
        exit;
    }
    
//     echo gen_alert(pr($_POST));
           // exit;   
        
    $chk = $database->num_rows("sell","where customer_name='".$_POST['customer_name']."' and sell_date_id = '".$_POST['sell_date_id']."' and sell_id != '".$_POST['h_val_id']."' and status = 1");
    if($chk == 0){
        $arr_update = array(
            'sell_date_id'=> $_POST['sell_date_id'],
            'refer'=> $_POST['refer'],
            'name_refer'=> addslashes($_POST['name_refer']),
            'type_product'=> implode(", ", $_POST['type_product']),
            'customer_name'=> addslashes($_POST['customer_name']),
            'customer_address'=> addslashes($_POST['customer_address']),
            'customer_tumbon'=> $_POST['customer_tumbon'],
            'customer_umpher'=> $_POST['customer_umpher'],
            'customer_province'=> $_POST['customer_province'],
            'customer_postal'=> $_POST['customer_postal'],
            'customer_tel'=> $_POST['customer_tel'],
            'customer_pay' => $_POST['customer_pay'],
            'detail' => $_POST['detail'],
            'type_pay' => $_POST['type_pay'],
            'status_pay' => $_POST['status_pay'],
            'profit' => $_POST['profit'],
            'partner' => implode(" , ", $_POST['partner']),
            'modified' =>date('Y-m-d h:i:s'), 
        );
        $arr_where = array(
            'sell_id' => $_POST['h_val_id']
        );
        
        $sell_details = $database->selects("sell_detail",  "where sell_id ='".$_POST['h_val_id']."'"); 
        foreach ($sell_details as $key => $value) {
            $database->update("products","qty = qty + ".$value['p_qty'], "where name = '".$value['p_name']."'");        
        } 
        $database->delete("sell_detail",$arr_where);      
            
        $txt_err = "";
        foreach ($_POST['p_name'] as $key => $value) {
                if(!empty($_POST['p_name'][$key]) && $_POST['p_qty'][$key]){
                    $chkp = $database->select("products","where name = '" .$_POST['p_name'][$key]."'");
                    if(!empty($chkp)){
                        if($chkp['qty'] < $_POST['p_qty'][$key]){

                            $txt_err .= $chkp['name']." จำนวนสต๊อกไม่พอครับ<br>";
                           //      
                        }
                    }else{
                        $txt_err .= "ไม่พบ ". $chkp['name']." ครับ<br>";
                    }
                }
            }
        if(!empty($txt_err)){  
            echo gen_alert($txt_err);   
            exit;
        } 


        $up = $database->update("sell",$arr_update,$arr_where);

        if($up){
            
                
            
            foreach ($_POST['p_name'] as $key => $value) {
                if(!empty($_POST['p_name'][$key]) && !empty($_POST['p_qty'][$key])){
                    $database->insert("sell_detail",array('sell_id'=>$_POST['h_val_id'],'p_name'=>$_POST['p_name'][$key],'p_qty'=>$_POST['p_qty'][$key]));

                    $database->update("products","qty = qty - ".$_POST['p_qty'][$key], "where name = '".$_POST['p_name'][$key]."'");

                }
            }
            
//            pr($sell_details);
            
            message("success","แก้ไขข้อมูลเรียบร้อยแล้วครับ");
            echo "<script> parent.location.reload(true);</script>";
        }
    }else{
        echo gen_alert('ข้อมูลการขายซ้ำครับ');  
    }
    
}


function del_sell(){ 
    global $database;
    $arr = array(
         'sell_id' => $_POST['sell_id']
     );     
      $del = $database->delete("sell",$arr);
      $database->delete("sell_detail",$arr);
    if($del){
        message("success","ลบข้อมูลเรียบร้อยแล้วครับ"); 	 
        echo "<script> parent.location.reload(true);</script>";
    }else{
        message("danger","ไม่สามารถลบได้"); 	 
        echo "<script> parent.location.reload(true);</script>"; 
    } 
}

function del_sell_all(){ 
    global $database;
 
    foreach ($_POST['sell_id'] as $key => $value) {
        $arr = array(
            'sell_id' => $value
        );     
        $del = $database->delete("sell",$arr);
        $database->delete("sell_detail",$arr);
    }
    
    message("success","ลบข้อมูลเรียบร้อยแล้วครับ"); 	 
    echo "<script> parent.location.reload(true);</script>";
    
}


function add_datesell() { 
    global $database;
    $chk = $database->num_rows("sell_date","where sell_date='".$_POST['sell_date']."'");
    
    if($chk == 0){
        $arr = array(
            'sell_date'=> $_POST['sell_date'],
            'advertise'=> $_POST['advertise'],
        );
        $add = $database->insert("sell_date",$arr);
        if($add){
            message("success","บันทึกข้อมูลเรียบร้อยแล้วครับ");
            echo "<script> parent.location.reload(true);</script>";
        }else{
           message("danger","เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้งครับ"); 
           echo "<script> parent.location.reload(true);</script>";
        }
    }else{
        message("danger","ข้อมูลซ้ำครับ"); 	 
        echo "<script> parent.location.reload(true);</script>";        
    }
}

function del_date(){ 
    global $database;
 
    $arr = array(
        'sell_date_id' => $_POST['sell_date_id']
    );     
    $del = $database->delete("sell",$arr);
    $del2 = $database->delete("sell_date",$arr);
//        $del = $database->delete("sell","where sell_id = '".$_POST['sell_id']."'");
    if($del){
        message("success","ลบข้อมูลเรียบร้อยแล้วครับ"); 	 
        echo "<script> parent.location.reload(true);</script>";
    }else{
        message("danger","ไม่สามารถลบได้เนื่องจากมีการอ้างอิงในตารางอื่น"); 	 
        echo "<script> parent.location.reload(true);</script>"; 
    } 
}

function chk_date(){
    global $database;
    $chk = $database->num_rows("sell","where sell_date_id='".$_POST['h_val_id']."'");
	 if ($chk != 0){
            echo "<script> $(function(){ $('#sell_date').attr('readOnly','true'); }); </script>";
        }
}

function del_date_all(){ 
    global $database;
 
    foreach ($_POST['sell_date_id'] as $key => $value) {
        $arr = array(
            'sell_date_id' => $value
        );     
        $del = $database->delete("sell",$arr);
        $del2 = $database->delete("sell_date",$arr);
    }
    
    message("success","ลบข้อมูลเรียบร้อยแล้วครับ"); 	 
    echo "<script> parent.location.reload(true);</script>";
    
}

function edit_date(){
    global $database;
    
        $chk = $database->num_rows("sell_date","where sell_date='".$_POST['sell_date']."' and sell_date_id != '".$_POST['h_val_id']."'");
	if($chk == 0){
            $arr_update = array(
                'sell_date' => $_POST['sell_date'],
                'advertise' => $_POST['advertise']
            );
            $arr_where = array(
                'sell_date_id' => $_POST['h_val_id']
            );
            $up = $database->update("sell_date",$arr_update,$arr_where);
        
            if($up){
                message("success","แก้ไขข้อมูลเรียบร้อยแล้วครับ");
                echo "<script> parent.location.reload(true);</script>";
            }
	}else{
	    message("danger","มีข้อมูลวันที่ขายนี้แล้วในระบบครับ"); 
            echo "<script> parent.location.reload(true);</script>";
	}
    
}




function add_product() { 
    global $database;
    $chk = $database->num_rows("products","where name ='".$_POST['name']."'");
    
    if($chk == 0){
        $arr = array(
            'p_id'=> $_POST['p_id'],
            'name'=> $_POST['name'],
            'size'=> $_POST['size'],
            'qty'=> $_POST['qty'],
            'text_search'=> preg_replace('/\s+/', '', $_POST['name']),
            'created' =>date('Y-m-d h:i:s'),
        );
        $add = $database->insert("products",$arr);
        if($add){
            message("success","บันทึกข้อมูลเรียบร้อยแล้วครับ");
            echo "<script> parent.location.reload(true);</script>";
        }else{
            echo gen_alert('เกิดข้อผิดพลาดกรุณาลองใหม่อีกครั้งครับ');    
        }
    }else{
        echo gen_alert('ชื่อสินค้าซ้ำครับ');       
    }
}


function edit_product(){
    global $database;
    
    $chk = $database->num_rows("products","where name = '".$_POST['name']."' and id != '".$_POST['h_val_id']."'");
    if($chk == 0){
        $arr_update = array(
            'p_id'=> $_POST['p_id'],
            'name'=> $_POST['name'],
            'size'=> $_POST['size'],
            'qty'=> $_POST['qty'],
            'text_search'=> preg_replace('/\s+/', '', $_POST['name']),            
        );
        $arr_where = array(
            'id' => $_POST['h_val_id']
        );
        $up = $database->update("products",$arr_update,$arr_where);

        if($up){
            message("success","แก้ไขข้อมูลเรียบร้อยแล้วครับ");
            echo "<script> parent.location.reload(true);</script>";
        }
    }else{
        echo gen_alert('ชื่อสินค้าซ้ำครับ');  
    }
    
}

function del_product(){
    global $database;
 
    $arr = array(
        'id' => $_POST['id']
    );     
    $del = $database->delete("products",$arr);
    if($del){
        message("success","ลบข้อมูลเรียบร้อยแล้วครับ"); 	 
        echo "<script> parent.location.reload(true);</script>";
    }else{
        message("danger","ไม่สามารถลบได้กรุณาลองใหม่อีกครั้ง"); 	 
        echo "<script> parent.location.reload(true);</script>"; 
    } 
}

function order_pro(){
    global $database;
    if(!empty($_POST['position'])){
        $arr = explode(',', $_POST['position']);
        
        foreach ($arr as $key => $value) {
            $arr_update = array(
                'position'=> $key+1,       
            );
            $arr_where = array(
                'id' => $value
            );
            $database->update("products",$arr_update,$arr_where);

        }
        
        message("success","เรียงข้อมูลเรียบร้อยแล้วครับ"); 	 
        echo "<script> parent.location.reload(true);</script>";
    }
    
}

function find_stock(){
    
    $str = trim($_POST['txt']);
    $return = get_stock($str);
    echo json_encode($return);
}


function save_sell_temp($txt){
    global $database;
    /*$txt = 'บันทึก-
            ช-สุรีย์ฉาย นามบุญ  
            ส-7/252 ม.6 บริษัทฟิชเชอร์แอนด์พายเคิ้ล นิคมอุตสาหกรรมอมตะซิตี้ ต-มาบยางพร อ-ปลวกแดง จ-ระยอง 21140
            ร-โปโลกรมริ้วขาว,D-F,L,กรมริ้วเหลืองเล็ก,D-S,L15,กรมแขนกุดปลาวาฬ,D-F2,F2 
            รบ-ดำหัวใจ,D-SLong2,L,กรมริ้วเหลือง,D-S,L';*/
           
    $str = trim($txt);
    $str = preg_replace('/ช[-|:]/', '|ช:', $str);
    $str = preg_replace('/ส[-|:]/', '|ส:', $str);
    $str = preg_replace('/ต[-|:]/', '|ต:', $str);
    $str = preg_replace('/อ[-|:]/', '|อ:', $str);
    $str = preg_replace('/จ[-|:]/', '|จ:', $str);
    $str = preg_replace('/ท[-|:]/', '|ท:', $str);
    $str = preg_replace('/ร[-|:]/', '|ร:', $str);
    $str = preg_replace('/รบ[-|:]/', '|รบ:', $str);
    $str = preg_replace('/cod[-|:]/', '|cod:', $str);
    $arr_str = explode('|', $str);
//    pr($arr_str);
    $data = array();
    foreach ($arr_str as $key => $value) {
         
        preg_match('/(ช|ส|ต|อ|จ|ท|ร|รบ|cod):/i', $value, $match );
        if(isset($match[0])){
            $tmp = trim(str_replace($match[0], '', $value));
            switch ($match[0]) {
                case 'ช:':
                    $data['customer_name'] = $tmp;
                    break;
                case 'ส:':
                    $data['customer_address'] = $tmp;
                    break;
                case 'ต:':
                    $data['customer_tumbon'] = $tmp;
                    break;
                case 'อ:':
                    $data['customer_umpher'] = $tmp;
                    break;
                case 'จ:':
                    if(preg_match('/[0-9]{5}/i', $tmp, $match22 )){
                        $tmp = trim(str_replace($match22[0], '', $tmp));
                        $data['customer_province'] = $tmp;
                        $data['customer_postal'] = $match22[0];
                    }else{
                        $data['customer_province'] = $tmp;
                    }               
                    
                    break;
                case 'ท:':
                    $data['customer_tel'] = $tmp;
                    break;
                case 'ร:':
                    $data['detail'] = $tmp;
                    break;
                case 'รบ:':
                    $data['detail_me'] = $tmp;
                    break;
                case 'cod:':
                    $data['cod'] = $tmp;
                    break;    
                default:
                    break;
            }
        }
    }


    $text_err = "";
    if(empty($data['customer_name'])){
        $text_err = "ไม่มีแท็กชื่อ ช ตามด้วย - หรือ : \nเช่น ช-เบญจมาภรณ์ เกิดพิทักษ์ \nกรุณาลองใหม่...!";
    }
    else if(empty($data['customer_address'])){
        $text_err = "ไม่มีแท็กที่อยู่ ส ตามด้วย - หรือ : \nเช่น ส-99/99 หมู่ 9 ถนนสวยงาม \nกรุณาลองใหม่...!";
    }
    else if(empty($data['customer_umpher'])){
        $text_err = "ไม่มีแท็กอำเภอ/เขต อ ตามด้วย - หรือ : \nเช่น อ-สรรคบุรี \nกรุณาลองใหม่...!";
    }
    else if(empty($data['customer_province'])){
        $text_err = "ไม่มีแท็กจังหวัด จ ตามด้วย - หรือ : \nเช่น จ-ชัยนาท \nกรุณาลองใหม่...!";
    }
    else if(empty($data['customer_postal'])){
        $text_err = "ไม่มีรหัสไปรษณีย์ หรือ รหัสไปรษณีย์ไม่ถูกต้อง \nจ ตามด้วย - หรือ : เช่น จ-ชัยนาท 17140 กรุณาลองใหม่...!";
    }
    else if(empty($data['detail']) && empty($data['detail_me'])){
        $text_err = "ไม่มีแท็กรายการสินค้า \nร ตามด้วย - หรือ : \nเช่น ร-แดงหัวใจ,D-S,M ถ้า 1 ไซส์มากกว่า 1 ตัว \nเช่น ร-แดงหัวใจ,D-S2,M3 \nกรุณาลองใหม่...!";
    }else if(!empty($data['cod']) && (!is_numeric($data['cod']) ) ){
        $text_err = "COD ต้องเป็นตัวเลขเท่านั้น \nกรุณาลองใหม่...!";
    }
    //return Error
    if(!empty($text_err)){
//        pr($text_err);
        return $text_err;
    }


    //สินค้าร้านอื่น
    $data['txt_detail'] = "";
    if(!empty($data['detail'])){        
        $tempproduct = get_arr_product($data['detail']);        
        foreach ($tempproduct as $key => $value) {
            $data['txt_detail'] .= $value['name']." ".$value['size']." ". $value['qty']." ตัว\n";
        }        
//        pr($data['detail']);exit;
    }

    //สินค้าร้านตัวเอง
    $text_empty = array();
    $data['txt_detail_me'] = "";
    if(!empty($data['detail_me'])){        
        $tempproduct_me = get_arr_product($data['detail_me']);
        
        foreach ($tempproduct_me as $key => $value) {
            $str_name = preg_replace('/\s+/', '', $value['name']);
            $product = $database->select("products",  "where text_search = '" .$str_name.$value['size']."'"); 
            
            if(empty($product)){
                $text_empty['not_found'][] = $value['name']." ".$value['size'];
            }else if ($product['qty'] < $value['qty']) {
                $text_empty['out_stock'][] = $product['name'];                
            }else{
                $tempproduct_me[$key]['p_name'] = $product['name'];
                $data['txt_detail_me'] .= $product['name']." ". $value['qty']." ตัว\n";
            }
        }
//        pr($tempproduct_me);
    }
    if(!empty($text_empty)){
//        pr($text_empty);   
        $txt_empty = "";
        if(!empty($text_empty['not_found'])){
            $text_empty['not_found'] = array_unique($text_empty['not_found']);
            $txt_empty .= implode("\n", $text_empty['not_found']) ."\nไม่พบสินค้า...!\n\n";
        }
        if(!empty($text_empty['out_stock'])){
            $text_empty['out_stock'] = array_unique($text_empty['out_stock']);
            $txt_empty .= implode("\n", $text_empty['out_stock']) ."\nสินค้าหมด...!\n\n";
        }
        $txt_empty = substr($txt_empty, 0,-2);
//        pr($txt_empty);
        return $txt_empty;
//        exit;
    }

    
    
    //save to database
    $sell_date = $database->select("sell_date",  "where sell_date = '" .date('Y-m-d')."'");
    if(empty($sell_date)){
        $lastdate = $database->select("sell_date",  "order by sell_date DESC"); 
        $database->insert("sell_date",array('sell_date'=>date('Y-m-d'),'advertise'=>$lastdate['advertise']));
        $sell_date_id = $database->lastid();
    }else{
        $sell_date_id = $sell_date['sell_date_id'];
    }
    $temp_sell  = $database->select("sell",  "where created like '".date('Y-m')."%' and confirm_code != '' and confirm_code IS NOT NULL order by sell_id DESC");
//    pr($temp_sell);
   if(empty($temp_sell)){
        $confirm_code = date('ym')."001";
    }else{
        $confirm_code = $temp_sell['confirm_code']+1;
    }
    $insert_sell = array(
        'type_product' => 'เสื้อคู่',
        'sell_date_id' => $sell_date_id,
        'customer_name' => addslashes($data['customer_name']),
        'customer_address' => $data['customer_address'],
        'customer_tumbon' => @$data['customer_tumbon'],
        'customer_umpher' => $data['customer_umpher'],
        'customer_province' => $data['customer_province'],
        'customer_postal' => $data['customer_postal'],
        'customer_tel' => @$data['customer_tel'],
        'detail' => trim($data['txt_detail']),
        'created' =>date('Y-m-d h:i:s'),
        'modified' =>date('Y-m-d h:i:s'),
        'status' => 0,
        'type_pay' => (!empty($data['cod']) ? 2 : 1),
        'customer_pay' => (!empty($data['cod']) ? $data['cod'] : ""),
        'status_pay' => (!empty($data['cod']) ? 2 : 1),
        'confirm_code' => $confirm_code 
    );
    $database->insert('sell',$insert_sell);
    $sell_id = $database->lastid();

    if(!empty($tempproduct_me)){
        foreach ($tempproduct_me as $key => $value) {
            $arr_insert = array(
                'sell_id' => $sell_id,
                'p_name' => $value['p_name'],
                'p_qty' => $value['qty']
                );
            $database->insert('sell_detail',$arr_insert);
        }
    }

    
    $txt_return = get_text_massage($sell_id, 0);    
//    pr($sell_id);
    return $txt_return;
}

function confirm($txt){
    global $database;
//    $txt = "CF1703003";    
    $confirm_code = substr($txt, 2);
//    pr($confirm_code);
    
    $temp_sell  = $database->select("sell",  "where confirm_code = '".$confirm_code."' and status = 0");
    if(!empty($temp_sell)){
//        pr($temp_sell);
        $sell_detail  = $database->selects("sell_detail",  "where sell_id = ".$temp_sell['sell_id']);
        
        if(!empty($sell_detail)){
//            pr($sell_detail);

            // ===================  check stock again ===================== Start
            $text_empty = array();
            foreach ($sell_detail as $key => $value) { 
                $product = $database->select("products","where name = '" .$value['p_name']."'");                
                if(empty($product)){
                    $text_empty['not_found'][] = $value['p_name'];
                }else if ($product['qty'] < $value['p_qty']) {
                    $text_empty['out_stock'][] = $product['name'];                
                }
            }

            if(!empty($text_empty)){
//                 pr($text_empty);   
                $txt_empty = "";
                if(!empty($text_empty['not_found'])){
                    $text_empty['not_found'] = array_unique($text_empty['not_found']);
                    $txt_empty .= implode("\n", $text_empty['not_found']) ."\nไม่พบสินค้า...!\n\n";
                }
                if(!empty($text_empty['out_stock'])){
                    $text_empty['out_stock'] = array_unique($text_empty['out_stock']);
                    $txt_empty .= implode("\n", $text_empty['out_stock']) ."\nสินค้าหมด...!\n\n";
                }
                $txt_empty = substr($txt_empty, 0,-2);
                pr($txt_empty);
                return $txt_empty;
            }
            // ===================  check stock again ===================== End

            //update stock
            foreach ($sell_detail as $key => $value) {               
                $database->update("products","qty = qty - ".$value['p_qty'], "where name = '".$value['p_name']."'");
            }
        }

        //update status
        $database->update("sell",array('status'=> 1),array('sell_id' => $temp_sell['sell_id']));
        
        $txt_return = get_text_massage($temp_sell['sell_id'], 1);        
        return $txt_return;
    }else{
        echo 'ไม่พบเลขที่ใบยืนยัน : '.$txt;
        return 'ไม่พบเลขที่ใบยืนยัน : '.$txt;        
    }
}

function del_sell_bot($txt){
    global $database;
    $confirm_code = substr($txt, 2);
//    pr($confirm_code);
    
    $temp_sell  = $database->select("sell",  "where confirm_code = '".$confirm_code."' and status = 1");
    if(!empty($temp_sell)){
        $sell_detail  = $database->selects("sell_detail",  "where sell_id = ".$temp_sell['sell_id']);
        
        if(!empty($sell_detail)){
            $arr_where = array(
                'sell_id' => $temp_sell['sell_id']
            );
            foreach ($sell_detail as $key => $value) {
                $database->update("products","qty = qty + ".$value['p_qty'], "where name = '".$value['p_name']."'");        
            } 
            $database->delete("sell_detail",$arr_where);    
        }
        $database->update("sell",array('status'=> 0),array('sell_id' => $temp_sell['sell_id']));
        echo 'ลบข้อมูลเรียบร้อยแล้ว...!';
        return 'ลบข้อมูลเรียบร้อยแล้ว...!';
    }else{
        echo 'ไม่พบเลขที่ใบยืนยัน : '.$txt;
        return 'ไม่พบเลขที่ใบยืนยัน : '.$txt;   
    }
}

function get_arr_product($txt){
    $temp_name = '';
    $tempproduct = array();
    $k=0;

    $arr = explode(',', $txt);
    foreach ($arr as $key => $value) {
       if(preg_match('/^[a-zA-Z][0-9]?/', $value)){
            $size = $value;
            $qty = 1;
            if(preg_match('/[0-9]{1,}$/', $value,$match)){
                $qty = $match[0];
                $size = str_replace($qty, "", $value);
            }
           if(!empty($temp_name)){
               $tempproduct[$k]['name'] = $temp_name;
               $tempproduct[$k]['size'] = trim($size);
               $tempproduct[$k]['qty'] = trim($qty);
               $k++;
           }  
       }else{
            //product name
            $temp_name = trim($value);
       }
    }

    return $tempproduct;
}

/*
 * param $type 0 = create,1 = confrim
 */
function get_text_massage($sell_id,$type){
    global $database;
    $data  = $database->select("sell a inner join sell_date b on a.sell_date_id = b.sell_date_id",  "where a.sell_id = ".$sell_id);
    $sell_detail  = $database->selects("sell_detail",  "where sell_id = ".$sell_id);
    $data['txt_detail_me'] = "";
    if(!empty($sell_detail)){
        foreach ($sell_detail as $key => $value) {
            $data['txt_detail_me'] .= $value['p_name']." ". $value['p_qty']." ตัว\n";
        }        
    }
    $data['txt_detail_me'] = trim($data['txt_detail_me']);
    
    $txt_return = "";
    if($type == 0){
        $txt_return .= "จัดส่ง\n";
    }
    if($type == 1){
        $txt_return .= "บันทึกสำเร็จ...!\n\nเลขที่ยืนยัน : CF".$data['confirm_code']."\nเลขที่บิล : ".$data['sell_id']."\nวันที่ : ".$data['sell_date']."\n\n";
    }
    
    $txttombon = "ตำบล";
    $txtumpher = "อำเภอ";
    if(preg_match("/กทม|กรุงเทพ/i", $data['customer_province'])){
        $txttombon = "แขวง";
        $txtumpher = "เขต";
    }
    

    $txt_return .= "คุณ".$data['customer_name']."\n"
        . $data['customer_address']. (!empty($data['customer_tumbon']) ? " ".$txttombon.":".$data['customer_tumbon']: "")." "
        . $txtumpher.":".$data['customer_umpher']." "
        . "\nจังหวัด:".$data['customer_province']." ". $data['customer_postal']
        . (!empty($data['customer_tel']) ? "\nโทร:".$data['customer_tel']: "")
        . (!empty($data['detail']) ? "\n\nรายการชุดร้านอื่น\n".$data['detail'] : "")
        . (!empty($data['txt_detail_me']) ? "\n\nรายการชุดร้านตัวเอง\n".$data['txt_detail_me'] : "");

    if($data['type_pay'] == 2 && !empty($data['customer_pay'])){
        $txt_return .= "\n\nยอดเงิน COD ".number_format($data['customer_pay']) ." บาท";
    }     
    if($type == 0){
        $txt_return .= "\n\nเลขที่ใบยืนยัน : CF".$data['confirm_code'];
    }  
//    pr($txt_return);
    return $txt_return;
    
}

function get_stock($str){
    global $database;
    $str = preg_replace('/\s+/', '', $str);
    $str = preg_replace('/<|>/i', '%', $str);
    $str = preg_replace('/%%/i', '% %', $str);
    $res = explode(' ', $str);
    $conditions = "";
    foreach ($res as $value) {
        if(preg_match('/ที่รัก/i', $value)){
            $conditions = "1=1 AND";
            break;
        }
        if(preg_match('/%/i', $value)){
            $conditions .= "text_search LIKE '".$value."' AND ";
        }else{
            $conditions .= "text_search LIKE '%".$value."%' AND ";
        }
    }
    $conditions = substr($conditions, 0 , -4);
    $products = $database->selects("products",  "where " .$conditions . " AND qty > 0 order by position ASC"); 
    $return = array();
    $return['txt'] = "";
    if(empty($products)){
        $return['txt'] = "ไม่พบรายการหรือสินค้าหมด...!\n􀄃􀅁pencil􏿿แนะนำการใช้งานพิมพ์ help";
        $return['count'] = 0;
    }else{        
        foreach ($products as $key => $value) {
            $return['txt'] .= $value['name'] . " เหลือ " .  $value['qty'] . " ตัว\n";            
        }
        $return['count'] = sizeof($products);
    }
    return $return;
}


function get_stock_by_size($txt){
    global $database;
    $return = "";
    $str = substr($txt, 5);     
    $arr = explode(',', $str);
    if(isset($arr[0]) && isset($arr[1])){
        $products = $database->selects("products",  "where (size = '".$arr[0]."' OR  size = '".$arr[1]."') AND qty > 0 GROUP BY `p_id` HAVING count(*) > 1 order by position ASC"); 
        if(empty($products)){
            $return = 'ไม่พบรายการหรือสินค้าหมด...!';
        }else{        
            foreach ($products as $key => $value) {
                $temp = explode(" ", $value['name']);
                $count_len = strlen(end($temp));
                $name_product = substr($value['name'], 0,-$count_len);
                $return .= $name_product. "\n";            
            }
        }
        pr($return);
        return $return;
        
    }else{
        return "กรุณากรอกไซส์ ชายและหญิง\nเช่นsize[-หรือ:]M,D-S";
    }
   
    //SELECT * FROM `products` where (size = 'D-S' OR  size = 'M')   and qty > 1  GROUP BY `p_id` HAVING count(*) >1
    
}

function add_stock_bot($txt){
    global $database;
    $return = "เพิ่มจำนวนสินค้าเรียบร้อย\n";
    $str = substr($txt, 4); 
    $str = preg_replace('/\s+/', '', $str);

    //เช็คสินค้าร้านว่ามีหรือป่าว
    $text_empty = array();    
    $products = get_arr_product($str);
    
    foreach ($products as $key => $value) {
        $str_name = preg_replace('/\s+/', '', $value['name']);
        $product = $database->select("products",  "where text_search = '" .$str_name.$value['size']."'");         
        if(empty($product)){
            $text_empty[] = $value['name']." ".$value['size'];
        }else{
            $products[$key]['p_name'] = $product['name'];
        }
    }    
    if(!empty($text_empty)){
        $txt_empty = "";
        $text_empty = array_unique($text_empty);
        $txt_empty .= implode("\n", $text_empty) ."\nไม่พบสินค้า...!\n"; 
        return $txt_empty;
    }

    //add stock

    foreach ($products as $key => $value) {
        $database->update("products","qty = qty + ".$value['qty'], "where name = '".$value['p_name']."'");
        $return .= $value['p_name']." ". $value['qty']." ตัว\n";
    } 
    return $return;

}

function set_stock_bot($txt){
    global $database;
    $return = "กำหนดจำนวนสินค้าเรียบร้อย\n";
    $str = substr($txt, 4); 
    $str = preg_replace('/\s+/', '', $str);

    //เช็คสินค้าร้านว่ามีหรือป่าว
    $text_empty = array();    
    $products = get_arr_product($str);
    
    foreach ($products as $key => $value) {
        $str_name = preg_replace('/\s+/', '', $value['name']);
        $product = $database->select("products",  "where text_search = '" .$str_name.$value['size']."'");         
        if(empty($product)){
            $text_empty[] = $value['name']." ".$value['size'];
        }else{
            $products[$key]['p_name'] = $product['name'];
        }
    }    
    if(!empty($text_empty)){
        $txt_empty = "";
        $text_empty = array_unique($text_empty);
        $txt_empty .= implode("\n", $text_empty) ."\nไม่พบสินค้า...!\n"; 
        return $txt_empty;
    }

    //add stock

    foreach ($products as $key => $value) {
        $database->update("products","qty = ".$value['qty'], "where name = '".$value['p_name']."'");
        $return .= $value['p_name']." ". $value['qty']." ตัว\n";
    } 
    return $return;

}

function verify(){
    $access_token = 'ASS7oydEPY40Cqwe68km/eCCIZSMS8yLFcRS+K/hkxgMYzPYa5CFOswBG+vfkXOYAmXjPIdlTtlXgaaCw6qAJ6UBJvGWggb/vjoHPC8qJZY3VXrbuHzo3TZUGRzwC3fDqHJUv3ECCP48eggvKIxvbAdB04t89/1O/w1cDnyilFU=';
//{"channelId":1499052708,"mid":"u963693a58c1f0533d1d28ca7a915b1bc"}
    $url = 'https://api.line.me/v1/oauth/verify';

    $headers = array('Authorization: Bearer ' . $access_token);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    echo $result;
}

function line_bot(){
    global $database;
    //user Owner
    $Owner_user = array('Ue76f53cb455056a7e7962b9af013705e','U6acc2bffa0cedbaf757459f5e0d78788');
    $access_token = 'ASS7oydEPY40Cqwe68km/eCCIZSMS8yLFcRS+K/hkxgMYzPYa5CFOswBG+vfkXOYAmXjPIdlTtlXgaaCw6qAJ6UBJvGWggb/vjoHPC8qJZY3VXrbuHzo3TZUGRzwC3fDqHJUv3ECCP48eggvKIxvbAdB04t89/1O/w1cDnyilFU=';

    // Get POST body content
    $content = file_get_contents('php://input');
    // Parse JSON
    $events = json_decode($content, true);
    // Validate parsed JSON data
    if (!is_null($events['events'])) {
        // Loop through each event
        foreach ($events['events'] as $event) {
            // Reply only when message sent is in 'text' format
            if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
                    // Get text sent
                    $text = $event['message']['text'];
                    
                    
                    $database->insert("log_message",array('user_id'=>$event['source']['userId'],'message'=>$text));
                    
                    $txt = "";
                    $muti_message = FALSE;
                    $custom_message = [];
                    if(preg_match('/บันทึก[-|:]/i', $text)){
                        $return = save_sell_temp($text);
                        $txt = trim($return);
                    }
                    else if(preg_match('/^cf/i', $text)){
                        $return = confirm($text);
                        $txt = trim($return);
                    }
                    else if(preg_match('/^dl/i', $text)){
                        $return = del_sell_bot($text);
                        $txt = trim($return);
                    }
                    else if(preg_match('/^size[-|:]/i', $text)){
                        $return = get_stock_by_size($text);
                        $txt = trim($return);
                    }
                    else if(preg_match('/^add[-|:]/i', $text)){
                        $return = add_stock_bot($text);
                        $txt = trim($return);
                    }
                    else if(preg_match('/^set[-|:]/i', $text)){
                        $return = set_stock_bot($text);
                        $txt = trim($return);
                    }
                    else if($text == 'help'){ 
                        if(in_array($event['source']['userId'], $Owner_user)){
                            $txt = line_help('help_owner', $muti_message, $custom_message);
                        }else{
                            $txt = line_help($text, $muti_message, $custom_message);
                        }
                    }
                    else if($text == '1' || $text == '2' || $text == '3' || $text == '4' ){  
                        if(in_array($event['source']['userId'], $Owner_user)){
                            $txt = line_help($text, $muti_message, $custom_message);      
                        }
                    }
                    else if(preg_match('/<|>/i', $text)){
                        $return = get_stock($text);
                        $txt = isset($return['txt']) ? trim($return['txt']) : "กรุณาลองใหม่";
                    } 
                    else{
                        $return = get_stock($text.">"); //ใส่ให้เลย
                        $txt = isset($return['txt']) ? trim($return['txt']) : "กรุณาลองใหม่";                        
                    }
                    
                    
                    
                    // Get replyToken
                    $replyToken = $event['replyToken'];
                    
                    if($text == 'info'){
                        $txt = $content;
                    }
                    // Build message to reply back
                    $messages = [
                            [
                            'type' => 'text',
                            'text' => $txt
                            ]
                     ];
                    
                   
                    // Make a POST Request to Messaging API to reply to sender
                    $url = 'https://api.line.me/v2/bot/message/reply';
                    $data = [
                            'replyToken' => $replyToken,
                            'messages' => (!empty($custom_message) ? $custom_message : $messages)
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
    }
    
    
    echo "OK";
}

function line_help($text,&$muti_message,&$custom_message){
    $txt_help ="􀄃􀅁pencil􏿿แนะนำการใช้งานพิมพ์ help";
    $txt_check = "􀄃􀅁pencil􏿿แนะนำการเช็คสินค้า ร้าน TM SHOP เสื้อคู่รัก\n\n"
                . "􀄃􀉘pointing right􏿿เช็คด้วยชื่อสินค้า พิมพ์ชื่อสินค้า เช่น แดงหัวใจ>\n"
                . "􀄃􀉘pointing right􏿿เช็คด้วยส่วนใดส่วนหนึ่งของชื่อสินค้า เช่น <หัวใจ> คือค้นหาชื่อสินค้าที่มีคำว่า หัวใจ\n"
                . "􀄃􀉘pointing right􏿿เช็คด้วยไซส์ เช่น <D-M> คือค้นหาสินค้าที่มีไซส์ D-M\n"
                . "􀄃􀉘pointing right􏿿เช็คด้วยชื่อและไซส์ เช่น <หัวใจ><D-S>  คือค้นหาชื่อสินค้าที่มีคำว่า หัวใจ และมีคำว่า D-S\n"
                . "􀄃􀉘pointing right􏿿เช็คด้วยไซส์ชายและหญิง เช่น size:M,D-S คือค้นหาสินค้าที่มี ชายไซส์ M หญิงไซส์ D-S\n\n"
                . "􀄃􀅸love􏿿ปล.ขอรายการชื่อสินค้าได้จาก เจ้าของร้าน TM SHOP\n"
                . "การเช็คสินค้าต้องมีเครื่องหมาย < หรือ > เสมอ เพื่อระบุขอบเขตการค้นหา";
    
    
    switch ($text) {
        case 'help_owner':
            $txt = "แนะนำการใช้งาน Line bot ของร้าน TM SHOP เสื้อคู่รัก\n\n"
                    . "กรุณาพิมพ์หมายเลขที่ต้องการให้คำแนะนำ\n"
                    . "􀄃􀅁pencil􏿿แนะนำการเช็คสินค้า พิมพ์ 1 􀄃􀅁pencil􏿿แนะนำการบันทึกการขาย พิมพ์ 2 􀄃􀅁pencil􏿿แนะนำการลบการขาย พิมพ์ 3 􀄃􀅁pencil􏿿แนะนำการเพิ่มสต๊อกสินค้า พิมพ์ 4";
                         
            break;
        case 'help':
            $txt = $txt_check;
            break;
        case '1':
            $txt = $txt_check;
            $muti_message = TRUE;
            $custom_message = [
                    ['type' => 'text','text' => $txt],
                    ['type' => 'text','text' => $txt_help],
            ];
            break;
        case '2':
            $txt = '222';
            break;
        case '3':
            $txt = '333';
            break;
        case '4':
            $txt = '444';
            break;
        default:
            $txt = $txt_help;
            break;
    }
    return $txt;
}

function send_jobs(){
    $access_token = 'ASS7oydEPY40Cqwe68km/eCCIZSMS8yLFcRS+K/hkxgMYzPYa5CFOswBG+vfkXOYAmXjPIdlTtlXgaaCw6qAJ6UBJvGWggb/vjoHPC8qJZY3VXrbuHzo3TZUGRzwC3fDqHJUv3ECCP48eggvKIxvbAdB04t89/1O/w1cDnyilFU=';
    // Make a POST Request to Messaging API to push to sender
    $url = 'https://api.line.me/v2/bot/message/push';
    $data = [
            'to' => 'Ue76f53cb455056a7e7962b9af013705e', //กูเอง
            'messages' => [
                        [
                            'type' => 'text',
                            'text' => 'test gggg'
                        ],
                        [
                            'type' => 'text',
                            'text' => 'test 7777'
                        ],
                        [
                            'type' => 'sticker',
                            'packageId' => '1',
                            'stickerId' => '10'
                        ],
                    ],
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

function gen_alert($txt){
    return '<div class="alert alert-danger" >
        <button type="button" class="close" data-dismiss="alert">×</button>
        <span>'.$txt.'</span>
    </div>
    <script> $(\'body,html\').animate({scrollTop: 0}, 500);</script>';
}

function payment() {
    global $database;
    $id = $_POST['sell_id'];
    if(!empty($id)){
        $database->update("sell",array('status_pay' => 1),array('sell_id' => $id));
        message("success","บันทึกข้อมูลเรียบร้อยแล้วครับ");
        echo "<script> parent.location.reload(true);</script>";
    }else{
        echo gen_alert('ไม่พบข้อมูลการขายค่ะ');
    }      
    
}

function line_template(){
    
    return $data = [
            'type' => 'template',
            'altText' => 'this is a buttons template',
            'template' => [
                'type'=> 'buttons',
                'thumbnailImageUrl'=> 'https://www.google.co.th/images/branding/googlelogo/2x/googlelogo_color_120x44dp.png',
                'title'=> 'Menu',
                'text'=> 'Please select',
                'actions' => [
                    [
                        'type' => 'postback',
                        'label'=> 'Buy',
                        'data'=>'https://devdocs.line.me/en/'                        
                    ],                    
                    [
                        'type' => 'uri',
                        'label'=> 'View detail',
                        'uri'=>'https://devdocs.line.me/en/'   
                    ]
                ]
                
            ],
        ];
       
    
}

function testfacebook() {
   $curl_post_data = array(
            'text' => 'แดงหัว'
    );
    echo CallAPI("POST", 'http://www.tm_shop.dev/action.php?go=fbapi',$curl_post_data);
}

function fbapi() {
    
    $text = $_POST['text'];
    $txt = "";
    $muti_message = FALSE;
    $custom_message = [];
    if(preg_match('/บันทึก[-|:]/i', $text)){
        $return = save_sell_temp($text);
        $txt = trim($return);
    }
    else if(preg_match('/^cf/i', $text)){
        $return = confirm($text);
        $txt = trim($return);
    }
    else if(preg_match('/^dl/i', $text)){
        $return = del_sell_bot($text);
        $txt = trim($return);
    }
    else if(preg_match('/^size[-|:]/i', $text)){
        $return = get_stock_by_size($text);
        $txt = trim($return);
    }
    else if(preg_match('/^add[-|:]/i', $text)){
        $return = add_stock_bot($text);
        $txt = trim($return);
    }
    else if($text == 'help'){ 
//        if(in_array($event['source']['userId'], $Owner_user)){
//            $txt = line_help('help_owner', $muti_message, $custom_message);
//        }else{
            $txt = line_help($text, $muti_message, $custom_message);
//        }
    }
    else if($text == '1' || $text == '2' || $text == '3' || $text == '4' ){  
//        if(in_array($event['source']['userId'], $Owner_user)){
            $txt = line_help($text, $muti_message, $custom_message);      
//        }
    }
    else if(preg_match('/<|>/i', $text)){
        $return = get_stock($text);
        $txt = isset($return['txt']) ? trim($return['txt']) : "กรุณาลองใหม่";
    } 
    else{
        $return = get_stock($text.">"); //ใส่ให้เลย
        $txt = isset($return['txt']) ? trim($return['txt']) : "กรุณาลองใหม่";                        
    }
//    echo $txt;
//    header("Content-type: text/html; charset=utf-8");
//    echo json_encode(array('result'=>$txt));
    echo $txt;
    exit();
//    $rr = json_encode(array('result'=>$txt));
//    pr($rr);
//    $tt = json_decode($rr,TRUE);
//    pr($tt['result']);
//    
}

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init($url);

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json;']);
    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
?> 
