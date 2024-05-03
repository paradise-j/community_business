<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $reid = $_POST['reid'];
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $phone = $_POST['phone']; 
        $perid = $_POST['perid'];
        $address = $_POST['address']; 

        $provinces = $_POST['provinces'];
        $stmt = $db->query("SELECT `name_th` as pv FROM `provinces` WHERE `id` = $provinces");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $amphures = $_POST['amphures'];
        $stmt = $db->query("SELECT `name_th` as dis FROM `amphures` WHERE `id` = $amphures");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $districts = $_POST['districts'];
        $stmt = $db->query("SELECT `name_th` as subdis FROM `districts` WHERE `id` = $districts");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $zipcode = $_POST['zipcode'];
        $group_id = $_POST['group_id'];

        $sql = $db->prepare("INSERT INTO `agc_data`(`agc_reid`, `agc_Fname`, `agc_Lname`, `agc_perid`, `agc_phone` , `agc_num`, `agc_subdis`, `agc_dis`, `agc_pv`, `agc_zip`, `group_id`)
                             VALUES ('$reid','$Fname','$Lname','$perid','$phone','$address','$subdis','$dis','$pv','$zipcode','$group_id')");
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
            header("refresh:1; url=agc_regis.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: agc_regis.php");
        }
    }
?>