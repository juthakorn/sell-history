<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>ศรีราชา เคลม เซอร์วิส</title>

        <!-- Core CSS - Include with every page -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- SB Admin CSS - Include with every page -->
        <link href="css/sb-admin.css" rel="stylesheet">

    </head>

    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <div id="res"></div>
                            <form class="login-form" action="" method="post" id="frmlogin" role="form" >
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Username" name="username" type="text" autofocus id="username" >
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Password" name="password" type="password" value="" onkeypress="return runScript(event)" id="password">
                                    
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" value="on">Remember Me
                                        </label>
                                    </div>
                                    <!-- Change this to a button or input when using this as a form -->
                                    <button type="submit" class="btn btn-lg btn-success btn-block" id="login">
                                        Login
                                    </button>  
                                    <div class="form-group">
                                        <div class="control">
                                            <div style="padding-top:15px; font-size:85%" >
                                                Don't have an account! 
                                                <a href="register.php" >Sign Up Here</a>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Core Scripts - Include with every page -->
        <script src="js/jquery-1.10.2.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script type="text/javascript" src="js/jquery.validate.min.js"></script>
        <!-- SB Admin Scripts - Include with every page -->
        <script src="js/sb-admin.js"></script>

    </body>
    <script type="text/javascript">
        function runScript(e) {
            if (e.keyCode == 13) {
               $("#login").click();
            }
        }
        $(function () {
            $("#frmlogin").validate({
                errorElement: 'label',
                errorClass: 'help-inline',
                focusInvalid: false,
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    remember: {
                        required: false
                    }
                },
                messages: {
                    username: {
                        required: "กรุณาป้อน Username ด้วยครับ."
                    },
                    password: {
                        required: "กรุณาป้อน Password ด้วยครับ."
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                success: function (element) {
                    element.closest('.form-group').removeClass('has-error');
                    element.remove();
                },
                submitHandler: function (form) {
                    			$.post("action_signin.php?go=signin",$("#frmlogin").serialize(),function(data){
                    				$("#res").html(data);
                    				//$(".loading").html('');
                    			});
                    console.log("Test");
                }
            });
            $('#frmlogin input:text, input:password, textarea, select').blur(function () {
                var check = $(this).val();
                if (check == '') {
                    $(this).css({'background-color': '#FFC0C0'});
                } else {
                    $(this).css({'background-color': '#FFFFFF'});
                }
            });
            
        });
    </script>
</html>
