<?php
    require_once '../connect.php';
    session_start();
    if(isset($_POST['function']) and $_POST['function'] == 'mf'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `mat_unit` FROM `material` WHERE `mat_id` = '$id'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["mat_unit"];
        exit();
    }
    
?>