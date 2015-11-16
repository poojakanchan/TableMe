<!DOCTYPE html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EZ Restaurant</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/bootstrap-responsive.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">


    <!--
    Leave the CSS file in the .php file for now.
    After everything is done, we will merge every singe css into one big file. 
    -->

    <style type ="text/css">

        .navbar-default {
            margin-bottom: 0px;
        }

        .jumbotron-banner {
            position: relative;
            width: 100%;
            height: 250px;
            background: url('banner.jpg') center center;
            background-size: cover;
            padding-right: 250px;
            padding-left: 250px;
            margin-bottom: 0px;       
        }

        .jumbotron-Ranking {
            padding-top: 5px;
            margin-top: 0px;
            background-color: white;
            //margin-right: 0px;

        }

        .jumbotron-Event {
            padding-top: 5px;
            margin-top: 0px;
            background-color: white;
            //margin-left: 0px;

        }

    </style>

</head>

<body>
    <?php
    require_once 'header.php';
    require_once 'app/models/Restaurant_model.php';
    require_once 'app/models/Event_model.php';
    
    define("N_PER_PAGE", 5); //number of restaurants to display per page
   
    $db;
    $restaurant_array;
    $foodCategoryArray;
    $restaurantListTitle;
    $nameAddCat = '%';
    $totalCount = 0; //total count of restaurants to display
    $currentPage = $numberOfPages = $startPage = 1; //page number for navigating search results
    if (!isset($db)) {
        $db = new Restaurant_model();
    }

    if (empty($foodCategoryArray)) {
        $foodCategoryArray = $db->getFoodCategories();
    }

//    if ($_GET) {
    $nameAddCat = ((!isset($_GET['searchText']) || empty($_GET['searchText'])) ? '%' : htmlspecialchars($_GET['searchText']));
    $currentPage = (isset($_GET['pgnum']) ? htmlspecialchars($_GET['pgnum']) : 1);
    $totalCount = $db->findRestaurantsCount($nameAddCat);
    $restaurant_array = $db->findRestaurantsLimitOffset($nameAddCat, N_PER_PAGE, ($currentPage - 1) * N_PER_PAGE);

//        var_dump($totalCount);
//        echo '<br>';
//        var_dump($restaurant_array);
//        exit();

    if ($nameAddCat == '%') {
        $restaurantListTitle = "All Restaurants (" . $totalCount . " total)";
    } else {
        $restaurantListTitle = "Your search found " . $totalCount . ($totalCount > 1 ? " restaurants" : " restaurant");
    }
