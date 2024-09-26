<?php
    require_once '../connect.php';
    session_start();
    if(isset($_POST['function']) and $_POST['function'] == 'pdunit'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `pd_unit` FROM `product` WHERE `pd_id` = '$id'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["pd_unit"];
        exit();
    }
    
?>