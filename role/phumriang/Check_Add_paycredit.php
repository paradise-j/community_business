<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $datepay = $_POST['datepay'];
        $custumer = $_POST['custumer'];
        $total = $_POST['total'];
        $amount = $_POST['amount'];
        $Newtotal = $total-$amount;

        $cd = $db->prepare("UPDATE `credit` SET `cd_pay`= $Newtotal WHERE `cd_name` = '$custumer'");
        $cd->execute();

        $pb = $db->prepare("INSERT INTO `paybalance`(`pb_date`, `pb_cus`, `pb_amount`) 
                            VALUES ('$datepay','$custumer','$amount')");
        $pb->execute();


        if ($cd && $pb) {
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
            header("refresh:1; url=Cus_credit.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Cus_credit.php");
        }
            
    }
?>