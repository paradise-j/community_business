<?php
    require_once '../connect.php';
    header('Content-Type: application/json; charset=utf-8');
    $stmt2 = $db->query("SELECT travel_orderlist_detail.tod_name, SUM(travel_orderlist_detail.tod_price) as total , MONTH(`tol_date`) as month 
FROM `travel_orderlist`
INNER JOIN `travel_orderlist_detail` ON travel_orderlist.tol_id = travel_orderlist_detail.tol_id
WHERE MONTH(`tol_date`) BETWEEN MONTH('2024-05-01') AND MONTH('2024-10-01')
GROUP BY travel_orderlist_detail.tod_name ,MONTH(`tol_date`)"); 
    $stmt2->execute();

    $arr = array();
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);

?>