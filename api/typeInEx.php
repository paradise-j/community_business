<?php
    require_once '../connect.php';
    session_start();

    $user_id = $_SESSION['user_id'];
    $stmt2 = $db->query("SELECT `group_id` FROM `user_data` WHERE `user_id` = '$user_id'");
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);

    try {
        if(isset($_POST['function']) and $_POST['function'] == 'type'){
            $id = $_POST['id'];
            $stmt = $db->query("SELECT `int_name` FROM `inextype` WHERE `int_type` = '$id' AND `group_id` = '$group_id'");
            $stmt->execute();
            $amps = $stmt->fetchAll();
            echo '<option selected disabled>กรุณาเลือกรายการ....</option>';
            foreach($amps as $amp){
                echo '<option value="'.$amp["int_name"].'">'.$amp["int_name"].'</option>';
            }
            exit();
        }
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    

    
?>