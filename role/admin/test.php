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
    print_r($check2);



    $cuss = $db->prepare("SELECT * FROM `customer`");
    $cuss->execute();
    while ($row = $cuss->fetch(PDO::FETCH_ASSOC)) {
        if('นาย ข' == $row["cus_name"]){
            $cus_id = $row["cus_id"]; 
            break;
        }
    }

    $cd = $db->prepare("SELECT `cd_name`, `cd_pay` FROM `credit`");
    $cd->execute();
    while ($row = $cd->fetch(PDO::FETCH_ASSOC)){
        echo "<br>";
        if ($cus_id == $row["cd_name"]) {
            echo $row["cd_name"]." ".$row["cd_pay"];
            // $cd3 = $db->prepare("UPDATE `credit` SET `cd_pay`= '$Newtotal2' WHERE `cd_name` = '$cus_id'");
            // $cd3->execute();
            break;
        } else {
            echo $row["cd_name"]."2222".$row["cd_pay"];
            // $cd2 = $db->prepare("INSERT INTO `credit`(`cd_date`, `cd_name`, `cd_pay`) VALUES ('$date' , '$cus_id' , $Newtotal)");
            // $cd2->execute();
            break;
        }

    }

?>