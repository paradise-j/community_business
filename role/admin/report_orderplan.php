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
        <?php include('../../sidebar/sidebar.php');?> <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../../topbar/topbar2.php');?>  <!-- Topbar -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 text-center">
                            <h4 class="m-0 font-weight-bold text-primary">สรุปยอดการผลิตสินค้า</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row mt-2">
                                    <div class="col-md-2"></div>
                                    <label class="col-form-label">ชื่อสินค้า</label>
                                    <div class="col-md-2">
                                        <select class="form-control" aria-label="Default select example" id="Gname" name="Gname" style="border-radius: 30px;">
                                            <option selected disabled>กรุณาเลือกชื่อสินค้า....</option>
                                            <?php 
                                                $stmt = $db->query("SELECT * FROM `product`");
                                                $stmt->execute();
                                                $pds = $stmt->fetchAll();
                                                
                                                foreach($pds as $pd){
                                            ?>
                                            <option value="<?= $pd['pd_id']?>"><?= $pd['pd_name']?></option>
                                            <?php
                                                }
                                            ?>
                                        </select>
                                    </div>
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
                                    $count = 1;

                                    $stmt2 = $db->query("SELECT SUM(sales.sale_Nprice) as total , MONTH(sale_date) as month 
                                                         FROM `sales` 
                                                         INNER JOIN `salesdetail` ON sales.sale_id = salesdetail.sale_id 
                                                         WHERE MONTH(sale_date) BETWEEN MONTH('$start_date') AND MONTH('$end_date')
                                                         GROUP BY MONTH(sale_date)"); 
                                    $stmt2->execute();

                                    $arr2 = array();
                                    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
                                        $arr2[] = $row;
                                    }
                                    $dataResult2 = json_encode($arr2);

                                    // echo $dataResult2 ;

                                    // $stmt1 = $db->query("SELECT group_g.gg_type , MONTH(sale.sale_date) as month , SUM(salelist.slist_price) as total
                                    //                     FROM `salelist` 
                                    //                     INNER JOIN `sale` ON sale.sale_id = salelist.sale_id
                                    //                     INNER JOIN `group_g` ON group_g.gg_id = salelist.gg_id 
                                    //                     WHERE MONTH(sale.sale_date) BETWEEN MONTH('$start_date') AND MONTH('$end_date')
                                    //                     GROUP BY  group_g.gg_type , MONTH(sale.sale_date)");
                                    // $stmt1->execute();

                                    // $arr = array();
                                    // while($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                    //     $arr[] = $row;
                                    // }
                                    // $dataResult = json_encode($arr);
                                }
                            ?>
                            <div class="row mt-4">
                                <!-- <div class="col-xl-5 col-lg-4">
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <h5 class="m-0 font-weight-bold text-primary">สรุปยอดขายสินค้า</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-area">
                                                <canvas id="myAreaChart" ></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-xl-7 col-lg-8">
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <h5 class="m-0 font-weight-bold text-primary text-center">สรุปยอดขายสินค้าในแต่ละเดือน</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-area">
                                                <canvas id="myAreaChart" ></canvas>
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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chartjs-plugin-datalabels.js"></script>


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
                case 1 :
                    my_label02.push('มกราคม')
                    break;
                case 2 :
                    my_label02.push('กุมภาพันธ์')
                    break;
                case 3 :
                    my_label02.push('มีนาคม')
                    break;
                case 4 :
                    my_label02.push('เมษายน')
                    break;
                case 5 :
                    my_label02.push('พฤษภาคม')
                    break;
                case 6 :
                    my_label02.push('มิถุนายน')
                    break;
                case 7 :
                    my_label02.push('กรกฎาคม')
                    break;
                case 8 :
                    my_label02.push('สิงหาคม')
                    break;
                case 9 :
                    my_label02.push('กันยายน')
                    break;
                case 10 :
                    my_label02.push('ตุลาคม')
                    break;
                case 11 :
                    my_label02.push('พฤศจิกายน')
                    break;
                case 12 :
                    my_label02.push('ธันวาคม')
                    break; 
            }
            
        });
        console.log("my_data02 = "+ my_data02);
        console.log("my_label02 = "+ my_label02);
        
        var ctx = document.getElementById("myAreaChart");
        var myAreaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: my_label02,
                datasets: [{
                    label: "ยอดขายสุทธิ",
                    lineTension: 0,
                    backgroundColor: "rgba(78, 115, 223, 0.07)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: my_data02,
                }],
            },
            options: {
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