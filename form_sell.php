<div class="panel-body">
    <div id="res3" ></div>
    <?php $get_date = @$_GET['sell_date'];
    if(empty($get_date)){
        $get_date = @$_GET['date'];
    }
    ?>
    <form class="form-horizontal" role="form" id="frmsell">
        <div class="form-group">
            <label class="control-label col-sm-2" for="sell_date_id">วันที่ <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <select class="form-control" id="sell_date_id" name="sell_date_id" empty="false">
                    <option value="" selected>--------- เลือกวันที่ ---------</option>
                    <?php
                    $provinces = $database->selects('sell_date', 'order by sell_date DESC limit 7');
                    $found = FALSE;
                    foreach ($provinces as $key => $value) {  if($get_date == $value['sell_date']) $found = TRUE;
                        ?>
                    <option value="<?= $value['sell_date_id'] ?>" <?= $get_date == $value['sell_date'] ? "selected" : ""?> ><?= $value['sell_date'] ?></option>
                    <?php } ?>
                    <?php if(!$found){
                        $dateeee = $database->select('sell_date', 'where sell_date = "'.$get_date.'" order by sell_date DESC limit 7');
                        ?>
                        <option value="<?= $dateeee['sell_date_id'] ?>" selected><?= $dateeee['sell_date'] ?></option>
                    
                    <?php }?>
                </select>
            </div>
        </div>



        <div class="form-group">
            <label class="control-label col-sm-2" for="refer">แหล่งที่มา <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <select class="form-control" id="refer" name="refer" empty="false">
                    <option value="" selected>---- เลือกแหล่งที่มา ----</option>
                    <option value="Facebook" >Facebook</option>
                    <option value="Line" >Line</option>
                    <option value="Welove" >Welove</option> 
                    <option value="Shopee" >Shopee</option>                                               
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name_refer">ชื่อแหล่งที่มา <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control" id="name_refer" name="name_refer" empty="false">
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-sm-2" for="type_product">ประเภทสินค้า <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="checkboxs" name="type_product[]" value="เสื้อคู่" checked="">เสื้อคู่
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="checkboxs"  name="type_product[]" value="รองเท้า">รองเท้า                                                </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="customer_name">ชื่อ - นามสกุล <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control" id="customer_name" name="customer_name" empty="false">
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-sm-2" for="customer_address">ที่อยู่ <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <textarea class="form-control" name="customer_address" id="customer_address" empty="false" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="customer_tumbon">ตำบล :</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control" id="customer_tumbon" name="customer_tumbon" >
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="customer_umpher">อำเภอ <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control" id="customer_umpher" name="customer_umpher" empty="false">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="customer_province">จังหวัด <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control" id="customer_province" name="customer_province" empty="false">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="customer_postal">รหัสไปรษณีย์ <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control" id="customer_postal" name="customer_postal" empty="false">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="customer_tel">เบอร์โทร :</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control" id="customer_tel" name="customer_tel" >
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="detail">รายละเอียด  :</label>
            <div class="col-sm-10"> 
                <textarea class="form-control" name="detail" id="detail"  rows="3"></textarea>
            </div>
        </div>
        <div id="for-me">
            <div class="form-group " id="product_sell_0">
                <label class="control-label col-sm-2" for="detail">สินค้าร้านตัวเอง  :</label>
                <div class="col-sm-4"> 
                    <input type="text" class="form-control" id="p_name_0" name="p_name[]" > 
                </div>
                <div class="col-sm-1"> 
                    <input type="text" class="form-control num" id="p_qty_0" name="p_qty[]" value="1" >
                </div>
                <div class="col-sm-2" style="margin-top: 1px;"> 
                    <a href="javascript:void(0)" onclick="addpro()" class="btn glyphicon glyphicon-plus btn-success"><i></i></a>
                </div>
            </div>
            
            
