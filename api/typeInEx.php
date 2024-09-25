<?php
    require_once '../connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'typeInEx'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT * FROM `amphures` WHERE `province_id` = '$id'");
        $stmt->execute();
        $amps = $stmt->fetchAll();
        echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
        foreach($amps as $amp){
            echo '<option value="'.$amp['id'].'">'.$amp["name_th"].'</option>';
        }
        exit();
    }

    
?>