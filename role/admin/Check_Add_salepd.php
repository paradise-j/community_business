<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 

    session_start();
    require_once '../../connect.php';

    $id = $_SESSION['id'];
    echo $id;
    $check_id = $db->prepare("SELECT `user_id` FROM `user_login` WHERE `ul_id` = '$id'");
    $check_id->execute();
    $row = $check_id->fetch(PDO::FETCH_ASSOC);
    extract($row);
    
    // if(isset($_POST["save_sale"])){

    //     $cus = $_POST["cus"];
    //     $phone = $_POST["phone"];
    //     $date = $_POST["date"];

    //     $cu = $db->prepare("SELECT * FROM `customer`");
    //     $cu->execute();

    //     $check = array();
    //     while ($row = $cu->fetch(PDO::FETCH_ASSOC)){
    //         $name = $row["cus_name"];
    //         array_push($check,$name);
    //     }

    //     if(!in_array($cus, $check)){
    //         $sql = $db->prepare("INSERT INTO `customer`(`cus_name`, `cus_phone`) VALUES ('$cus', '$phone')");
    //         $sql->execute();
    //     }
            
        
    //     // ----------------------------- customer -----------------------------
    //     $cuss = $db->prepare("SELECT * FROM `customer`");
    //     $cuss->execute();
    //     while ($row = $cuss->fetch(PDO::FETCH_ASSOC)) {
    //         if($cus == $row["cus_name"]){
    //             $cus_id = $row["cus_id"]; 
    //             break;
    //         }
    //     }

    //     $sql = $db->prepare("INSERT INTO `sale`(`sale_date`, `agc_id`, `cus_id`) VALUES ('$date', '$agc_id', '$cus_id')");
    //     $sql->execute();

    //     $sales = $db->prepare("SELECT * FROM `sale`");
    //     $sales->execute();
    //     while ($row = $sales->fetch(PDO::FETCH_ASSOC)) {
    //         if($cus_id == $row["cus_id"] and $agc_id == $row["agc_id"]){
    //             $sale_id = $row["sale_id"]; 
    //             break;
    //         }
    //     }

    //     foreach($_SESSION["shopping_cart"] as $key=>$value){
    //         $quantity = $value["item_quantity"];
    //         $weight = $value["item_weight"];
    //         $pricekg = $value["item_pricekg"];
    //         $price = $value["item_price"];
    //         $gg_id = $value["item_id_gg"];

    //         $sql = $db->prepare("INSERT INTO `salelist`(`slist_quantity`, `slist_weight`, `slist_KgPirce`, `slist_price`, `sale_id`, `gg_id`) 
    //                             VALUES ($quantity, $weight, $pricekg, $price,'$sale_id','$gg_id')");
    //         $sql->execute();

    //         $ggs = $db->prepare("SELECT * FROM `group_g` WHERE `gg_id`= '$gg_id'");
    //         $ggs->execute();
    //         $row = $ggs->fetch(PDO::FETCH_ASSOC);


    //         $totals = $row["gg_quantity"] - $quantity;
    //         $sql2 = $db->prepare("UPDATE `group_g` SET `gg_quantity`= $totals WHERE `gg_id` = '$gg_id' and `agc_id` = '$agc_id'");
    //         $sql2->execute();
    //     }

    //     unset($_SESSION["shopping_cart"]);
    //     // header("location:add_salegoat.php");
    //     echo "<script>
    //         $(document).ready(function() {
    //             Swal.fire({
    //                 title: 'สำเร็จ',
    //                 text: 'เพิ่มข้อมูลเรียบร้อยแล้ว',
    //                 icon: 'success',
    //                 timer: 5000,
    //                 showConfirmButton: false
    //             });
    //         })
    //     </script>";
    //     header("refresh:1; url=Sale.php");
    // }
    // $db = null; 
?>