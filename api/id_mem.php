<?php
    header('Content-Type: application/json; charset=utf-8');
    require_once '../connect.php';
    session_start();
    
    if(isset($_POST['function']) and $_POST['function'] == 'id_mem'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `odr_name`, `odr_phone` FROM `orderer` WHERE `odr_phone` = '$id'");
        $stmt->execute();

        $arr = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($arr,$row);
        }
        echo json_encode($arr);
        // exit();
    }
    
?>