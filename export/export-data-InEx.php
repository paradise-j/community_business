<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once '../connect.php';
    session_start();

    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }
 
    $fileName = "Data-manufacture_".date('Y-m-d').".xls"; 
    $fields = array('วันที่ทำรายการ', 'ประเภทรายการ', 'ชื่อรายการ', 'จำนวนเงิน'); 
    $excelData = implode("\t", array_values($fields))."\n"; 
    
    $user_id = $_SESSION['user_id'];
    $stmt2 = $db->query("SELECT `group_id` FROM `user_data` WHERE `user_id` = '$user_id'");
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);

    $query = $db->query("SELECT * FROM `inex_data` WHERE `group_id` = '$group_id'"); 
    $query->execute();
    $inexs = $query->fetchAll();

    if (!$inexs) {
        $excelData .= 'ไม่มีข้อมูล...'. "\n";
    } else {
        foreach($inexs as $inex){
            $lineData = array($inex['inex_date'], $inex['inex_type'],$inex['inex_name'], number_format($inex['inex_price'],2)); 
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        }

    }

    header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"$fileName\""); 
    
    echo $excelData; 
    
    exit;

?>