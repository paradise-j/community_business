<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 6){
        header("location: ../../index.php");
        exit;
    }
    require_once '../../connect.php';

    $user_id = $_SESSION['user_id'];
    $stmt2 = $db->query("SELECT `group_id` FROM `user_data` WHERE `user_id` = '$user_id'");
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);
    // echo $group_sb;

    $stmt3 = $db->query("SELECT `group_sb` FROM `group_comen` WHERE `group_id` = '$group_id'");
    $stmt3->execute();
    $check_groupsb = $stmt3->fetch(PDO::FETCH_ASSOC);
    extract($check_groupsb);
    // echo $group_sb;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>ระบบจัดการข้อมูลร้านค้ารัฐวิสาหกิจชุมชน</title>

        <!-- Custom fonts for this template-->
        <link rel="icon" type="image/png" href="img/home-solid.svg">
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link
            href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
            rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
    </head>

    <body id="page-top">
        <div id="wrapper">  
            <?php include('../../sidebar/'.$group_sb.'.php'); ?>  <!-- Sidebar -->
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include('../../topbar/topbar2.php');?> <!-- Topbar -->
                    <div class="container-fluid">
                    <?php
                        $dayTH = ['อาทิตย์','จันทร์','อังคาร','พุธ','พฤหัสบดี','ศุกร์','เสาร์'];
                        $monthTH = [null,'มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
                        $monthTH_brev = [null,'ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];

                        function thai_date_fullmonth($time){   // 19 ธันวาคม 2556
                            global $dayTH,$monthTH;   
                            // $thai_date_return = date("j",$time);   
                            // $thai_date_return.=" ".$monthTH[date("n",$time)];   
                            $thai_date_return.= " ".(date("Y",$time)+543);   
                            return $thai_date_return;   
                        } 
                    ?>
                        <div class="row">
                            <?php $date = date('Y-m-d'); ?>
                            <?php //$date2 = date('Y'); echo $date2; ?>
                            <div class="col text-center"><h1 class="text-dark center">สรุปยอดขายภาพรวมในการดำเนินงานในปี พ.ศ. <?= thai_date_fullmonth(strtotime($date));?></h1></div>
                        </div>
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
                        ?>
                        <div class="row">
                        

                            <!-- <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-lg font-weight-bold text-success text-uppercase mb-1">จำนวนสมาชิก</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"> -->
                                                <?php
                                                    // $stmt = $db->prepare("SELECT COUNT(`user_id`) as total FROM `user_data` WHERE `group_id` = '$group_id'");
                                                    // $stmt->execute();
                                                    // $users = $stmt->fetchAll();
                                                    // foreach($users as $user){
                                                    //     echo $user['total'];
                                                    // }
                                                ?>
                                                <!-- คน -->
                                                <!-- </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->

                            
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-lg font-weight-bold text-success text-uppercase mb-1">สินค้าทั้งหมด</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT COUNT(`pd_id`) as total FROM `product`");
                                                    $stmt->execute();
                                                    $pds = $stmt->fetchAll();
                                                    foreach($pds as $pd){
                                                        echo $pd['total'];
                                                    }
                                                ?>
                                                รายการ
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-brands fa-product-hunt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-info shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-lg font-weight-bold text-info text-uppercase mb-1">ยอดขายรวมสะสม</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT  SUM(salesdetail.sd_price) as sum_price
                                                                          FROM `mf_data` 
                                                                          INNER JOIN `salesdetail` ON mf_data.mf_name = salesdetail.sd_pdname 
                                                                        --   WHERE mf_data.group_id = '$group_id'
                                                                          ");
                                                    $stmt->execute();
                                                    $pds = $stmt->fetchAll();
                                                    foreach($pds as $pd){
                                                        echo number_format($pd['sum_price'],2); 
                                                    }
                                                ?>
                                                บาท
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-brands fa-product-hunt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-purple shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-lg font-weight-bold text-purple text-uppercase mb-1">กำไรรวมสะสม</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT  (SUM(salesdetail.sd_price) - mf_data.mf_price) as profit
                                                                          FROM `mf_data` 
                                                                          INNER JOIN `salesdetail` ON mf_data.mf_name = salesdetail.sd_pdname 
                                                                        --   WHERE mf_data.group_id = '$group_id'
                                                                          ");
                                                    $stmt->execute();
                                                    $pds = $stmt->fetchAll();
                                                    foreach($pds as $pd){
                                                        echo number_format($pd['profit'],2); 
                                                    }
                                                ?>
                                                บาท
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-brands fa-product-hunt fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Pie Chart -->
                            <div class="col-xl-4 col-lg-5">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-dark">สรุปยอดรายรับ-รายจ่าย ภาพรวมทั้งหมด</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-pie pt-4 pb-2">
                                            <canvas id="myPieChart"></canvas>
                                        </div>
                                        <div class="mt-4 text-center small">
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-success"></i> รายรับ
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-danger"></i> รายจ่าย
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Area Chart -->
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-dark">สรุปยอดขายภาพรวมในแต่ละเดือน</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-area">
                                            <canvas id="myAreaChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-7 col-lg-7">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-dark">สรุปยอดกำไรรวมจากยอดขายสินค้าสะสม (บาท)</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- <div class="chart-bar">
                                            <canvas id="myBarChart"></canvas>
                                        </div> -->
                                        <div class="table-responsive scrollbar">
                                            <table class="table" id="dataTable" width="100%" cellspacing="0" >
                                                <thead>
                                                    <tr align="center" style="font-size: 0.8em;">
                                                        <!-- <th>เดือน</th> -->
                                                        <th>ชื่อรายการ</th>
                                                        <th>ต้นทุนรวมสะสม</th>
                                                        <th>จำนวนคงเหลือ</th>
                                                        <th>จำนวนที่ขายไป</th>
                                                        <th>ยอดขายรวมสะสม</th>
                                                        <th>กำไรรวม</th>
                                                        
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
                                                        $stmt = $db->query("SELECT mf_data.mf_name ,mf_data.mf_unit, mf_data.mf_price , SUM(salesdetail.sd_price) as sum_price , mf_data.mf_quan , 
                                                                            SUM(salesdetail.sd_quantity) as sd_quantity , (SUM(salesdetail.sd_price) - mf_data.mf_price) as profit
                                                                            FROM `mf_data` 
                                                                            INNER JOIN `salesdetail` ON mf_data.mf_name = salesdetail.sd_pdname 
                                                                            -- WHERE mf_data.group_id = '$group_id' 
                                                                            GROUP BY mf_data.mf_name");
                                                        $stmt->execute();
                                                        $ggs = $stmt->fetchAll();
                                                        if (!$ggs) {
                                                            echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                                        } else {
                                                        foreach($ggs as $gg)  {  
                                                    ?>
                                                    <tr align="center" style="font-size: 0.8em;">
                                                        <!-- <td><?= $gg['month']; ?></td> -->
                                                        <td><?= $gg['mf_name']; ?></td>
                                                        <td><?= $gg['mf_price']; ?></td>
                                                        <td><?= $gg['mf_quan']." ".$gg['mf_unit']; ?></td>
                                                        <td><?= $gg['sd_quantity']." ".$gg['mf_unit']; ?></td>
                                                        <td><?= $gg['sum_price']; ?></td>
                                                        <td><?= $gg['profit']; ?></td>
                                                    </tr>
                                                    <?php }
                                                        } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-7">
                                <div class="card shadow">
                                    <!-- Card Header - Dropdown -->
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-dark">สรุปยอดกำไรภาพรวมในปุัจจุบัน</h6>
                                    </div>
                                    <!-- Card Body -->
                                    <div class="card-body">
                                        <div class="chart-area">
                                            <canvas id="myBarChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
                <?php include('../../footer/footer.php');?> <!-- Footer -->
            </div>
        </div>

        <!-- Scroll to Top Button-->
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
        <script src="vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/chart-area-demo.js"></script>
        <script src="js/demo/chart-pie-demo.js"></script>
        <script src="js/demo/chart-bar-demo.js"></script>
    </body>
</html>