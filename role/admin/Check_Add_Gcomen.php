<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $namegf = $_POST['namegf'];
        $provinces = $_POST['provinces'];
        $amphures = $_POST['amphures'];
        $districts = $_POST['districts'];
        $zipcode = $_POST['zipcode'];
        $sql = $db->prepare("INSERT INTO `group_comen`(`group_name`, `group_subdis`, `group_dis`, `group_pv`, `group_zip`)
                             VALUES ('$namegf','$districts','$amphures','$provinces','$zipcode')");
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
            header("refresh:1; url=information_G_agc.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: information_G_agc.php");
        }
    }
?>