<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $Sdate = $_POST['Sdate'];
        $name = $_POST['name'];
        $quan = $_POST['quan'];
        // $pd = $db->prepare("SELECT `veget_name` FROM `vegetable`");
        // $pd->execute();
        // $row = $pd->fetch(PDO::FETCH_ASSOC);
        // extract($row);
        // echo $veget_name ;


        

    
        $sql = $db->prepare("INSERT INTO `plant_orderlist`(`pld_date`, `pld_nplant`, `pld_quan`)
                             VALUES ('$Sdate','$name','$quan')");
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
            header("refresh:1; url= Plant_orderlist.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: Plant_orderlist.php");
        }
            
    }
?>