//    } else {
//        $totalCount = $db->getAllRestaurantsCount();
//        $restaurantListTitle = "All Restaurants (" . $totalCount . " total)";
//        if ($totalCount > N_PER_PAGE) {
//            $restaurant_array = $db->getAllRestaurantsLimitOffset(N_PER_PAGE, 0);
//        }
//    }

    $numberOfPages = (int) ceil($totalCount / N_PER_PAGE);

    if ($currentPage <= 5) {
        $startPage = 1;
    } else if ($currentPage > $numberOfPages - 4) {
        $startPage = ($numberOfPages - 8 < 1 ? 1 : $numberOfPages - 8);
    }

    $pageArray = array();
    for ($i = 0; $i < 9 && $i < $numberOfPages; $i++) {
        $pageArray[$i] = $startPage++;
    }

    //populates event array
    $db = new Event_model();
    $eventArray = $db->getAllEvents();
    
    ?>

    <div class="jumbotron jumbotron-banner">
        <br><br><br>
        <center><h4> This Web site is for SFSU CSC648/848 Software Engineering Project </h4></center>

        <form class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get"> <!-- Class for Search box -->

            <input name="foodCategory" id="foodCategory" value="" hidden />
            <input type="text" class="form-control" name = "searchText" id="searchText" required placeholder="Search by Address, Name, Food Category of the Restaurants." value="<?php echo($nameAddCat === '%' ? "" : $nameAddCat); ?>"/>
            <span class="input-group-btn">
                <input class="btn btn-default" type="submit" value="Search" />
            </span>
        </form> <!-- End of the Search box -->
    </div><!-- /.col-lg-6 -->

    <!-- 2nd Section of the Page (contains Ranking page & Events Page -->

    <div class = "row">
        <div class ="col-xs-6">
            <div class ="jumbotron jumbotron-Ranking">
                <center> <h2> <?php echo $restaurantListTitle ?> </h2> </center>
                <div class="panel panel-default">

                    <?php
//                         echo '<br><br><br><br>'.var_dump($nameAdd).'<br><br>'.var_dump($currentPage).'<br>'.var_dump($totalCount);
                    foreach ($restaurant_array as $restaurant) {
                        $image = base64_encode($restaurant['thumbnail']);
                        $image_src = "data:image/jpeg;base64," . $image;
                        $resId = $restaurant['restaurant_id'];
                        ?>

                        <div class="panel-body"> <!-- Will work on the details later -->
                            <a href="#restaurant view page"> <img width="100" height="100" src="<?php echo $image_src; ?>" /> </a>
                            <h3>  <a  href="<?php echo 'app/views/home/restaurant.php?resid=' . $restaurant['restaurant_id'] ?>" > <?php echo $restaurant['name'] ?> </a> </h3>
                            <p> <?php echo $restaurant['address'] ?> </p>
                            <p>  <?php echo $restaurant['description'] ?> </p>
                            <button class="btn btn-info" data-toggle="modal" data-id="<?php echo $restaurant['restaurant_id'] ?>" data-target="#reservation-<?php echo $restaurant['restaurant_id'] ?>" >
                                Reservation
                            </button>

                            <div  class="modal fade" id="reservation-<?php echo $restaurant['restaurant_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <form name="myForm" action="#.php"
                                      onsubmit="return validateForm()" method="post">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <label class="modal-title" name ="myModalLabel" id="myModalLabel">Make reservation at restaurant </label>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-lg-12 well">
                                                    <div class="row">
                                                        <input type="hidden" name="restaurant" value="<?php echo $resId ?> ">
                                                        <!-- for debug purposes, displays restaurant ID -->
                                                        <?php echo $resId ?>
                                                        <div class="col-sm-12">          

                                                            <select class="selectpicker" data-width="auto" id="guests" name="guests" required>
                                                                <option value="" disabled selected>Number of Guests</option>

                                                                <option value="2">2</option>

                                                                <option value="4">4</option>

                                                                <option value="6">6</option>
                                                            </select>

                                                            <br>
                                                            <br>

                                                            <select class="selectpicker" data-width="auto" id="month" name="month" required>
                                                                <option value="" disabled selected>Month</option>
                                                                <option value ="January">January</option>
                                                                <option value="February">February</option>
                                                                <option value="March">March</option>
                                                                <option value="April">April</option>
                                                                <option value="May">May</option>
                                                                <option value="June">June</option>
                                                                <option value ="July">July</option>
                                                                <option value="August">August</option>
                                                                <option value="September">September</option>
                                                                <option value="October">October</option>
                                                                <option value="November">November</option>
                                                                <option value="December">December</option>
                                                            </select>

                                                            <select class="selectpicker" data-width="auto" id="day" name="day" required>
                                                                <option value="" disabled selected>Day</option>
                                                                <option value ="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value ="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value ="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                                <option value="20">20</option>
                                                                <option value="21">21</option>
                                                                <option value="22">22</option>
                                                                <option value="23">23</option>
                                                                <option value="24">24</option>
                                                                <option value="25">25</option>
                                                                <option value="26">26</option>
                                                                <option value ="27">27</option>
                                                                <option value="28">28</option>
                                                                <option value="29">29</option>
                                                                <option value="30">30</option>
                                                                <option value="31">31</option>
                                                            </select>

                                                            <select class="selectpicker" data-width="auto" id="year" name="year" required>
                                                                <option value="" disabled selected>Year</option>
                                                                <option value ="2015">2015</option>
                                                                <option value="2016">2016</option>
                                                                <option value="2017">2017</option>
                                                            </select>

                                                            <select class="selectpicker" data-width="auto" id="time" name="time" required>
                                                                <option value="" disabled selected>Time</option>
                                                                <option value ="8am">8:00 AM</option>
                                                                <option value="8:30am">8:30 AM</option>
                                                                <option value="9am">9:00 AM</option>
                                                                <option value="930am">9:30 AM</option>
                                                                <option value="10am">10:00 AM</option>
                                                                <option value="1030am">10:30 AM</option>
                                                                <option value ="11am">11:00 AM</option>
                                                                <option value="1130am">11:30 AM</option>
                                                                <option value="12pm">12:00 PM</option>
                                                                <option value="1230pm">12:30 PM</option>
                                                                <option value="1pm">1:00 PM</option>
                                                                <option value="130pm">1:30 PM</option>
                                                                <option value="2pm">2:00 PM</option>
                                                                <option value="230pm">2:30 PM</option>
                                                                <option value="3pm">3:00 PM</option>
                                                                <option value="330pm">3:30 PM</option>
                                                                <option value="4pm">4:00 PM</option>
                                                                <option value="430pm">4:30 PM</option>
                                                                <option value="5pm">5:00 PM</option>
                                                                <option value="530pm">5:30 PM</option>
                                                                <option value="6pm">6:00 PM</option>
                                                                <option value="630pm">6:30 PM</option>
                                                                <option value="7pm">7:00 PM</option>
                                                                <option value="730pm">7:30 PM</option>
                                                                <option value="8pm">8:00 PM</option>
                                                                <option value="830pm">8:30 PM</option>
                                                                <option value="9pm">9:00 PM</option>
                                                                <option value="930pm">9:30 PM</option>
                                                                <option value="10pm">10:00 PM</option>
                                                                <option value="1030pm">10:30 PM</option>
                                                                <option value="11pm">11:00 PM</option>
                                                                <option value="1130pm">11:30 PM</option>
                                                                <option value="12am">12:00 AM</option>
                                                                <option value="1230am">12:30 AM</option>
                                                                <option value="1am">1:00 AM</option>
                                                                <option value="130am">1:30 AM</option>
                                                                <option value="2am">2:00 AM</option>
                                                                <option value="230am">2:30 AM</option>
                                                                <option value="3am">3:00 AM</option>
                                                                <option value="330am">3:30 AM</option>
                                                                <option value="4am">4:00 AM</option>
                                                                <option value="430am">4:30 AM</option>
                                                                <option value="5am">5:00 AM</option>
                                                                <option value="530am">5:30 AM</option>
                                                                <option value="6am">6:00 AM</option>
                                                                <option value="630am">6:30 AM</option>
                                                                <option value="7am">7:00 AM</option>
                                                                <option value="730am">7:30 AM</option>
                                                            </select>

                                                            <br>
                                                            <br>

                                                            <div class="row">


                                                                <div class="col-sm-6 form-group">
                                                                    <label>First Name</label>
                                                                    <input type="text" name="reservationFirstName" placeholder="Please enter your first name..." class="form-control" required>
                                                                </div>
                                                                <div class="col-sm-6 form-group">
                                                                    <label>Last Name</label>
                                                                    <input type="text" name="reservationLastName" placeholder="Please enter your last name..." class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-sm-6 form-group">
                                                                    <label>Email</label>
                                                                    <input type="email" name="reservationEmail" placeholder="Please enter your email address..." class="form-control" required>
                                                                </div>
                                                                <div class="col-sm-6 form-group">
                                                                    <label>Phone Number</label>
                                                                    <input type="text" name="reservationPhone" placeholder="Please enter your phone number..." class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Accommodations</label>
                                                                <input type="text" name="accommodations" placeholder="Please enter any special requests you may have..." class="form-control">
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" value="submit-reservation" name="submit-reservation" >Make reservation</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>                       
                            <!--
    <div data-role="popup" id="reservation" class="ui-content" style="min-width:250px;">

         <form method="post" action="demoform.asp">
          <div>
            <h3>Login information</h3>
            <label for="usrnm" class="ui-hidden-accessible">Username:</label>
            <input type="text" name="user" id="usrnm" placeholder="Username">
            <label for="pswd" class="ui-hidden-accessible">Password:</label>
            <input type="password" name="passw" id="pswd" placeholder="Password">
            <label for="log">Keep me logged in</label>
            <input type="checkbox" name="login" id="log" value="1" data-mini="true">
            <input type="submit" data-inline="true" value="Log in">
          </div>
        </form>
    </div> -->


                        </div>
                        <?php
                    }
                    ?>

                </div>
                <?php
                if ($numberOfPages > 1) {
                    echo '<ul class="pagination pagination-lg">';

                    if ($currentPage == 1) {
                        echo '<li class="disabled"><a href="#">&laquo;</a></li>';
                    } else {
                        echo '<li><a href="index.php?searchText=' . $nameAddCat . '&pgnum=' . ($currentPage - 1) . '">&laquo;</a></li>';
                    }

                    for ($i = 0; $i < 9 && $i < $numberOfPages; $i++) {
                        if ($pageArray[$i] == $currentPage) {
                            echo '<li class="active"><a href="index.php?searchText=' . $nameAddCat . '&pgnum=' . $pageArray[$i] . '">' . $pageArray[$i] . '</a></li>';
                        } else {
                            echo '<li><a href="index.php?searchText=' . $nameAddCat . '&pgnum=' . $pageArray[$i] . '">' . $pageArray[$i] . '</a></li>';
                        }
                    }

                    if ($currentPage == $numberOfPages) {
                        echo '<li class="disabled"><a href="#">&raquo;</a></li>';
                    } else {
                        echo '<li><a href="index.php?searchText=' . $nameAddCat . '&pgnum=' . ($currentPage + 1) . '">&raquo;</a></li>';
                    }

                    echo '</ul>';
                }
                ?>
                <!--                    <ul class="pagination pagination-lg">
                                            <li><a href="#">&laquo;</a></li>
                                            <li><a href="#">1</a></li>
                                            <li><a href="#">2</a></li>
                                            <li><a href="#">3</a></li>
                                            <li><a href="#">4</a></li>
                                            <li><a href="#">5</a></li>
                                            <li><a href="#">&raquo;</a></li>
                                        </ul>-->
            </div> <!-- End of Jumbotron -->

        </div>
        <div class ="col-xs-6">
            <div class ="jumbotron jumbotron-Event">
                <center> <h2> Upcoming Events </h2> </center> 
                <div class="panel panel-default">
                    <?php
                    foreach ($eventArray as $event) {
                        $image = base64_encode($event['event_photo']);
                        echo '<div class="panel panel-body">';
                        echo '<a href="app/views/home/restaurant.php?resid=' . $event['restaurant_id'] . '"> <img width="200" height="auto" src="data:image/jpeg;base64,' . $image . '"/></a>';
                        echo '<a href="app/views/home/restaurant.php?resid=' . $event['restaurant_id'] . '"> <h3>' . $event['name'] . '</h3></a>';
                        echo '<p>' . $event['date'] . '</p>';
                        echo '<p>' . $event['description'] . '</p>';
                        echo '<a href="#reservation page" class="btn btn-info" role="button"> Reservation </a>';
                        echo '</div>';
                    }
                    ?>
                    <!--                        <div class="panel panel-body">
                                                <h3> Event Name at Restaurant Name </h3>
                                                <p> Date: xx.xx.xx xx:xx-xx:xx </p>
                                                <p> Address <a href="#restaurant view page"> (View More) </a> </p>
                                                <a href="#reservation page" class="btn btn-info" role="button"> Reservation </a>
                                            </div>-->
                </div>
            </div> <!-- End of Jumbotron -->
        </div>
    </div> <!-- End of 2nd Section -->



</body>
</html>