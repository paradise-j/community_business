<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $materialid = $_POST['materialid'];
        $materialname = $_POST['materialname'];

        $sql = $db->prepare("UPDATE `material` SET `mat_name`='$materialname'
                             WHERE `mat_id`='$materialid'");
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
            header("refresh:1; url=material.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: material.php");
        }
    }
?>