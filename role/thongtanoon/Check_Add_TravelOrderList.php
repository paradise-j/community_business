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
    
    // echo '<pre>' . print_r($_SESSION["shopping_tp"], TRUE) . '</pre>';
    $total = 0;
    foreach ($_SESSION['shopping_tp'] as $key => $value) { 
        $total=$total+($value['item_tpprice']);
    }

    // echo $total ;
    
    if(isset($_POST["save_order"])){

        // $odr = $_POST["orderer"];
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $date = $_POST["date"];
        $quan_pp = $_POST["quan_pp"];

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

        // $odrs = $db->prepare("SELECT * FROM `orderer`");
        // $odrs->execute();
        // while ($row = $odrs->fetch(PDO::FETCH_ASSOC)) {
        //     if($odr == $row["odr_id"]){
        //         $odr_id = $row["odr_id"]; 
        //         break;
        //     }
        // }



        $sql = $db->prepare("INSERT INTO `travel_orderlist`(`tol_date`, `tol_quan`, `tol_cus`, `tol_phone`,`tol_totalp`)
                             VALUES ('$date','$quan_pp','$name','$phone','$total')");
        $sql->execute();

        $tols = $db->prepare("SELECT * FROM `travel_orderlist`");
        $tols->execute();
        while ($row = $tols->fetch(PDO::FETCH_ASSOC)) {
            if($name == $row["tol_cus"] and $date == $row["tol_date"] and $quan_pp == $row["tol_quan"]){
                $tol_id = $row["tol_id"]; 
                break;
            }
        }
        // echo $pld_id;

        foreach ($_SESSION['shopping_tp'] as $key => $value){  
              
            $tpname = $value["item_tpname"];
            $tpprice = $value["item_tpprice"]; 

            $sql = $db->prepare("INSERT INTO `travel_orderlist_detail`(`tod_name`, `tod_price`, `tol_id`)
                                 VALUES ('$tpname', $tpprice, '$tol_id')");
            $sql->execute();
        }

        unset($_SESSION["shopping_tp"]);
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
        header("refresh:1; url=Travel.php");
    }
    $db = null; 
?>