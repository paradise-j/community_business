<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');

    $result = $db->query("SELECT  MONTH(`px_date`) as \"month\", orderer.odr_name as \"veg_name\" ,Plant_export.px_quan as \"export_quan\"
                        FROM `Plant_export`
                        INNER JOIN `orderer` ON Plant_export.odr_id = orderer.odr_id
                        GROUP BY MONTH(`px_date`), orderer.odr_name");
    $result->execute();

    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
?>