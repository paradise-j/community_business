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


    if (isset($_REQUEST['mf_id'])) {
        $id = $_REQUEST['mf_id'];
        $_SESSION['mf_id'] = $id;

        $Formula = $db->query("SELECT * FROM `Formula` WHERE `mf_id` = '$id'");
        $Formula->execute();
        $row = $Formula->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $mf_data = $db->query("SELECT `fml_name` FROM `Formula` WHERE `mf_id` = '$id'");
        $mf_data->execute();
        $count = $mf_data->rowCount();

        $mf_check = $db->query("SELECT `mf_name`,`mf_unit` FROM `mf_data` WHERE `mf_id`= '$id'");
        $mf_check->execute();
        $check = $mf_check->fetch(PDO::FETCH_ASSOC);
        extract($check);
    }

    if(isset($_POST["add_fml"])){
        $unit = 'กิโลกรัม';
        if($_POST["price"] < $_POST["cost"]){
            $_SESSION['error'] = 'ไม่สามารถขายสินค้าต่ำกว่าราคาทุนได้';
            header("refresh:2; url=mf_agian.php");
        }else{
            $maxindex = $_SESSION["fml_indexmax"];
            for ($i=1; $i <= $maxindex ; $i++) { 
                $item_array = array(
                    'item_name'       =>     $_POST["fml_name".$i],
                    'item_quantity'      =>     $_POST["fml_quan".$i],
                    'item_unit'       =>     $unit,
                    'item_price'         =>     $_POST["fml_price".$i]
                );
                $_SESSION["materialagain_cart"][] =  $item_array;
            }
            header("location:mf_agian.php?mf_id=".$_SESSION['mf_id']);
            exit;
        }
    }

    // echo '<pre>' . print_r($_SESSION["materialagain_cart"], TRUE) . '</pre>';
?>


