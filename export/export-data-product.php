<?php
    require_once '../connect.php';
    session_start();

    $id = $_SESSION['id'];
    echo $id;
    $stmt = $db->prepare("SELECT `user_id` FROM `user_login` WHERE `user_id` = :user_id");
    $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($result);

    $stmt2 = $db->prepare("SELECT `group_id` FROM `user_data` WHERE `user_id` = :user_id");
    $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt2->execute();
    $check_group = $stmt2->fetch(PDO::FETCH_ASSOC);
    extract($check_group);
    echo $group_id

    $stmt3 = $db->query("SELECT  product.pd_date, group_comen.group_name as group_name ,product.pd_name,  product.pd_unit 
                           FROM `product` INNER JOIN `group_comen` ON group_comen.group_id = product.group_id
                           WHERE product.group_id = '$group_id'");
    $stmt3->execute();
    $table = '<table>
            <tr>
                <td>วันที่เพิ่มข้อมูลสินค้า</td>
                <td>กลุ่มวิสาหกิจชุมชน</td>
                <td>ชื่อสินค้าชุมชน</td>
                <td>หน่วยนับ</td>
            </tr>';
    while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
        $table.= '<tr>
                    <td>'.$row['pd_date'].'</td>
                    <td>'.$row['group_name'].'</td>
                    <td>'.$row['pd_name'].'</td>
                    <td>'.$row['pd_unit'].'</td>
                  </tr>';
    }
        $table.= '</table>';
    header("Content-Type:application/xls");
    header("Content-Disposition: attachment; filename=Data-Product.xls");
    echo $table;




?>