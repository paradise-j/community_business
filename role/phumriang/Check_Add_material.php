<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    try{
        if (isset($_POST['submit'])) {
            echo "1";
            $g_id = $_POST['group'];
            $mname = $_POST['mname'];
            $unit = $_POST['unit'];


            $pb = $db->prepare("INSERT INTO `material`(`mat_name`, `mat_unit`, `group_id`)
                                VALUES  ('$mname','$unit','$g_id')");
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
                header("refresh:1; url=material.php");
            } else {
                $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                header("location: material.php");
            }
                
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    } 

?>