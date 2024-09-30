<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";
    try{
        if (isset($_POST['submit'])) {
            $date = $_POST['date'];  
            $orderer = $_POST['orderer'];
            $name = $_POST['name']; 
            $quan = $_POST['quan']; 
            $price = $_POST['price']; 
            $total = $quan*$price; 
            $pldID = $_POST['pldID'];


            $pb = $db->prepare("INSERT INTO `Plant_export`(`px_date`, `odr_id`, `px_name`, `px_quan`, `px_price`, `px_total`, `pld_id`) 
                                VALUES  ('$date','$orderer','$name',$quan,$price,$total,'$pldID')");
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
                header("refresh:1; url=Export_products.php");
            } else {
                $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                header("location: Export_products.php");
            }
                
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    } 

?>