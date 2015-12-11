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
    .containerMain{
        /*background-color:#2E52E0!important;*/
        background-color:rgba(0,0,0,0)!important;
        border: none!important;
    }
    
    .container-fluid-header{
        /*margin: 10px 10px 10px 10px;*/
        /*border-radius: 25px;*/
        /*border: 1px solid #e3e3e3;*/
        background-color:#f5f5f5;
        /*background-color:rgba(0,0,0,0.5)*/
        position: relative;
        width: 100%;
        height: 200px;
        background: url('banner2.jpg') center center;
        background-size: cover;
    }
    
    .searchbar, .btn-search{
        margin-top: 100px;
    }
    
    .searchbox {
        width: 40%;
        margin: auto;
    }
</style>

<nav class ="navbar navbar-default">
    <div class ="container-fluid-header">
        <div class ="navbar-header">
            <!--<a href="../../../index.php"><img src="../../../blueLogo.png"  width="175" height="120"/></a>-->
            <a href="../../../index.php"><img src="../../../blueLogo.png"  width="125" height="100"/></a>
        </div>
        <div>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Register <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="user_registration.php"> User</a></li>
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
        
        <!--Serch box-->
        <form class="input-group searchbox" action=" " method="get"> <!-- Class for Search box -->

            <!--<input name="foodCategory" id="foodCategory" value="" hidden />-->
            <input type="text" class="form-control searchbar" size="10" name = "searchText" id="searchText" required placeholder="Search by Address, Name, Food Category of the Restaurants." value=""/>
            <span class="input-group-btn">
                <input class="btn btn-default btn-search" type="submit" value="Search" />
            </span>
        </form> <!-- End of the Search box -->
<!--        <center><h4> This Website is only for CSC648/848 Software Engineering Project </h4></center>
        <center><h4> Created by Team 11, if you want to learn more about us <a href="aboutus.php">(Click Here)</a></h4></center>-->
    </div>
</nav>
