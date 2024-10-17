<?php
    require_once '../connect.php';
    session_start();

    $id = $_SESSION['id'];
    $stmt = $db->prepare("SELECT `user_id` FROM `user_login` WHERE `user_id` = :user_id");
    $stmt->bindParam(':user_id', $id, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($result);

    $stmt2 = $db->prepare("SELECT `group_id` FROM `user_data` WHERE `user_id` = :user_id");
    $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_STR);
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);

    $sidebars = [
        'CM001' => './sidebar1.php',
        'CM002' => './sidebar4.php',
        'CM003' => './sidebar2.php',
        'CM004' => './sidebar6.php',
        'CM005' => './sidebar7.php',
        'CM006' => './sidebar8.php'
    ];
    
    $sidebar_to_include = $sidebars[$group_id] ?? './sidebar_plant.php';
    // include($sidebar_to_include);
    // require $sidebar_to_include;
    echo "working";

?>
<script> 
    window.onload = () => {
        console.log('work')
    }
</script>