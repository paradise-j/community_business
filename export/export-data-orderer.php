<?php
    require_once '../connect.php';
    session_start();

    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }
 
    $fileName = "Data-orderer_".date('Y-m-d').".xls"; 
    $fields = array('ชื่อผู้สั่งซื้อ', 'เบอร์โทรศัพท์', 'ตำบล', 'อำเภอ', 'จังหวัด', 'รหัสไปรษณีย์'); 
    $excelData = implode("\t", array_values($fields))."\n"; 
    
    $id = $_SESSION['id'];
    $stmt = $db->prepare("SELECT `user_id` FROM `user_login` WHERE `user_id` = :user_id");
    $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($result);

    $stmt2 = $db->prepare("SELECT `group_id` FROM `user_data` WHERE `user_id` = :user_id");
    $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);

    $query = $db->query("SELECT * FROM `orderer` WHERE `group_id` = '$group_id'"); 
    $query->execute();
    $users = $query->fetchAll();

    if (!$users) {
        $excelData .= 'ไม่มีข้อมูล...'. "\n";
    } else {
        foreach($users as $user){
            $lineData = array($user['odr_name'], $user['odr_phone'], $user['user_subdis'], 
                              $user['user_dis'], $user['user_pv'], $user['user_zip']); 
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        }

    }

    header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"$fileName\""); 
    
    echo $excelData; 
    
    exit;

?>