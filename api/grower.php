<?php
    require_once '../connect.php';
    session_start();

    if(isset($_POST['function']) and $_POST['function'] == 'grower'){
        $id = $_POST['id'];
        $stmt = $db->query("SELECT * FROM `grower` WHERE `gw_id` = '$id'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["gw_name"];

        // $gws = $stmt->fetchAll();
        // foreach($gws as $gw){
        //     echo '<option value="'.$gw['id'].'">'.$gw["name_th"].'</option>';
        // }
        exit();
    }

?>