<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $date = $_POST['date'];
        $g_id = $_POST['g_id'];
        $name = $_POST['name'];
        $quan = $_POST['quan'];
        $price = $_POST['price'];
        $order_id = $_POST['order_id'];
        $problem = $_POST['problem'];
        $total = $quan*$price;


        $pb = $db->prepare("INSERT INTO `bproduce`(`bp_date`, `veget_name`, `bp_quan`, `bp_pricekg`, `bp_totalprice`, `gw_id`, `bp_order_id`, `bp_problem`)
                            VALUES  ('$date','$name','$quan','$price','$total','$g_id','$order_id','$problem')");
        $pb->execute();


        if ($pb) {
            $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อย";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'เพิ่มข้อมูลเรียบร้อย',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                })
            </script>";
            header("refresh:1; url=Bproduce.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Bproduce.php");
        }
            
    }
?>