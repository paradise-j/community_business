<?php
    require_once '../connect.php';
    session_start();

    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    }
 
    $fileName = "Data-Fixed_assets_".date('Y-m-d').".xls"; 
    $fields = array('ชื่อ', 'นามสกุล', 'ที่อยู่', 'ตำบล', 'อำเภอ', 'จังหวัด', 'รหัสไปรษณีย์', 'เบอร์โทรศัพท์', 'ชื่อผู้ใช้งานระบบ', 'รหัสผ่าน'); 
    $excelData = implode("\t", array_values($fields))."\n"; 
    
    $user_id = $_SESSION['user_id'];
    $stmt2 = $db->query("SELECT `group_id` FROM `user_data` WHERE `user_id` = '$user_id'");
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);

    $query = $db->query("SELECT * FROM `user_data`
                        INNER JOIN `user_login` on user_data.user_id = user_login.user_id
                        INNER JOIN `group_comen` on user_data.group_id = group_comen.group_id 
                        WHERE user_data.group_id = '$group_id'"); 
    $query->execute();
    $users = $query->fetchAll();

    if (!$users) {
        $excelData .= 'ไม่มีข้อมูล...'. "\n";
    } else {
        foreach($users as $user){
            $lineData = array($user['user_Fname'], $user['user_Lname'], $user['user_num'], $user['user_subdis'], 
                              $user['user_dis'], $user['user_pv'], $user['user_zip'], $user['user_phone'],
                              $user['ul_username'], $user['ul_password']); 
            array_walk($lineData, 'filterData'); 
            $excelData .= implode("\t", array_values($lineData)) . "\n"; 
        }

    }

    header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"$fileName\""); 
    
    echo $excelData; 
    
    exit;

?>