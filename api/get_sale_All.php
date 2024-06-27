<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');

    $result = $db->query("SELECT MONTH(`sale_date`) as month, SUM(`sale_Nprice`) as total
                          FROM `sales` GROUP BY MONTH(`sale_date`)");
    $result->execute();

    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
?>