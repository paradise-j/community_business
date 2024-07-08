<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $Productid = $_POST['Productid'];
        $Productname = $_POST['Productname'];

        $img = $_FILES['img'];

        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt; 
        $filePath = 'uploads/'.$fileNew;

        if (in_array($fileActExt, $allow)) {
            if ($img['size'] > 0 && $img['error'] == 0) {
                if (move_uploaded_file($img['tmp_name'], $filePath)) {
                                $sql = $db->prepare("UPDATE `product` SET `pd_name`='$Productname' , `pd_img`='$fileNew'
                                                     WHERE `pd_id`='$Productid'");
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
                                    header("refresh:1; url=Product.php");
                                } else {
                                    $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                                    header("location: Product.php");
                                }

                }
            }
        }
    }
?>