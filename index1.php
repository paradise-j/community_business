<?php
    require_once 'connect.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>เข้าสู่ระบบ</title>

    <link rel="icon" type="image/png" href="img/login2.png">
    

    <link
        href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./bootrap/css/sb-admin-2.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-">
                <div class="card o-hidden border-0 shadow-lg my-5 ">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col">
                                <div class="p-4">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">ลงทะเบียนเข้าใข้งานระบบ</h1>
                                    </div>
                                    <form class="user" name="login" action="Check_login.php" method="POST">
                                        <div class="form-group">
                                            <input type="tel" name="username" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="ชื่อผู้ใช้งาน">
                                        </div>
                                        <div class="form-group">
                                            <input type="tel" name="password" class="form-control form-control-user bx bxs-low-vision" id="" placeholder="รหัสผ่าน">
                                        </div>

                                        <button class="btn btn-success btn-user btn-block " style="font-size: 15px;" type="submit" name="btn_login">เข้าสู่ระบบ</button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a href="register.php" class="btn btn-primary btn-user btn-block" style="border-radius: 25px; font-size: 15px;">ลงทะเบียนเข้าใข้งานระบบ</a>
                                    </div>
                                    <hr>
                                    <!-- <a href="index.php" class="btn btn-secondary" style="border-radius: 30px; font-size: 10px;"><i class='bx bx-arrow-back'></i>  กลับสู่หน้าหลัก</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="./bootrap/vendor/jquery/jquery.min.js"></script>
    <script src="./bootrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="./bootrap/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="./bootrap/js/sb-admin-2.min.js"></script>
    
    <script type="text/javascript">
$(function(){

    $(document.body).on("click","[class*='fa-eye']",function(){
        $(this).toggleClass("fa-eye-slash fa-eye");  
        let ele = $(this).closest(".input-group-append").siblings(".pass-swap");
        let swap_attr = (ele.attr("type")=="password")?"text":"password";
        ele.attr("type",swap_attr);     
    });
});
</script>

</body>

</html>