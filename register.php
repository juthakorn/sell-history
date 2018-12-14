<!DOCTYPE html>
<html>
    <?php require_once 'header.php' ?>
    <body>
        <div id="wrapper">
            
            
            
            
            
            
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">ศรีราชา เคลม เซอร์วิส</a>
                </div>
                <!-- /.navbar-header -->


                
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search"> 
                                <img src="image/logo.png">                                
                            </li>
                            <li>
                                <a href="index.php"><i class="fa fa-user fa-fw"></i> เข้าสู่ระบบ</a>
                            </li>    
                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>
            <div id="res"></div>
            <div id="page-wrapper" >

                <div class="row">

                    <div class="col-lg-12">
                        <h1 class="page-header">สมัครสมาชิก</h1>
                        <?php require_once 'message.php' ?>

                    </div>
                    <!-- /.col-lg-12 -->

                </div>
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class=" panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Registration Form</h3>
                            </div>
                            <div class="panel-body">
                                <div class="alert alert-danger" style="display:none">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <span>กรุณาป้อน ข้อมูลให้ครบ ด้วยค่ะ.</span>
                                </div>
                                <form class="form-horizontal" role="form" method="POST" id="frmregister" action="action.php?go=register">
                                    <!--<h2>Registration Form</h2>-->
                                    <div class="form-group">
                                        <label for="first_name" class="col-sm-3 control-label">ชื่อ</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="first_name" name="first_name" placeholder="ชื่อ" class="form-control" autofocus empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name" class="col-sm-3 control-label">นามสกุล</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="last_name" name="last_name" placeholder="นามสกุล" class="form-control" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3">เพศ</label>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="radio-inline">
                                                        <input type="radio" id="sex" name="sex" value="ชาย">ชาย
                                                    </label>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="radio-inline">
                                                        <input type="radio" id="sex" name="sex" value="หญิง">หญิง
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- /.form-group -->
                                    <div class="form-group">
                                        <label for="card_id" class="col-sm-3 control-label">เลขบัตรประชาชน</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="card_id" name="card_id"  maxlength="13" placeholder="เลขบัตรประชาชน" class="form-control num" empty="false">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="username" class="col-sm-3 control-label">Username</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="username" id="username" placeholder="Username" class="form-control" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password"  name="password" id="password" placeholder="Password" class="form-control" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password2" class="col-sm-3 control-label">Re-enter Password</label>
                                        <div class="col-sm-9">
                                            <input type="password"  name="password2" id="password2" placeholder="Re-enter Password" class="form-control" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="birth_date" class="col-sm-3 control-label">วัน/เดือน/ปี เกิด</label>
                                        <div class="col-sm-9">
                                            <input type="date" id="birth_date" name="birth_date" class="form-control" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address" class="col-sm-3 control-label">ที่อยู่</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="address" rows="3" empty="false"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tel" class="col-sm-3 control-label">ตำบล / แขวง</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="sub_district" name="sub_district" placeholder="ตำบล / แขวง" class="form-control" empty="false" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tel" class="col-sm-3 control-label">อำเภอ / เขต</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="district" name="district" placeholder="อำเภอ / เขต" class="form-control" empty="false" >
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="hospital_name">จังหวัด </label>
                                        <div class="col-sm-9"> 
                                            <select class="form-control" id="province_id" name="province_id" empty="false">
                                                <option value="" selected>--------- เลือกจังหวัด ---------</option>
                                                <?php 
                                                $provinces = $database->selects('province','order by province_name');
                                                foreach ($provinces as $key => $value) {?>
                                                <option value="<?=$value['province_id']?>"><?=$value['province_name']?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email" class="col-sm-3 control-label">Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" id="email" name="email" placeholder="Email" class="form-control" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="tel" class="col-sm-3 control-label">เบอร์โทร</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="tel" name="tel" placeholder="เบอร์โทร" class="form-control num" empty="false">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="license" class="col-sm-3 control-label">เลขที่ใบอนุญาติขับขี่</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="license" name="license" placeholder="เลขที่ใบอนุญาติขับขี่" class="form-control" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="license_date" class="col-sm-3 control-label">วันอนุญาตใบขับขี่</label>
                                        <div class="col-sm-9">
                                            <input type="date" id="license_date" name="license_date" placeholder="วันอนุญาตใบขับขี่" class="form-control" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="license_exp_date" class="col-sm-3 control-label">วันใบขับขี่หมดอายุ</label>
                                        <div class="col-sm-9">
                                            <input type="date" id="license_exp_date" name="license_exp_date" placeholder="วันใบขับขี่หมดอายุ" class="form-control" empty="false">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-9 col-sm-offset-3">
                                            <button type="submit"  class="btn btn-success btn-block">สมัครสมาชิก</button>
                                        </div>
                                    </div>

                                </form> <!-- /form -->
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /#page-wrapper -->

        </div>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                $('.num').blur(function () {
                    var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
                    if (!numberRegex.test($(this).val())) {
                        alert('กรุณากรอกเป็นตัวเลขเท่านั้น');
                        $(this).val("").focus();
                        return false;
                    }
                });
                $('#frmregister').submit(function () {
                    if(check()){
                         return true;
                    }else{
                        return false;
                    }
                    
                    
                });
                $('#frmregister').find('[empty="false"]').blur(function () {
                    var check = $(this).val();
                    if (check == '') {
                        $(this).css({'background-color': '#FFC0C0'});
                    } else {
                        $(this).css({'background-color': '#FFFFFF'});
                    }
                });
                // event when contact form is subbmitted

//                $('#btnsave').click(function(){
//                    check();
//                });
                function check() {


                    var requiredOk = true;

//                     check each required fields
                    $('#frmregister').find('[empty="false"]').each(function (index, obj) {

                        if ($(obj).val().length === 0) {
                            $(obj).css({'background-color': '#FFC0C0'});
                            requiredOk = false;
                        } else {
                            $(obj).css({'background-color': '#FFFFFF'});
                        }
                    });

                    // required fields fail
                    if (!requiredOk) {
                        $('.alert-danger').fadeIn(1000);
                        return false;
                    } else {
                        $('.alert-danger').fadeOut(1000);

                        if ($('#password').val() !== $('#password2').val()) {
                            alert('รฟัสผ่านไม่ตรงกันค่ะ');
                            $('#password').val('');
                            $('#password2').val('');
                            $('#password').focus();
                            return false;
                        }
//                       $.ajax({
//                           url: "action.php?go=register",
//                           type: "post",
//                           data : $("#frmregister").serialize(),
//                           success: function(ret)
//                           {
//                               $('#res').html(ret);
//                           }
//                        });
                        return true;
                    }
                }
            });
        </script>
        <?php require_once 'footer.php' ?>
    </body>
</html>

