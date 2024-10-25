<?php
    $servername = "localhost";
    $username = "motolife_nfcapp";
    $password = "FGAxvvuSt4jHqKfr6hFP";
    $dbname = "motolife_nfcapp";
    $charset = "utf8";

    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("set names utf8");
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>