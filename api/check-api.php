<?php
    require_once '../connect.php';
    header('Content-Type: application/json; charset=utf-8');

    $stmt2 = $db->query("SELECT * FROM (

(SELECT `tb_1`.trip, `tb_1`.count, `tb_2`.data
FROM ( SELECT `travel_orderlist`.tol_tp1 AS \"trip\", COUNT(`travel_orderlist`.tol_tp1) AS \"count\" FROM `travel_orderlist` WHERE `travel_orderlist`.tol_tp1 NOT LIKE \"\" AND MONTH(`travel_orderlist`.tol_date) BETWEEN MONTH('2024-11-01') AND MONTH('2024-12-31') GROUP BY `travel_orderlist`.tol_tp1 ) `tb_1`
INNER JOIN ( SELECT `travel_orderlist`.tol_tp1 AS \"trip\", JSON_ARRAYAGG( JSON_OBJECT( \"month\", MONTH(`travel_orderlist`.tol_date), \"date\", `travel_orderlist`.tol_date ) ) AS \"data\" FROM `travel_orderlist` WHERE `travel_orderlist`.tol_tp1 NOT LIKE \"\" AND MONTH(`travel_orderlist`.tol_date) BETWEEN MONTH('2024-11-01') AND MONTH('2024-12-31') GROUP BY `travel_orderlist`.tol_tp1 ) `tb_2`
ON `tb_1`.trip = `tb_2`.trip)

UNION

SELECT `tb_1`.trip, `tb_1`.count, `tb_2`.data
FROM ( SELECT `travel_orderlist`.tol_tp2 AS \"trip\", COUNT(`travel_orderlist`.tol_tp2) AS \"count\" FROM `travel_orderlist` WHERE `travel_orderlist`.tol_tp2 NOT LIKE \"\" AND MONTH(`travel_orderlist`.tol_date) BETWEEN MONTH('2024-11-01') AND MONTH('2024-12-31') GROUP BY `travel_orderlist`.tol_tp2 ) `tb_1`
INNER JOIN ( SELECT `travel_orderlist`.tol_tp2 AS \"trip\", JSON_ARRAYAGG( JSON_OBJECT( \"month\", MONTH(`travel_orderlist`.tol_date), \"date\", `travel_orderlist`.tol_date ) ) AS \"data\" FROM `travel_orderlist` WHERE `travel_orderlist`.tol_tp2 NOT LIKE \"\" AND MONTH(`travel_orderlist`.tol_date) BETWEEN MONTH('2024-11-01') AND MONTH('2024-12-31') GROUP BY `travel_orderlist`.tol_tp2 ) `tb_2`
ON `tb_1`.trip = `tb_2`.trip

UNION

SELECT `tb_1`.trip, `tb_1`.count, `tb_2`.data
FROM ( SELECT `travel_orderlist`.tol_tp3 AS \"trip\", COUNT(`travel_orderlist`.tol_tp3) AS \"count\" FROM `travel_orderlist` WHERE `travel_orderlist`.tol_tp3 NOT LIKE \"\" AND MONTH(`travel_orderlist`.tol_date) BETWEEN MONTH('2024-11-01') AND MONTH('2024-12-31') GROUP BY `travel_orderlist`.tol_tp3 ) `tb_1`
INNER JOIN ( SELECT `travel_orderlist`.tol_tp3 AS \"trip\", JSON_ARRAYAGG( JSON_OBJECT( \"month\", MONTH(`travel_orderlist`.tol_date), \"date\", `travel_orderlist`.tol_date ) ) AS \"data\" FROM `travel_orderlist` WHERE `travel_orderlist`.tol_tp3 NOT LIKE \"\" AND MONTH(`travel_orderlist`.tol_date) BETWEEN MONTH('2024-11-01') AND MONTH('2024-12-31') GROUP BY `travel_orderlist`.tol_tp3 ) `tb_2`
ON `tb_1`.trip = `tb_2`.trip

)`main_table`
ORDER BY `main_table`.count DESC"); 
    $stmt2->execute();

    $arr = array();
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);

?>