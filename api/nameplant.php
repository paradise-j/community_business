<?php

    require_once '../connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'g_id'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `plant_name` FROM `planting` WHERE `plant_grower` = '$id'");
        $stmt->execute();
        $amps = $stmt->fetchAll();
        echo '<option selected disabled>กรุณาเลือกผัก....</option>';
        foreach($amps as $amp){
            echo '<option value="'.$amp['plant_name'].'">'.$amp["plant_name"].'</option>';
        }
        exit();
    }

?>
