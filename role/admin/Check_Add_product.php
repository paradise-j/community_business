<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $pdname = $_POST['pdname'];

        $pd = $db->prepare("SELECT `pd_name` FROM `product`");
        $pd->execute();

        $check = array();
        while ($row = $pd->fetch(PDO::FETCH_ASSOC)){
            $name = $row["pd_name"];
            array_push($check,$name);
            
        }

        if(!in_array("$pdname", $check)){
            // echo "Match not found";
            $sql = $db->prepare("INSERT INTO `product`(`pd_name`)
                             VALUES ('$pdname')");
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

        }else{
            // echo "Match found";
            $_SESSION['success'] = "ข้อมูลสินค้านี้มีแล้ว";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ข้อมูลสินค้านี้มีแล้ว',
                        icon: 'warning',
                        timer: 15000,
                        showConfirmButton: false
                    });
                })
            </script>";
            header("refresh:1; url=Product.php");
        } 
    }
?>