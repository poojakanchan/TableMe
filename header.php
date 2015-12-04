<?php
if (session_id() == '') {
    session_start();
}

if (isset($_GET['logout'])) {
    unset($_SESSION['username']);
    unset($_GET['logout']);
}
?>


<nav class ="navbar navbar-default">
    <div class ="container-fluid">
        <div class ="navbar-header logo">
            <a href="index.php"><img src="blueLogo.png"  width="90" height="70"/></a>
        </div>
        <div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Register <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="app/views/home/user_registration.php">User</a></li>
                        <li><a href="app/views/home/restaurant_registration.php">Restaurant</a></li>
                    </ul>
                </li>             
                <?php
                if (isset($_SESSION['username'])) {
                    $link = "#";
                    if (isset($_SESSION['role'])) {
                        switch ($_SESSION['role']) {
                            case 'owner':
                                $link = 'app/views/owner/ownerpage.php';
                                break;
                            case 'user':
                                $link = 'app/views/user/userpage.php';
                                break;
                            case 'host':
                                $link = 'app/views/host/hostview.php';
                                break;
                            case 'admin':
                                $link = 'app/views/admin/adminpage.php';
                                break;
                        }
                    }
                    echo '<li><a href=' . $link . '>My Profile</a></li>';
                    echo '<li><a href="?logout=1">Logout</a></li>';
                } else {
                    echo '<li> <a href ="app/views/home/login.php">Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
