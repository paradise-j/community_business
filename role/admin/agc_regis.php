<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    // if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
    //     header("location: ../../index.php");
    //     exit;
    // }
    require_once '../../connect.php';

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $db->query("DELETE FROM `group_comen` WHERE `group_id` = '$delete_id'");
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
            header("refresh:1; url=information_G_agc.php");
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

    <title>Infor_Group_agriculturist</title>

    <link rel="icon" type="image/png" href="img/home-solid.svg"/>
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
                    <form action="Check_Add_Gcomen.php" method="POST">
                        <div class="mb-1">
                            <label for="" class="col-form-label">เลขทะเบียน</label>
                            <input type="text" required class="form-control" name="reid" style="border-radius: 30px;">
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="" class="col-form-label">ชื่อ</label>
                                <input type="text" required class="form-control" name="Fname" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-6">
                                <label for="" class="col-form-label">สกุล</label>
                                <input type="text" required class="form-control" name="Lnamegf" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-5">
                                <label for="" class="col-form-label">เลขประจำตัวประชาชน</label>
                                <input type="text" required class="form-control" name="perid" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-7">
                                <label for="" class="col-form-label">ที่อยู่</label>
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
                        <div class="row mb-1">
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
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" style="border-radius: 30px;">ยกเลิก</button>
                            <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 30px;">เพิ่มข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ---------------------------------------      showdataModal ---------------------------------------------------------------------->
    

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
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `agc_data`");
                                            $stmt->execute();
                                            $agcs = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$agcs) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                             foreach($agcs as $agc)  {  
                                        ?>
                                        <tr>
                                            <!-- <td align="center"><?= $agc['agc_reid']; ?></td> -->
                                            <td><?= $agc['agc_Fname']." ".$agc['agc_Lname']; ?></td>
                                            <td align="center"><button class="btn btn-info" style="border-radius: 30px; font-size: .75rem;" data-toggle="modal" data-target="#showdataModal<?= $agc['agc_id']?>"><i class="fas fa-eye"></i></button></td>
                                            <td align="center"><a href="Edit_agc.php?edit_id=<?= $agc['agc_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: .75rem;" name="edit"><i class="fas fa-edit"></i></a></td>
                                            <td align="center"><a data-id="<?= $agc['agc_id']; ?>" href="?delete=<?= $agc['agc_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: .75rem;"><i class="fa-solid fa-trash"></i></a></td>
                                            
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $agc['agc_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลสมาชิก</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อ-สกุล : </b><?= $agc['agc_Fname']." ".$agc['agc_Lname']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>เลขทะเบียน : </b><?= $agc['agc_reid']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>รหัสบัตรประชาชน : </b><?= $agc['agc_perid']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ที่อยู่ : </b><?= $agc['agc_num']." ตำบล".$agc['agc_subdis']." อำเภอ".$agc['agc_dis']." จังหวัด".$agc['agc_pv']." รหัสไปรษณีย์ ".$agc['agc_zip']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <!-- <label class="col-form-label" style="font-size: 1.25rem;"><b>รหัสไปรษณีย์ : </b><?= $agc['agc_zip']; ?></label> -->
                                                        </div>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

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
                                url: 'information_G_agc.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'information_G_agc.php';
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
            $.ajax({
                type : "post",
                url : "../../address.php",
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