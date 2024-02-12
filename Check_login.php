<?php 
    require_once 'connect.php';
    session_start();

    if (isset($_POST['btn_login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        try {
            $select_stmt = $db->prepare("SELECT * FROM `user_login` WHERE `user_name` = '$username' AND `user_password` = '$password'");
            $select_stmt->execute(); 

            while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $dbid = $row['user_id'];
                $dbusername = $row['user_name'];
                $dbpassword = $row['user_password'];
                $dbrole = $row['user_role'];
            }

            if ($username != null AND $password != null) {
                if ($select_stmt->rowCount() > 0) {
                    if ($username == $dbusername AND $password == $dbpassword ) {
                        switch($dbrole) {
                            case '1':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['success'] = "Admin... Successfully Login...";
                                header("location: role/admin/index.php");
                            break;
                            case '2':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['success'] = "director... Successfully Login...";
                                header("location: role/director/index.php");
                            break;
                            
                            default:
                                $_SESSION['error'] = "Wrong email or password or role";
                                header("location: agriculturist/index.php");
                        }
                    }
                } else {
                    $_SESSION['error'] = "Wrong email or password or role";
                    header("location: index.php");
                }
            }
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }
?>