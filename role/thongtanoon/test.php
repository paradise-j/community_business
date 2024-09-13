<?php
    
    session_start();
    require_once '../../connect.php';

    $cd = $db->prepare("SELECT `cd_name`, `cd_pay` FROM `credit`");
    $cd->execute();
    $rowcd = $cd->fetch(PDO::FETCH_ASSOC);
    extract($rowcd);
    // echo $cd_name,"<br>",$cd_pay;

    $check2 = array();
    while ($row = $cd->fetch(PDO::FETCH_ASSOC)){
        $id = $row["cd_name"];
        array_push($check2,$id);
    }
    // print_r($check2);



    $cuss = $db->prepare("SELECT * FROM `customer`");
    $cuss->execute();
    while ($row = $cuss->fetch(PDO::FETCH_ASSOC)) {
        if('นาย ก' == $row["cus_name"]){
            $cus_id = $row["cus_id"]; 
            break;
        }
    }
    echo $cus_id;



?>