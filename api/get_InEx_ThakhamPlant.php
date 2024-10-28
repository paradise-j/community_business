<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');

    $result = $db->query("SELECT `inex_type`,SUM(`inex_price`) as money FROM `inex_data` WHERE `group_id` = 'CM007' GROUP BY `inex_type`");
    $result->execute();

    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
?>