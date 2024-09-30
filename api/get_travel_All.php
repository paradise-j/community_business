<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');

    $result = $db->query("SELECT MONTH(`tol_date`) as month, SUM(`tol_totalp`) as total
                          FROM `travel_orderlist` 
                          GROUP BY MONTH(`tol_date`)");
    $result->execute();

    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
?>