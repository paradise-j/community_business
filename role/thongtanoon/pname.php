<?php
    require_once '../../connect.php';
    session_start();

    // if(isset($_POST['function']) and $_POST['function'] == 'pname'){
        // $id = $_POST['id'];
        $stmt = $db->query("SELECT * FROM `product` WHERE `pd_id` = '2'");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        echo $pd_unitprice;
        exit();
    // }

?>