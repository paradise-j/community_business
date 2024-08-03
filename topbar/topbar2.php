<?php 
    $username = $_SESSION["username"];
    $password = $_SESSION["password"];
    
    // echo $username." ".$password;
    $stmt = $db->prepare("SELECT user_login.ul_id, user_login.user_id, user_data.user_Fname, user_data.user_Lname 
                          FROM `user_login` 
                          INNER JOIN `user_data` ON user_login.user_id = user_data.user_id
                          WHERE user_login.ul_username = '$username' and user_login.ul_password = '$password'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);

?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                <?php
                    echo $user_Fname." ".$user_Lname."&nbsp&nbsp";
                ?>
                </span>
                <img class="img-profile rounded-circle"
                    src="img/undraw_profile.svg">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    โปรไฟล์
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    ออกจากระบบ
                </a>
            </div>
        </li>

    </ul>

</nav>