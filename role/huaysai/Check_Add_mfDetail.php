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

    foreach ($_SESSION['material_cart'] as $key => $value){
        $total=$total+($value['item_price']);
    }
    try {
        if(isset($_POST["save_sale"])){
            $date = $_POST["date"];  
            $pdname = $_POST["pdname"]; 

            $check_name = $db->prepare("SELECT `pd_name` as pdname FROM `product` WHERE `pd_id` = '$pdname'");
            $check_name->execute();
            $row = $check_name->fetch(PDO::FETCH_ASSOC);
            extract($row);

            $pdquan = $_POST["pdquan"];
            $pdunit = $_POST["pdunit"];

            $lbprice = $_POST["lbprice"]; 
            $water = $_POST["water"]; 
            $elec = $_POST["elec"]; 
            $fuel = $_POST["fuel"]; 
            $package = $_POST["package"]; 
            $other = $_POST["other"];
            $problem = $_POST["problem"]; 

            $price = $total+$lbprice+$water+$elec+$fuel+$package+$other;
            $cost = $price/$pdquan;

            $group_id = 'CM006';

            // echo $price;
            $mf = $db->prepare("SELECT `mf_name` FROM `mf_data`");
            $mf->execute();
            $check = array();
            while ($row = $mf->fetch(PDO::FETCH_ASSOC)){
                $name = $row["mf_name"];
                array_push($check,$name);
                
            }
            if (!in_array("$pdname", $check)) {
                
                $sql = $db->prepare("INSERT INTO `mf_data`(`mf_date`, `mf_name`, `mf_unit`, `mf_quan`, `mf_price`, `mf_cost`, `group_id`)
                                                VALUES ('$date','$pdname', '$pdunit', $pdquan , $price, $cost ,'$group_id')");
                $sql->execute();


                $mfs = $db->prepare("SELECT * FROM `mf_data`");
                $mfs->execute();
                while ($row = $mfs->fetch(PDO::FETCH_ASSOC)) {
                    if($pdname == $row["mf_name"] and $date == $row["mf_date"] and $pdquan == $row["mf_quan"] and $price == $row["mf_price"]){
                        $mf_id = $row["mf_id"]; 
                        break;
                    }
                }

                $sql = $db->prepare("INSERT INTO `mf_data_detail` (`mfd_labor_price`, `mfd_water_price`, `mfd_electricity_price`, `mfd_fuel_price`,`mfd_package`, `mfd_problem`, `mf_id`) 
                                                        VALUES ($lbprice, $water,$elec,$fuel,$package,'$problem','$mf_id')");
                $sql->execute();

                $mfds = $db->prepare("SELECT * FROM `mf_data_detail`");
                $mfds->execute();
                while ($row = $mfds->fetch(PDO::FETCH_ASSOC)) {
                    if($lbprice == $row["mfd_labor_price"] and $water == $row["mfd_water_price"] and $elec == $row["mfd_electricity_price"] and $package == $row["mfd_package"]){
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
                if ($sql) {
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
                    header("refresh:1; url=manufacture.php");
                } else {
                    $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                    header("location: manufacture.php");
                }
            } else {
                $mf = $db->prepare("SELECT * FROM `mf_data` WHERE `mf_name` = '$pdname'");
                $mf->execute();
                $row = $mf->fetch(PDO::FETCH_ASSOC);
                extract($row);

                $Nquan = $pdquan + $mf_quan;
                $Nprice = $price + $mf_price;
                $Navgcost = $Nprice/$Nquan;


                $sql = $db->prepare("UPDATE `mf_data` SET `mf_date`='$date',`mf_name`='$pdname',
                                                          `mf_unit`='$pdunit',`mf_quan`='$Nquan',
                                                          `mf_price`='$Nprice',`mf_cost`='$Navgcost' 
                                     WHERE `mf_id`='$mf_id'");
                $sql->execute();


                $mfs = $db->prepare("SELECT * FROM `mf_data`");
                $mfs->execute();
                while ($row = $mfs->fetch(PDO::FETCH_ASSOC)) {
                    if($pdname == $row["mf_name"] and $date == $row["mf_date"] and $pdquan == $row["mf_quan"] and $price == $row["mf_price"]){
                        $mf_id = $row["mf_id"]; 
                        break;
                    }
                }

                $sql = $db->prepare("INSERT INTO `mf_data_detail` (`mfd_labor_price`, `mfd_water_price`, `mfd_electricity_price`,`mfd_fuel_price`, `mfd_package`, `mfd_problem`, `mf_id`) 
                                                        VALUES ($lbprice, $water,$elec,$fuel,$package,'$problem','$mf_id')");
                $sql->execute();

                $mfds = $db->prepare("SELECT * FROM `mf_data_detail`");
                $mfds->execute();
                while ($row = $mfds->fetch(PDO::FETCH_ASSOC)) {
                    if($lbprice == $row["mfd_labor_price"] and $water == $row["mfd_water_price"] and $elec == $row["mfd_electricity_price"] and $package == $row["mfd_package"]){
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
                if ($sql) {
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
                    header("refresh:1; url=manufacture.php");
                } else {
                    $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                    header("location: manufacture.php");
                }
            }
        }
   } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
   }
    
    
?>