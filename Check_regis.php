<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "connect.php";

    if (isset($_POST['submit'])) {
        $prename = $_POST['prename'];
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $name = $Fname." ".$Lname;
        $Bdate = $_POST['Bdate'];
        $personid = $_POST['personid'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $Homenumber = $_POST['Homenumber'];
        $moo = $_POST['moo'];
        $provinces = $_POST['provinces'];
        $amphures = $_POST['amphures'];
        $districts = $_POST['districts'];
        $zipcode = $_POST['zipcode'];
        $username = $_POST['personid'];
        $password = $_POST['tel'];

        try {
            if (!isset($_SESSION['error'])) {
                $sql = $db->prepare("INSERT INTO `tp_member`(`mem_pre`, `mem_name`, 
                                                     `mem_mail`, `mem_tel`, 
                                                     `mem_Bdate`, `mem_perid`, `mem_homenum`, 
                                                     `mem_moo`, `mem_subdis`, `mem_dis`, 
                                                     `mem_province`, `mem_zipcode`, `mem_username`, `mem_password`)
                                                     VALUES ('$prename','$name','$email','$tel',
                                                             '$Bdate','$personid','$Homenumber','$moo','$districts',
                                                             '$amphures','$provinces','$zipcode','$username','$password')");

                $sql->execute();
                $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";

                ini_set('display_errors', 1);
                ini_set('display_startup_errors', 1);
                error_reporting(E_ALL);
                date_default_timezone_set("Asia/Bangkok");

                $sToken = "JmOIl7IYgz42fT0fEkaUZl4HO1Gv3ObSTmXb2xk07c1";
                $sMessage = "แจ้งเตือนสมัครสมาชิก\r\n";
                $sMessage .= $prename.$Fname." ".$Lname."\n ได้ทำการสมัครสมาชิก\r\n";
                $sMessage .= "เบอร์โทรศัพท์ : ".$tel."\r\n";
                $sMessage .= "อีเมล : ".$email."\r\n";

                
                $chOne = curl_init(); 
                curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
                curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0); 
                curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0); 
                curl_setopt( $chOne, CURLOPT_POST, 1); 
                curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$sMessage); 
                $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$sToken.'', );
                curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
                curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
                $result = curl_exec( $chOne ); 

                //Result error 
                if(curl_error($chOne)) 
                { 
                    echo 'error:' . curl_error($chOne); 
                } 
                else { 
                    $result_ = json_decode($result, true); 
                    // echo "status : ".$result_['status']; echo "message : ". $result_['message'];
                } 
                curl_close( $chOne );  

                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    })
                </script>";
                header("refresh:1; url=index.php");
                
            } else {
                $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                header("location: register.php");
            }

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    }
?>