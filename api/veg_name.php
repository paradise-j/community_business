<?php
    require_once '../connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'pld_id'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT `pod_name` FROM `plant_orderlist_detail` WHERE `pld_id` = '$id'");
        $stmt->execute();

        // $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // echo $row["gw_id"];

        $gws = $stmt->fetchAll();
        foreach($gws as $gw){
            echo '<option value="'.$gw['pod_name'].'">'.$gw["pod_name"].'</option>';
        }
        exit();
    }

?>