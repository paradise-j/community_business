<?php
    require_once '../connect.php';
    header('Content-Type: application/json; charset=utf-8');
    $stmt2 = $db->query("SELECT MONTH(plant_orderlist.pld_date) as month , plant_orderlist_detail.pod_name , SUM(plant_orderlist_detail.pod_quan) as total
                        FROM `plant_orderlist_detail` 
                        INNER JOIN `plant_orderlist` ON plant_orderlist_detail.pld_id = plant_orderlist.pld_id
                        WHERE MONTH(plant_orderlist.pld_date) BETWEEN MONTH('2024-08-01') AND MONTH('2024-10-01')
                        GROUP BY plant_orderlist_detail.pod_name , MONTH(plant_orderlist.pld_date)
                        ORDER BY MONTH(plant_orderlist.pld_date)"); 
    $stmt2->execute();

    $arr = array();
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
    
?>