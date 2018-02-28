<?PHP

error_reporting(E_ALL);
session_start();
include "include/connect.php";


$go = $_GET['go'];
if ($go === 'signin') {
    signIn();
}

function signIn() {
    
    global $database;
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $chk = (isset($_POST['remember']) ? $_POST['remember'] : '');
    //เช็ค user และ password จาก ฟอร์ม
    if ((!empty($username)) and ( !empty($password)) or $password == '') {
        
        $sql = sprintf("select * from register where username='%s' and password='%s'", mysqli_real_escape_string($database->get_conn(),$username), mysqli_real_escape_string($database->get_conn(),$password));
      
        $num_rows = $database->num_rows_bysql($sql);
        
        if ($num_rows != 0) {
            $row = $database->select("register", "where username='$username'");
            
            $_SESSION['id'] = $row['register_id'];
            $_SESSION["username"] = $row['username'];
            $_SESSION["first_name"] = $row['first_name'];
            $_SESSION["last_name"] = $row['last_name'];
            $_SESSION["user_role"] = $row['user_role'];
            if ($chk == 'on') { // ถ้าติ๊กถูก Login ตลอดไป ให้ทำการสร้าง cookie
                setcookie("username_log", $username, time() + 3600 * 24 * 356);
            }
            $link = "";
            if($row['user_role'] == 1){//admin แผนกจัดการทั่วไป
                $link = "admin/insurance_data_admin.php";
            }elseif($row['user_role'] == 2){ // บัญชี
                $link = "insurance_pay.php";
            }elseif($row['user_role'] == 3){ // เคลม
                $link = "claim.php";
            }else{ //user
                $link = "insurance.php";
            }
//            pr($row['user_role']);
//            pr($link);
//            pr($row);exit;
            echo "<script>
                    $(function(){								
                                    window.location.href='".$link."';			
                    });
                </script>";
        } else {
            //$modal=Modal("portlet-error","error","แจ้งเตือน","ผิดพลาด! ไม่มี Username นี้ในระบบ...");
            echo "<br><p class='alert alert-danger'>ผิดพลาด! ไม่สามารถเข้าใช้งานระบบได้.</p>";
        }
    }
}

?>