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

    $stmt3 = $db->query("SELECT `group_sb` FROM `group_comen` WHERE `group_id` = '$group_id'");
    $stmt3->execute();
    $check_groupsb = $stmt3->fetch(PDO::FETCH_ASSOC);
    extract($check_groupsb);

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
                            <div class="col-xl-4 col-md-6 mb-4">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-lg font-weight-bold text-success text-uppercase mb-1">แพ็คเกจทั้งหมด</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT COUNT(`tp_id`) as total FROM `travel_pack`");
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
                                                    $stmt = $db->prepare("SELECT
                                                                            SUM(travel_orderlist_detail.tod_Nprice) as \"total\"
                                                                        FROM
                                                                        `travel_orderlist_detail`
                                                                        INNER JOIN `travel_orderlist` ON travel_orderlist.tol_id = travel_orderlist_detail.tol_id");
                                                    $stmt->execute();
                                                    $pds = $stmt->fetchAll();
                                                    foreach($pds as $pd){
                                                        echo number_format($pd['total'],2); 
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
                                                    $stmt = $db->prepare("SELECT
                                                                            (SUM(travel_orderlist_detail.tod_Nprice))-(SUM(travel_orderlist_detail.tod_deduct)) as \"total\"
                                                                        FROM
                                                                        `travel_orderlist_detail`
                                                                        INNER JOIN `travel_orderlist` ON travel_orderlist.tol_id = travel_orderlist_detail.tol_id");
                                                    $stmt->execute();
                                                    $pds = $stmt->fetchAll();
                                                    foreach($pds as $pd){
                                                        echo number_format($pd['total'],2); 
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
                            <div class="col-xl-4 col-lg-4">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <h5 class="m-0 font-weight-bold text-primary">สรุปโปรแกรมท่องเที่ยวที่นิยม</h5>
                                    </div>
                                    <div class="card-body">
                                            <table width="100%" cellspacing="0">
                                                <thead>
                                                    <tr align="center" style="font-size: 1rem;">
                                                        <th>จำนวนกลุ่มนักท่องเที่ยว</th>
                                                        <th>ชื่อโปรแกรม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        try{
                                                            $stmt4 = $db->query("SELECT * FROM (
                                                                (SELECT \"เกาะเสร็จ\" as \"trip\", COUNT(`tol_tp1`) as \"count\"
                                                                FROM `travel_orderlist`
                                                                WHERE `tol_tp1` NOT LIKE \"\")
                                                                UNION 
                                                                (SELECT \"วิถีชุมชนพุมเรียง\" as \"trip\", COUNT(`tol_tp2`) as \"count\"
                                                                FROM `travel_orderlist`
                                                                WHERE `tol_tp2` NOT LIKE \"\")
                                                                UNION 
                                                                (SELECT \"ตามรอยท่านพุทธทาส\" as \"trip\", COUNT(`tol_tp3`) as \"count\"
                                                                FROM `travel_orderlist` 
                                                                WHERE `tol_tp3` NOT LIKE \"\")
                                                                )`tb1` 
                                                                ORDER BY `tb1`.count DESC");
                                                            $stmt4->execute();
                                                            $tps = $stmt4->fetchAll();

                                                            if (empty($tps)) {
                                                            echo "<p><td colspan='6' class='text-center'>ไม่พบข้อมูล</td></p>";
                                                            } else {
                                                                foreach($tps as $tp)  {
                                                                    $trip = $tp['trip'];
                                                                    $count = $tp['count'];
                                                    ?>
                                                    <tr align="center" style="font-size: 0.8em;">
                                                        
                                                        
                                                        <td style="font-size: 1rem;"><?php   if(empty($count)){ echo "0"; }else{ echo  $count;}?></td>
                                                        <td style="font-size: 1rem;"><?php   if(empty($trip)){ echo "0"; }else{ echo  $trip;}?></td>
                                                    </tr>
                                                    <?php       }
                                                            }
                                                        } catch(PDOException $e) {
                                                            echo "Connection failed: " . $e->getMessage();
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                        <!-- </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-4">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <h5 class="m-0 font-weight-bold text-primary">สรุปยอดรายได้ทั้งหมดในแต่ละเดือน</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-area">
                                            <canvas id="myAreaChart" ></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            
                            <div class="col-xl-6 col-lg-4">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <h5 class="m-0 font-weight-bold text-primary">สรุปรายได้ทั้งหมดแยกตามแพ็คเกจ</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-area">
                                            <canvas id="myChartBar1" ></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-4">
                                <div class="card shadow">
                                    <div class="card-header py-3">
                                        <h5 class="m-0 font-weight-bold text-primary">สรุปยอดรายได้ที่หักเข้ากลุ่ม แยกตามแพ็คเกจ</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-area">
                                            <canvas id="myChartBar2" ></canvas>
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
        <script src="js/demo/chart-bar1-demo.js"></script>
        <script src="js/demo/chart-bar2-demo.js"></script>
    </body>
</html>