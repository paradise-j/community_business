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
        $deletestmt = $db->query("DELETE FROM `planting` WHERE `plant_id` = '$delete_id'");
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
            header("refresh:1; url=PlanFollow.php");
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

    <title>วางแผนและติดตามการผลิต</title>

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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลรายการการสั่งซื้อ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_Plant_order.php" method="POST">
                        <div class="mb-2">
                            <?php $date = date('Y-m-d'); ?>
                            <label for="" class="col-form-label">วันที่ทำรายการ</label>
                            <input type="date" required class="form-control" name="Sdate" id="Sdate" min="<?= $date; ?>" style="border-radius: 30px;">
                        </div>
                        <!-- <div class="mb-2">
                            <label for="" class="col-form-label">วันที่เก็บเกี่ยว</label>
                            <input type="date" required class="form-control" name="Edate" id="Edate" min="<?= $date; ?>" style="border-radius: 30px;">
                        </div> -->
                        <div class="mb-3">
                            <label for="" class="col-form-label">ชื่อผัก</label>
                            <!-- <input type="text" required class="form-control" name="name" style="border-radius: 30px;"> -->
                            <select class="form-control" aria-label="Default select example" id="name" name="name" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกผัก....</option>
                                <?php 
                                    $stmt = $db->query("SELECT * FROM `vegetable`");
                                    $stmt->execute();
                                    $vgs = $stmt->fetchAll();
                                    
                                    foreach($vgs as $vg){
                                ?>
                                <option value="<?= $vg['veget_name']?>"><?= $vg['veget_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">ปริมาณการสั่งซื้อ &nbsp&nbsp&nbsp
                                <label style="color:red;" >** หน่วยเป็น กิโลกรัม **</label>
                            </label>
                            <input type="decimal" required class="form-control" id="quan" name="quan" style="border-radius: 30px;">
                        </div>
                        <!-- <div class="d-flex justify-content-end">
                            <button class="btn btn-success add_item mb-2" style="border-radius: 30px; font-size: 0.8rem;"><i class="fas fa-plus"></i></button>
                        </div> -->
                        <!-- <div id="show_item">
                            <div class="row mb-1">
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <label for="" class="col-form-label">รหัสลูกสวน</label>
                                        <input type="text" required class="form-control" id="g_id" name="g_id" style="border-radius: 30px;" readonly>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="mb-2">
                                        <label for="" class="col-form-label">ชื่อผู้รับผิดชอบ</label>
                                        <select class="form-control" aria-label="Default select example" id="g_name" name="g_name" style="border-radius: 30px;" required>
                                            <option selected disabled>เลือกชื่อผู้รับผิดชอบ....</option>
                                            <?php 
                                                $stmt = $db->query("SELECT * FROM `grower`");
                                                $stmt->execute();
                                                $gws = $stmt->fetchAll();
                                                
                                                foreach($gws as $gw){
                                            ?>
                                            <option value="<?= $gw['gw_id']?>"><?= $gw['gw_name']?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-1">
                                    <div class="mt-3">
                                        <br>
                                        <button class="btn btn-danger remove_item mb-2" style="border-radius: 30px; font-size: 0.8rem;"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div> -->
                            <!-- </div> -->
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
                            <h3 class="m-0 font-weight-bold text-primary">ข้อมูลรายการการสั่งซื้อ</h3>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <!-- <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">เพิ่มข้อมูลรายการการสั่งซื้อ</a> -->
                                <a href="PlantOrderList.php" class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit">เพิ่มข้อมูลรายการการสั่งซื้อ</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr align="center">
                                            
                                            <th>รหัสการสั่งซื้อ</th>
                                            <th>ชื่อผัก</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `plant_orderlist`");
                                            $stmt->execute();
                                            $plds = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$plds) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                             foreach($plds as $pld)  {  
                                        ?>
                                        <tr>
                                            
                                            <td align="center"><?= $pld['pld_id']; ?></td>
                                            <td><?= $pld['pld_nplant']; ?></td>
                                            <td align="center">
                                                <button class="btn btn-info" style="border-radius: 30px; font-size: 0.9rem;" data-toggle="modal" data-target="#showdataModal<?= $pld['pld_id']?>">ดูข้อมูล</button>
                                                <a href="Edit_pld.php?edit_id=<?= $pld['pld_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: 0.9rem;" name="edit">แก้ไข</a>
                                                <a data-id="<?= $pld['pld_id']; ?>" href="?delete=<?= $pld['pld_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: 0.9rem;">ลบ</a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $pld['pld_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลการสั่งซื้อ</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>รหัสการสั่งซื้อ : </b><?= $pld['pld_id']; ?></label>
                                                        </div>
                                                        <div class="mb-2">                         
                                                            <label class="col-form-label" id="date_th" style="font-size: 1.25rem;"><b>วันที่เริ่มปลูก : </b><?= thai_date_fullmonth(strtotime($pld['pld_date'])) ; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อผัก : </b><?= $pld['pld_nplant']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>จำนวนที่ทำการสั่งซื้อ : </b><?= $pld['pld_quan']." "."กิโลกรัม"; ?></label>
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
    <!-- <script src="vendor/jquery/jquery-ui.min.js"></script> -->
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

    <!-- <script>
        $(document).ready(function() {  
            $(".add_item").click(function(e) {
                // console.log("111");
                e.preventDefault();
                $("#show_item").prepend(`
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-2">
                                <label for="" class="col-form-label">รหัสผู้รับผิดชอบ</label>
                                <select class="form-control" aria-label="Default select example" id="grower" name="grower" style="border-radius: 30px;" required>
                                    <option selected disabled>เลือกรหัส....</option>
                                    <?php 
                                        $stmt = $db->query("SELECT * FROM `grower`");
                                        $stmt->execute();
                                        $gws = $stmt->fetchAll();
                                        
                                        foreach($gws as $gw){
                                    ?>
                                    <option value="<?= $gw['gw_id']?>"><?= $gw['gw_id']?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <label for="" class="col-form-label">ชื่อผู้รับผิดชอบ</label>
                                <input type="text" required class="form-control" name="gw_name" id="gw_name" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mt-3">
                                <br>
                                <button class="btn btn-danger remove_item mb-2" style="border-radius: 30px; font-size: 0.8rem;"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>`
                    
                );
            });

            $(document).on('click', '.remove_item', function(e) {
                e.preventDefault();
                let row_item = $(this).parent().parent().parent();
                $(row_item).remove();
            });

        });
    </script> -->


    <script>
        // $(document).ready(function () {
        //     $('#Sdate').datepicker({
        //         dateFormat: 'dd-mm-yy'
        //     });
        // });

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
                                url: 'PlanFollow.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'PlanFollow.php';
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