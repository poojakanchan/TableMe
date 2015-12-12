<?php
if (session_id() == '') {
    session_start();
}

if (isset($_GET['logout'])) {
    unset($_SESSION['username']);
    if (isset($_SESSION['user_id'])) {
        unset($_SESSION['user_id']);
    }
    unset($_GET['logout']);
}
?>

<style>
    h1 {
        text-align: center;
    }
    h2 {
        text-align: center;
    }
    .member {
        text-align: center;
    }
    h5{
        font-weight: bold;
    }

    .member{
        margin: 10px 10px 10px 10px;
        border-radius: 25px;
        border: 1px solid #e3e3e3;
        background-color:#f5f5f5;
        /*background-color:rgba(0,0,0,0.5)*/
    }
    .navbar-custom {
        margin-bottom: 0px;
        width: 100%;
        height: 80px;
        font-size: 120%;
        font-weight: bold;
        background-color: #F0FFFF;
    }

    li a {           
        color: #000000;
    }

    .logo{
        padding-top: 5px;
        padding-right: 15px;
    }

    .navbar-left {
        padding-top: 15px;
    }

    .navbar-right {
        padding-top: 15px
    }
    
    .navgationbar{
        background-color:rgba(0,0,0,0)!important;
        border: none!important;
        margin: 0 0 0 0!important;
    }
</style>

<nav class ="navbar navbar-custom">
    <div class ="container-fluid navgationbar">
        <div class ="navbar-header logo">
            <a href="index.php"><img src="blueLogo.png" width="90" height="70"/></a>
        </div>
        <div class="nav navbar-nav navbar-left">
            <li><a href="index.php">HOME</a></li>
            <li><a href="../../../aboutus.php">ABOUT</a></li>
        </div>
        <div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> JOIN US <span class="caret"></span></a>
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
                    echo '<li> <a href ="app/views/home/login.php">LOGIN</a></li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
