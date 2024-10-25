<?php
    require_once '../connect.php';
    header('Content-Type: application/json; charset=utf-8');

    $stmt2 = $db->query("SELECT MONTH(`inex_date`) as \"month\" , `inex_type` as \"type\", SUM(`inex_price`) as \"total\"
                        FROM `inex_data` 
                        WHERE MONTH(`inex_date`) BETWEEN MONTH('2024-01-01') AND MONTH('2024-12-23') AND `group_id` = 'CM001'
                        GROUP BY MONTH(`inex_date`),`inex_type`"); 
    $stmt2->execute();

    $arr = array();
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);

?>