<!-- 888b     d888 8888888888               d8888  .d8888b.         d8888 8888888 888b    888  -->
<!-- 8888b   d8888 888                     d88888 d88P  Y88b       d88888   888   8888b   888  -->
<!-- 88888b.d88888 888                    d88P888 888    888      d88P888   888   88888b  888  -->
<!-- 888Y88888P888 8888888               d88P 888 888            d88P 888   888   888Y88b 888  -->
<!-- 888 Y888P 888 888                  d88P  888 888  88888    d88P  888   888   888 Y88b888  -->
<!-- 888  Y8P  888 888                 d88P   888 888    888   d88P   888   888   888  Y88888  -->
<!-- 888   "   888 888                d8888888888 Y88b  d88P  d8888888888   888   888   Y8888  -->
<!-- 888       888 888      88888888 d88P     888  "Y8888P88 d88P     888 8888888 888    Y888  -->
                                                                                                                                                                           
                                                                                      
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>การผลิตสินค้า</title>

    <link rel="icon" type="image/png" href="img/store-solid.svg"/>
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
    <div id="wrapper">
        <?php include('../../sidebar/'.$group_sb.'.php'); ?>  <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../../topbar/topbar2.php');?>  <!-- Topbar -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card shadow mb-2">
                                <div class="card-body">
                                    <div class="card-header py-3 text-center mb-2">
                                        <h5 class="m-0 font-weight-bold text-primary">รายการวัตถุดิบ</h5>
                                    </div>
                                    <form action="?" method="post">
                                        <?php 
                                            $fml_index = 0;
                                            while ($row1 = $mf_data->fetch(PDO::FETCH_ASSOC)) {
                                                $fml_index+=1 ;
                                                echo '<div class="row mb-1">';
                                                    echo '<div class="col-md-6">';
                                                        echo '<label class="col-form-label">วัตถุดิบ</label>';
                                                        echo '<input class="form-control" type="text" name="fml_name'.$fml_index.'" value="'.$row1["fml_name"].'" style="border-radius: 30px;" readonly>';
                                                        // echo '<input class="form-control" type="text" name="fml_name" value="'.$row1["fml_name"].'" style="border-radius: 30px;" readonly>';
                                                    echo '</div>';
                                                    echo '<div class="col-md-3">';
                                                        echo '<label class="col-form-label">ปริมาณ</label>';
                                                        echo '<input class="form-control" type="text" name="fml_quan'.$fml_index.'" value="" style="border-radius: 30px;">';   
                                                        // echo '<input class="form-control" type="text" name="fml_quan" value="" style="border-radius: 30px;">';   
                                                    echo '</div>';
                                                    echo '<div class="col-md-3">';
                                                        echo '<label class="col-form-label">ราคา</label>';
                                                        echo '<input class="form-control" type="text" name="fml_price'.$fml_index.'" value="" style="border-radius: 30px;">';   
                                                        // echo '<input class="form-control" type="text" name="fml_price" value="" style="border-radius: 30px;">';  
                                                    echo '</div>';
                                                echo '</div>';
                                                
                                            }
                                            // echo $fml_index;
                                            $_SESSION["fml_indexmax"] =  $fml_index;

                                        ?>
                                        <div class="row mt-4 mb-4">
                                            <div class="col text-right">
                                                <!-- <a href="mf_agian.php?type=submit" class="btn btn-blue" style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการขาย</a> -->
                                                <button class="btn btn-primary " style="border-radius: 30px;" type="submit" name="add_fml">บึนทึกรายการวัตถุดิบ</button>
                                            </div>  
                                        </div>
                                    </form>
                                </div>
                            </div> 
                        </div>
                        <div class="col-lg-8">
                            <div class="card shadow mb-2">
                                <div class="card-body">
                                    <div class="card-header py-3 text-center mb-2">
                                        <h5 class="m-0 font-weight-bold text-primary">สรุปการผลิตสินค้า</h5>
                                    </div>
                                    <form action="Check_Add_mfagian.php" method="post">
                                        <div class="row mb-2">
                                            <!-- <div class="col-md-1"></div> -->
                                            <div class="col-md-3">
                                                <?php $date = date('Y-m-d'); ?>
                                                <label for="" class="col-form-label">วันที่ในการผลิต</label>
                                                <input type="date" required class="form-control" name="date" max="<?= $date; ?>" style="border-radius: 30px;">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="" class="col-form-label">ชื่อสินค้าที่ผลิต</label>
                                                <input type="text"  class="form-control" name="pdname" id="pdname" value="<?= $mf_name;?>" style="border-radius: 30px;" required readonly>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <label for="" class="col-form-label">จำนวนที่ผลิตได้</label>
                                                <input type="number"  class="form-control" name="pdquan" step="0.01" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label for="" class="col-form-label">หน่วยนับ</label>
                                                <input type="text"  class="form-control" name="pdunit" id="pdunit" value="<?= $mf_unit;?>" style="border-radius: 30px;" required readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-md-2">
                                                <label class="col-form-label">ค่าแรง (บาท)</label>
                                                <input type="number"  class="form-control" name="lbprice" step="0.01" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="col-form-label">ค่าน้ำ (บาท)</label>
                                                <input type="number" required class="form-control" name="water" step="0.01" style="border-radius: 30px;">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="col-form-label">ค่าไฟ (บาท)</label>
                                                <input type="number" required class="form-control" name="elec" step="0.01" style="border-radius: 30px;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="col-form-label">ค่าเชื้อเพลิง (บาท)</label>
                                                <input type="number" required class="form-control" name="fuel" step="0.01" style="border-radius: 30px;">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="col-form-label">ค่าบรรจุภัณฑ์ (บาท)</label>
                                                <input type="number" required class="form-control" name="package" step="0.01" style="border-radius: 30px;">
                                            </div>
                                            
                                        </div>
                                        <div class="row mb-1"> 
                                            <div class="col-md-2">
                                                <label class="col-form-label">อื่น ๆ (บาท)</label>
                                                <input type="number" required class="form-control" name="other" step="0.01" min="0" value="0" style="border-radius: 30px;">
                                            </div>   
                                            <div class="col-md-3">
                                                <label for="" class="col-form-label">ปัญหาในการผลิต</label>
                                                <select class="form-control" aria-label="Default select example" name="problem" style="border-radius: 30px;" required >
                                                    <option selected disabled>เลือกปัญหาในการผลิต....</option>
                                                    <option value="ไม่พบปัญหา">ไม่พบปัญหา</option>
                                                    <option value="หนี้สิน-เงินทุน">หนี้สิน-เงินทุน</option>
                                                    <option value="แหล่งน้ำ">แหล่งน้ำ</option>
                                                    <option value="ที่ดิน">ที่ดิน</option>
                                                    <option value="สิทธิการเกษตร-สวัสดิการ">สิทธิการเกษตร-สวัสดิการ</option>
                                                    <option value="ราคา-การตลาด">ราคา-การตลาด</option>
                                                    <option value="สังคม-คุณภาพชีวิต">สังคม-คุณภาพชีวิต</option>
                                                    <option value="อื่น ๆ">อื่น ๆ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead class="thead-light">
                                                    <tr align="center">
                                                        <th>ชื่อวัตถุดิบ</th>
                                                        <th>จำนวน</th>
                                                        <th>หน่วย</th>
                                                        <th>จำนวนเงิน</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if(!empty($_SESSION["materialagain_cart"])){
                                                        $total=0;
                                                        foreach ($_SESSION['materialagain_cart'] as $key => $value) { 
                                                    ?>
                                                        <tr>
                                                            <td align="center"><?php echo $value['item_name'];?></td>
                                                            <td align="right"><?php echo number_format($value['item_quantity'],2);?></td>
                                                            <td align="right"> <?php echo $value['item_unit'];?></td>
                                                            <td align="right">฿ <?php echo number_format($value['item_price'],2);?> บาท</td>
                                                            <!-- <td align="right">฿ <?php echo number_format($value['item_pricekg']*$value['item_weight'],2);?> บาท</td> -->
                                                            <td align="center"><a href="mf_detail.php?action=delete&id=<?php echo $key;?>">ลบรายการ</td>
                                                        </tr>
                                                    <?php
                                                        $total=$total+($value['item_price']);
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="3" align="right">ราคารวม</td>
                                                        <td align="right">฿ <?php echo number_format($total, 2); ?> บาท</td>
                                                        <td></td>

                                                    </tr>
                                                    <?php
                                                    }else{
                                                        echo "<p><td colspan='5' class='text-center'>ยังไม่มีข้อมูลรายละเอียดวัตถุดิบ</td></p>";
                                                    }
                                                    ?>
                                                </tbody>
                                                <!-- <?php echo '<pre>' . print_r($_SESSION["materialagain_cart"], TRUE) . '</pre>'; ?>  -->
                                                 <!-- <?php echo '<pre>' . print_r($_SESSION["product_cart"], TRUE) . '</pre>'; ?>  -->
                                            </table>
                                        </div>
                                        <div class="row mt-4 mb-4">
                                            <div class="col text-right">
                                                <!-- <a href="mf_agian.php?type=submit" class="btn btn-blue" style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการขาย</a> -->
                                                <button class="btn btn-primary " style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการ</button>
                                            </div>  
                                        </div>
                                    </form>
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
    <script src="../../bootrap/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../bootrap/vendor/datatables/dataTables.bootstrap4.min.js"></script>

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
                                url: 'manufacture.php',
                                type: 'GET',
                                data: 'delete=' + userId,
                            })
                            .done(function() {
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                    icon: 'success',
                                }).then(() => {
                                    document.location.href = 'manufacture.php';
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

        $('#mfname').change(function(){
            var id_mfname = $(this).val();
            console.log("mf = ",id_mfname);
            $.ajax({
                type : "post",
                url : "../../api/mfname.php",
                data : {id:id_mfname,function:'mf'},     
                success: function(data){
                    console.log("unit = ",data);
                    $('#unit').val(data); 

                }
            });
        });

        $('#pdname').change(function(){
            var id_pdunit = $(this).val();
            console.log("id_pdunit = ",id_pdunit);
            $.ajax({
                type : "post",
                url : "../../api/id_pdunit.php",
                data : {id:id_pdunit,function:'pdunit'},     
                success: function(data){
                    console.log("unit = ",data);
                    $('#pdunit').val(data); 

                }
            });
        });

    

        $('#show_dataMem').click(function(){
            var id_mem = $('#id_mem').val();
            // console.log("id_mem = ",id_mem);
            $.ajax({
                type : "post",
                url : "../../api/id_mem.php",
                data : {id:id_mem,function:'id_mem'},     
                success: function(data){
                    // console.log("price = ",data);
                    data.forEach(item => {
                        // console.log("cusname = ",item.cus_name);
                        // console.log("cusphone = ",item.cus_phone);
                        $('#cus').val(item.cus_name); 
                        $('#phone').val(item.cus_phone); 

                    })
                    
                    
                    // $('#phone').val(data[1]);

                }
            });
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