<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');


    $result = $db->query("SELECT MONTH(travel_orderlist.tol_date) as month, 
                                travel_orderlist_detail.tod_type as type, 
                                SUM(travel_orderlist_detail.tod_deduct) as deduct
                        FROM `travel_orderlist_detail` 
                        INNER JOIN `travel_orderlist` ON travel_orderlist.tol_id = travel_orderlist_detail.tol_id
                        GROUP BY MONTH(travel_orderlist.tol_date) , travel_orderlist_detail.tod_type");
    $result->execute();

    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
?>