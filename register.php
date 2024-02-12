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

    <title>ลงทะเบียนเข้าใข้งานระบบ</title>

    <link rel="icon" type="image/png" href="img/login2.png">

    <!-- Custom fonts for this template-->
    <link href="./bootrap/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="./bootrap/css/sb-admin-2.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- <div class="row"> -->
            <!-- <div class="col-md-2"></div> -->
            <div class="card o-hidden border-0 shadow-lg mt-3 mb-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                        <div class="col-lg">
                            <div class="p-4">
                                <div class="text-center">
                                    <h1 class="h3 text-gray-900 mb-4">ลงทะเบียนเข้าใข้งานระบบ</h1>
                                </div>
                                <form class="user" name="regiter" action="Check_regis.php" method="POST">
                                
                                    <div class="form-group row">
                                        <div class="col-md-3 mb-3 mb-sm-0">
                                            <label class="form-label">คำนำหน้าชื่อ</label><br>
                                            <select class="form-control" aria-label="Default select example" name="prename" style="border-radius: 25px;" required>
                                                <option value="">กรุณาเลือก....</option>
                                                <option value="นาย">นาย</option>
                                                <option value="นาง">นาง</option>
                                                <option value="นางสาว">นางสาว</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-sm-0">
                                            <label class="form-label">ชื่อ</label><br>
                                            <input type="text" class="form-control" style="border-radius: 25px;" name="Fname" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">นามสกุล</label><br>
                                            <input type="text" class="form-control" style="border-radius: 25px;" name="Lname" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-7 mb-3 mb-sm-0">
                                            <?php $date = date('Y-m-d'); ?>
                                            <label class="form-label">วัน/เดือน/ปี ที่เกิด</label><br>
                                            <input type="date" class="form-control" style="border-radius: 25px;" max="<?= $date; ?>" name="Bdate" required>
                                        </div>
                                        <div class="col-md-5 mb-3 mb-sm-0">
                                            <label class="form-label">เลขบัตรประจำตัวประชาชน</label><br>
                                            <input type="text" class="form-control" style="border-radius: 25px;" minlength="13" maxlength="13" name="personid" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-8 mb-3 mb-sm-0">
                                            <label class="form-label">อีเมล</label><br>
                                            <input type="email" class="form-control" style="border-radius: 25px;" name="email" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">เบอร์โทรศัพท์</label><br>
                                            <input type="tel" class="form-control" style="border-radius: 25px;" minlength="10" maxlength="10" name="tel" required>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="form-label">บ้านเลขที</label>
                                            <input type="text" class="form-control" style="border-radius: 25px;" name="Homenumber" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">หมู่ที่</label>
                                            <input type="number" class="form-control" style="border-radius: 25px;" name="moo" required>
                                        </div>
                                        <div class="col-md-6 mb-3 mb-sm-0">
                                            <label class="form-label">จังหวัด</label>
                                            <select class="form-control" aria-label="Default select example" id="provinces" name="provinces" style="border-radius: 30px;" required>
                                                <option selected disabled>กรุณาเลือกจังหวัด....</option>
                                                <?php 
                                                    $stmt = $db->query("SELECT * FROM `provinces`");
                                                    $stmt->execute();
                                                    $pvs = $stmt->fetchAll();
                                                    
                                                    foreach($pvs as $pv){
                                                ?>
                                                <option value="<?= $pv['id']?>"><?= $pv['name_th']?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-5 mb-3 mb-sm-0">
                                            <label class="form-label">อำเภอ</label>
                                            <select class="form-control" aria-label="Default select example" id="amphures" name="amphures" style="border-radius: 30px;" required>
                                                <option selected disabled>กรุณาเลือกอำเภอ....</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3 mb-sm-0">
                                            <label class="form-label">ตำบล</label>
                                            <select class="form-control" aria-label="Default select example" id="districts" name="districts" style="border-radius: 30px;" required>
                                                <option selected disabled>กรุณาเลือกตำบล....</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3 mb-sm-0">
                                            <label class="form-label">รหัสไปรษณีย์</label>
                                            <input type="text" required class="form-control" id="zipcode" name="zipcode" style="border-radius: 30px;"  required>
                                        </div>
                                    </div>
                                    <hr>
                                    <button class="btn btn-primary btn-user btn-block" type="submit" name="submit"  style="font-size: 1rem;">ลงทะเบียน</button>
                                </form>
                                <hr>
                                <a href="index.php" class="btn btn-secondary" style="border-radius: 30px;"><i class='bx bx-arrow-back'></i>  กลับสู่หน้าหลัก</a>
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
    

    <script>
        $('#provinces').change(function(){
            var id_provnce = $(this).val();
            $.ajax({
                type : "post",
                url : "address.php",
                data : {id:id_provnce,function:'provinces'},
                success: function(data){
                    $('#amphures').html(data);
                    $('#districts').html(' ');
                    $('#zipcode').val(' ');
                }
            });
        });

        $('#amphures').change(function(){
            var id_amphures = $(this).val();
            $.ajax({
                type : "post",
                url : "address.php",
                data : {id:id_amphures,function:'amphures'},
                success: function(data){
                    $('#districts').html(data);
                    $('#zipcode').val(' ');
                }
            });
        });

        $('#districts').change(function(){
            var id_districts = $(this).val();
            $.ajax({
                type : "post",
                url : "address.php",
                data : {id:id_districts,function:'districts'},
                success: function(data){
                    $('#zipcode').val(data)
                }
            });
        });
    </script>
</body>

</html>