<?php
    require_once '../connect.php';
    session_start();
    if(isset($_POST['function']) and $_POST['function'] == 'pdname'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `mf_tocost`,`mf_unit` FROM `mf_data` WHERE `mf_id` = '$id'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["mf_tocost"];
        exit();
    }
    
?>