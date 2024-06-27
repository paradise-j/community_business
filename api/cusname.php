<?php
    require_once '../connect.php';
    session_start();
    if(isset($_POST['function']) and $_POST['function'] == 'custumer'){
        $id = $_POST['id'];
        // echo $id;
        $stmt = $db->query("SELECT `cd_pay` FROM `credit` WHERE `cd_name` = '$id'");
        // $stmt = $db->query("SELECT `cd_pay` FROM `credit` WHERE `cd_name` = 'C0003'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["cd_pay"];
        exit();
    }

    
?>