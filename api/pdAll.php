<?php
    require_once '../connect.php';
    session_start();
    if(isset($_POST['function']) and $_POST['function'] == 'pdAll'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `mf_cost` FROM `mf_data` WHERE `mf_id` = 'MF0068'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // $arr = array();
        // while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        //     array_push($arr,$row);
        // }
        // echo json_encode($arr);
        echo $row["mf_cost"];
        exit();
    }
    
?>