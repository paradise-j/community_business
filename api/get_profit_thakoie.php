<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once('../connect.php');

    $date = date('Y');
    $result = $db->query("SELECT  YEAR(sales.sale_date) as \"Year\" , (SUM(salesdetail.sd_price) - mf_data.mf_price) as profit
                          FROM `mf_data` 
                          INNER JOIN `salesdetail` ON mf_data.mf_name = salesdetail.sd_pdname 
                          INNER JOIN `sales` ON sales.sale_id = salesdetail.sale_id
                          WHERE mf_data.group_id = 'CM001' 
                          GROUP BY  YEAR(sales.sale_date)");
    $result->execute();

    $arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
?>