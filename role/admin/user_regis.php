<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
        header("location: ../../index.php");
        exit;
    }
    require_once '../../connect.php';

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        echo $delete_id;
        $deletestmt = $db->query("DELETE FROM `user_data` WHERE `user_id` = '$delete_id'");
        $deletestmt->execute();
        
        if ($deletestmt) {
            // echo "<script>alert('Data has been deleted successfully');</script>";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'ลบข้อมูลเรียบร้อยแล้ว',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                })
            </script>";
            header("refresh:1; url=user_regis.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ข้อมูลทะเบียนสมาชิก</title>

    <link rel="icon" type="image/png" href="img/seedling-solid.svg"/>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div class="modal fade" id="AddGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลสมาชิก</h5>
                    <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                </div>
                <div class="modal-body">
                    <form action="Check_Add_regisAgc.php" method="POST">
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="" class="col-form-label">ชื่อกลุ่มวืสาหกิจชุมชข</label>
                                <select class="form-control" aria-label="Default select example" id="group_id" name="group_id" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกวืสาหกิจชุมชข....</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `group_comen`");
                                    $stmt->execute();
                                    $cms = $stmt->fetchAll();
                                    
                                    foreach($cms as $cm){
                                ?>
                                <option value="<?= $cm['group_id']?>"><?= $cm['group_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <!-- <div class="col-md-5">
                                <label for="" class="col-form-label">เลขทะเบียน</label>
                                <input type="text" required class="form-control" name="reid" minlength="10" maxlength="10" style="border-radius: 30px;">
                            </div> -->
                            <div class="col-md-7">
                                <label for="" class="col-form-label">ตำแหน่ง</label>
                                <select class="form-control" aria-label="Default select example" id="position" name="position" style="border-radius: 30px;" required>
                                    <option selected disabled>กรุณาเลือกตำแหน่ง....</option>
                                    <option value="1">ประธานกลุ่ม</option>
                                    <option value="2">รองประธานกลุ่ม</option>
                                    <option value="3">เหรัญญิก</option>
                                    <option value="4">รองเหรัญญิก</option>
                                    <option value="5">เลขานุการ</option>
                                    <option value="6">ผู้ช่วยเลขานุการ</option>
                                    <option value="7">ประชาสัมพันธ์</option>
                                    <option value="8">ฝ่ายผลิต</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="" class="col-form-label">ชื่อ</label>
                                <input type="text" required class="form-control" name="Fname" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="col-form-label">สกุล</label>
                                <input type="text" required class="form-control" name="Lname" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="" class="col-form-label">เบอร์โทรศัพท์</label>
                                <input type="text" required class="form-control" name="phone" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-5">
                                <label for="" class="col-form-label">เลขประจำตัวประชาชน</label>
                                <input type="text" required class="form-control" name="perid"  minlength="13" maxlength="13" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-7">
                                <label for="" class="col-form-label">บ้านเลขที่</label>
                                <input type="text" required class="form-control" name="address" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="" class="col-form-label">จังหวัด</label>
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
                            <div class="col-md-6">
                                <label for="" class="col-form-label">อำเภอ</label>
                                <select class="form-control" aria-label="Default select example" id="amphures" name="amphures" style="border-radius: 30px;" required>
                                    <option selected disabled>กรุณาเลือกอำเภอ....</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <label for="" class="col-form-label">ตำบล</label>
                                <select class="form-control" aria-label="Default select example" id="districts" name="districts" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกตำบล....</option>
                            </select>
                            </div>
                            <div class="col-md-5">
                                <label for="firstname" class="col-form-label">รหัสไปรษณีย์</label>
                                <input type="text" required class="form-control" id="zipcode" name="zipcode" style="border-radius: 30px;">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <label for="" class="col-form-label">สิทธิ์การใช้งาน</label>
                                <select class="form-control" aria-label="Default select example" id="permission" name="permission" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกสิทธิ์การใช้งาน....</option>
                                <option value="1">ผู้ดูแลระบบ</option>
                                <option value="2">สภาเกษตร</option>
                                <option value="3">ประธานกลุ่มวิสากิจชุมชน</option>
                                <option value="4">สมาชิกทั่วไป</option>
                                <!-- <option value="5">ผู้ดูแลระบบ</option> -->
                            </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 30px;">ยกเลิก</button>
                            <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 30px;">เพิ่มข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ---------------------------------------  ImportModal ---------------------------------------------------------------------->
    <div class="modal fade" id="ImportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลสมาชิกจากไฟล์ Excel</h5>
                </div>
                
                <div class="modal-body">
                    <form action="./import_user/f_save.php" method="POST" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                        <input type="file" style="border-radius: 20px;" name="file" id="file" accept=".xls,.xlsx">
                        <div class="modal-footer">
                            <button type="submit" name="import" class="btn btn-primary" style="border-radius: 30px;">เพิ่มข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="wrapper">
        <?php include('../../sidebar/sidebar.php');?> <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../../topbar/topbar2.php');?>  <!-- Topbar -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-center">
                            <h3 class="m-0 font-weight-bold text-primary">ข้อมูลทะเบียนสมาชิก</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">เพิ่มข้อมูลสมาชิก</a>
                                <a href="#" class="btn btn-sm btn-success shadow-sm" style="border-radius: 25px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#ImportModal"><i class="fas fa-download fa-sm text-white-50"></i> เพิ่มข้อมูลจาก Excel</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr align="center">
                                            <!-- <th>เลขทะเบียน</th> -->
                                            <th>ชื่อ-สกุล</th>
                                            <th></th>
                                            <!-- <th></th> -->
                                            <!-- <th></th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `user_data`
                                                                INNER JOIN `user_login` on user_data.user_id = user_login.user_id");
                                            $stmt->execute();
                                            $users = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$users) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                             foreach($users as $user)  {  
                                        ?>
                                        <tr>
                                            <!-- <td align="center"><?= $user['user_id']; ?></td> -->
                                            <td align="center"><?= $user['user_Fname']." ".$user['user_Lname']; ?></td>
                                            <td align="center">
                                                <button class="btn btn-info" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#showdataModal<?= $user['user_id']?>">ดูข้อมูล</button>
                                                <!-- <a href="Edit_user.php?edit_id=<?= $user['user_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: 0.9rem;" name="edit">แก้ไข</a> -->
                                                <button class="btn btn-warning" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#editGroupModal<?= $user['user_id'];?>">แก้ไข</button>
                                                <a data-id="<?= $user['user_id']; ?>" href="?delete=<?= $user['user_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: 0.9rem;">ลบ</a>
                                            </td>                                     
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $user['user_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลสมาชิก</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อ-สกุล : </b><?= $user['user_Fname']." ".$user['user_Lname']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>เลขทะเบียน : </b><?= $user['user_reid']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>รหัสบัตรประชาชน : </b><?= $user['user_perid']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ที่อยู่ : </b><?= $user['user_num']." ตำบล".$user['user_subdis']." อำเภอ".$user['user_dis']." จังหวัด".$user['user_pv']." รหัสไปรษณีย์ ".$user['user_zip']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>สถานะสมาชิก :  </b>
                                                                <?php
                                                                    if ($user['ul_status'] == 1) {
                                                                        echo "ผู้ดูแลระบบ";
                                                                    }elseif ($user['ul_status'] == 2) {
                                                                        echo "สภาเกษตร";
                                                                    }elseif ($user['ul_status'] == 3) {
                                                                        echo "ประธานกลุ่ม";
                                                                    }else{
                                                                        echo "สมาชิกทั่วไป";
                                                                    } 
                                                                 ?>
                                                            
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ---------------------------------------  EditdataModal ---------------------------------------------------------------------->
                                        <div class="modal fade" id="editGroupModal<?= $user['user_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลสมาชิก</h5>
                                                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="Check_edit_user.php" method="POST">
                                                            <div class="mb-1">
                                                                <label for="" class="col-form-label">รหัสสมาชิก</label>
                                                                <input type="text" required class="form-control" id="userid" name="Productid" value="<?= $user['user_id'];?>" style="border-radius: 30px;" readonly>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-md-6">
                                                                    <label for="" class="col-form-label">ชื่อ</label>
                                                                    <input type="text" required class="form-control" name="Fname" value="<?= $user['user_Fname'];?>" style="border-radius: 30px;">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="" class="col-form-label">สกุล</label>
                                                                    <input type="text" required class="form-control" name="Lname" value="<?= $user['user_Lname'];?>" style="border-radius: 30px;">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-md-6">
                                                                    <label for="" class="col-form-label">เบอร์โทรศัพท์</label>
                                                                    <input type="text" required class="form-control" name="phone" value="<?= $user['user_phone'];?>" style="border-radius: 30px;">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-md-5">
                                                                    <label for="" class="col-form-label">เลขประจำตัวประชาชน</label>
                                                                    <input type="text" required class="form-control" name="perid"  minlength="13" maxlength="13" value="<?= $user['user_perid'];?>" style="border-radius: 30px;">
                                                                </div>
                                                                <div class="col-md-7">
                                                                    <label for="" class="col-form-label">บ้านเลขที่</label>
                                                                    <input type="text" required class="form-control" name="address" value="<?= $user['user_num'];?>" style="border-radius: 30px;">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-md-6">
                                                                    <label for="" class="col-form-label">จังหวัด</label>
                                                                    <select class="form-control" aria-label="Default select example" id="provinces2" name="provinces2" style="border-radius: 30px;" required>
                                                                    <option selected disabled><?= $user['user_pv'];?></option>
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
                                                                <div class="col-md-6">
                                                                    <label for="" class="col-form-label">อำเภอ</label>
                                                                    <select class="form-control" aria-label="Default select example" id="amphures2" name="amphures2" style="border-radius: 30px;" required>
                                                                        <option selected disabled><?= $user['user_dis'];?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-7">
                                                                    <label for="" class="col-form-label">ตำบล</label>
                                                                    <select class="form-control" aria-label="Default select example" id="districts2" name="districts2" style="border-radius: 30px;" required>
                                                                    <option selected disabled ><?= $user['user_subdis'];?></option>
                                                                </select>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="firstname" class="col-form-label">รหัสไปรษณีย์</label>
                                                                    <input type="text" required class="form-control" id="zipcode2" name="zipcode2" value="<?= $user['user_zip'];?>"style="border-radius: 30px;">
                                                                </div>
                                                            </div>

                                                            <script>
                                                                $('#provinces2').change(function(){
                                                                    var id_provnce2 = $(this).val();
                                                                    console.log("id_provnce2 = "+id_provnce2);
                                                                    $.ajax({
                                                                        type : "post",
                                                                        url : "../../address2.php",
                                                                        data : {id:id_provnce2,function:'provinces2'},     
                                                                        success: function(data){
                                                                            console.log(data);
                                                                            $('#amphures2').html(data);
                                                                            $('#districts2').html(' ');
                                                                            $('#zipcode2').val(' ');
                                                                        }
                                                                    });
                                                                });

                                                                $('#amphures2').change(function(){
                                                                    var id_amphures = $(this).val();
                                                                    $.ajax({
                                                                        type : "post",
                                                                        url : "../../address2.php",
                                                                        data : {id:id_amphures,function:'amphures2'},
                                                                        success: function(data){
                                                                            $('#districts2').html(data);
                                                                            $('#zipcode2').val(' ');
                                                                        }
                                                                    });
                                                                });

                                                                $('#districts2').change(function(){
                                                                    var id_districts = $(this).val();
                                                                    $.ajax({
                                                                        type : "post",
                                                                        url : "../../address2.php",
                                                                        data : {id:id_districts,function:'districts2'},
                                                                        success: function(data){
                                                                            $('#zipcode2').val(data)
                                                                        }
                                                                    });
                                                                });
                                                            </script>

                                                            <div class="modal-footer">
                                                                <button type="submit" name="submit" class="btn btn-warning" style="border-radius: 30px;">แก้ไขข้อมูล</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                             }      
                                            }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?php include('../../footer/footer.php');?> <!-- Footer -->
        </div>

    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>


    <script>
        $(".delete-btn").click(function(e) {
            var userId = $(this).data('id');
            // console.log(userId);
            e.preventDefault();
            deleteConfirm(userId);
        })

        function deleteConfirm(userId) {
            Swal.fire({
                title: 'ลบข้อมูล',
                text: "คุณแน่ใจใช่หรือไม่ที่จบลบข้อมูลนี้",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ลบข้อมูล',
                showLoaderOnConfirm: true,
                preConfirm: function() {
                    return new Promise(function(resolve) {
                        $.ajax({
                                url: 'user_regis.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'user_regis.php';
                                })
                            })
                            .fail(function() {
                                Swal.fire({
                                    title: 'ไม่สำเร็จ',
                                    text: 'ลบข้อมูลไม่สำเร็จ',
                                    icon: 'danger',
                                })
                                window.location.reload();
                            });
                    });
                },
            });
        }
        
        $.extend(true, $.fn.dataTable.defaults, {
            "language": {
                    "sProcessing": "กำลังดำเนินการ...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดงรายการ 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกรายการ)",
                    "sInfoPostFix": "",
                    "sSearch": "ค้นหา:",
                    "sUrl": "",
                    "oPaginate": {
                                    "sFirst": "เริ่มต้น",
                                    "sPrevious": "ก่อนหน้า",
                                    "sNext": "ถัดไป",
                                    "sLast": "สุดท้าย"
                    }
            }
        });
        $('.table').DataTable();


        $('#provinces').change(function(){
            var id_provnce = $(this).val();
            console.log(id_provnce);
            $.ajax({
                type : "post",
                url : "../../address.php",
                data : {id:id_provnce,function:'provinces'},     
                success: function(data){
                    console.log(data);
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
                url : "../../address.php",
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
                url : "../../address.php",
                data : {id:id_districts,function:'districts'},
                success: function(data){
                    $('#zipcode').val(data)
                }
            });
        });

    </script>

</body>

</html>