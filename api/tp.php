<?php
    require_once '../connect.php';
    session_start();
    if(isset($_POST['function']) and $_POST['function'] == 'tpname'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `tp_price` FROM `travel_pack` WHERE `tp_id` = '$id'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["tp_price"];
        exit();
    }
    
?>