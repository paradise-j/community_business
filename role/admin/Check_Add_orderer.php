<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $odr_name = $_POST['odr_name'];
        $odr_phone = $_POST['odr_phone'];
        $group = $_POST['group'];

        $odr = $db->prepare("SELECT `odr_name` FROM `orderer` WHERE `group_id` = '$group'");
        $odr->execute();

        $check = array();
        while ($row = $odr->fetch(PDO::FETCH_ASSOC)){
            $name = $row["odr_name"];
            array_push($check,$name);
            
        }

        if(!in_array("$odr_name", $check)){
            // echo "Match not found";
            $sql = $db->prepare("INSERT INTO `orderer`(`odr_name`, `odr_phone` , `group_id`)
                             VALUES ('$odr_name','$odr_phone','$group')");
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
                header("refresh:1; url=orderer.php");
            } else {
                $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                header("location: orderer.php");
            }

        }else{
            // echo "Match found";
            $_SESSION['success'] = "ข้อมูลผู้สั่งซิื้อนี้มีแล้ว";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ข้อมูลผู้สั่งซิื้อนี้มีแล้ว',
                        icon: 'warning',
                        timer: 15000,
                        showConfirmButton: false
                    });
                })
            </script>";
            header("refresh:1; url=orderer.php");
        } 
    }
?>