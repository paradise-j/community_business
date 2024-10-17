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


    $check_group = $db->prepare("SELECT `group_id` FROM `user_data` WHERE `user_id` = '$user_id'");
    $check_group->execute();
    $row2 = $check_group->fetch(PDO::FETCH_ASSOC);
    extract($row2);
    // echo $group_id;
    
    // echo '<pre>' . print_r($_SESSION["shopping_cart"], TRUE) . '</pre>';
    $total = 0;
    foreach ($_SESSION['shopping_cart'] as $key => $value) { 
        $total=$total+($value['item_pricepd']*$value['item_quantity']);
    }

    try {
    
    
        if(isset($_POST["save_sale"])){

            $typeS = $_POST["typeS"];
            $typeEx = $_POST["typeEx"];
            $cus = $_POST["cus"];
            $phone = $_POST["phone"];
            $date = $_POST["date"];
            $discount = $_POST["discount"];
            
            

            if ($typeS == "แจกฟรี") {
                $Newtotal = 0;
            }else{
                $Newtotal = $total - $discount;
            }


            $cu = $db->prepare("SELECT * FROM `customer`");
            $cu->execute();

            $check = array();
            while ($row = $cu->fetch(PDO::FETCH_ASSOC)){
                $name = $row["cus_name"];
                array_push($check,$name);
            }

            
            
            if(!in_array($cus, $check) && !is_null($cus)){
                $sql = $db->prepare("INSERT INTO `customer`(`cus_name`, `cus_phone`) VALUES ('$cus', '$phone')");
                $sql->execute();
            }



            if(empty($cus) ){
                $cus_id = "General";
            }else{
                $cuss = $db->prepare("SELECT * FROM `customer`");
                $cuss->execute();
                while ($row = $cuss->fetch(PDO::FETCH_ASSOC)) {
                    if($cus == $row["cus_name"]){
                        $cus_id = $row["cus_id"]; 
                        break;
                    }
                }
            }

        
        // ----------------------------- credit -----------------------------
        if ($typeS == "เครดิต") {

            

            $cd = $db->prepare("SELECT `cd_pay` FROM `credit` WHERE `cd_name` = '$cus_id'");
            $cd->execute();
            $rowcd = $cd->fetch(PDO::FETCH_ASSOC);
            extract($rowcd);

            // echo $cus_id."<br>";
            // echo $Newtotal."+".$cd_pay;
            $Newtotal2 = $Newtotal + $cd_pay;

        

            $check2 = array();
            $cd = $db->prepare("SELECT `cd_name`, `cd_pay` FROM `credit` ");
            $cd->execute();
            while ($row = $cd->fetch(PDO::FETCH_ASSOC)){
                $name2 = $row["cd_name"];
                array_push($check2,$name2);
            }


            if(!in_array($cus_id, $check2)){
                $cd2 = $db->prepare("INSERT INTO `credit`(`cd_date`, `cd_name`, `cd_pay`) VALUES ('$date' , '$cus_id' , $Newtotal)");
                $cd2->execute();
            }else{
                $cd3 = $db->prepare("UPDATE `credit` SET `cd_pay`= '$Newtotal2' WHERE `cd_name` = '$cus_id'");
                $cd3->execute();
            }
        }
            

            $sql = $db->prepare("INSERT INTO `sales`(`sale_type`, `sale_typeEx`, `sale_date`, `sale_total`, `sale_discount`, `sale_Nprice`, `cus_id`, `group_id`)  
                                VALUES ('$typeS','$typeEx', '$date','$total', '$discount', '$Newtotal', '$cus_id', '$group_id')");
            $sql->execute();

            $sales = $db->prepare("SELECT * FROM `sales`");
            $sales->execute();
            while ($row = $sales->fetch(PDO::FETCH_ASSOC)) {
                if($cus_id == $row["cus_id"] and $date == $row["sale_date"] and $total == $row["sale_total"]){
                    $sale_id = $row["sale_id"]; 
                    break;
                }
            }

            foreach ($_SESSION['shopping_cart'] as $key => $value){  
                
                $pdname = $value["item_pdname"]; 
                $quantity = $value["item_quantity"]; 
                $pricekg = $value["item_pricepd"]; 
                $price = $value["item_price"]; 

                $sql = $db->prepare("INSERT INTO `salesdetail` (`sd_pdname`, `sd_quantity` , `sd_pricekg`, `sd_price`, `sale_id`) 
                                    VALUES ('$pdname', $quantity, $pricekg, $price, '$sale_id')");
                $sql->execute();


                $mfs = $db->prepare("SELECT `mf_id`,`mf_quan` FROM `mf_data` WHERE `mf_name` = '$pdname'");
                $mfs->execute();
                $row = $mfs->fetch(PDO::FETCH_ASSOC);
                extract($row);

                $New_mf_quan = $mf_quan - $quantity ;

                $mfs = $db->prepare("UPDATE `mf_data` SET `mf_quan`= $New_mf_quan WHERE `mf_id` = '$mf_id'");
                $mfs->execute();
            }

            
            unset($_SESSION["shopping_cart"]);
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
            header("refresh:1; url=Sale.php");
        }
        $db = null; 
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
   }
?>