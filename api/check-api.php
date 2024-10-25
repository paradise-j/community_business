<?php
    require_once '../connect.php';
    header('Content-Type: application/json; charset=utf-8');

    $stmt2 = $db->query("SELECT MONTH(`px_date`) as \"month\" , `px_name` as \"name\" ,SUM(`px_total`) as \"total\"
                        FROM `Plant_export` 
                        WHERE MONTH(`px_date`) BETWEEN MONTH('2024-01-01') AND MONTH('2024-12-01')
                        GROUP BY MONTH(`px_date`) , `px_name`"); 
    $stmt2->execute();

    $arr = array();
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);

?>