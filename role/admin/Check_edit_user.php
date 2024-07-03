<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $userid = $_POST['userid'];
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
        // $permission = $_POST['permission'];
        // $group_id = $_POST['group_id'];

        $sql = $db->prepare("UPDATE `user_data` SET `user_Fname`='$Fname',
                                                    `user_Lname`='$Lname',
                                                    `user_perid`='$perid',
                                                    `user_phone`='$phone',
                                                    `user_num`='$address',
                                                    `user_subdis`='$subdis',
                                                    `user_dis`='$dis',
                                                    `user_pv`='$pv',
                                                    `user_zip`='$zipcode'
                                                    WHERE `user_id`='$userid'");
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
            header("refresh:1; url=user_regis.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: user_regis.php");
        }
    }
?>