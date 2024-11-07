<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
        header("location: ../../index.php");
        exit;
    }
    require_once '../../connect.php';

    $user_id = $_SESSION['user_id'];
    $stmt2 = $db->query("SELECT `group_id` FROM `user_data` WHERE `user_id` = '$user_id'");
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);

    $stmt3 = $db->query("SELECT `group_sb` FROM `group_comen` WHERE `group_id` = '$group_id'");
    $stmt3->execute();
    $check_groupsb = $stmt3->fetch(PDO::FETCH_ASSOC);
    extract($check_groupsb);

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $db->query("DELETE FROM `orderer` WHERE `odr_id` = '$delete_id'");
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
            header("refresh:1; url=orderer.php");
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

    <title>ข้อมูลผู้สั่งซื้อ</title>

    <link rel="icon" type="image/png" href="img/product-hunt.svg"/>
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
    <!-- ---------------------------------------      AdddataModal ---------------------------------------------------------------------->
    <div class="modal fade" id="AddGroupModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลผู้สั่งซื้อ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_orderer.php" method="POST">
                        <div class="mb-3">
                            <label for="" class="col-form-label">กลุ่มวิสาหกิจชุมชน</label>
                            <select class="form-control" aria-label="Default select example" id="group" name="group" style="border-radius: 30px;" required readonly>
                                <option selected value="CM007">วสช.กลุ่มเกษตรกรทำสวนผสมผสานแบบยั่งยืนบางท่าข้าม</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">ชื่อผู้สั่งซื้อ</label>
                            <input type="text"  class="form-control" name="odr_name" style="border-radius: 30px;" required>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" maxlength="10" minlength="10" name="odr_phone" style="border-radius: 30px;" required>
                        </div>
                        <div class="row mb-3">
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
                        <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="firstname" class="col-form-label">ตำบล</label>
                                    <select class="form-control" aria-label="Default select example" id="districts" name="districts" style="border-radius: 30px;" required>
                                        <option selected disabled>กรุณาเลือกตำบล....</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="firstname" class="col-form-label">รหัสไปรษณีย์</label>
                                    <input type="text" required class="form-control" id="zipcode" name="zipcode" style="border-radius: 30px;">
                                </div>
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
        $dayTH = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
        $monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
        $monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];

        function thai_date_fullmonth($time){   // 19 ธันวาคม 2556
            global $dayTH,$monthTH;   
            $thai_date_return = date("j",$time);   
            $thai_date_return.=" ".$monthTH[date("n",$time)];   
            $thai_date_return.= " ".(date("Y",$time)+543);   
            return $thai_date_return;   
        } 
    ?>

    <div id="wrapper">
        <?php include('../../sidebar/'.$group_sb.'.php'); ?>  <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../../topbar/topbar2.php');?>  <!-- Topbar -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-center">
                            <h3 class="m-0 font-weight-bold text-primary">ข้อมูลผู้สั่งซื้อ</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">เพิ่มข้อมูลผู้สั่งซื้อ</a>
                                <a href="../../export/export-data-orderer.php" class="btn btn-sm btn-success shadow-sm" style="border-radius: 25px; font-size: .8rem;" type="submit" ><i class="fas fa-solid fa-file-export fa-sm text-white-50"></i></i> ส่งออกข้อมูลเป็น Excel</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr align="center">
                                            <th>ชื่อผู้สั่งซื้อ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $id = $_SESSION['id'];
                                            $check_id = $db->prepare("SELECT `user_id` FROM `user_login` WHERE user_login.user_id = '$id'");
                                            $check_id->execute();
                                            $row1 = $check_id->fetch(PDO::FETCH_ASSOC);
                                            extract($row1);
                                            // echo $user_id;

                                            $check_group = $db->prepare("SELECT `group_id` FROM `user_data` WHERE `user_id` = '$user_id'");
                                            $check_group->execute();
                                            $row2 = $check_group->fetch(PDO::FETCH_ASSOC);
                                            extract($row2);
                                            // echo $group_id;

                                            $stmt = $db->query("SELECT orderer.odr_id , orderer.odr_name , orderer.odr_phone ,
                                                                    orderer.group_id , group_comen.group_name as group_name
                                                                FROM `orderer` 
                                                                INNER JOIN `group_comen` ON orderer.group_id  = group_comen.group_id
                                                                WHERE orderer.group_id = '$group_id'");
                                            $stmt->execute();
                                            $odrs = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$odrs) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                             foreach($odrs as $odr)  {  
                                        ?>
                                        <tr>
                                            <td><?= $odr['odr_name']; ?></td>
                                            <!-- <td class="date_th"><?= $odr['odr_date']; ?></td> -->
                                            <td align="center">
                                                <button class="btn btn-info" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#showdataModal<?= $odr['odr_id']?>">ดูข้อมูล</button>
                                                <button class="btn btn-warning" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#editGroupModal<?= $odr['odr_id']?>">แก้ไข</button>
                                                <!-- <a href="Edit_odr.php?edit_id=<?= $odr['odr_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: 0.9rem;" name="edit"  data-toggle="modal" data-target="#editdataModal<?= $odr['odr_id']?>">แก้ไข</a> -->
                                                <a data-id="<?= $odr['odr_id']; ?>" href="?delete=<?= $odr['odr_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: 0.9rem;">ลบ</a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $odr['odr_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลผู้สั่งซื้อ</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>รหัสผู้สั่งซื้อ : </b><?= $odr['odr_id']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>กลุ่มวิสาหกิจชุมชน : </b><?= $odr['group_name']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อผู้สั่งซื้อ : </b><?= $odr['odr_name']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>เบอร์โทรศัพท์ : </b><?= $odr['odr_phone']; ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ---------------------------------------  EditdataModal ---------------------------------------------------------------------->
                                        <div class="modal fade" id="editGroupModal<?= $odr['odr_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลผู้สั่งซื้อ</h5>
                                                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                    </div>
                                                    <div class="modal-body mt-1">
                                                        <form action="Check_edit_orderer.php" method="POST">
                                                            <div class="mb-3">
                                                                <label for="" class="col-form-label">รหัสผู้สั่งซื้อ</label>
                                                                <input type="text" required class="form-control" id=" odr_id" name=" odr_id" value="<?= $odr['odr_id'];?>" style="border-radius: 30px;" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" class="col-form-label">กลุ่มวิสาหกิจชุมชน</label>
                                                                <input type="text" required class="form-control" id="group_name" name="group_name" value="<?= $odr['group_name'];?>" style="border-radius: 30px;" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" class="col-form-label">ชื่อผู้สั่งซื้อ</label>
                                                                <input type="text" required class="form-control" id="odr_name" name="odr_name" value="<?= $odr['odr_name'];?>" style="border-radius: 30px;">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" class="col-form-label">เบอร์โทรศัพท์</label>
                                                                <input type="text" required class="form-control" id="odr_phone" name="odr_phone" value="<?= $odr['odr_phone'];?>" style="border-radius: 30px;">
                                                            </div>
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
    <script src="../../bootrap/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../bootrap/vendor/datatables/dataTables.bootstrap4.min.js"></script>

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
                                url: 'orderer.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'orderer.php';
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



        
        const dom_date = document.querySelectorAll('.date_th')
        dom_date.forEach((elem)=>{

            const my_date = elem.textContent
            const date = new Date(my_date)
            const result = date.toLocaleDateString('th-TH', {

            year: 'numeric',
            month: 'long',
            day: 'numeric',

            }) 
            elem.textContent=result
        })
        
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