<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $pdname = $_POST['pdname'];
        $quan = $_POST['quan'];
        $cost = $_POST['cost'];
        $date = $_POST['date'];
        $unitcost = $cost/$quan;
        $unitprice = $unitcost+50;

        $sql = $db->prepare("INSERT INTO `product`(`pd_name`, `pd_date`, `pd_quan`, `pd_cost`, `pd_unitcost`, `pd_unitprice`)
                             VALUES ('$pdname','$date','$quan','$cost','$unitcost','$unitprice')");
        $sql->execute();

        if ($sql) {
            $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                })
            </script>";
            header("refresh:1; url=Product.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Product.php");
        }
    }
?>