<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        // $pld_id = $_POST['pld_id'];
        $Sdate = $_POST['Sdate'];
        $Edate = $_POST['Edate'];
        $name = $_POST['name'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $target = $_POST['target'];
        $g_id = $_POST['g_id'];

    
        $sql = $db->prepare("INSERT INTO `planting`(`plant_name`, `plant_latitude`, `plant_longitude`, `plant_target`, `plant_date`, `plant_harvest`, `plant_grower`, `plant_status`)
                             VALUES ('$name',$latitude ,$longitude ,$target ,'$Sdate','$Edate','$g_id','2')");
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