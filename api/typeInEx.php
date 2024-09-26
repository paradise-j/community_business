<?php
    require_once '../connect.php';
    session_start();

    try {
        if(isset($_POST['function']) and $_POST['function'] == 'typeInEx'){
            $id = $_POST['id'];
            $stmt = $db->query("SELECT `int_name` FROM `inextype` WHERE `int_type` = '$id'");
            $stmt->execute();
            $amps = $stmt->fetchAll();
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            foreach($amps as $amp){
                echo '<option value="'.$amp["int_name"].'">'.$amp["int_name"].'</option>';
            }
            exit();
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    

    
?>