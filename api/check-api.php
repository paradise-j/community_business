<?php
    require_once '../connect.php';
    header('Content-Type: application/json; charset=utf-8');

    $stmt2 = $db->query("SELECT * FROM ((SELECT "เกาะเสร็จ" as "trip", COUNT(`tol_tp1`) as "count"
                        FROM `travel_orderlist`
                        WHERE `tol_tp1` NOT LIKE "" AND MONTH(`tol_date`) BETWEEN MONTH('2024-11-01') AND MONTH('2024-12-01'))
                        UNION 
                        (SELECT "ผ้าไหมพุมเรียง" as "trip", COUNT(`tol_tp2`) as "count"
                        FROM `travel_orderlist`
                        WHERE `tol_tp2` NOT LIKE "" AND MONTH(`tol_date`) BETWEEN MONTH('2024-11-01') AND MONTH('2024-12-01'))
                        UNION 
                        (SELECT "ตามรอยท่านพุทธทาส" as "trip", COUNT(`tol_tp3`) as "count"
                        FROM `travel_orderlist` 
                        WHERE `tol_tp3` NOT LIKE "" AND MONTH(`tol_date`) BETWEEN MONTH('2024-11-01') AND MONTH('2024-12-01')))`tb1` 
                        ORDER BY `tb1`.count DESC;"); 
    $stmt2->execute();

    $arr = array();
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);

?>