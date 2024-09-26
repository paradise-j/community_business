<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');

    $result = $db->query("SELECT MONTH(mf_data.mf_date) as month , mf_data.mf_name , mf_data.mf_price , SUM(salesdetail.sd_price) as sum_price FROM `mf_data` 
                          INNER JOIN `salesdetail` ON mf_data.mf_name = salesdetail.sd_pdname
                          WHERE  mf_data.group_id = 'CM004'
                          GROUP BY mf_data.mf_name");
    $result->execute();

    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
?>