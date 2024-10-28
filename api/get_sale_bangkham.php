<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');

    $result = $db->query("SELECT MONTH(`px_date`) as month, SUM(`px_total`) as total
                          FROM `Plant_export` GROUP BY MONTH(`px_date`)");
    $result->execute();

    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
?>