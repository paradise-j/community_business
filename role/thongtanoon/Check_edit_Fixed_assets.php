<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $fa_id = $_POST['fa_id'];
        $fa_name = $_POST['fa_name'];
        $fa_price = $_POST['fa_price'];
        $fa_location = $_POST['fa_location'];

        $sql = $db->prepare("UPDATE `fixed_asset` SET `fa_name`='$fa_name' , `fa_price` = '$fa_price' , `fa_location` = '$fa_location'
                             WHERE `fa_id`='$fa_id'");
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
            header("refresh:1; url=Fixed_assets.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Fixed_assets.php");
        }
    }
?>