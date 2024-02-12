<?php
    require_once 'connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'provinces'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT * FROM `amphures` WHERE `province_id` = '$id'");
        $stmt->execute();
        $amps = $stmt->fetchAll();
        echo '<option selected disabled>กรุณาเลือกอำเภอ....</option>';
        foreach($amps as $amp){
            echo '<option value="'.$amp['id'].'">'.$amp["name_th"].'</option>';
        }
        exit();
    }

    if(isset($_POST['function']) and $_POST['function'] == 'amphures'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT * FROM `districts` WHERE `amphure_id` = '$id'");
        $stmt->execute();
        $amps = $stmt->fetchAll();
        echo '<option selected disabled>กรุณาเลือกตำบล....</option>';
        foreach($amps as $amp){
            echo '<option value="'.$amp['id'].'">'.$amp["name_th"].'</option>';
        }
        exit();
    }

    if(isset($_POST['function']) and $_POST['function'] == 'districts'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT * FROM `districts` WHERE `id` = $id ");
        $stmt->execute();
        // $amps = $stmt->fetchAll();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["zip_code"];
        exit();
    }

?>