<?php
    require_once '../connect.php';
    header('Content-Type: application/json; charset=utf-8');

    $stmt2 = $db->query("SELECT
                            MONTH(`md_date`) AS \"month\",
                            `md_name`,
                            SUM(`md_price`) AS \"total\"
                        FROM
                            `mfd_matdetail`
                        INNER JOIN `mf_data_detail` ON mfd_matdetail.mfd_id = mf_data_detail.mfd_id
                        INNER JOIN `mf_data` ON mf_data_detail.mf_id = mf_data.mf_id
                        WHERE
                            MONTH(`md_date`) BETWEEN MONTH('2024-01-01') AND MONTH('2024-12-23') AND mf_data.group_id = 'CM001'
                        GROUP BY
                            MONTH(`md_date`),
                            `md_name`"); 
    $stmt2->execute();

    $arr = array();
    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){
        array_push($arr,$row);
    }
    echo json_encode($arr);

?>