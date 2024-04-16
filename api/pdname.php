<?php
    require_once '../connect.php';
    session_start();
    echo "1";
    // if(isset($_POST['function']) and $_POST['function'] == 'pname'){
        echo "1";
        $id = $_POST['id'];
        // $id = 4;
        $stmt = $db->query("SELECT `pd_avgprice` as price FROM `product` WHERE `pd_id` = '$id'");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row["price"];
        exit();
    // }
    
?>