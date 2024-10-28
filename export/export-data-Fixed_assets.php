<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once '../connect.php';
    session_start();

    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }
 
    $fileName = "Data-Fixed_assets_".date('Y-m-d').".xls"; 
    $fields = array('ชื่อสินทรัพย์ถาวร', 'ราคา(บาท)', 'ที่ตั้ง', 'แหล่งที่มา'); 
    $excelData = implode("\t", array_values($fields))."\n"; 
    
    $user_id = $_SESSION['user_id'];
    $stmt2 = $db->query("SELECT `group_id` FROM `user_data` WHERE `user_id` = '$user_id'");
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);

    $query = $db->query("SELECT `fa_name`,`fa_price`,`fa_location`,`location222` FROM `fixed_asset` WHERE `group_id` = '$group_id'"); 
    $query->execute();
    $fas = $query->fetchAll();

    if (!$fas) {
        $excelData .= 'ไม่มีข้อมูล...'. "\n";
    } else {
        foreach($fas as $fa){
            $lineData = array($fa['fa_name'], number_format($fa['fa_price'],2), $fa['fa_location'], $fa['location222']); 
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        }

    }

    header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"$fileName\""); 
    
    echo $excelData; 
    
    exit;

?>