<?php
    $servername = "app.nfcsurat.or.th";
    $username = "motolife_nfcapp";
    $password = "FGAxvvuSt4jHqKfr6hFP";
    $dbname = "motolife_nfcapp";

    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
?>