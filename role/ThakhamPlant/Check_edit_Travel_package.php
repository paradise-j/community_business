<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $tp_id = $_POST['tp_id'];
        $tp_name = $_POST['tp_name'];
        $tp_price = $_POST['tp_price'];

        $sql = $db->prepare("UPDATE `travel_pack` SET `tp_name`='$tp_name',`tp_price`='$tp_price' WHERE `tp_id` ='$tp_id'");
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
            header("refresh:1; url=Travel_package.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Travel_package.php");
        }
    }
?>