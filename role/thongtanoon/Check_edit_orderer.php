<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $odr_id = $_POST['odr_id'];
        $odr_name = $_POST['odr_name'];
        $odr_phone = $_POST['odr_phone'];

        $sql = $db->prepare("UPDATE `orderer` SET `odr_name`='$odr_name',`odr_phone`='$odr_phone'
                             WHERE `odr_id`='$odr_id'");
        $sql->execute();

        if ($sql) {
            $_SESSION['success'] = "สำเร็จ";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'แก้ไขข้อมูลเรียบร้อยแล้ว',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                })
            </script>";
            header("refresh:1; url=orderer.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: orderer.php");
        }
    }
?>