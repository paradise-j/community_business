<?php
    require_once '../connect.php';
    session_start();
    if(isset($_POST['function']) and $_POST['function'] == 'permission'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `pre_name` FROM `pre_user` WHERE `pre_id` = '$id'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["pre_name"];
        exit();
    }

    
?>