<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    try {
        if (isset($_POST['submit'])) {
            $date = $_POST['date'];
            $g_id = $_POST['group'];
            $typeInEx = $_POST['typeInEx'];
            $nameInEX = $_POST['nameInEX'];
            $price = $_POST['price'];


            $pb = $db->prepare("INSERT INTO `inex_data` (`inex_date`, `inex_type`, `inex_name`, `inex_price`, `group_id`)
                                                VALUES  ('$date','$typeInEx','$nameInEX',$price,'$g_id')");
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
                header("refresh:1; url=InEx.php");
            } else {
                $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                header("location: InEx.php");
            }
                
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
?>