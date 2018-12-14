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
    $chk = $database->num_rows("sell","where customer_name='".$_POST['customer_name']."' and sell_date_id = '".$_POST['sell_date_id']."'");
    
    if($chk == 0){
        $arr = array(
            'sell_date_id'=> $_POST['sell_date_id'],
            'refer'=> $_POST['refer'],
            'name_refer'=> $_POST['name_refer'],
            'type_product'=> implode(", ", $_POST['type_product']),
            'customer_name'=> $_POST['customer_name'],
            'customer_address'=> $_POST['customer_address'],
            'customer_tumbon'=> $_POST['customer_tumbon'],
            'customer_umpher'=> $_POST['customer_umpher'],
            'customer_province'=> $_POST['customer_province'],
            'customer_postal'=> $_POST['customer_postal'],
            'customer_tel'=> $_POST['customer_tel'],
            'detail' => $_POST['detail'],
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
        
    $chk = $database->num_rows("sell","where customer_name='".$_POST['customer_name']."' and sell_date_id = '".$_POST['sell_date_id']."' and sell_id != '".$_POST['h_val_id']."'");
    if($chk == 0){
        $arr_update = array(
            'sell_date_id'=> $_POST['sell_date_id'],
            'refer'=> $_POST['refer'],
            'name_refer'=> $_POST['name_refer'],
            'type_product'=> implode(", ", $_POST['type_product']),
            'customer_name'=> $_POST['customer_name'],
            'customer_address'=> $_POST['customer_address'],
            'customer_tumbon'=> $_POST['customer_tumbon'],
            'customer_umpher'=> $_POST['customer_umpher'],
            'customer_province'=> $_POST['customer_province'],
            'customer_postal'=> $_POST['customer_postal'],
            'customer_tel'=> $_POST['customer_tel'],
            'customer_pay' => $_POST['customer_pay'],
            'detail' => $_POST['detail'],
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
    /*$_POST['txt'] = 'บันทึก-
            ช-สุรีย์ฉาย นามบุญ  
            ส-7/252 ม.6 บริษัทฟิชเชอร์แอนด์พายเคิ้ล นิคมอุตสาหกรรมอมตะซิตี้ ต-มาบยางพร อ-ปลวกแดง จ-ระยอง 21140
            ร-โปโลกรมริ้วขาว,D-F,L,กรมริ้วเหลืองเล็ก,D-S,L15,กรมแขนกุดปลาวาฬ,D-F2,F2 
            รบ-ดำหัวใจ,D-SLong2,L,กรมริ้วเหลือง,D-S,L';
            */
    $str = trim($txt);
    $str = preg_replace('/ช[-|:]/', '|ช:', $str);
    $str = preg_replace('/ส[-|:]/', '|ส:', $str);
    $str = preg_replace('/ต[-|:]/', '|ต:', $str);
    $str = preg_replace('/อ[-|:]/', '|อ:', $str);
    $str = preg_replace('/จ[-|:]/', '|จ:', $str);
    $str = preg_replace('/ท[-|:]/', '|ท:', $str);
    $str = preg_replace('/ร[-|:]/', '|ร:', $str);
    $str = preg_replace('/รบ[-|:]/', '|รบ:', $str);
    $arr_str = explode('|', $str);
    pr($arr_str);
    $data = array();
    foreach ($arr_str as $key => $value) {
         
        preg_match('/(ช|ส|ต|อ|จ|ท|ร|รบ):/i', $value, $match );
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
        $text_err = "ไม่มีแท็กที่อยู่ ส ตามด้วย - หรือ : \nเช่น ส-99/99 หมู่ 9 ถนนสวยงาม  \nกรุณาลองใหม่...!";
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
    }
    //return Error
    if(!empty($text_err)){
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
            $product = $database->select("products",  "where text_search = '" .$value['name'].$value['size']."'"); 
            
            if(empty($product)){
                $text_empty['not_found'][] = $value['name']."";
            }else if ($product['qty'] < $value['qty']) {
                $text_empty['out_stock'][] = $product['name'];                
            }else{
                $tempproduct_me[$key]['p_name'] = $product['name'];
                $data['txt_detail_me'] .= $product['name']." ". $value['qty']." ตัว\n";
            }
        }
        pr($tempproduct_me);
    }
    if(!empty($text_empty)){
        pr($text_empty);   
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
    $temp_sell  = $database->select("sell",  "where created like '".date('Y-m')."%' and confirm_code != '' and confirm_code IS NOT NULL order by created DESC");
    pr($temp_sell);
    
    if(empty($temp_sell)){
        $confirm_code = date('ym')."001";
    }else{
        $confirm_code = $temp_sell['confirm_code']+1;
    }
    $insert_sell = array(
        'type_product' => 'เสื้อคู่',
        'sell_date_id' => $sell_date_id,
        'customer_name' => $data['customer_name'],
        'customer_address' => $data['customer_address'],
        'customer_tumbon' => @$data['customer_tumbon'],
        'customer_umpher' => $data['customer_umpher'],
        'customer_province' => $data['customer_province'],
        'customer_postal' => $data['customer_postal'],
        'customer_tel' => @$data['customer_tel'],
        'detail' => $data['txt_detail'],
        'created' =>date('Y-m-d h:i:s'),
        'modified' =>date('Y-m-d h:i:s'),
        'status' => 0,
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

    $txttombon = "ตำบล";
    $txtumpher = "อำเภอ";
    if(preg_match("/กทม|กรุงเทพ/i", $data['customer_province'])){
        $txttombon = "แขวง";
        $txtumpher = "เขต";
    }

    $txt_return = "จัดส่ง\nคุณ". $data['customer_name']."\n"
        . $data['customer_address']. (!empty($data['customer_tumbon']) ? " ".$txttombon.":".$data['customer_tumbon']: "")." "
        . $txtumpher.":".$data['customer_tumbon']." "
        . "\nจังหวัด:".$data['customer_province']." ". $data['customer_postal']
        . (!empty($data['customer_tel']) ? "\nโทร:".$data['customer_tel']: "")
        . (!empty($data['txt_detail']) ? "\n\nรายการชุดร้านอื่น\n".$data['txt_detail'] : "")
        . (!empty($data['txt_detail_me']) ? "\n\nรายการชุดร้านตัวเอง\n".$data['txt_detail_me'] : "")
        . "\n\nเลขที่ใบยืนยัน : CF".$confirm_code ."
        ";
        pr($txt_return);
    pr($data);
    pr($sell_id);
    return $txt_return;
}

function confirm($txt){
     return 'บันทึกสำเร็จ...!';
}

function confirm__($txt){
    global $database;
    $txt = "CF17030013";
    
    $confirm_code = substr($txt, 2);
    pr($confirm_code);
    
    $temp_sell  = $database->select("sell",  "where confirm_code = '".$confirm_code."' and status = 0");
    if(!empty($temp_sell)){
        pr($temp_sell);
        
        

        $sell_detail  = $database->selects("sell_detail",  "where sell_id = ".$temp_sell['sell_id']);
        
        if(!empty($sell_detail)){
            pr($sell_detail);

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
                 pr($text_empty);   
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
        
        pr('บันทึก สำเร็จ');
        return 'บันทึก สำเร็จ';
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
       if(preg_match('/^[a-zA-Z][1-9]?/', $value)){
            $size = $value;
            $qty = 1;
            if(preg_match('/[1-9]{1,}$/', $value,$match)){
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
        $return['txt'] = 'ไม่พบรายการหรือสินค้าหมด...!';
        $return['count'] = 0;
    }else{        
        foreach ($products as $key => $value) {
            $return['txt'] .= $value['name'] . " เหลือ " .  $value['qty'] . " ตัว\n";            
        }
        $return['count'] = sizeof($products);
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
                    if(preg_match('/บันทึก[-|:]/i', $text)){
                        $return = save_sell_temp($text);
                        $txt = trim($return);
                    }
                    else if(preg_match('/^cf/i', $text)){
                        $return = confirm($text);
                        $txt = trim($return);
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
                            'type' => 'text',
                            'text' => $txt
                    ];

                    // Make a POST Request to Messaging API to reply to sender
                    $url = 'https://api.line.me/v2/bot/message/reply';
                    $data = [
                            'replyToken' => $replyToken,
                            'messages' => [$messages],
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
?> 
