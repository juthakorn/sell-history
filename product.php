<!DOCTYPE html>
<html>
    <?php require_once 'header.php' ?>
    <body>
        <div id="wrapper">
            <?php require_once 'menu.php' ?>
            <div id="res"></div>
            <div id="page-wrapper" >

                <div class="row">

                    <div class="col-lg-12">
                        <h1 class="page-header">เพิ่มสินค้า</h1>
                        <?php require_once 'message.php' ?>

                    </div>
                    <!-- /.col-lg-12 -->

                </div>
                <div class="row">
                    <div class="col-lg-12">                    
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                ฟอร์มเพิ่มสินค้า
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="alert alert-danger" style="display:none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <span>กรุณาป้อน ข้อมูลให้ครบ ด้วยค่ะ.</span>
                                </div>

                                <form class="form-horizontal" role="form" id="frmpro" method="POST">

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="p_id">รหัสสินค้า <span style="color:#d9534f"> *</span> :</label>
                                        <div class="col-sm-10"> 
                                            <input type="text" class="form-control" id="p_id" name="p_id" empty="false">
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="name">ชื่อสินค้า <span style="color:#d9534f"> *</span> :</label>
                                        <div class="col-sm-10"> 
                                            <input type="text" class="form-control" id="name" name="name" empty="false">
                                        </div>
                                    </div> 
                                    
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="size">ไซส์ <span style="color:#d9534f"> *</span> :</label>
                                        <div class="col-sm-10"> 
                                            <input type="text" class="form-control" id="size" name="size" empty="false">
                                        </div>
                                    </div> 

                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="qty">จำนวน<span style="color:#d9534f"> *</span> :</label>
                                        <div class="col-sm-10"> 
                                            <input type="text" class="form-control num" id="qty" name="qty" empty="false">
                                        </div>
                                    </div> 


                                    <div class="form-group"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="button" id="btnsave" class="btn btn-success">บันทึก</button>
                                            <button type="reset" id="reset" class="btn btn-danger">ยกเลิก</button>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success hide">ddd</button>
                                    <input name="h_val_id" type="hidden" id="h_val_id" value="">
                                </form>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>

                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                ข้อมูลวันที่ขาย
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="table-result-scroll">
                                    <table class="table table-striped table-bordered table-hover" id="tb_pang2">
                                        <thead>
                                            <tr class='alert alert-success'>
                                                <th style="text-align:center">รหัสสินค้า</th>
                                                <th style="text-align:center">ชื่อสินค้า</th>
                                                <th style="text-align:center">จำนวน</th>
                                                <th style="text-align:center">แก้ไข</th>
                                                <th style="text-align:center">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $results = $database->selects("products","where 1 =1 order by position DESC");                                            
                                            foreach ($results as $key => $result) {
                                                $val = $result['id'] . "|" . $result['p_id']. "|" . $result['name']. "|" . $result['qty']. "|" . $result['size'];
                                                ?>
                                                <tr class="gradeX" style="cursor:pointer;" >
                                                    <td style="text-align:center"><?= $result['p_id']; ?></td>
                                                    <td><?= $result['name']; ?></td>
                                                    <td style="text-align:center"><?= $result['qty']; ?></td>
                                                    <td style="text-align:center"><a  href="javascript:void(0)"  onclick="edit('<?= $result['id']; ?>','<?=$val?>')" class="btn glyphicon glyphicon-pencil btn-success"><i></i></a></td>
                                                    <td style="text-align:center"><a href="javascript:void(0)"  onclick="del('<?= $result['id']; ?>','<?= $result['name']; ?>')" class="btn glyphicon glyphicon-trash btn-danger"><i></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div> 
                       
                </div>

            </div>
            <!-- /#page-wrapper -->

        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                
                
                 $('#frmpro input:text, input:password, textarea, select').blur(function(){
                    var check = $(this).val();
                    if(check == ''){
                          $(this).css({'background-color':'#FFC0C0'});
                    }else{
                          $(this).css({'background-color':'#FFFFFF'});  
                    }
                });
                $("#frmpro").submit(function(){
                    action();
                    return false;
                });
                // event when contact form is subbmitted
                $("#btnsave").click(function(){
                    action();
                    
                });
            });
            
            $('.num').blur(function () {
                var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
                if (!numberRegex.test($(this).val()) && $(this).val().length > 0) {
                    alert('กรุณากรอกเป็นตัวเลขเท่านั้น');
                    $(this).val("").focus();
                    return false;
                }
            });
            
            
            function action(){
                var requiredOk = true;

//                  check each required fields
                $('#frmpro').find('[empty="false"]').each(function (index, obj) { 

                    if($(obj).val().length === 0) {
                        $(obj).css({'background-color':'#FFC0C0'});  
                        requiredOk = false;
                     }else{
                        $(obj).css({'background-color':'#FFFFFF'});
                     }
                });




                // required fields fail
                if (!requiredOk) {
                    $('.alert-danger').fadeIn(1000);
                    return false;
                }else {
                    $('.alert-danger').fadeOut(1000);
                    var chk_action = $("#h_val_id").val();
                    if(chk_action == ''){
                        //add                           
                        $.ajax({
                           url: "../action.php?go=add_product",
                           type: "post",
                           data : $("#frmpro").serialize(),
                           success: function(ret)
                           {
                               $('#res2').html(ret);
                           }
                        });
                    }else{
                        $.ajax({
                           url: "../action.php?go=edit_product",
                           type: "post",
                           data : $("#frmpro").serialize(),
                           success: function(ret)
                           {
                               $('#res2').html(ret);
                           }
                        });
                    }

                    return true;
                }
            }
            
            function del(id,name){
                if(confirm('คุณต้องการลบข้อมูล ' + name +' ใช่หรือไม่ ?')==true){
                $.post('action.php?go=del_product',{'id':id},function(data){
                    $("#res").html(data);
                });
                }else{
                        return false;
                }	
            }
                
            function edit(id,value){
                var data = value.split("|");
                //alert(data);
                $("#h_val_id").val(id);
                $("#p_id").val(data[1]);
                $("#name").val(data[2]);
                $("#qty").val(data[3]);
                
                $("#size").val(data[4]);
                

                $('body,html').animate({
                    scrollTop: 0
                }, 500);
                return false;

            }
                
                
        </script>
        <?php require_once 'footer.php' ?>
    </body>
</html>

