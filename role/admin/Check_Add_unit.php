<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $g_id = $_POST['group'];
        $unit_name = $_POST['unit_name'];


        $pb = $db->prepare("INSERT INTO `unit`(`unit_name`, `group_id`)
                            VALUES  ('$unit_name','$g_id')");
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
            header("refresh:1; url=manage_unit.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: manage_unit.php");
        }
            
    }
?>