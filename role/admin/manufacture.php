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
        $deletestmt = $db->query("DELETE FROM `product` WHERE `pd_id` = '$delete_id'");
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
            header("refresh:1; url=Product.php");
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

    <title>เพาะปลูก</title>

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
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลการรอบการผลิต</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_product.php" method="POST">
                        <div class="mb-3">
                            <label for="" class="col-form-label">วันที่ในการผลิต</label>
                            <input type="date" required class="form-control" name="namegf" style="border-radius: 30px;">
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">ชื่อรายการผลิต</label>
                            <input type="text" required class="form-control" name="pdname" style="border-radius: 30px;">
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">จำนวน</label>
                            <input type="number" required class="form-control" name="quan" style="border-radius: 30px;">
                        </div>
                        <div class="mb-3">
                            <label for="firstname" class="col-form-label">ราคาทุน</label>
                            <input type="number" required class="form-control" name="cost" style="border-radius: 30px;">
                        </div>
                        <!-- <div class="mb-3">
                            <?php $date = date('Y-m-d'); ?>
                            <label for="firstname" class="col-form-label">วันที่รับของ</label>
                            <input type="date" required class="form-control" name="date" max="<?= $date; ?>" style="border-radius: 30px;">
                        </div> -->
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
                            <h4 class="m-0 font-weight-bold text-primary">ข้อมูลการรอบการผลิต</h4>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">เพิ่มข้อมูลการรอบการผลิต</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr align="center">
                                            <th>รายการผลิต</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $stmt = $db->query("SELECT * FROM `planting`");
                                            $stmt->execute();
                                            $pts = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$pts) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                             foreach($pts as $pt)  {  
                                        ?>
                                        <tr>
                                            <td><?= $pt['plant_name']; ?></td>
                                            <!-- <td class="date_th"><?= $pt['plant_date']; ?></td> -->
                                            <td align="center">
                                                <button class="btn btn-info" style="border-radius: 30px; font-size: .75rem;" data-toggle="modal" data-target="#showdataModal<?= $pt['plant_id']?>"><i class="fas fa-eye"></i></button>
                                                <a href="Edit_pd.php?edit_id=<?= $pt['plant_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: .75rem;" name="edit"><i class="fas fa-edit"></i></a>
                                                <a data-id="<?= $pt['plant_id']; ?>" href="?delete=<?= $pt['plant_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: .75rem;"><i class="fa-solid fa-trash"></i></a>
                                            </td>
                                            <!-- <td align="center"><a href="Edit_pd.php?edit_id=<?= $pt['plant_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: .75rem;" name="edit"><i class="fas fa-edit"></i></a></td> -->
                                            <!-- <td align="center"><a data-id="<?= $pt['plant_id']; ?>" href="?delete=<?= $pt['plant_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: .75rem;"><i class="fa-solid fa-trash"></i></a></td> -->
                                            
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $pt['plant_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลการเพาะปลูก</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <?php 
                                                                $date = $pt['plant_date'];
                                                                $newDate = date("d-m-Y", strtotime($date));
                                                            ?>
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>วันที่รับของ : </b><?=$newDate; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อการเพาะปลูก : </b><?= $pt['plant_name']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" type="number" style="font-size: 1.25rem;"><b>จำนวน : </b><?= number_format($pt['plant_quan']); ?> </label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ราคาทุน : </b><?= number_format($pt['plant_cost']);?> บาท</label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ราคาทุนต่อหน่วย : </b><?= number_format($pt['plant_unitcost'],2); ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ราคาขายต่อหน่วย : </b><?=number_format($pt['plant_unitprice']); ?></label>
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
                                url: 'Product.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'Product.php';
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