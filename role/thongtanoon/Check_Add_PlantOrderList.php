<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../../connect.php';

    $id = $_SESSION['id'];
    // echo $id;
    $check_id = $db->prepare("SELECT `user_id` FROM `user_login` WHERE `ul_id` = '$id'");
    $check_id->execute();
    $row = $check_id->fetch(PDO::FETCH_ASSOC);
    extract($row);
    
    // echo '<pre>' . print_r($_SESSION["shopping_veg"], TRUE) . '</pre>';
    $total = 0;
    // foreach ($_SESSION['shopping_veg'] as $key => $value) { 
    //     $total=$total+($value['item_pricepd']*$value['item_quantity']);
    // }

    // echo $total ;
    
    if(isset($_POST["save_order"])){

        $odr = $_POST["orderer"];
        $phone = $_POST["phone"];
        $date = $_POST["date"];

        // $cu = $db->prepare("SELECT * FROM `customer`");
        // $cu->execute();

        // $check = array();
        // while ($row = $cu->fetch(PDO::FETCH_ASSOC)){
        //     $name = $row["cus_name"];
        //     array_push($check,$name);
        // }

        // if(!in_array($cus, $check)){
        //     $sql = $db->prepare("INSERT INTO `customer`(`cus_name`, `cus_phone`) VALUES ('$cus', '$phone')");
        //     $sql->execute();
        // }
            
        
        // ----------------------------- customer -----------------------------

        // $cuss = $db->prepare("SELECT * FROM `customer`");
        // $cuss->execute();
        // while ($row = $cuss->fetch(PDO::FETCH_ASSOC)) {
        //     if($cus == $row["cus_name"]){
        //         $cus_id = $row["cus_id"]; 
        //         break;
        //     }
        // }

        $odrs = $db->prepare("SELECT * FROM `orderer`");
        $odrs->execute();
        while ($row = $odrs->fetch(PDO::FETCH_ASSOC)) {
            if($odr == $row["odr_id"]){
                $odr_id = $row["odr_id"]; 
                break;
            }
        }



        $sql = $db->prepare("INSERT INTO `plant_orderlist`(`pld_date`, `odr_id`)  
                             VALUES ('$date','$odr_id')");
        $sql->execute();

        $plds = $db->prepare("SELECT * FROM `plant_orderlist`");
        $plds->execute();
        while ($row = $plds->fetch(PDO::FETCH_ASSOC)) {
            if($odr_id == $row["odr_id"] and $date == $row["pld_date"]){
                $pld_id = $row["pld_id"]; 
                break;
            }
        }
        echo $pld_id;

        foreach ($_SESSION['shopping_veg'] as $key => $value){  
              
            $vgname = $value["item_vgname"]; echo $vgname;
            $quantity = $value["item_quantity"]; 

            $sql = $db->prepare("INSERT INTO `plant_orderlist_detail`(`pod_name`, `pod_quan`, `pld_id`)
                                 VALUES ('$vgname', $quantity, '$pld_id')");
            $sql->execute();
        }

        unset($_SESSION["shopping_veg"]);
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
        header("refresh:1; url=Plant_orderlist.php");
    }
    $db = null; 
?>