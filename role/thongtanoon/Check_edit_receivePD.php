<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        echo"1";
        $rp_id = $_POST['rp_id'];
        $rp_name = $_POST['rp_name'];

        $img = $_FILES['img'];

        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt; 
        $filePath = 'uploads/receivePD/'.$fileNew;

        if (in_array($fileActExt, $allow)) {
            echo"2";
            if ($img['size'] > 0 && $img['error'] == 0) {
                echo"3";
                if (move_uploaded_file($img['tmp_name'], $filePath)) {
                    echo"4";
                                $sql = $db->prepare("UPDATE `receivepd` SET `rp_name`='$rp_name' , `rp_img`='$fileNew'
                                                     WHERE `rp_id`='$rp_id'");
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
                                    header("refresh:1; url=receivePD.php");
                                } else {
                                    $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                                    header("location: receivePD.php");
                                }

                }
            }
        }
    }
?>