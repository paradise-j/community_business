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

    <title>ข้อมูลกลุ่มวิสาหกิจชุมชน</title>

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
                                            <th></th>
                                            <!-- <th>แก้ไข</th> -->
                                            <!-- <th>ลบ</th> -->
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
                                            <td align="center">
                                                <button class="btn btn-info" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#showdataModal<?= $gcom['group_id']?>">ดูข้อมูล</button>
                                                <button class="btn btn-warning" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#editGroupModal<?= $gcom['group_id'];?>">แก้ไข</button>
                                                <!-- <a href="Edit_gcom.php?edit_id=<?= $gcom['group_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: 0.9rem;" name="edit"></i>แก้ไข</a> -->
                                                <a data-id="<?= $gcom['group_id']; ?>" href="?delete=<?= $gcom['group_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: 0.9rem;">ลบ</a>
                                            </td>
                                            <!-- <td align="center"><a href="Edit_gcom.php?edit_id=<?= $gcom['group_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: .75rem;" name="edit"><i class="fas fa-edit"></i></a></td> -->
                                            <!-- <td align="center"><a data-id="<?= $gcom['group_id']; ?>" href="?delete=<?= $gcom['group_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: .75rem;"><i class="fa-solid fa-trash"></i></a></td> -->
                                            
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $gcom['group_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลกลุ่มวิสาหกิจ</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>รหัสกลุ่มวิสาหกิจ : </b><?= $gcom['group_id']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อกลุ่ม : </b><?= $gcom['group_name']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>จังหวัด : </b><?= $gcom['group_pv']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>อำเภอ : </b><?= $gcom['group_dis']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ตำบล : </b><?= $gcom['group_subdis']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>รหัสไปรษณีย์ : </b><?= $gcom['group_zip']; ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ---------------------------------------  EditdataModal ---------------------------------------------------------------------->
                                        <div class="modal fade" id="editGroupModal<?= $gcom['group_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลกลุ่มวิสาหกิจ</h5>
                                                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="Check_edit_user.php" method="POST">
                                                            <div class="row mb-1">
                                                                <!-- <div class="col-md-4">
                                                                    <label for="" class="col-form-label">รหัสกลุ่มวิสาหกิจ</label>
                                                                    <input type="text" required class="form-control" name="phone" value="<?= $gcom['group_id'];?>" style="border-radius: 30px;">
                                                                </div> -->
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-md-12">
                                                                    <label for="" class="col-form-label">ชื่อกลุ่มวิสาหกิจ</label>
                                                                    <input type="text" required class="form-control" name="phone" value="<?= $gcom['group_name'];?>" style="border-radius: 30px;">
                                                                </div>
                                                            </div>
                                                            <div class="row mb-1">
                                                                <div class="col-md-6">
                                                                    <label for="" class="col-form-label">จังหวัด</label>
                                                                    <select class="form-control" aria-label="Default select example" id="provinces3" name="provinces3" style="border-radius: 30px;" required>
                                                                        <option selected disabled><?= $gcom['group_pv'];?></option>
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
                                                                        <option selected disabled><?= $gcom['group_dis'];?></option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-md-7">
                                                                    <label for="" class="col-form-label">ตำบล</label>
                                                                    <select class="form-control" aria-label="Default select example" id="districts2" name="districts2" style="border-radius: 30px;" required>
                                                                    <option selected disabled ><?= $gcom['group_subdis'];?></option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="firstname" class="col-form-label">รหัสไปรษณีย์</label>
                                                                    <input type="text" required class="form-control" id="zipcode2" name="zipcode2" value="<?= $gcom['group_zip'];?>" style="border-radius: 30px;">
                                                                </div>
                                                            </div>

                                                            <script>
                                                                $('#provinces3').change(function(){
                                                                    var id_provinces3 = $(this).val();

                                                                    console.log("provinces = "+ id_provinces3);
                                                                    // $.ajax({
                                                                    //     type : "post",
                                                                    //     url : "../../address3.php",
                                                                    //     data : {id:provinces3,function:'provinces3'},     
                                                                    //     success: function(data){
                                                                    //         console.log(data);
                                                                            // $('#amphures2').html(data);
                                                                            // $('#districts2').html(' ');
                                                                            // $('#zipcode2').val(' ');
                                                                        // }
                                                                    // });
                                                                });

                                                                $('#amphures2').change(function(){
                                                                    var id_amphures = $(this).val();
                                                                    $.ajax({
                                                                        type : "post",
                                                                        url : "../../address3.php",
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
                                                                        url : "../../address3.php",
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