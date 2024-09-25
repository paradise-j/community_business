<?php 
    session_start();
    if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 6){
        header("location: ../../index.php");
        exit;
    }
    require_once '../../connect.php';
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
            <?php include('../../sidebar/sidebar6.php');?> <!-- Sidebar -->
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content">
                    <?php include('../../topbar/topbar2.php');?> <!-- Topbar -->
                    <div class="container-fluid">
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
                                                <div class="text-lg font-weight-bold text-success text-uppercase mb-1">จำนวนสมาชิก</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT COUNT(`user_id`) as total FROM `user_data` WHERE `group_id` = '$group_id'");
                                                    $stmt->execute();
                                                    $users = $stmt->fetchAll();
                                                    foreach($users as $user){
                                                        echo $user['total'];
                                                    }
                                                ?>
                                                คน
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                                <div class="text-lg font-weight-bold text-info text-uppercase mb-1">สินค้าทั้งหมด</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php
                                                    $stmt = $db->prepare("SELECT COUNT(`pd_id`) as total FROM `product` WHERE `group_id` = '$group_id'");
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
                                                <i class="fas fa-circle text-primary"></i> รายได้
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-success"></i> รายจ่าย
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
                                        <h6 class="m-0 font-weight-bold text-dark">สรุปยอดขายภาพรวมในแต่ละปี</h6>
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

                        <!-- <div class="row">
                            <div class="col-xl-8 col-lg-7">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">สรุปยอดการส่งของตามออร์เดอ</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="myBarChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
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