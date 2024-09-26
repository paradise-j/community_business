<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../../connect.php';

    // $id = $_SESSION['id'];
    // echo $id;
    // $check_id = $db->prepare("SELECT `user_id` FROM `user_login` WHERE `ul_id` = '$id'");
    // $check_id->execute();
    // $row = $check_id->fetch(PDO::FETCH_ASSOC);
    // extract($row);
    
    // echo '<pre>' . print_r($_SESSION["material_cart"], TRUE) . '</pre>';
   
    
    if(isset($_POST["save_sale"])){
        echo "1";
        $date = $_POST["date"];  echo "date = " .$date."<br>" ;
        $pdname = $_POST["pdname"]; 
        $pdquan = $_POST["pdquan"];
        $pdunit = $_POST["pdunit"];
        
        $lbquan = $_POST["lbquan"]; 
        echo "lbquan = " .$lbquan."<br>" ;
       
        $lbprice = $_POST["lbprice"]; 
        echo "lbprice = " .$lbprice."<br>" ;
       
        $water = $_POST["water"]; 
        echo "water = " .$water."<br>" ;
       
        $elec = $_POST["elec"]; 
        echo "elec = " .$elec."<br>" ;
        
        $package = $_POST["package"]; 
        echo "package = " .$package."<br>" ;
       
        $other = $_POST["other"]; 
        echo "other = " .$other."<br>" ;
        
        $problem = $_POST["problem"]; 
        echo "problem = " .$problem."<br>" ;
        
 

        $sql = $db->prepare("INSERT INTO `mf_data`( `mf_date`, `mf_name`, `mf_unit`, `mf_quan`, `group_id`)
                                    VALUES ('$date','$pdname', '$pdunit',$pdquan,'CM004')");
        $sql->execute();


        $mfs = $db->prepare("SELECT * FROM `mf_data`");
        $mfs->execute();
        while ($row = $mfs->fetch(PDO::FETCH_ASSOC)) {
            if($pdname == $row["mf_name"] and $date == $row["mf_date"] and $pdunit == $row["mf_unit"]){
                $mf_id = $row["mf_id"]; 
                break;
            }
        }
        // echo "mf_id = ".$mf_id ; 

        $sql = $db->prepare("INSERT INTO `mf_data_detail` (`mfd_labor_quan`, `mfd_labor_price`, `mfd_water_price`, `mfd_electricity_price`, `mfd_matdetail_id`, `mfd_package`, `mfd_problem`, `mf_id`) 
                                                VALUES ($lbquan,$lbprice, $water,$elec,'1',$package,'$problem','$mf_id')");
        $sql->execute();

        $mfds = $db->prepare("SELECT * FROM `mf_data_detail`");
        $mfds->execute();
        while ($row = $mfds->fetch(PDO::FETCH_ASSOC)) {
            if($lbprice == $row["mfd_labor_price"] and $water == $row["mfd_water_price"] and $elec == $row["mfd_electricity_price"]){
                $mfd_id = $row["mfd_id"]; 
                break;
            }
        }


        foreach ($_SESSION['material_cart'] as $key => $value){  
                
            $pdname = $value["item_name"]; 
            $quantity = $value["item_quantity"]; 
            $unit = $value["item_unit"]; 
            $price = $value["item_price"]; 

            $sql = $db->prepare("INSERT INTO `mfd_matdetail`(`md_name`, `md_quan`, `md_unit`, `md_price`, `mfd_id`) 
                                 VALUES ('$pdname', $quantity, '$unit', $price, '$mfd_id')");
            $sql->execute();
        }

        unset($_SESSION["material_cart"]);
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
        header("refresh:1; url=mf_detail.php");

        $db = null; 
    }
?>