<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    // if(!isset($_SESSION["username"]) and !isset($_SESSION["password"]) and $_SESSION["permission"] != 1){
    //     header("location: ../../index.php");
    //     exit;
    // }
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



    // if(isset($_POST["add_sale"])){
    //     $gg_type = $_POST['gg_type'];
    //     $id_user = $_SESSION["id"];
    //     $agc = $db->prepare("SELECT `agc_id` FROM `user_login` WHERE `user_id` = '$id_user'");
    //     $agc->execute();
    //     $row = $agc->fetch(PDO::FETCH_ASSOC);
    //     extract($row);


    //     $gg = $db->prepare("SELECT * FROM `group_g` WHERE `agc_id` = '$agc_id'");
    //     $gg->execute();
    //     while ($row = $gg->fetch(PDO::FETCH_ASSOC)) {
    //         if($gg_type == $row["gg_type"]){
    //             $gg_id = $row["gg_id"]; 
    //             break;
    //         }
    //     }

    //     $gg2 = $db->prepare("SELECT * FROM `group_g` WHERE `agc_id` = '$agc_id' AND `gg_id` = '$gg_id'");
    //     $gg2->execute();
    //     $row = $gg2->fetch(PDO::FETCH_ASSOC);
    //     extract($row);

    //     if($_POST["quantity"] > $gg_quantity){
    //         $_SESSION['error'] = 'ยอดแพะของท่านไม่เพียงพอ';
    //         header("refresh:2; url=add_salegoat.php");
    //     }else{
    //         $item_array = array(

    //             'item_gg_type'       =>     $_POST["gg_type"],
    //             'item_id_gg'         =>     $gg_id,
    //             'item_quantity'      =>     $_POST["quantity"],
    //             'item_weight'        =>     $_POST["weight"],
    //             'item_pricekg'       =>     $_POST["pricekg"],
    //             'item_price'         =>     $_POST["pricekg"]*$_POST["weight"]
    //             );
    //             $_SESSION["shopping_cart"][] =  $item_array;
    //         header("location:add_salegoat.php");
    //         exit;
    //     }
    // }

    // if(isset($_GET['action'])){
    //     if($_GET['action']=="delete"){
    //         $id = $_GET["id"];
    //         unset($_SESSION["shopping_cart"][$id]);
    //         header("location:add_salegoat.php");
    //         exit;
    //         $total = $total-($_SESSION["shopping_cart"]['item_weight']*$_SESSION["shopping_cart"]['item_pricekg']);
    //       }
    // }

    
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ขายสินค้า</title>

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
        <?php include('../../sidebar/sidebar.php');?> <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <?php include('../../topbar/topbar2.php');?>  <!-- Topbar -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 text-center">
                                    <h5 class="m-0 font-weight-bold text-primary">รายละเอียดการขาย</h5>
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
                                        <div class="row mt-2">
                                            <!-- <div class="col text-center">
                                                <label style="color:red;" >**** ในกรณีในเดือนนั้นขายแพะไม่ครบทุกประเภท ให้ระบุค่า 0 ลงในประเภทแพะที่ไม่ได้ขาย ****</label>
                                            </div> -->
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-1"></div>
                                            
                                            <div class="col-md-3">
                                                <label class="form-label">ชื่อผลิตภัณฑ์</label>
                                                <select class="form-control" aria-label="Default select example"  id="pname" name="pname" style="border-radius: 30px;" required>
                                                    <option selected disabled>กรุณาเลือก....</option>
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
                                            <div class="col-md-2">
                                                <label class="form-label">จำนวน</label>
                                                <input type="number" class="form-control" id="Gname" name="quantity" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">ราคาขาย</label>
                                                <input type="text" class="form-control" id="price" name="price" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">ส่วนลด</label>
                                                <input type="number" class="form-control" id="phone" name="pricekg" style="border-radius: 30px;" required>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-body">
                                    <div class="card-header py-3 text-center mb-4">
                                        <h5 class="m-0 font-weight-bold text-primary">รายการขายผลิตภัณฑ์</h5>
                                    </div>
                                    <form action="Check_Add_salegoat.php" method="post">
        
                                        <div class="row mb-4">
                                            <div class="col-md-2">
                                                <label class="form-label">ชื่อผู้ซื้อ</label>
                                                <input type="text" class="form-control" name="cus" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">เบอร์โทรศัพท์</label>
                                                <input type="text" class="form-control" name="phone" style="border-radius: 30px;" required>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">วันที่ขาย</label>
                                                <?php $date = date('Y-m-d'); ?>
                                                <input type="date" class="form-control" name="date" max="<?= $date; ?>" style="border-radius: 30px;" required>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>ชื่อผลิตภัณฑ์</th>
                                                        <th>จำนวน</th>
                                                        <th>ราคา</th>
                                                        <th>ส่วนลด</th>
                                                        <th>ยอดจ่าย</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if(!empty($_SESSION["shopping_cart"])){
                                                        $total=0;
                                                        foreach ($_SESSION['shopping_cart'] as $key => $value) { 
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <?php
                                                                    if($value['item_gg_type'] == 1){
                                                                        echo "พ่อพันธุ์";
                                                                    }elseif($value['item_gg_type'] == 2){
                                                                        echo "แม่พันธุ์";
                                                                    }else{
                                                                        echo "แพะขุน";
                                                                    }
                                                                ?>
                                                            </td>
                                                            <td align="right"><?php echo number_format($value['item_quantity'],2);?> ตัว</td>
                                                            <td align="right"><?php echo number_format($value['item_weight'],2);?> กก.</td>
                                                            <td align="right">฿ <?php echo number_format($value['item_pricekg'],2);?> บาท</td>
                                                            <td align="right">฿ <?php echo number_format($value['item_pricekg']*$value['item_weight'],2);?> บาท</td>
                                                            <td><a href="add_salegoat.php?action=delete&id=<?php echo $key;?>">ลบรายการ</td>
                                                        </tr>
                                                    <?php
                                                        $total=$total+($value['item_weight']*$value['item_pricekg']);
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="4" align="right">ราคารวม</td>
                                                        <td align="right">฿ <?php echo number_format($total, 2); ?> บาท</td>
                                                        <td></td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                                <!-- <?php echo '<pre>' . print_r($_SESSION["shopping_cart"], TRUE) . '</pre>'; ?>  -->
                                            </table>
                                        </div>
                                        <div class="row mt-4 mb-4">
                                            <div class="col text-right">
                                                <!-- <a href="add_salegoat.php?type=submit" class="btn btn-blue" style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการขาย</a> -->
                                                <button class="btn btn-blue " style="border-radius: 30px;" type="submit" name="save_sale">บึนทึกรายการขาย</button>
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

        $('#pname').change(function(){
            var id_pname = $(this).val();
            // console.log(id_pname);
            $.ajax({
                type : "post",
                url : "pname.php",
                data : {id:id_pname,function:'pname'},     
                success: function(data){
                    console.log(data);
                    $('#price').html(data);

                }
            });
        });

        // $('#provinces').change(function(){
        //     var id_provnce = $(this).val();
        //     $.ajax({
        //         type : "post",
        //         url : "../../address.php",
        //         data : {id:id_provnce,function:'provinces'},     
        //         success: function(data){
        //             $('#amphures').html(data);
        //             $('#districts').html(' ');
        //             $('#zipcode').val(' ');
        //         }
        //     });
        // });

        
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