<!--            <div class="form-group" id="product_sell_1" >
                <label class="control-label col-sm-2" for="detail"></label>
                <div class="col-sm-4"> 
                        <input type="text" class="form-control num" id="customer_pay" name="customer_pay" empty="false"> 
                </div>
                <div class="col-sm-1"> 
                        <input type="text" class="form-control num" id="customer_pay" name="customer_pay" empty="false">
                </div>
                <div class="col-sm-2" style="margin-top: 1px;"> 
                    <a href="javascript:void(0)" onclick="delpro('product_sell_1')" class="btn glyphicon glyphicon-trash btn-danger"><i></i></a>
                </div>
            </div>-->
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="type_pay">วิธีการชำระเงิน <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <select class="form-control" id="type_pay" name="type_pay" empty="false" >
                    <option value="1" selected>โอนเงิน</option>
                    <option value="2" >เก็บปลายทาง</option>                                               
                </select>
            </div>
        </div>
        
        <div class="form-group" id="box_status_pay" style="display:none ">
            <label class="control-label col-sm-2" for="status_pay">สถานะการชำระเงิน  :</label>
            <div class="col-sm-10"> 
                <div class="radio">
                    <label>
                        <input type="radio" name="status_pay" id="status_pay1" value="1" checked="">ชำระเงินเงินแล้ว
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="status_pay" id="status_pay2" value="2">ยังไม่ชำระเงิน
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="customer_pay">ลูกค้าจ่าย <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control num" id="customer_pay"  name="customer_pay" empty="false">
            </div>
        </div> 
        <div class="form-group">
            <label class="control-label col-sm-2" for="profit">กำไร <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <input type="text" class="form-control num" id="profit" name="profit" empty="false">
            </div>
        </div> 

        <!--                                    <div class="form-group">
                                    <label class="control-label col-sm-2" for="advertise">ค่าโฆษณา <span style="color:#d9534f"> *</span> :</label>
                                    <div class="col-sm-10"> 
                                        <input type="text" class="form-control num" id="advertise" name="advertise" empty="false">
                                    </div>
                                </div>-->


        <div class="form-group">
            <label class="control-label col-sm-2" for="partner">แจ้งส่งร้าน <span style="color:#d9534f"> *</span> :</label>
            <div class="col-sm-10"> 
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="checkboxs" id="partner0" name="partner[]" value="ส่งเอง">ส่งเอง
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="checkboxs" id="partner1" name="partner[]" value="พี่บอม">พี่บอม
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"  class="checkboxs" id="partner2" name="partner[]" value="nefer house">nefer house
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"  class="checkboxs" id="partner6" name="partner[]" value="Begin Again">Begin Again
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"  class="checkboxs" id="partner7" name="partner[]" value="Little Love">Little Love
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="checkboxs" id="partner3" name="partner[]" value="cat">Cat
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="checkboxs" id="partner4" name="partner[]" value="พี่นาถ">พี่นาถ
                    </label>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="checkboxs" id="partner5" name="partner[]" value="I-SHOP">I-SHOP
                    </label>
                </div>
            </div>
        </div>


        <div class="form-group"> 
            <div class="col-sm-offset-2 col-sm-10">
                <button type="button" id="btnsave" class="btn btn-success">บันทึก</button>
                <button type="reset" id="reset" class="btn btn-danger">ยกเลิก</button>
            </div>
        </div>
        <input name="h_val_id" type="hidden" id="h_val_id" value="" >
        <input name="remove_sell_detail" type="hidden" id="remove_sell_detail" value="" >
    </form>
</div>
<?php
$products = $database->selects('products', 'order by name');
$txt_arr = "";
foreach ($products as $key => $value) {
    $txt_arr .= '"'.addslashes($value['name']).'",';
}
?>
<script>
    var availableTags = [<?=$txt_arr?>];
    var count_sell_product = 99;
    function addpro(){
        $('#for-me').append('<div class="form-group" id="product_sell_'+count_sell_product+'" >'+
                    '<label class="control-label col-sm-2" for="detail"></label>'+
                    '<div class="col-sm-4"> '+
                            '<input type="text" class="form-control" id="p_name_'+count_sell_product+'" onkeyup="autocom($(this))" name="p_name[]" empty="false"> '+ 
                    '</div>'+
                    '<div class="col-sm-1">'+ 
                            '<input type="text" class="form-control num" id="p_qty_'+count_sell_product+'" name="p_qty[]" value="1" empty="false">'+
                    '</div>'+
                    '<div class="col-sm-2" style="margin-top: 1px;">'+ 
                        '<a href="javascript:void(0)" onclick="delpro(\'product_sell_'+count_sell_product+'\')" class="btn glyphicon glyphicon-trash btn-danger"><i></i></a>'+
                    '</div>'+
                '</div>');
        count_sell_product++;
       
    }

    function delpro(id_tarket,id){
        $('#'+id_tarket).remove();        
    }
    
    function autocom(target){
        $(target).autocomplete({
            source: availableTags,
            change: function(event,ui){
                //console.log(ui.item);
              $(this).val((ui.item ? ui.item.value : ""));
            }
        });
    }
    
    $( "#p_name_0" ).autocomplete({
      source: availableTags,
      change: function(event,ui){
          //console.log(ui.item);
        $(this).val((ui.item ? ui.item.value : ""));
      }
    });
    
    
    $('#type_pay').change(function(){ 
       if($(this).val() == '2'){
           $('#box_status_pay').show();
           $('#status_pay2').prop("checked", true);
       }else{          
           $('#box_status_pay').hide();
           $('#status_pay1').prop("checked", true);
       } 
    });
</script>