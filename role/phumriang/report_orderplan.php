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
        <?php include('../../sidebar/sidebar7.php');?> <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../../topbar/topbar2.php');?>  <!-- Topbar -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-center">
                            <h4 class="m-0 font-weight-bold text-primary">สรุปยอดการท่องเที่ยวชุมชน</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row mt-2">
                                    <div class="col-md-3"></div>
                                    <label for="inputState" class="form-label mt-2">ตั้งแต่วันที่</label>
                                    <div class="col-md-2">
                                        <input type="date" style="border-radius: 30px;" id="start_date" name="start_date" class="form-control" required>
                                    </div>
                                    <label for="inputState" class="form-label mt-2">ถึงวันที่</label>
                                    <div class="col-md-2">
                                        <input type="date" style="border-radius: 30px;" id="end_date" name="end_date" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success" style="border-radius: 30px;" type="submit" name="submit">เรียกดู</button>
                                    </div>
                                </div>
                            </form>
                            
                            <?php 
                                if(isset($_POST["submit"])){
                                    $start_date = $_POST["start_date"];
                                    // echo $start_date;
                                    $end_date = $_POST["end_date"];
                                    $Gname = $_POST["Gname"];
                                    // echo $Gname ;
                                    $count = 1;

                                    $stmt2 = $db->query("SELECT SUM(`tol_totalNet`) as total , MONTH(`tol_date`) as month 
                                                        FROM `travel_orderlist`
                                                        
                                                        WHERE MONTH(`tol_date`) BETWEEN MONTH('$start_date') AND MONTH('$end_date')
                                                        GROUP BY MONTH(`tol_date`)"); 
                                    $stmt2->execute();

                                    $arr2 = array();
                                    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                        $arr2[] = $row;
                                    }
                                    $dataResult2 = json_encode($arr2);

                                    // echo $dataResult2 ;

                                    $stmt1 = $db->query("SELECT MONTH(travel_orderlist.tol_date) as month, 
                                                                travel_orderlist_detail.tod_type as type, 
                                                                SUM(travel_orderlist_detail.tod_Nprice) as total
                                                        FROM `travel_orderlist_detail` 
                                                        INNER JOIN `travel_orderlist` ON travel_orderlist.tol_id = travel_orderlist_detail.tol_id
                                                        WHERE MONTH(travel_orderlist.tol_date) BETWEEN MONTH('$start_date') AND MONTH('$end_date')
                                                        GROUP BY MONTH(travel_orderlist.tol_date) , travel_orderlist_detail.tod_type");
                                    $stmt1->execute();

                                    $arr = array();
                                    while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                        $arr[] = $row;
                                    }
                                    $dataResult = json_encode($arr);


                                    $stmt3 = $db->query("SELECT MONTH(travel_orderlist.tol_date) as month, 
                                                                travel_orderlist_detail.tod_type as type, 
                                                                SUM(travel_orderlist_detail.tod_deduct) as deduct
                                                        FROM `travel_orderlist_detail` 
                                                        INNER JOIN `travel_orderlist` ON travel_orderlist.tol_id = travel_orderlist_detail.tol_id
                                                        WHERE MONTH(travel_orderlist.tol_date) BETWEEN MONTH('$start_date') AND MONTH('$end_date')
                                                        GROUP BY MONTH(travel_orderlist.tol_date) , travel_orderlist_detail.tod_type");
                                    $stmt3->execute();

                                    $arr3 = array();
                                    while($row = $stmt3->fetch(PDO::FETCH_ASSOC)){
                                        $arr3[] = $row;
                                    }
                                    $dataResult3 = json_encode($arr3);

                                    
                                    
                                }
                            ?>
                            <div class="md-2">
                                <h5 class="m-0 font-weight-bold text-primary text-center">ช่วงเวลาที่กำหนดตั้งแต่</h5>
                                <h4 class="m-0 font-weight-bold text-indigo text-center">
                                    <?php 
                                    if(empty($start_date) and empty($end_date)){
                                        echo "ยังไม่กำหนดช่วงเวลา";
                                    }else{
                                        echo  thai_date_fullmonth(strtotime($start_date))." ถึง ".thai_date_fullmonth(strtotime($end_date));
                                    }
                                    ?> 
                                </h4>
                            </div>
                            
                            <div class="row mt-4">
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
                                                                    WHERE `tol_tp1` NOT LIKE \"\" AND MONTH(`tol_date`) BETWEEN MONTH('$start_date') AND MONTH('$end_date'))
                                                                    UNION 
                                                                    (SELECT \"วิถีชุมชนพุมเรียง\" as \"trip\", COUNT(`tol_tp2`) as \"count\"
                                                                    FROM `travel_orderlist`
                                                                    WHERE `tol_tp2` NOT LIKE \"\" AND MONTH(`tol_date`) BETWEEN MONTH('$start_date') AND MONTH('$end_date'))
                                                                    UNION 
                                                                    (SELECT \"ตามรอยท่านพุทธทาส\" as \"trip\", COUNT(`tol_tp3`) as \"count\"
                                                                    FROM `travel_orderlist` 
                                                                    WHERE `tol_tp3` NOT LIKE \"\" AND MONTH(`tol_date`) BETWEEN MONTH('$start_date') AND MONTH('$end_date'))
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
                                                <canvas id="myChartBar" ></canvas>
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
                                                <canvas id="myChartBar3" ></canvas>
                                            </div>
                                        </div>
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
    <!-- <script src="vendor/datatables/jquery.dataTables.min.js"></script> -->
    <script src="../../bootrap/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../bootrap/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chartjs-plugin-datalabels.min.js"></script>
     <!-- <script type="text-jsvascript" src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0/chartjs-plugin-datalabels.min.js" 
            integrity="sha512-R/QOHLpV1Ggq22vfDAWYOaMd5RopHrJNMxi8/lJu8Oihwi4Ho4BRFeiMiCefn9rasajKjnx9/fTQ/xkWnkDACg==" 
            crossorigin="anonymous" referrerpolicy="no-referrer">
    </script> -->


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

// ============================================= myAreaChart =============================================
        const my_dataAll2 = <?= $dataResult2; ?> ; 
        // comsole.log("my_dataAll2 = "+ my_dataAll2);
        var my_data02 = [];
        var my_label02 = [];
        my_dataAll2.forEach(item => {
            my_data02.push(item.total);
            switch (item.month) {
                case "1" :
                    my_label02.push('มกราคม')
                    break;
                case "2" :
                    my_label02.push('กุมภาพันธ์')
                    break;
                case "3" :
                    my_label02.push('มีนาคม')
                    break;
                case "4" :
                    my_label02.push('เมษายน')
                    break;
                case "5" :
                    my_label02.push('พฤษภาคม')
                    break;
                case "6" :
                    my_label02.push('มิถุนายน')
                    break;
                case "7" :
                    my_label02.push('กรกฎาคม')
                    break;
                case "8" :
                    my_label02.push('สิงหาคม')
                    break;
                case "9" :
                    my_label02.push('กันยายน')
                    break;
                case "10" :
                    my_label02.push('ตุลาคม')
                    break;
                case "11" :
                    my_label02.push('พฤศจิกายน')
                    break;
                case "12" :
                    my_label02.push('ธันวาคม')
                    break; 
            }
            
        });
        // console.log("my_data02 = "+ my_data02);
        // console.log("my_label02 = "+ my_label02);

        
        var ctx = document.getElementById("myAreaChart");
        var myAreaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: my_label02,
                datasets: [{
                    label: "ยอดรายได้ทั้งหมด",
                    lineTension: 0,
                    backgroundColor: "rgba(138, 78, 223, 0.07)",
                    borderColor: "rgba(138, 78, 223, 1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(138, 78, 223, 1)",
                    pointBorderColor: "rgba(138, 78, 223, 1)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(138, 78, 223, 1)",
                    pointHoverBorderColor: "rgba(138, 78, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: my_data02,
                }],
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true
                }
                
            }
            
        });

        // ============================================= myChartBar =============================================
        // const my_dataAll = <?= $dataResult; ?> ; 
        const my_dataAll = <?= $dataResult; ?> ; 
        let res = []
        my_dataAll.forEach(obj => {
            let type = obj['type']
            let month = ''
            switch (obj['month']) {
                case "1" :
                    month ='มกราคม'
                    break;
                case "2" :
                    month ='กุมภาพันธ์'
                    break;
                case "3" :
                    month ='มีนาคม'
                    break;
                case "4" :
                    month ='เมษายน'
                    break;
                case "5" :
                    month ='พฤษภาคม'
                    break;
                case "6" :
                    month ='มิถุนายน'
                    break;
                case "7" :
                    month ='กรกฎาคม'
                    break;
                case "8" :
                    month ='สิงหาคม'
                    break;
                case "9" :
                    month ='กันยายน'
                    break;
                case "10" :
                    month ='ตุลาคม'
                    break;
                case "11" :
                    month ='พฤศจิกายน'
                    break;
                case "12" :
                    month ='ธันวาคม'
                    break; 
            }

            let total = obj['total']
            res[type] = res[type] || []
            res[type][month] = res[type][month] || []
            res[type][month] = total
        })

        var my_data = [];
        var my_label = [];
        var Unique_month = [];
        my_dataAll.forEach(item => {
            my_data.push(item.total);
            switch (item.month) {
                case "1" :
                    my_label.push('มกราคม')
                    break;
                case "2" :
                    my_label.push('กุมภาพันธ์')
                    break;
                case "3" :
                    my_label.push('มีนาคม')
                    break;
                case "4" :
                    my_label.push('เมษายน')
                    break;
                case "5" :
                    my_label.push('พฤษภาคม')
                    break;
                case "6" :
                    my_label.push('มิถุนายน')
                    break;
                case "7" :
                    my_label.push('กรกฎาคม')
                    break;
                case "8" :
                    my_label.push('สิงหาคม')
                    break;
                case "9" :
                    my_label.push('กันยายน')
                    break;
                case "10" :
                    my_label.push('ตุลาคม')
                    break;
                case "11" :
                    my_label.push('พฤศจิกายน')
                    break;
                case "12" :
                    my_label.push('ธันวาคม')
                    break; 
            }
            
        });

        for( var i=0; i<my_label.length; i++ ) {
            if ( Unique_month.indexOf( my_label[i] ) < 0 ) {
            Unique_month.push( my_label[i] );
            }
        } 

        console.log("my_data = "+ my_data);
        // console.log("my_label = "+ my_label);
        console.log("Unique_month = "+ Unique_month);
        console.log("------------------------------------------------");


        function getRandomArbitrary(min, max) {
            return Math.floor(Math.random() * (max - min) + min);
        }


        let backgroundColor = ["#87be7e","#ec396e","#6a4903","#9f9f9f","#c33e22","#ec9206","#eef73e","#2aa251","#17d1ae","#256ae3","#8450ca","#ef34f6"]

        let borderColor = ["#87be7e","#ec396e","#6a4903","#9f9f9f","#c33e22","#ec9206","#eef73e","#2aa251","#17d1ae","#256ae3","#8450ca","#ef34f6"]

        let labels = Unique_month
        let datasets = []
        let tasrgets = Object.keys(res)


        let color_index = 0

        tasrgets.forEach(tasrget => {
            let data = []
            labels.forEach(month => {
                let total = res[tasrget][month] || "0.00"
                data.push(total)
            })
            datasets.push({
                label: tasrget,
                data,
                backgroundColor: backgroundColor[color_index],
                borderColor: borderColor[color_index],
                borderWidth: 1
            })

            color_index = color_index+1
        })


        let data = { labels, datasets }
        // console.log("data = "+ data)

        var ctx = document.getElementById('myChartBar');
        var myChartBar = new Chart(ctx, {
            type: 'bar',
            data ,
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true
                }
            }
        });

        // ============================================= myChartBar3 =============================================
        const my_dataAll3 = <?= $dataResult3; ?> ; 


        let res_1 = []
        my_dataAll3.forEach(obj => {
            let type = obj['type']
            let month = ''
            switch (obj['month']) {
                case "1" :
                    month ='มกราคม'
                    break;
                case "2" :
                    month ='กุมภาพันธ์'
                    break;
                case "3" :
                    month ='มีนาคม'
                    break;
                case "4" :
                    month ='เมษายน'
                    break;
                case "5" :
                    month ='พฤษภาคม'
                    break;
                case "6" :
                    month ='มิถุนายน'
                    break;
                case "7" :
                    month ='กรกฎาคม'
                    break;
                case "8" :
                    month ='สิงหาคม'
                    break;
                case "9" :
                    month ='กันยายน'
                    break;
                case "10" :
                    month ='ตุลาคม'
                    break;
                case "11" :
                    month ='พฤศจิกายน'
                    break;
                case "12" :
                    month ='ธันวาคม'
                    break; 
            }

            let deduct = obj['deduct']
            res_1[type] = res_1[type] || []
            res_1[type][month] = res_1[type][month] || []
            res_1[type][month] = deduct
        })

        var my_data3 = [];
        var my_label3 = [];
        var Unique_month3 = [];
        my_dataAll3.forEach(item => {
            my_data3.push(item.deduct);
            switch (item.month) {
                case "1" :
                    my_label3.push('มกราคม')
                    break;
                case "2" :
                    my_label3.push('กุมภาพันธ์')
                    break;
                case "3" :
                    my_label3.push('มีนาคม')
                    break;
                case "4" :
                    my_label3.push('เมษายน')
                    break;
                case "5" :
                    my_label3.push('พฤษภาคม')
                    break;
                case "6" :
                    my_label3.push('มิถุนายน')
                    break;
                case "7" :
                    my_label3.push('กรกฎาคม')
                    break;
                case "8" :
                    my_label3.push('สิงหาคม')
                    break;
                case "9" :
                    my_label3.push('กันยายน')
                    break;
                case "10" :
                    my_label3.push('ตุลาคม')
                    break;
                case "11" :
                    my_label3.push('พฤศจิกายน')
                    break;
                case "12" :
                    my_label3.push('ธันวาคม')
                    break; 
            }
            
        });

        for( var i=0; i<my_label3.length; i++ ) {
            if ( Unique_month3.indexOf( my_label3[i] ) < 0 ) {
            Unique_month3.push( my_label3[i] );
            }
        } 
        console.log("my_data3 = "+ my_data3);
        // console.log("my_label3 = "+ my_label3);
        console.log("Unique_month3 = "+ Unique_month3);


        function getRandomArbitrary(min, max) {
            return Math.floor(Math.random() * (max - min) + min);
        }


        let backgroundColor3 = ["#c33e22","#ec9206","#eef73e","#87be7e","#2aa251","#17d1ae","#256ae3","#8450ca","#ef34f6","#ec396e","#6a4903","#9f9f9f"]

        let borderColor3 = ["#c33e22","#ec9206","#eef73e","#87be7e","#2aa251","#17d1ae","#256ae3","#8450ca","#ef34f6","#ec396e","#6a4903","#9f9f9f"]

        let labels3 = Unique_month3
        let datasets3 = []
        let tasrgets3 = Object.keys(res_1)


        let color_index3 = 0

        tasrgets3.forEach(tasrget3 => {
            let data3 = []
            labels3.forEach(month3 => {
                let total3 = res_1[tasrget3][month3] || "0.00"
                data3.push(total3)
            })
            datasets3.push({
                label: tasrget3,
                data: data3,
                backgroundColor: backgroundColor3[color_index3],
                borderColor: borderColor3[color_index3],
                borderWidth: 1
            })

            color_index3 = color_index3+1
        })


        let data3 = { labels:labels3, datasets:datasets3 }
        // console.log("datasets3 = "+ datasets3) 
        // console.log(JSON.stringify(data3)) 
        
        var ctx3 = document.getElementById('myChartBar3');
        var myChartBar3 = new Chart(ctx3, {
            type: 'bar',
            data: data3 ,
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true
                }
            }
        });


        
        // const dom_date = document.querySelectorAll('.date_th')
        // dom_date.forEach((elem)=>{

        //     const my_date = elem.textContent
        //     const date = new Date(my_date)
        //     const result = date.toLocaleDateString('th-TH', {

        //     year: 'numeric',
        //     month: 'long',
        //     day: 'numeric',

        //     }) 
        //     elem.textContent=result
        // })
        
        // $.extend(true, $.fn.dataTable.defaults, {
        //     "language": {
        //             "sProcessing": "กำลังดำเนินการ...",
        //             "sLengthMenu": "แสดง _MENU_ รายการ",
        //             "sZeroRecords": "ไม่พบข้อมูล",
        //             "sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
        //             "sInfoEmpty": "แสดงรายการ 0 ถึง 0 จาก 0 รายการ",
        //             "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกรายการ)",
        //             "sInfoPostFix": "",
        //             "sSearch": "ค้นหา:",
        //             "sUrl": "",
        //             "oPaginate": {
        //                             "sFirst": "เริ่มต้น",
        //                             "sPrevious": "ก่อนหน้า",
        //                             "sNext": "ถัดไป",
        //                             "sLast": "สุดท้าย"
        //             }
        //     }
        // });
        // $('.table').DataTable();


    </script>

</body>

</html>