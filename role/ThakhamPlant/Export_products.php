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
        $deletestmt = $db->query("DELETE FROM `Plant_export` WHERE `px_id` = '$delete_id'");
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
            header("refresh:1; url=Export_products.php");
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

    <title>ส่งออกผลผลิต</title>

    <link rel="icon" type="image/png" href="img/truck-solid.svg"/>
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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลการส่งออกผลผลิต</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_export.php" method="POST">
                        <div class="mb-1">
                            <?php $date = date('Y-m-d'); ?>
                            <label for="" class="col-form-label">รหัสการสั่งซื้อ</label>
                            <select class="form-control" aria-label="Default select example" id="pldID" name="pldID" style="border-radius: 30px;" required>
                                <option selected disabled>เลือกรหัสการสั่งซื้อ....</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `plant_orderlist`");
                                    $stmt->execute();
                                    $plds = $stmt->fetchAll();
                                    
                                    foreach($plds as $pld){
                                ?>
                                <option value="<?= $pld['pld_id']?>"><?= $pld['pld_id']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-1">
                            <?php $date = date('Y-m-d'); ?>
                            <label for="" class="col-form-label">วันที่ส่งออกผลผลิต</label>
                            <input type="date" required class="form-control" name="date" min="<?= $date; ?>" max="<?= $date; ?>" style="border-radius: 30px;">
                        </div>
                        <div class="mb-1">
                            <label for="" class="col-form-label">ผู้รับผลผลิต</label>
                            <!-- <input type="text" required class="form-control" name="name" style="border-radius: 30px;"> -->
                            <select class="form-control" aria-label="Default select example" id="orderer" name="orderer" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกผู้รับผลผลิต....</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `orderer` ");
                                    $stmt->execute();
                                    $odrs = $stmt->fetchAll();
                                    
                                    foreach($odrs as $odr){
                                ?>
                                <option value="<?= $odr['odr_id']?>"><?= $odr['odr_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-1">
                            <label for="" class="col-form-label">ผลผลิตที่รับซื้อ</label>
                            <!-- <input type="text" required class="form-control" name="name" style="border-radius: 30px;"> -->
                            <select class="form-control" aria-label="Default select example" id="name" name="name" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกผัก....</option>
                                <?php 
                                    $stmt = $db->query("SELECT `pd_id`,`pd_name` FROM `product` WHERE `group_id` = 'CM007'");
                                    $stmt->execute();
                                    $vgs = $stmt->fetchAll();
                                    
                                    foreach($vgs as $vg){
                                ?>
                                <option value="<?= $vg['pd_name']?>"><?= $vg['pd_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">จำนวน **หน่วยเป็นกิโลกรัม**</label>
                                    <input type="number" required class="form-control"  id="quan" name="quan" style="border-radius: 30px;">
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="col-form-label">ราคาต่อกิโลกรัม</label>
                                    <input type="number" required class="form-control" id="price" name="price" style="border-radius: 30px;">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="mb-2">
                            <button onclick="myFunction()" name="submit" class="btn btn-primary" style="border-radius: 30px; font-size: 0.8rem;">คิดเงิน</button>
                        </div> -->
                        <!-- <div class="mb-3">
                            <label for="" class="col-form-label">รวมเงินสุทธิ</label>
                            <input type="text" required class="form-control"  id="total" name="total" style="border-radius: 30px;" readonly>
                        </div> -->
                        <!-- <div class="d-flex justify-content-end">
                            <button class="btn btn-success add_item mb-2" style="border-radius: 30px; font-size: 0.8rem;"><i class="fas fa-plus"></i></button>
                        </div> -->
                        <div class="modal-footer mt-2">
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
                            <h3 class="m-0 font-weight-bold text-primary">ข้อมูลการส่งออกผลผลิต</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">เพิ่มข้อมูลการส่งออกผลผลิต</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr align="center">
                                            <th>รหัสคำสั่งซื้อ</th>
                                            <th>วันที่ส่งออก</th>
                                            <th>ชื่อลูกค้า</th>
                                            <th>ผลผลิตส่งออก</th>
                                            <th>ปริมาณส่งออก</th>
                                            <th>ราคาต่อกิโลกรัม</th>
                                            <th>ราคาสุทธิ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT `px_date`, orderer.odr_name,`px_name`,`px_quan`,`px_price`,`px_total`,`pld_id`
                                                                FROM `Plant_export`
                                                                INNER JOIN `orderer` ON Plant_export.odr_id = orderer.odr_id");
                                            $stmt->execute();
                                            $pxs = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$pxs) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                             foreach($pxs as $px)  {  
                                        ?>
                                        <tr>
                                            <td><?= $px['pld_id']; ?></td>
                                            <td align="center" class="date_th"><?= $px['px_date']; ?></td>
                                            <td><?= $px['odr_name']; ?></td>
                                            <td><?= $px['px_name']; ?></td>
                                            <td><?= $px['px_quan']; ?></td>
                                            <td><?= $px['px_price']; ?></td>
                                            <td><?= $px['px_total']; ?></td>
                                            <td align="center">
                                                <!-- <button class="btn btn-info" style="border-radius: 30px; font-size: 0.8rem;" data-toggle="modal" data-target="#showdataModal<?= $px['px_id']?>">ดูข้อมูล</i></button> -->
                                                <!-- <a href="Edit_px.php?edit_id=<?= $px['px_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: 0.8rem;" name="edit"><i class="fas fa-edit"></i></a> -->
                                                <a data-id="<?= $px['px_id']; ?>" href="?delete=<?= $px['px_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: 0.8rem;">ลบข้อมูล</i></a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $px['px_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลการส่งออกผลผลิต</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>วันที่ส่งออกผลผลิต : </b><?= thai_date_fullmonth(strtotime($px['px_date'])) ; ?></label>
                                                        </div> -->
                                                        <!-- <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อเจ้าของสวน : </b><?= $px['gw_id']; ?></label>
                                                        </div> -->
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ผลผลิตที่รับซื้อ : </b><?= $px['px_name']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>จำนวนที่รับซื้อไว้ : </b><?= $px['px_quan']." กิโลกรัม"; ?></label>
                                                        </div>
                                                        <!-- <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ราคาต่อกิโลกรัม : </b><?= $px['px_pricekg']." บาท"; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ราคาสุทธิ : </b><?= $px['px_totalprice']." บาท"; ?></label>
                                                        </div> -->
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
        $('#g_name').change(function(){
             var id_gw = $(this).val();
            //  console.log(id_gw);
             $.ajax({
                 type : "post",
                 url : "../../api/grower.php",
                 data : {id:id_gw,function:'g_name'},     
                 success: function(data){
                    // console.log(data);
                     $('#g_id').val(data);
                 }
             });
        });

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
                                url: 'Export_products.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Export_products.php';
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


         $('#grower').change(function(){
             var id_gw = $(this).val();
             $.ajax({
                 type : "post",
                 url : "../../api/grower.php",
                 data : {id:id_gw,function:'grower'},     
                 success: function(data){
                     $('#gw_name').val(data);
                 }
             });
         });
         



    </script>



</body>

</html>