<?php
    require_once '../connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'pld_id'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `pod_name`,`pod_quan` FROM `plant_orderlist_detail` WHERE `pld_id` = '$id'");
        $stmt->execute();

        $arr = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            array_push($arr,$row);
        }
        echo json_encode($arr);
        
        // exit();
    }

?>