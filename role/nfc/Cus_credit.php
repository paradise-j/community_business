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
    $stmt2 = $db->prepare("SELECT `group_id` FROM `user_data` WHERE `user_id` = :user_id");
    $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);

    $stmt3 = $db->prepare("SELECT `group_sb` FROM `group_comen` WHERE `group_id` = :group_id");
    $stmt3->bindParam(':group_id', $group_id, PDO::PARAM_INT);
    $stmt3->execute();
    $check_groupsb = $stmt3->fetch(PDO::FETCH_ASSOC);
    extract($check_groupsb);

    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $deletestmt = $db->query("DELETE FROM `inex_comen` WHERE `inex_id` = '$delete_id'");
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

    <title>ลูกค้าเครดิต</title>

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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลการชำระยอดค้าง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_paycredit.php" method="POST">
                        <div class="mb-3">
                            <label for="" class="col-form-label">วันที่ทำรายการ</label>
                            <input type="date" required class="form-control" name="datepay" style="border-radius: 30px;">
                        </div>
                        <!-- <div class="mb-3">
                            <label for="" class="col-form-label">ประเภทรายการ</label>
                            <select class="form-control" aria-label="Default select example" id="amphures" name="amphures" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกประเภท....</option>
                                <option value="1"></option>
                                <option value="2"></option>
                            </select>
                        </div> -->
                        <div class="mb-3">
                            <label for="" class="col-form-label">ชื่อลูกค้า</label>
                            <!-- <input type="text" required class="form-control" name="namegf" style="border-radius: 30px;"> -->
                            <select class="form-control" aria-label="Default select example"  id="custumer" name="custumer" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือก....</option>
                                <?php 
                                    $stmt = $db->query("SELECT `cd_pay` , `cd_name` as cus_id , customer.cus_name
                                                        FROM `credit` 
                                                        INNER JOIN `customer` ON credit.cd_name = customer.cus_id");
                                    $stmt->execute();
                                    $cds = $stmt->fetchAll();
                                    
                                    foreach($cds as $cd){
                                ?>
                                <option value="<?= $cd['cus_id']?>"><?= $cd['cus_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ยอดค้างทั้งหมด</label>
                            <input type="text" class="form-control" id="total" name="total" style="border-radius: 30px; color:red;" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ยอดชำระ</label>
                            <input type="text" required class="form-control" id="amount" name="amount" style="border-radius: 30px;">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 30px;">ตกลง</button>
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
                            <h3 class="m-0 font-weight-bold text-primary">ข้อมูลลูกค้าเครดิต</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">เพิ่มข้อมูลการชำระยอดค้าง</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr align="center">
                                            <th>ชื่อลูกค้า</th>
                                            <th></th>
                                            <!-- <th>แก้ไข</th> -->
                                            <!-- <th>ลบ</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $cd = $db->query("SELECT `cd_id`, `cd_date`, `cd_name`, `cd_pay`, customer.cus_name as cus_name
                                                              FROM `credit` 
                                                              INNER JOIN customer ON customer.cus_id = credit.cd_name");
                                            $cd->execute();
                                            $cds = $cd->fetchAll();
                                            $count = 1;
                                            if (!$cds) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                             foreach($cds as $cd)  {  
                                        ?>
                                        <tr>
                                            <td><?= $cd['cus_name']; ?></td>
                                            <td align="center">
                                                <button class="btn btn-info" style="border-radius: 30px; font-size: 0.8rem;" data-toggle="modal" data-target="#showdataModal<?= $cd['cd_id']?>">ดูข้อมูล</button>
                                                <!-- <a href="Edit_cd.php?edit_id=<?= $cd['cd_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: 1.125rem;" name="edit"><i class="fas fa-edit"></i></a> -->
                                                <!-- <a data-id="<?= $cd['cd_id']; ?>" href="?delete=<?= $cd['cd_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: 1.125rem;"><i class="fa-solid fa-trash"></i></a> -->
                                            </td>
                                            <!-- <td align="center"><a href="Edit_cd.php?edit_id=<?= $cd['cd_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: .75rem;" name="edit"><i class="fas fa-edit"></i></a></td> -->
                                            <!-- <td align="center"><a data-id="<?= $cd['cd_id']; ?>" href="?delete=<?= $cd['cd_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: .75rem;"><i class="fa-solid fa-trash"></i></a></td> -->
                                            
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $cd['cd_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลลูกค้าเครดิต</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>วันที่ทำรายการ : </b><?= thai_date_fullmonth(strtotime($cd['cd_date'])); ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อลูกค้า : </b><?= $cd['cus_name']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ยอดค้างชำระ : </b><?= $cd['cd_pay']; ?></label>
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

        $('#custumer').change(function(){
            var id_cname = $(this).val();
            console.log("cn = ",id_cname);
            $.ajax({
                type : "post",
                url : "../../api/cusname.php",
                data : {id:id_cname,function:'custumer'},     
                success: function(data){
                    console.log("cus = ",data);
                    $('#total').val(data);

                }
            });
        });
        
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


    </script>

</body>

</html>