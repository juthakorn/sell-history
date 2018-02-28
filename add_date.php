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
                        <h1 class="page-header">เพิ่มวันที่ขาย</h1>
                        <?php require_once 'message.php' ?>

                    </div>
                    <!-- /.col-lg-12 -->

                </div>
                <div class="row">
                    <div class="col-lg-12">                    
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                เพิ่มวันที่ขาย
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div class="alert alert-danger" style="display:none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <span>กรุณาป้อน ข้อมูลให้ครบ ด้วยค่ะ.</span>
                                </div>
                                <form class="form-horizontal" role="form" id="frmsellDate">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="sell_date">วันที่ <span style="color:#d9534f"> *</span> :</label>
                                        <div class="col-sm-10"> 
                                            <input type="date" class="form-control" id="sell_date" name="sell_date" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="advertise">ค่าโฆษณา <span style="color:#d9534f"> *</span> :</label>
                                        <div class="col-sm-10"> 
                                            <input type="text" class="form-control num" id="advertise" name="advertise" empty="false">
                                        </div>
                                    </div> 
                                    <div class="form-group"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="button" id="btnsave" class="btn btn-success">บันทึก</button>
                                            <button type="reset" id="reset" class="btn btn-danger">ยกเลิก</button>
                                        </div>
                                    </div>
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
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="tb_pang2">
                                        <thead>
                                            <tr class='alert alert-success'>
                                                <th style="text-align:center">วันที่ขาย</th>
                                                <th style="text-align:center">ค่าโฆษณา</th>
                                                <th style="text-align:center">แก้ไข</th>
                                                <th style="text-align:center">ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $results = $database->selects("sell_date","where 1 =1 order by sell_date DESC");                                            
                                            foreach ($results as $key => $result) {
                                                $val = $result['sell_date_id'] . "|" . $result['sell_date']. "|" . $result['advertise'];
                                                ?>
                                                <tr class="gradeX" style="cursor:pointer;" >
                                                    <td style="text-align:center"><?= $result['sell_date']; ?></td>
                                                    <td><?= $result['advertise']; ?></td>
                                                    <td style="text-align:center"><a  href="javascript:void(0)"  onclick="edit('<?= $result['sell_date_id']; ?>','<?=$val?>')" class="btn glyphicon glyphicon-pencil btn-success"><i></i></a></td>
                                                    <td style="text-align:center"><a href="javascript:void(0)"  onclick="del('<?= $result['sell_date_id']; ?>','<?= $result['sell_date']; ?>')" class="btn glyphicon glyphicon-trash btn-danger"><i></i></a></td>
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
            function del(id,name){
                if(confirm('คุณต้องการลบข้อมูล ' + name +' ใช่หรือไม่ ?')==true){
                    $.post('action.php?go=del_date',{'sell_date_id':id},function(data){
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
                $("#sell_date").val(data[1]);
                $("#advertise").val(data[2]);
				
                $.post('action.php?go=chk_date',$("#frmsellDate").serialize(),function(data){
                        $("#res").html(data);
                });
                $('body,html').animate({
                    scrollTop: 0
                }, 500);
                return false;

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
                
                 $('#frmsellDate input:text, input:password, textarea, select').blur(function(){
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
                        $('#frmsellDate').find('[empty="false"]').each(function (index, obj) { 
                            
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
                               url: "action.php?go=add_date",
                               type: "post",
                               data : $("#frmsellDate").serialize(),
                               success: function(ret)
                               {
                                   $('#res').html(ret);
                               }
                            });
                        }else{
                            $.ajax({
                               url: "action.php?go=edit_date",
                               type: "post",
                               data : $("#frmsellDate").serialize(),
                               success: function(ret)
                               {
                                   $('#res').html(ret);
                               }
                            });
                        }
                        
                        return true;
                    }
                });
            });
        </script>
        <?php require_once 'footer.php' ?>
    </body>
</html>

