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
        <div class ="navbar-header">
            <a href="../../../index.php"><img src="../../../blueLogo.png"  width="175" height="120"/></a>
        </div>
        <div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Register <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../home/user_registration.php"> User</a></li>
                        <li><a href="../home/restaurant_registration.php">Restaurant</a></li>
                    </ul>
                </li>
                <?php
                if (isset($_SESSION['username'])) {
                    $link = "#";
                    if (isset($_SESSION['role'])) {
                        switch ($_SESSION['role']) {
                            case 'owner':
                                $link = '../owner/ownerpage.php';
                                break;
                            case 'user':
                                $link = '../user/userpage.php';
                                break;
                            case 'host':
                                $link = '../host/hostview.php';
                                break;
                            case 'admin':
                                $link = '../admin/adminpage.php';
                                break;
                        }
                    }
                    echo '<li><a href=' . $link . '>My Profile</a></li>';
                    echo '<li><a href="?logout=1">Logout</a></li>';
                } else {
                    echo '<li> <a href ="../home/login.php">Login</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
