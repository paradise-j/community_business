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
        $deletestmt = $db->query("DELETE FROM `receivepd` WHERE `rp_id` = '$delete_id'");
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
            header("refresh:1; url=receivePD.php");
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

    <title>ข้อมูลการรับสินค้า</title>

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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลการรับสินค้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_receivePD.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="" class="col-form-label">กลุ่มวิสาหกิจชุมชน</label>
                            <select class="form-control" aria-label="Default select example" id="group" name="group" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกกลุ่มวิสาหกิจชุมชน....</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `group_comen`");
                                    $stmt->execute();
                                    $gcs = $stmt->fetchAll();
                                    
                                    foreach($gcs as $gc){
                                ?>
                                <option value="<?= $gc['group_id']?>"><?= $gc['group_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <?php $date = date('Y-m-d'); ?>
                            <label for="" class="col-form-label">วันที่รับสินค้า</label>
                            <input type="date" required class="form-control" name="rpdate" id="rpdate" min="<?= $date; ?>" style="border-radius: 30px;">
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">ชื่อการรับสินค้า</label>
                            <input type="text" required class="form-control" name="rpname" style="border-radius: 30px;">
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">จำนวน</label>
                            <input type="text" required class="form-control" name="rpquan" style="border-radius: 30px;">
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">ราคา</label>
                            <input type="text" required class="form-control" name="rpprice" style="border-radius: 30px;">
                        </div>
                        <div class="col-md-1 text-center">
                            <img loading="lazy" width="175px" style="border-radius: 20px;" id="previewImg" alt="">
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-7">
                            <label for="img" class="form-label">อัปโหลดรูปภาพ</label>
                            <input type="file" class="form-control" id="imgInput" style="border-radius: 30px;" name="img" required>
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
        <?php include('../../sidebar/sidebar.php');?> <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../../topbar/topbar2.php');?>  <!-- Topbar -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-center">
                            <h3 class="m-0 font-weight-bold text-primary">ข้อมูลการรับสินค้า</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">เพิ่มข้อมูลการรับสินค้า</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr align="center">
                                            <th>ชื่อการรับสินค้า</th>
                                            <th>รูปสินค้า</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT receivepd.rp_id , receivepd.rp_date, receivepd.rp_name ,receivepd.rp_quan,receivepd.rp_price,receivepd.rp_cost, receivepd.rp_img, receivepd.group_id , group_comen.group_name as group_name 
                                                                FROM `receivepd` INNER JOIN `group_comen` ON group_comen.group_id = receivepd.group_id");
                                            $stmt->execute();
                                            $rps = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$rps) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                             foreach($rps as $rp)  {  
                                        ?>
                                        <tr align="center">
                                            <td width="200px"><?= $rp['rp_name']; ?></td>
                                            <td width="150px"><img class="rounded" width="100%" src="uploads/receivePD/<?= $rp['rp_img']; ?>" alt=""></td>
                                            <!-- <td class="date_th"><?= $rp['rp_date']; ?></td> -->
                                            <td align="center">
                                                <button class="btn btn-info" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#showdataModal<?= $rp['rp_id']?>">ดูข้อมูล</button>
                                                <!-- <button class="btn btn-warning" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#editGroupModal<?= $rp['rp_id']?>">แก้ไข</button> -->
                                                <!-- <a href="Edit_rp.php?edit_id=<?= $rp['rp_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: 0.9rem;" name="edit"  data-toggle="modal" data-target="#editdataModal<?= $rp['rp_id']?>">แก้ไข</a> -->
                                                <a data-id="<?= $rp['rp_id']; ?>" href="?delete=<?= $rp['rp_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: 0.9rem;">ลบ</a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $rp['rp_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลการรับสินค้า</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>วันที่เพิ่มข้อมูลสินค้า : </b> <?= thai_date_fullmonth(strtotime($rp['rp_date'])) ; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>กลุ่มวิสาหกิจชุมชน : </b> <?= $rp['group_name']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อการรับสินค้า : </b> <?= $rp['rp_name']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>จำนวน  : </b> <?= $rp['rp_quan']." **กิโลกรัม/ชิ้น/แพ็ค**"; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ราคา : </b> <?= $rp['rp_price']." บาท"; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ต้นทุน : </b> <?= $rp['rp_cost']." บาท"; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>รูปภาพการรับสินค้า : </b> </label><br>
                                                            <img class="rounded" width="50%" src="uploads/receivePD/<?= $rp['rp_img']; ?>" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ---------------------------------------  EditdataModal ---------------------------------------------------------------------->
                                        <div class="modal fade" id="editGroupModal<?= $rp['rp_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">แก้ไขข้อมูลการรับสินค้า</h5>
                                                        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                    </div>
                                                    <div class="modal-body mt-1">
                                                        <form action="Check_edit_receivePD.php" method="POST" enctype="multipart/form-data">
                                                            <div class="mb-3">
                                                                <label for="" class="col-form-label">รหัสสินค้า</label>
                                                                <input type="text" required class="form-control" id="rp_id" name="rp_id" value="<?= $rp['rp_id'];?>" style="border-radius: 30px;" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" class="col-form-label">กลุ่มวิสาหกิจชุมชน</label>
                                                                <input type="text" required class="form-control" id="group_name" name="group_name" value="<?= $rp['group_name'];?>" style="border-radius: 30px;" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="" class="col-form-label">ชื่อการรับสินค้า</label>
                                                                <input type="text" required class="form-control" id="rp_name" name="rp_name" value="<?= $rp['rp_name'];?>" style="border-radius: 30px;">
                                                            </div>
                                                            <div class="col-md-1 text-center">
                                                                <img loading="lazy" width="175px" style="border-radius: 20px;" id="previewImgEdit" alt="" src="uploads/receivePD/<?= $rp['rp_img']; ?>">
                                                            </div>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-7">
                                                                <label for="img" class="form-label">อัปโหลดรูปภาพ</label>
                                                                <input type="file" class="form-control" id="imgInputEdit" style="border-radius: 30px;" name="img" value="uploads/receivePD/<?= $rp['rp_img']; ?>"> 
                                                            </div>
                                                            <script>
                                                                let imgInputEdit = document.getElementById('imgInputEdit');
                                                                let previewImgEdit = document.getElementById('previewImgEdit');

                                                                imgInputEdit.onchange = evt => {
                                                                    const [file] = imgInputEdit.files;
                                                                        if (file) {
                                                                            previewImgEdit.src = URL.createObjectURL(file)
                                                                    }
                                                                }
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
        let imgInput = document.getElementById('imgInput');
        let previewImg = document.getElementById('previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
                if (file) {
                    previewImg.src = URL.createObjectURL(file)
            }
        }

 

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
                                url: 'receivePD.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'receivePD.php';
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


    </script>

</body>

</html>