<!DOCTYPE html>
<html>
    <?php require_once 'header.php' ?>
    <?php
    $data_sum = $database->select("sell a inner join sell_date b on a.sell_date_id = b.sell_date_id and a.status=1",
                    "where b.sell_date ='".$_GET['date']."' order by a.sell_id DESC",
            "a.*,sum(`profit`) as sum_profit,b.*"); 
    $sum = $data_sum['sum_profit'] - $data_sum['advertise'];
    
    $datas = $database->selects("sell a inner join sell_date b on a.sell_date_id = b.sell_date_id and a.status=1",
                    "where b.sell_date ='".$_GET['date']."' order by a.sell_id DESC"); 
    
                                        
    ?>
    <body>
        <div id="wrapper">
            <?php require_once 'menu.php' ?>
            <div id="res"></div>
            <div id="page-wrapper" >

                <div class="row">

                    <div class="col-lg-12">
                        <h1 class="page-header" style="display: inline-block">ประวัติการขายวันที่ <?=DThai_long($_GET['date'])?>   
                        <?php
                        if($sum < 0){
                            $txt = "( ขาดทุน <span style=\"color: #C50B05\">".$sum."</span> )";
                        }else{
                           $txt = "( กำไร <span style=\"color: #4cae4c\">".$sum."</span> )";
                        }
                        echo $txt;
                        ?>
                       </h1>
                        <a href="sell.php?sell_date=<?=$_GET['date']?>" class="btn btn-success plus"><i class="glyphicon glyphicon-plus"></i> เพิ่มการขาย</a>
                        
                        <a href="javascript:void(0)" class="btn btn-info plus" onclick="print('<?=$_GET['date']?>');" ><i class="glyphicon glyphicon-print"></i> พิมพ์</a>
                        <?php require_once 'message.php' ?>

                    </div>

                </div>
                <div class="row equalheight">
                    <?php foreach ($datas as $key => $data) {
                        
                        $sell_details = $database->selects("sell_detail", "where sell_id ='".$data['sell_id']."'"); 
                        $json_detail = !empty($sell_details) ? json_encode($sell_details) : "";
                        $all = $data['sell_id']."|".$data['sell_date_id']."|".$data['refer']."|".$data['name_refer']."|".$data['type_product']."|".$data['customer_name']."|".$data['customer_address']."|".$data['detail']
                                ."|".$data['profit']."|".$data['partner']."|".$data['customer_pay']."|".$data['customer_tumbon']."|".$data['customer_umpher']."|".$data['customer_province']
                                ."|".$data['customer_postal']."|".$data['customer_tel']."|".$data['type_pay']."|".$data['status_pay'];
                        ?>
                            
                    <div id="json_<?=$data['sell_id']?>" style=" display: none"><?=$json_detail?></div>
                    <div class="col-lg-6">                    
                        <div class="panel panel-primary">
                            <div class="panel-heading add-a">
                                คุณ <?=$data['customer_name']?>
                                
                                <a href="javascript:void(0)"  onclick="del('<?= $data['sell_id']; ?>','<?= $data['customer_name']; ?>')" class="btn glyphicon glyphicon-trash btn-danger add-aa"></a>
                                <button type="button" onclick="edit('<?= $data['sell_id']; ?>','<?=base64_encode($all)?>');" id="popup" class="btn glyphicon glyphicon-pencil btn-success add-aa" data-toggle="modal" data-target="#myModal"></button>
                                <input type="checkbox" name="chk[]" class="checkboxes add-aa" value="<?=$data['sell_id'];?>" />
                                
                            </div>
                            
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >แหล่งที่มา :</label>
                                        <label class="control-label col-sm-8" ><?=$data['refer']?></label>                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >ชื่อแหล่งที่มา :</label>
                                        <label class="control-label col-sm-8" ><?=$data['name_refer']?></label>  
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >ประเภทสินค้า :</label>
                                        <label class="control-label col-sm-8" ><?=$data['type_product']?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >ชื่อ - นามสกุล :</label>
                                        <label class="control-label col-sm-8" ><?=$data['customer_name']?></label>
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >ที่อยู่  :</label>
                                        <?php
                                        $txttombon = "ตำบล";
                                        $txtumpher = "อำเภอ";
                                        $txtprovince = "จังหวัด";
                                        if(preg_match("/กทม|กรุงเทพ/i", $data['customer_province'])){
                                            $txttombon = "แขวง";
                                            $txtumpher = "เขต";
                                            $txtprovince = "";
                                        }
                                        ?>
                                        <label class="control-label col-sm-8" ><?=$data['customer_address']." "?>
                                            <?= !empty($data['customer_tumbon']) ? $txttombon.$data['customer_tumbon']." " : ""; ?>
                                            <?= !empty($data['customer_umpher']) ? $txtumpher.$data['customer_umpher']." " : ""; ?>
                                            <?= !empty($data['customer_province']) ? "<br />".$txtprovince.$data['customer_province']." ".$data['customer_postal']." " : ""; ?>
                                            <?= !empty($data['customer_tel']) ? 'เบอร์โทร '.$data['customer_tel'] : ""; ?>
                                        </label>
                                    </div> 
                                    
                                        <?php
                                        $txt = empty($data['detail']) ? "" : $data['detail']."<br>";                                        
                                        if(!empty($sell_details)){
                                            foreach ($sell_details as $key => $value) {
                                                $txt .= $value['p_name']." ".$value['p_qty']." ตัว<br>";
                                            }
                                            
                                        }                                        
                                        ?>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >รายละเอียด  :</label>
                                        <label class="control-label col-sm-8" >
                                        
                                        <?= empty($txt) ? "" : substr($txt, 0, -4)?>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >ลูกค้าจ่าย :</label>
                                        <label class="control-label col-sm-8" ><?= empty($data['customer_pay']) ? "-" : $data['customer_pay']?></label>
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >กำไร  :</label>
                                        <label class="control-label col-sm-8" ><?=$data['profit']?></label>
                                    </div> 
                                    
                                    
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >แจ้งส่งร้าน  :</label>
                                        <label class="control-label col-sm-8" ><?=$data['partner']?></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >วิธีการชำระเงิน :</label>
                                        <label class="control-label col-sm-8" ><?= $data['type_pay'] == '1' ? "โอนเงิน" : "เก็บปลายทาง" ?></label>
                                    </div>
                                    <?php if($data['type_pay'] == '2') {?>
                                    <div class="form-group">
                                        <label class="control-label col-sm-4 text-right" >สถานะการชำระเงิน  :</label>
                                        <label class="control-label col-sm-8" >
                                        <?= $data['status_pay'] == '1' ? "<span style=\"color: green\">ชำระเงินเงินแล้ว</span>" : "<span style=\"color: red\">ยังไม่ชำระเงิน</span>" ?>
                                        </label>
                                    </div>
                                    <?php } ?>
                                    
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <?php } ?>    
                       
                </div>

            </div>
            <!-- /#page-wrapper -->

        </div>
        <?php require_once 'popup_form_sell.php' ?>
        <script type="text/javascript">
            function del(id,name){
                var selectedItems = new Array();
                $("input[name='chk[]']:checked").each(function() {selectedItems.push($(this).val());}).get().join(",");
                if(selectedItems != ''){                    
                    if(confirm('คุณต้องการลบประวัติการขายที่เลือกหรือไม่ ?')==true){
                    $.post('action.php?go=del_sell_all',{'sell_id':selectedItems},function(data){
                            $("#res").html(data);
                    });
                    }else{
                            return false;
                    }	
                }else{
                    if(confirm('คุณต้องการลบประวัติขาย คุณ' + name +' ใช่หรือไม่ ?')==true){
                        $.post('action.php?go=del_sell',{'sell_id':id},function(data){
                                $("#res").html(data);
                        });
                    }else{
                            return false;
                    }
                }	
            }
            
            
            function edit(id,value){
                
                var data = Base64.decode(value).split("|");
                
                
                $("#h_val_id").val(id); 
                $("#sell_date_id option[value='"+data[1]+"']").prop('selected', true);
                $("#refer option[value='"+data[2]+"']").prop('selected', true);
                
                $("#name_refer").val(data[3]);
//                $("#type_product").val(data[4]);
                $("#customer_name").val(data[5]);
                $("#customer_address").text(data[6]);
                $("#detail").val(data[7]);
                $("#profit").val(data[8]);
                $("#customer_tumbon").val(data[11]);
                $("#customer_umpher").val(data[12]);
                $("#customer_province").val(data[13]);
                $("#customer_postal").val(data[14]);
                $("#customer_tel").val(data[15]);
                $("#type_pay option[value='"+data[16]+"']").prop('selected', true).change();
                 $('#status_pay'+data[17]).prop("checked", true);
                jQuery("input:checkbox:checked").removeAttr("checked");

                var partner = new Array();
                partner = data[9].split(", ");
                for (let i = 0; i < partner.length; i++) { 
//                    alert(partner[i])
                    $(".checkboxs[value='"+partner[i]+"']").prop('checked', true);
                }
                
                var type_product = new Array();
                type_product = data[4].split(", ");
                for (let i = 0; i < type_product.length; i++) { console.log(type_product[i]);
//                    $(".checkboxs[value='"+type_product[i]+"']").attr("checked", "checked");
                    $(".checkboxs[value='"+type_product[i]+"']").prop('checked', true);
                }
                $("#customer_pay").val(data[10]);
                 
                 
                 
                $('#for-me').empty(); 
                $('#remove_sell_detail').val('');            
                var obj_sell;
                var json_sell = $('#json_'+id).text().trim();
                if(json_sell !== ""){
                    obj_sell = JSON.parse(json_sell);
                    
                                      
                }else{
                    obj_sell = [{'p_name':'','p_qty':'1'}];
                    
                }
                console.log(obj_sell);
                for (j = 0; j < obj_sell.length; j++) { 
                  
                    $('#for-me').append('<div class="form-group" id="product_sell_'+j+'" >'+                                
                        '<label class="control-label col-sm-2" for="detail">'+ (j === 0 ? "สินค้าร้านตัวเอง" : "") +'</label>'+
                        '<div class="col-sm-4"> '+
                                '<input type="text" class="form-control" id="p_name_'+j+'" onkeyup="autocom($(this))" name="p_name[]"  value="'+obj_sell[j].p_name+'"> '+ 
                        '</div>'+
                        '<div class="col-sm-1">'+ 
                                '<input type="text" class="form-control num" id="p_qty_'+j+'" name="p_qty[]" value="'+obj_sell[j].p_qty+'" empty="false">'+
                        '</div>'+
                        (j === 0 ?
                            '<div class="col-sm-2" style="margin-top: 1px;">' +
                                '<a href="javascript:void(0)" onclick="addpro()" class="btn glyphicon glyphicon-plus btn-success"><i></i></a>'+
                            '</div>'
                        : 
                            '<div class="col-sm-2" style="margin-top: 1px;">'+ 
                                '<a href="javascript:void(0)" onclick="delpro(\'product_sell_'+j+'\')" class="btn glyphicon glyphicon-trash btn-danger"><i></i></a>'+
                            '</div>'    
                        )
                       +
                    '</div>');
                }  
               
            }

            jQuery(document).ready(function () {                 
                $('.num').blur(function () {                    
                    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
                    if (!numberRegex.test($(this).val()) && $(this).val().length > 0) {
                        alert('กรุณากรอกเป็นตัวเลขเท่านั้น');
                        $(this).val("").focus();
                        return false;
                    }
                });
                
                 $('#frmsell input:text, input:password, textarea, select').blur(function(){
                    var check = $(this).val();
                    if(check == ''){
                          $(this).css({'background-color':'#FFC0C0'});
                    }else{
                          $(this).css({'background-color':'#FFFFFF'});  
                    }
                });
                // event when contact form is subbmitted
                $("#btnsave").click(function(){

                    var requiredOk = true;

//                     check each required fields
                        $('#frmsell').find('[empty="false"]').each(function (index, obj) { 
                            
                            if($(obj).val().length === 0) {
                                $(obj).css({'background-color':'#FFC0C0'});  
                                requiredOk = false;
                             }else{
                                $(obj).css({'background-color':'#FFFFFF'});
                             }
                        });
                        
                        var checked = $("#frmsell input:checked").length > 0;
                        if (!checked){
                            requiredOk = false;
                        }
                        
                    // required fields fail
                    if (!requiredOk) {
                        $('.alert-danger').fadeIn(1000);
			return false;
                    }else {
                        $('.alert-danger').fadeOut(1000);
                            $.ajax({
                               url: "action.php?go=edit_sell",
                               type: "post",
                               data : $("#frmsell").serialize(),
                               success: function(ret)
                               {
                                   $('#res3').html(ret);
                               }
                            });
                        return true;
                    }
                });
            });
            
    equalheight = function(container){

        var currentTallest = 0,
             currentRowStart = 0,
             rowDivs = new Array(),
             $el,
             topPosition = 0;
        $(container).each(function() {

            $el = $(this);
            $($el).height('auto')
            topPostion = $el.position().top;

            if (currentRowStart != topPostion) {
             for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
               rowDivs[currentDiv].height(currentTallest);
            }
             rowDivs.length = 0; // empty the array
             currentRowStart = topPostion;
             currentTallest = $el.height();
             rowDivs.push($el);
            } else {
             rowDivs.push($el);
             currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
           for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
             rowDivs[currentDiv].height(currentTallest);
           }
        });
    }
    
    $(window).load(function() {
      equalheight('.equalheight .col-lg-6');
    });
    
    
    function print(date){
//        alert('print');
        var selectedItems = new Array();
                $("input[name='chk[]']:checked").each(function() {
                    selectedItems.push($(this).val());
                }).get().join(",");
        var sell_id = selectedItems.join("-");        
        
        if(sell_id !== ""){  
            window.open('print.php?p&date=' +date+'&sell_id='+sell_id, '_blank');  
        }else{
            window.open('print.php?p&date=' +date, '_blank');    
        }
    }

        </script>
        <?php require_once 'footer.php' ?>
    </body>
</html>

