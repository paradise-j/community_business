<?php
    require_once '../connect.php';
    session_start();
    if(isset($_POST['function']) and $_POST['function'] == 'orderer'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `odr_phone` FROM `orderer` WHERE `odr_id` = '$id'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["odr_phone"];
        exit();
    }
    
?>