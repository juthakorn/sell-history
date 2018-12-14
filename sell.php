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
                        <h1 class="page-header">เพิ่มการขาย</h1>
                        <?php require_once 'message.php' ?>

                    </div>
                    <!-- /.col-lg-12 -->

                </div>
                <div class="row">
                    <div class="col-lg-12">                    
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                ฟอร์มเพิ่มการขาย
                            </div>
                            <!-- /.panel-heading -->
                            <?php require_once 'form_sell.php' ?>
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
                $('.num').blur(function () {
                    if($(this).val() != ""){
                        var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
                        if (!numberRegex.test($(this).val()) && $(this).val().length > 0) {
                            alert('กรุณากรอกเป็นตัวเลขเท่านั้น');
                            $(this).val("").focus();
                            return false;
                        }
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
                        //add                           
                        $.ajax({
                           url: "../action.php?go=add_sell",
                           type: "post",
                           data : $("#frmsell").serialize(),
                           success: function(ret)
                           {
                               $('#res2').html(ret);
                           }
                        });                        
                        
                        return true;
                    }
                });
            });
        </script>
        <?php require_once 'footer.php' ?>
    </body>
</html>

