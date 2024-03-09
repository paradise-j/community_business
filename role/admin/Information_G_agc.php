<?php 
    session_start();
    // if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
    //     header("location: ../../index.php");
    //     exit;
    // }
    require_once '../../connect.php';

    // if (isset($_GET['show_id'])) {
        // $delete_id = $_GET['show_id'];
        // echo $delete_id;
        // $deletestmt = $db->query("DELETE FROM `agriculturist` WHERE `agc_id` = '$delete_id'");
        // $deletestmt->execute();
        
        // if ($deletestmt) {
        //     echo "<script>alert('Data has been deleted successfully');</script>";
        //     header("refresh:1; url=Manage_agc.php");
        // }
    // }
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

    <link rel="icon" type="image/png" href="img/undraw_posting_photo.svg"/>
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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลกลุ่มวิสาหกิจ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_Gcomen.php" method="POST">
                        <div class="mb-3">
                            <label for="" class="col-form-label">ชื่อกลุ่ม</label>
                            <input type="text" required class="form-control" name="namegf" style="border-radius: 30px;">
                        </div>
                        <div class="mb-3">
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
                        <div class="mb-3">
                            <label for="" class="col-form-label">อำเภอ</label>
                            <select class="form-control" aria-label="Default select example" id="amphures" name="amphures" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกอำเภอ....</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ตำบล</label>
                            <select class="form-control" aria-label="Default select example" id="districts" name="districts" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกตำบล....</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">รหัสไปรษณีย์</label>
                            <input type="text" required class="form-control" id="zipcode" name="zipcode" style="border-radius: 30px;">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 30px;">เพิ่มข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ---------------------------------------      showdataModal ---------------------------------------------------------------------->
    <?php 
        // if (isset($_GET['show_id'])) {
            // $delete_id = $_GET['show_id'];
            // echo $delete_id;
            $stmt = $db->query("SELECT * FROM `group_comen`");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
        // }
    ?>
    <div class="modal fade" id="showdataModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลกลุ่มวิสาหกิจ</h4>
                    <span class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อกลุ่ม : </b><?= $group_name ?></label>
                    </div>
                    <div class="mb-2">
                        <?php 
                            $stmt = $db->query("SELECT `name_th` as pv FROM `provinces` WHERE `id` = $group_pv");
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            extract($row);
                        ?>
                        <label for="" class="col-form-label" style="font-size: 1.25rem;"><b>จังหวัด : </b><?= $pv ?></label>
                    </div>
                    <div class="mb-2">
                        <?php 
                            $stmt = $db->query("SELECT `name_th` as dis FROM `amphures` WHERE `id` = $group_dis");
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            extract($row);
                        ?>
                        <label for="" class="col-form-label" style="font-size: 1.25rem;"><b>อำเภอ : </b><?= $dis?></label>
                    </div>
                    <div class="mb-2">
                        <?php 
                            $stmt = $db->query("SELECT `name_th` as subdis FROM `districts` WHERE `id` = $group_subdis");
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            extract($row);
                        ?>
                        <label for="firstname" class="col-form-label" style="font-size: 1.25rem;"><b>ตำบล : </b><?= $subdis?></label>
                    </div>
                    <div class="mb-2">
                        <label for="firstname" class="col-form-label" style="font-size: 1.25rem;"><b>รหัสไปรษณีย์ : </b><?= $group_zip ?></label>
                    </div>
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
                            <h3 class="m-0 font-weight-bold text-primary">ข้อมูลกลุ่มวิสาหกิจชุมชน</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">เพิ่มข้อมูลกลุ่มวิสาหกิจ</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr align="center">
                                            <th>ชื่อกลุ่มวิสาหกิจ</th>
                                            <th>ข้อมูลเพิ่มเติม</th>
                                            <th>แก้ไข</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `group_comen`");
                                            $stmt->execute();
                                            $gcoms = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$gcoms) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                            foreach($gcoms as $gcom)  {  
                                        ?>
                                        <tr>
                                            <td><?= $gcom['group_name']; ?></td>
                                            <!-- <td><a data-id="<?= $gcom['group_id']; ?>" href="?show_id=<?= $gcom['group_id']; ?>" class="btn btn-danger"><i class="fa-solid fa-trash"></i></a></td> -->
                                            <td align="center"><a data-id="<?= $gcom['group_id']; ?>" href="?show_id=<?= $gcom['group_id']; ?>" class="btn btn-info dalate-btn" style="border-radius: 30px; font-size: .75rem;" data-toggle="modal" data-target="#showdataModal"><i class="fas fa-eye"></i></a></td>
                                            <td align="center"><a href="Edit_gcom.php?edit_id=<?= $gcom['group_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: .75rem;" name="edit"><i class="fas fa-edit"></i></a></td>
                                            
                                        </tr>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function showdataModal() {
            var showdata = document.getelementbyid("show").value;
            console.log(showdata);
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