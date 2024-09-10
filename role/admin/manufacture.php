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

    <title>ผลิตสินค้าชุมชน</title>

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
                    <form action="Check_Add_mf.php" method="POST">
                        <div class="mb-3">
                            <?php $date = date('Y-m-d'); ?>
                            <label for="" class="col-form-label">วันที่ในการผลิต</label>
                            <input type="date" required class="form-control" name="date" max="<?= $date; ?>" style="border-radius: 30px;">
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">ชื่อสินค้าที่ผลิต</label>
                            <select class="form-control" aria-label="Default select example" id="pdname" name="pdname" style="border-radius: 30px;" required>
                                <option selected disabled>กรุณาเลือกสินค้า....</option>
                                <?php 
                                    $stmt = $db->query("SELECT `pd_name` FROM `product`");
                                    $stmt->execute();
                                    $pds = $stmt->fetchAll();
                                    
                                    foreach($pds as $pd){
                                ?>
                                <option value="<?= $pd['pd_name']?>"><?= $pd['pd_name']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <!-- <input type="text" required class="form-control" name="pdname" style="border-radius: 30px;"> -->
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">จำนวนที่ผลิตได้</label>
                            <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                        </div>
                        <hr>
                        <label class="col-form-label" style="color: black; font-size: 1.3rem;">รายละเอียดทุนผันแปร</label><br>
                        <div class="row">
                            <div class="col text-center">
                                <label class="col-form-label " style="color: black; font-size: 1.1rem;">------------- ค่าแรงรวม -------------</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="col-form-label">จำนวนคน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">ราคารวม</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <label class="col-form-label " style="color: black; font-size: 1.1rem;">------------- ค่าน้ำ -------------</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="col-form-label">จำนวนหน่วยที่ใช้งาน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <label class="col-form-label " style="color: black; font-size: 1.1rem;">------------- ค่าไฟ -------------</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="col-form-label">จำนวนหน่วยที่ใช้งาน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <!-- ======================================================================ค่าวัตถุดิบหลัก ======================================================================================== -->
                        <div class="row">
                            <div class="col text-center">
                                <label class="col-form-label " style="color: black; font-size: 1.1rem;">------------- ค่าวัตถุดิบหลัก -------------</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label class="col-form-label">รายการวัตถุดิบที่ 1</label>
                                <select class="form-control" aria-label="Default select example" id="g_name" name="g_name" style="border-radius: 30px;" required>
                                    <option selected disabled>เลือกรายการวัตถุดิบ....</option>
                                    <?php 
                                        // $stmt = $db->query("SELECT * FROM `grower`");
                                        // $stmt->execute();
                                        // $gws = $stmt->fetchAll();
                                        
                                        // foreach($gws as $gw){
                                    ?>
                                    <!-- <option value="<?= $gw['gw_id']?>"><?= $gw['gw_name']?></option> -->
                                    <?php
                                        // }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">ปริมาณวัตถุดิบ</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label class="col-form-label">รายการวัตถุดิบที่ 2</label>
                                <select class="form-control" aria-label="Default select example" id="g_name" name="g_name" style="border-radius: 30px;" required>
                                    <option selected disabled>เลือกรายการวัตถุดิบ....</option>
                                    <?php 
                                        // $stmt = $db->query("SELECT * FROM `grower`");
                                        // $stmt->execute();
                                        // $gws = $stmt->fetchAll();
                                        
                                        // foreach($gws as $gw){
                                    ?>
                                    <!-- <option value="<?= $gw['gw_id']?>"><?= $gw['gw_name']?></option> -->
                                    <?php
                                        // }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">ปริมาณวัตถุดิบ</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label class="col-form-label">รายการวัตถุดิบที่ 3</label>
                                <select class="form-control" aria-label="Default select example" id="g_name" name="g_name" style="border-radius: 30px;" required>
                                    <option selected disabled>เลือกรายการวัตถุดิบ....</option>
                                    <?php 
                                        // $stmt = $db->query("SELECT * FROM `grower`");
                                        // $stmt->execute();
                                        // $gws = $stmt->fetchAll();
                                        
                                        // foreach($gws as $gw){
                                    ?>
                                    <!-- <option value="<?= $gw['gw_id']?>"><?= $gw['gw_name']?></option> -->
                                    <?php
                                        // }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">ปริมาณวัตถุดิบ</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label class="col-form-label">รายการวัตถุดิบที่ 4</label>
                                <select class="form-control" aria-label="Default select example" id="g_name" name="g_name" style="border-radius: 30px;" required>
                                    <option selected disabled>เลือกรายการวัตถุดิบ....</option>
                                    <?php 
                                        // $stmt = $db->query("SELECT * FROM `grower`");
                                        // $stmt->execute();
                                        // $gws = $stmt->fetchAll();
                                        
                                        // foreach($gws as $gw){
                                    ?>
                                    <!-- <option value="<?= $gw['gw_id']?>"><?= $gw['gw_name']?></option> -->
                                    <?php
                                        // }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">ปริมาณวัตถุดิบ</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label class="col-form-label">รายการวัตถุดิบที่ 5</label>
                                <select class="form-control" aria-label="Default select example" id="g_name" name="g_name" style="border-radius: 30px;" required>
                                    <option selected disabled>เลือกรายการวัตถุดิบ....</option>
                                    <?php 
                                        // $stmt = $db->query("SELECT * FROM `grower`");
                                        // $stmt->execute();
                                        // $gws = $stmt->fetchAll();
                                        
                                        // foreach($gws as $gw){
                                    ?>
                                    <!-- <option value="<?= $gw['gw_id']?>"><?= $gw['gw_name']?></option> -->
                                    <?php
                                        // }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">ปริมาณวัตถุดิบ</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div><label class="col-form-label">อื่น ๆ </label>
                        <div class="row mb-3">
                            
                            <div class="col-md-4">
                                <label class="col-form-label">ปริมาณวัตถุดิบ</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <!-- ======================================================================ค่าหีบห่อ บรรจุภัณฑ์ ======================================================================================== -->
                        <div class="row">
                            <div class="col text-center">
                                <label class="col-form-label " style="color: black; font-size: 1.1rem;">---------- ค่าหีบห่อ บรรจุภัณฑ์ ----------</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="col-form-label">จำนวนหน่วยที่ใช้งาน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-6">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <label class="col-form-label " style="color: black; font-size: 1.1rem;">------------- อื่น ๆ  -------------</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <label class="col-form-label">รายการอื่น ๆ  </label>
                                <input type="text" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-4">
                                <label class="col-form-label">ปริมาณวัตถุดิบ</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                            <div class="col-md-3">
                                <label class="col-form-label">จำนวนเงิน</label>
                                <input type="number" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">ปัญหาในการผลิต</label>
                            <select class="form-control" aria-label="Default select example" id="g_name" name="g_name" style="border-radius: 30px;" required>
                                <option selected disabled>เลือกปัญหาในการผลิต....</option>
                                <option value="หนี้สิน-เงินทุน">หนี้สิน-เงินทุน</option>
                                <option value="แหล่งน้ำ">แหล่งน้ำ</option>
                                <option value="ที่ดิน">ที่ดิน</option>
                                <option value="สิทธิการเกษตร-สวัสดิการ">สิทธิการเกษตร-สวัสดิการ</option>
                                <option value="ราคา-การตลาด">ราคา-การตลาด</option>
                                <option value="สังคม-คุณภาพชีวิต">สังคม-คุณภาพชีวิต</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="col-form-label">รายละเอียดปัญหา</label>
                            <input type="text" required class="form-control" name="quan" step="0.01" style="border-radius: 30px;">
                            <!-- <textarea name="" id="" style="border-radius: 30px;"></textarea> -->
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
                            <h4 class="m-0 font-weight-bold text-primary">ข้อมูลการรอบการผลิตสินค้าชุมชน</h4>
                        </div>
                        <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px; font-size: .8rem;" type="submit" data-toggle="modal" data-target="#AddGroupModal">เพิ่มข้อมูลการรอบการผลิตสินค้าชุมชน</a>
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
                                            $stmt = $db->query("SELECT * FROM `mf_data`");
                                            $stmt->execute();
                                            $mfs = $stmt->fetchAll();
                                            $count = 1;
                                            if (!$mfs) {
                                                echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                            } else {
                                             foreach($mfs as $mf)  {  
                                        ?>
                                        <tr>
                                            <td><?= $mf['mf_name']; ?></td>
                                            <!-- <td class="date_th"><?= $mf['mf_date']; ?></td> -->
                                            <td align="center">
                                                <button class="btn btn-info" style="border-radius: 30px; font-size: 0.8rem;" data-toggle="modal" data-target="#showdataModal<?= $mf['mf_id']?>">ดูข้อมูล</i></button>
                                                <button class="btn btn-warning" style="border-radius: 30px; font-size: 0.8rem;" data-toggle="modal" data-target="#showdataModal<?= $mf['mf_id']?>">แก้ไข</i></button>
                                                <!-- <a href="Edit_pd.php?edit_id=<?= $mf['mf_id']; ?>" class="btn btn-warning " style="border-radius: 30px; font-size: 0.8rem;" name="edit"><i class="fas fa-edit"></i></a> -->
                                                <a data-id="<?= $mf['mf_id']; ?>" href="?delete=<?= $mf['mf_id']; ?>" class="btn btn-danger delete-btn" style="border-radius: 30px; font-size: 0.8rem;">ลบ</a>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="showdataModal<?= $mf['mf_id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">รายละเอียดข้อมูลการผลิตสินค้าชุมชน</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-2">
                                                            <?php 
                                                                // $date = $mf['mf_date'];
                                                                // $newDate = date("d-m-Y", strtotime($date));
                                                            ?>
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>วันที่ผลิตสินค้าชุมชน : </b><?= thai_date_fullmonth(strtotime($mf['mf_date'])); ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ชื่อการผลิตสินค้าชุมชน : </b><?= $mf['mf_name']; ?></label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" type="number" style="font-size: 1.25rem;"><b>จำนวน : </b><?= number_format($mf['mf_quan'],2); ?> </label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ราคาทุนรวม : </b><?= number_format($mf['mf_cost']);?> บาท</label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <label class="col-form-label" style="font-size: 1.25rem;"><b>ราคาทุนต่อหน่วย : </b><?= number_format($mf['mf_cost']/$mf['mf_quan'],2)." "."บาท"; ?></label>
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