<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../../connect.php";

    if (isset($_POST['submit'])) {
        $pre = $_POST['pre'];
        $name = $_POST['name'];
        $tel = $_POST['tel'];
        $passDoctor = $_POST['passDoctor'];
        $type = $_POST['type'];

        $sql = $db->prepare("INSERT INTO `doctor_data`(`doc_pre`, `doc_name`, `doc_tel`, `doc_passDoctor`, `doc_type`)
                             VALUES ('$pre','$name','$tel','$passDoctor','$type')");

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
            header("refresh:1; url=../ManageDoctor.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: ../ManageDoctor.php");
        }
    }
?>