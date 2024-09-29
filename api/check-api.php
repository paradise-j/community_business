<?php
    require_once '../connect.php';
    // header('Content-Type: application/json; charset=utf-8');
    // $stmt2 = $db->query("SELECT MONTH(plant_orderlist.pld_date) as month , plant_orderlist_detail.pod_name , SUM(plant_orderlist_detail.pod_quan) as total
    //                     FROM `plant_orderlist_detail` 
    //                     INNER JOIN `plant_orderlist` ON plant_orderlist_detail.pld_id = plant_orderlist.pld_id
    //                     WHERE MONTH(plant_orderlist.pld_date) BETWEEN MONTH('2024-08-01') AND MONTH('2024-10-01')
    //                     GROUP BY plant_orderlist_detail.pod_name , MONTH(plant_orderlist.pld_date)
    //                     ORDER BY MONTH(plant_orderlist.pld_date)"); 
    // $stmt2->execute();

    // $arr = array();
    // while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
    //     array_push($arr,$row);
    // }
    // echo json_encode($arr);
    
    foreach ($_SESSION['shopping_cart'] as $key => $value){  
                
        $pdname = $value["item_pdname"];  echo "pdname = ".$pdname."<br>" ;
        $quantity = $value["item_quantity"]; echo "quantity = ".$quantity."<br>" ;
        $pricekg = $value["item_pricepd"];  echo "pricekg = ".$pricekg."<br>" ;
        $price = $value["item_price"];  echo "price = ".$price."<br>" ;

        // $sql = $db->prepare("INSERT INTO `salesdetail` (`sd_pdname`, `sd_quantity` , `sd_pricekg`, `sd_price`, `sale_id`) 
        //                     VALUES ('$pdname', $quantity, $pricekg, $price, '$sale_id')");
        // $sql->execute();

        
        $mfs = $db->prepare("SELECT `mf_id`,`mf_quan` FROM `mf_data` WHERE `mf_name` = '$pdname'");
        $mfs->execute();

        $New_mf_quan = $mf_quan - $quantity ;

        echo $mf_id." " ;
        echo $mf_quan." " ;
        echo $New_mf_quan." " ;

        // $mfss = $db->prepare("UPDATE `mf_data` SET `mf_quan`= $New_mf_quan WHERE `mf_id` = '$mf_id'");
        // $mfss->execute();
    }
?>