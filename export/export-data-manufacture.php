<?php
    require_once '../connect.php';
    session_start();

    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }
 
    $fileName = "Data-manufacture_".date('Y-m-d').".xls"; 
    $fields = array('วันที่ผลิตสินค้าชุมชน', 'ชื่อสินค้าชุมชน', 'หน่วยนับ', 'จำนวน', 'ราคาทุนรวม', 'ราคาทุนต่อหน่วย'); 
    $excelData = implode("\t", array_values($fields))."\n"; 
    
    $user_id = $_SESSION['user_id'];
    $stmt2 = $db->query("SELECT `group_id` FROM `user_data` WHERE `user_id` = '$user_id'");
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);

    $query = $db->query("SELECT * FROM `mf_data` WHERE `group_id` = '$group_id'"); 
    $query->execute();
    $mfs = $query->fetchAll();

    if (!$mfs) {
        $excelData .= 'ไม่มีข้อมูล...'. "\n";
    } else {
        foreach($mfs as $mf){
            $lineData = array($mf['mf_date'], $mf['mf_name'],$mf['mf_unit'], 
                              number_format($mf['mf_quan'],2), number_format($mf['mf_price'],2), number_format($mf['mf_cost'],2)); 
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        }

    }

    header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"$fileName\""); 
    
    echo $excelData; 
    
    exit;

?>