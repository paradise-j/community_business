<?php
    require_once '../connect.php';
    header('Content-Type: application/json; charset=utf-8');
    $stmt2 = $db->query("SELECT SUM(sales.sale_Nprice) as total , MONTH(sale_date) as month 
                         FROM `sales` 
                         INNER JOIN `salesdetail` ON sales.sale_id = salesdetail.sale_id 
                         WHERE MONTH(sale_date) BETWEEN MONTH('2024-06-01') AND MONTH('2024-08-04')
                         GROUP BY MONTH(sale_date)"); 
    $stmt2->execute();

    $arr = array();
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);
    
?>