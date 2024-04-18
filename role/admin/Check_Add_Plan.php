<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $Sdate = $_POST['Sdate'];
        $Edate = $_POST['Edate'];
        $name = $_POST['name'];
        $grower = $_POST['grower'];

    
        $sql = $db->prepare("INSERT INTO `planting`(`plant_name`, `plant_date`, `plant_harvest`, `plant_grower`)
                             VALUES ('$name','$Sdate','$Edate','$grower')");
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
            header("refresh:1; url=PlanFollow.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: PlanFollow.php");
        }
            
    }
?>