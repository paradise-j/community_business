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
            header("refresh:1; url=TravelOrderList.php");
        }
    }



    if(isset($_POST["add_sale"])){
        $tpname = $_POST['tpname'];

        $pd = $db->prepare("SELECT `tp_name` FROM `travel_pack` WHERE `tp_id` = '$tpname'");
        $pd->execute();
        $row = $pd->fetch(PDO::FETCH_ASSOC);
        extract($row);

        // if($_POST["quantity"] > $gg_quantity){
        //     $_SESSION['error'] = 'ยอดสินค้าของท่านไม่เพียงพอ';
        //     header("refresh:2; url=PlantOrderList.php");
        // }else{
            $item_array = array(

                'item_tpname'       =>     $tp_name,
                'item_tpprice'      =>     $_POST["tpprice"],
                'item_tpquan'      =>     $_POST["tpquan"],
                );
                $_SESSION["shopping_tp"][] =  $item_array;
            header("location:TravelOrderList.php");
            exit;
        // }
    }

    if(isset($_GET['action'])){
        if($_GET['action']=="delete"){
            $id = $_GET["id"];
            unset($_SESSION["shopping_tp"][$id]);
            header("location:TravelOrderList.php");
            exit;
            // $total = $total-($_SESSION["shopping_tp"]['item_pricepd']*$_SESSION["shopping_tp"]['item_quantity']);
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

    <title>การจอง</title>

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
        <?php include('../../sidebar/sidebar7.php');?> <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../../topbar/topbar2.php');?>  <!-- Topbar -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 text-center">
                                    <h5 class="m-0 font-weight-bold text-primary">รายละเอียดการจอง</h5>
                                </div>
                                <div class="card-body">
                                    <form action="?" method="POST" enctype="multipart/form-data">
                                        <?php if(isset($_SESSION['error'])) { ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php 
                                                    echo $_SESSION['error'];
                                                    unset($_SESSION['error']);
                                                ?>
                                            </div>
                                        <?php } ?>
                                        <!-- <div class="row mt-2"> -->
                                            <!-- <div class="col text-center">
                                                <label style="color:red;" >**** ในกรณีในเดือนนั้นขายแพะไม่ครบทุกประเภท ให้ระบุค่า 0 ลงในประเภทแพะที่ไม่ได้ขาย ****</label>
                                            </div> -->
                                        <!-- </div> -->
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">ชื่อแพ็คเกจ</label>
                                                <select class="form-control" aria-label="Default select example"  id="tpname" name="tpname" style="border-radius: 30px;" required>
                                                    <option selected disabled>กรุณาเลือก....</option>
                                                    <?php 
                                                        $stmt = $db->query("SELECT * FROM `travel_pack`");
                                                        $stmt->execute();
                                                        $tps = $stmt->fetchAll();
                                                        
                                                        foreach($tps as $tp){
                                                    ?>
                                                    <option value="<?= $tp['tp_id']?>"><?= $tp['tp_name']?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ราคา</label>
                                                <input type="number" class="form-control" id="tpprice" name="tpprice" step="0.01" style="border-radius: 30px;" required>
                                            </div>
                                            <!-- <div class="col-md-3">
                                                <label class="form-label">ราคา &nbsp&nbsp&nbsp
                                                </label>
                                                <input type="number" class="form-control" id="tpprice" name="tpprice" step="0.01" style="border-radius: 30px;" required>
                                            </div> -->
                                            <div class="col-md-3">
                                                <label class="form-label">จำนวน &nbsp&nbsp&nbsp
                                                </label>
                                                <input type="number" class="form-control" id="tpquan" name="tpquan" step="1" style="border-radius: 30px;" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col text-right">
                                                <button class="btn btn-primary" style="border-radius: 30px;" type="submit" name="add_sale">เพิ่มรายการ</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                               
                            </div>
                            <div class="col text-left">
                                <a href="Travel.php" class="btn btn-secondary" style="border-radius: 30px;"><i class="fa-solid fa-arrow-left"></i>&nbsp&nbsp&nbspย้อนกลับ</a>
                            </div>
                        </div>
                        
                        <div class="col-lg-7">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="card-header py-3 text-center mb-4">
                                        <h5 class="m-0 font-weight-bold text-primary">สรุปการจอง
                                    </div>
                                    <form action="Check_Add_TravelOrderList.php" method="post">
                                        <div class="row mb-3">
                                            <div class="col-md-2">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="tp1" value="เกาะเสร็จ">
                                                    <label class="form-check-label" for="inlineCheckbox1" style="font-size: 1.2rem;">เกาะเสร็จ</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="tp2" value="ผ้าไหมพุมเรียง">
                                                    <label class="form-check-label" for="inlineCheckbox1" style="font-size: 1.2rem;">ผ้าไหมพุมเรียง</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="tp3" value="ตามรอยท่านพุทธทาส">
                                                    <label class="form-check-label" for="inlineCheckbox1" style="font-size: 1.2rem;">ตามรอยท่านพุทธทาส</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-4">
                                                <label class="form-label">ชื่อผู้จอง</label>
                                                <!-- <input type="text" class="form-control" name="cus" style="border-radius: 30px;" required> -->
                                                <!-- <select class="form-control" aria-label="Default select example"  id="orderer" name="orderer" style="border-radius: 30px;" required>
                                                    <option selected disabled>กรุณาเลือก....</option>
                                                    <?php 
                                                        $stmt = $db->query("SELECT `odr_id`, `odr_name` FROM `orderer`");
                                                        $stmt->execute();
                                                        $odrs = $stmt->fetchAll();
                                                        
                                                        foreach($odrs as $odr){
                                                    ?>
                                                    <option value="<?= $odr['odr_id']?>"><?= $odr['odr_name']?></option>
                                                    <?php
                                                        }
                                                    ?>
                                                    
                                                </select> -->
                                                <input type="text" class="form-control" id="name" name="name" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">เบอร์โทรศัพท์</label>
                                                <input type="text" class="form-control" id="phone" name="phone" minlength="10" maxlength="10"style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">วันที่ทำการจอง</label>
                                                <?php $date = date('Y-m-d'); ?>
                                                <input type="date" class="form-control" name="date" min="<?= $date; ?>" style="border-radius: 30px;" required>
                                            </div>
                                            
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-3">
                                                <label class="form-label">จำนวนนักท่องเที่ยว</label>
                                                <input type="number" class="form-control" id="quan_pp" name="quan_pp" style="border-radius: 30px;" required>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead class="thead-light">
                                                    <tr align ="center">
                                                        <th>ชื่อสินค้า</th>
                                                        <th>จำนวน</th>
                                                        <th>ราคา</th>
                                                        <th>ราคารวม</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if(!empty($_SESSION["shopping_tp"])){
                                                        $total=0;
                                                        foreach ($_SESSION['shopping_tp'] as $key => $value) { 
                                                    ?>
                                                        <tr>
                                                            <td align="center"><?php echo $value['item_tpname'];?></td>
                                                            <td align="right"><?php echo number_format($value['item_tpquan'])." รายการ";?></td>
                                                            <td align="right"><?php echo number_format($value['item_tpprice'],2)." บาท";?></td>
                                                            <td align="right"><?php echo number_format($value['item_tpquan']*$value['item_tpprice'],2)." บาท";?></td>
                                                            <!-- <td align="right">฿ <?php echo number_format($value['item_pricekg']*$value['item_weight'],2);?> บาท</td> -->
                                                            <td align="center"><a href="TravelOrderList.php?action=delete&id=<?php echo $key;?>">ลบรายการ</td>
                                                        </tr>
                                                    <?php
                                                        $total=$total+($value['item_tpquan']*$value['item_tpprice']);
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td align="right" colspan='3'>ราคาสุทธิ</td>
                                                        <td align="right">฿ <?php echo number_format($total, 2); ?> บาท</td>
                                                        <!-- <td></td> -->
                                                    </tr>
                                                    <?php
                                                    }else{
                                                        echo "<p><td colspan='4' class='text-center'>ยังไม่มีข้อมูลรายละเอียดการจอง</td></p>";
                                                    }
                                                    ?>
                                                </tbody>
                                                <!-- <?php echo '<pre>' . print_r($_SESSION["shopping_tp"], TRUE) . '</pre>'; ?>  -->
                                            </table>
                                        </div>
                                        <div class="row mt-4 mb-4">
                                            <div class="col text-right">
                                                <!-- <a href="PlantOrderList.php?type=submit" class="btn btn-blue" style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการขาย</a> -->
                                                <button class="btn btn-primary " style="border-radius: 30px;" type="submit" name="save_order">บึนทึกรายการขาย</button>
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
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>


    <script>

        $('#orderer').change(function(){
            var id_odr = $(this).val();
            // console.log("odr = ",id_odr);
            $.ajax({
                type : "post",
                url : "../../api/orderer.php",
                data : {id:id_odr,function:'orderer'},     
                success: function(data){
                    // console.log("phone = ",data);
                    $('#phone').val(data);

                }
            });
        });

        $('#tpname').change(function(){
            var id_tp = $(this).val();
            // console.log("odr = ",id_odr);
            $.ajax({
                type : "post",
                url : "../../api/tp.php",
                data : {id:id_tp,function:'tpname'},     
                success: function(data){
                    // console.log("phone = ",data);
                    $('#tpprice').val(data);

                }
            });
        });

        
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