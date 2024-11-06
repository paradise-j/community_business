<?php 
    require_once 'connect.php';
    session_start();

    if (isset($_POST['btn_login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        try {
            $select_stmt = $db->prepare("SELECT * FROM `user_login` WHERE `ul_username` = '$username' AND `ul_password` = '$password'");
            $select_stmt->execute(); 

            while($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
                $dbid = $row['ul_id'];
                $dbusername = $row['ul_username'];
                $dbpassword = $row['ul_password'];
                $dbrole = $row['ul_status'];
                $dbuser_id = $row['user_id'];
                
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
                                $_SESSION['user_id'] = $dbuser_id;
                                $_SESSION['success'] = "Admin... Successfully Login...";
                                header("location: role/admin/index.php");
                            break;
                            case '2':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['user_id'] = $dbuser_id;
                                $_SESSION['success'] = "DirectorNFC... Successfully Login...";
                                header("location: role/nfc/index.php");
                            break;
                            case '3':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['user_id'] = $dbuser_id;
                                $_SESSION['success'] = "thakoie... Successfully Login...";
                                header("location: role/thakoie/index.php");
                            break;
                            case '4':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['user_id'] = $dbuser_id;
                                $_SESSION['success'] = "khongchaoun... Successfully Login...";
                                header("location: role/khongchaoun/index.php");
                            break;
                            case '5':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['user_id'] = $dbuser_id;
                                $_SESSION['success'] = "thongtanoon... Successfully Login...";
                                header("location: role/thongtanoon/index.php");
                            break;
                            case '6':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['user_id'] = $dbuser_id;
                                $_SESSION['success'] = "rubber... Successfully Login...";
                                header("location: role/rubber/index.php");
                            break;
                            case '7':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['user_id'] = $dbuser_id;
                                $_SESSION['success'] = "phumriang... Successfully Login...";
                                header("location: role/phumriang/index.php");
                            break;
                            case '8':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['user_id'] = $dbuser_id;
                                $_SESSION['success'] = "huaysai... Successfully Login...";
                                header("location: role/huaysai/index.php");
                            break;
                            case '9':
                                $_SESSION['id'] = $dbid;
                                $_SESSION['username'] = $dbusername;
                                $_SESSION['password'] = $dbpassword;
                                $_SESSION['permission'] = $dbrole;
                                $_SESSION['user_id'] = $dbuser_id;
                                $_SESSION['success'] = "ThakhamPlant... Successfully Login...";
                                header("location: role/ThakhamPlant/index.php");
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