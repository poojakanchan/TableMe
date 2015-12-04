<?php
    include 'header.php';
    require_once 'app/models/Restaurant_model.php';
    require_once 'app/models/Event_model.php';
    require_once 'app/controllers/Reservation_controller.php';
    

    define("N_PER_PAGE", 5); //number of restaurants to display per page
    $db;
    $restaurant_array;
    $foodCategoryArray;
    $restaurantListTitle;
    $nameAddCat = '%';
    $totalCount = 0; //total count of restaurants to display
    $currentPage = $numberOfPages = $startPage = 1; //page number for navigating search results
    $reservation;
    if (!isset($db)) {
        $db = new Restaurant_model();
    }

    if (empty($foodCategoryArray)) {
        $foodCategoryArray = $db->getFoodCategories();
    }
    if (!isset($reservation)) {
        $reservation = new Reservation_controller();
    }
    if ($_POST) {
        $reservation->add();
    }

    if ($_GET) {
        $nameAddCat = (empty($_GET['searchText']) ? '%' : htmlspecialchars($_GET['searchText']));
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
    } else {
        $totalCount = $db->getAllRestaurantsCount();
        $restaurantListTitle = "All Restaurants (" . $totalCount . " total)";
        if ($totalCount > N_PER_PAGE) {
            $restaurant_array = $db->getAllRestaurantsLimitOffset(N_PER_PAGE, 0);
        }
    }

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
<!DOCTYPE html>
    
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TableMe</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="css/bootstrap-responsive.min.css"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- this scripts and links are for datepicking -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        $(document).ready(function () {
            $('[id=datetimepicker1]').each(function () {
                $(this).datepicker();
            });
        });
    </script> <!-- datepicking end -->

    <!--
    Leave the CSS file in the .php file for now.
    After everything is done, we will merge every singe css into one big file. 
    -->

    <style type ="text/css">

        .navbar-default {
            margin-bottom: 0px;
        }

        .frontpage-banner {
            position: relative;
            width: 100%;
            height: 250px;
            background: url('banner2.jpg') center center;
            background-size: cover;
            margin-bottom: 0px;
            padding-top: 0px;
        }

        .searchbox {
            width: 50%;
            margin: auto;
        }

        .row {
            margin-left: 0px;
            margin-right: 0px;
        }

        .frontpage-list {
            padding-right: 5px;
            padding-left: 10px;
            padding-top: 10px;
        }

        .frontpage-event {
            padding-left: 5px;
            padding-top: 10px;
            padding-right: 10px;
        }

        .profile {
            width: 150px;
            height: 150px;
            padding-right: 0px;
            padding-left: 0px;    
        }

        .detail {
            width: 570px;
            height: 150px;
            padding-left: 15px;

        }

        .reservation {
            width: 100px;
            height: 30px;
            padding-left:0px;
            padding-right:0px;
            padding-top:60px;

        }

    </style>

</head>

<body>


    <div class="jumbotron frontpage-banner">
        <br><br>
        <center><h4> This Website is only for CSC648/848 Software Engineering Project </h4></center>
        <center><h4> Created by Team 11, if you want to learn more about us <a href="aboutus.php">(Click Here)</a></h4></center>
        <br>

        <form class="input-group searchbox" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get"> <!-- Class for Search box -->

            <input name="foodCategory" id="foodCategory" value="" hidden />
            <input type="text" class="form-control" name = "searchText" id="searchText" required placeholder="Search by Address, Name, Food Category of the Restaurants." value="<?php echo($nameAddCat === '%' ? "" : $nameAddCat); ?>"/>
            <span class="input-group-btn">
                <input class="btn btn-default" type="submit" value="Search" />
            </span>
        </form> <!-- End of the Search box -->
        <br>
        <center> <h4><a href="app/views/home/restaurant_registration.php">Join Us to Spread Your Restaurant!!</a></h4> </center>
    </div><!-- /.col-lg-6 -->

    <!-- 2nd Section of the Page (contains Restaurant List & Events Page) -->
    <div class = "row">
        <div class ="col-md-9 frontpage-list">
            <div class="panel panel-info">
                <div class="panel-heading panel-titleforlist">
                    <center> <h2> <?php echo $restaurantListTitle ?> </h2> </center>
                </div>
                <?php
                foreach ($restaurant_array as $restaurant) {
                    $image = base64_encode($restaurant['thumbnail']);
                    $image_src = "data:image/jpeg;base64," . $image;
                    $resId = $restaurant['restaurant_id'];
                    ?>

                    <div class="panel-body panel-restaurantlist"> 
                        <table class="table restaurantlisttable">
                            <tr>
                                <td>
                                    <div class="col-md-2 profile" style="width:20%">
                                        <a href="<?php echo 'app/views/home/restaurant.php?resid=' . $restaurant['restaurant_id'] ?>"> <img width="150" height="150" style="float: left;" src="<?php print $image_src; ?>" /> </a>    
                                    </div> <!-- End of Profile Picture -->
                                    <div class="col-md-8 detail" style="width:70%"> 
                                        <h3>  <a  href="<?php echo 'app/views/home/restaurant.php?resid=' . $restaurant['restaurant_id'] ?>" > <?php echo $restaurant['name'] ?> </a> </h3>
                                        <p> <?php echo $restaurant['address'] ?> </p>
                                        <p>  <?php echo $restaurant['description'] ?> </p>
                                    </div> <!-- End of Restaurant Detail -->
                                    <div class="col-md-2 reservation" style="width:10%">
                                        <button class="btn btn-info" data-toggle="modal" data-id="<?php echo $restaurant['restaurant_id'] ?>" data-target="#reservation-<?php echo $restaurant['restaurant_id'] ?>" >
                                            Reservation
                                        </button>
                                    </div> <!-- End of reservation button -->
                                </td>
                            </tr>
                            <div  class="modal fade" id="reservation-<?php echo $restaurant['restaurant_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <form name="myForm" action="#.php"
                                      onsubmit="return validateForm()" method="post">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <label class="modal-title" name ="myModalLabel" id="myModalLabel">Make reservation at <?php echo $restaurant['name'] ?></label>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col-md-12 well">
                                                    <div class="row">
                                                        <input type="hidden" name="restaurant" value="<?php echo $resId ?> ">
                                                        <!-- for debug purposes, displays restaurant ID -->
                                                        <?php //echo $resId ?>
                                                        <div class="col-md-12">          
                                                            <label>Number of Guests</label>
                                                            <select class="selectpicker" data-width="auto" id="guests" name="guests" required>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="4">4</option>
                                                                <option value="6">6</option>
                                                            </select>

                                                            <br>
                                                            <br>

                                                            <!-- This is for the datapicking method -->
                                                            <div class="input-append date" id="datetimepicker1">
                                                                <label>Enter Date</label>
                                                                <input  data-format="dd/MM/yyyy hh:mm:ss" type="text" name="date" id="date"></input>
                                                                <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span> 
                                                                <!-- <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span> -->
                                                            </div>
                                                            

                                                            <label>Enter Time</label>
                                                            <select class="selectpicker" data-width="auto" id="hours" name="hours" required>
                                                                <!-- <option value="" disabled selected>Hours</option> -->
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                            
                                                            <select class="selectpicker" data-width="auto" id="minutes" name="minutes" required>
                                                                    <!--<option value="" disabled selected>Minutes</option> -->
                                                                    <option value=":00">:00</option>
                                                                    <option value=":30">:30</option>
                                                             </select>
                                                            
                                                            <select class="selectpicker" data-width="auto" id="ampm" name="ampm" required>
                                                                    <option value="" disabled selected>AM/PM</option>
                                                                    <option value="am">am</option>
                                                                    <option value="pm">pm</option>
                                                            </select>

                                                            <br>
                                                            <br>

                                                            <div class="row">


                                                                <div class="col-md-6 form-group">
                                                                    <label>First Name</label>
                                                                    <input type="text" name="reservationFirstName" placeholder="Please enter your first name..." class="form-control" required>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label>Last Name</label>
                                                                    <input type="text" name="reservationLastName" placeholder="Please enter your last name..." class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 form-group">
                                                                    <label>Email</label>
                                                                    <input type="email" name="reservationEmail" placeholder="Please enter your email address..." class="form-control" required>
                                                                </div>
                                                                <div class="col-md-6 form-group">
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
                        </table>
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
        </div> <!-- end of "frontpage-list" -->
        
        <div class ="col-md-3 frontpage-event">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <center> <h2> Upcoming Events </h2> </center>
                </div> <!-- End of panel-heading -->
                <div class="panel-body">
                    <table class="table eventtable">
                        <?php
                            foreach ($eventArray as $event) {
                                $image = base64_encode($event['event_photo']);
                                echo '<tr>';
                                echo '<td>';
                                //echo '<div class="panel panel-body">';
                                echo '<a href="app/views/home/restaurant.php?resid=' . $event['restaurant_id'] . '"> <img width="200" height="auto" src="data:image/jpeg;base64,' . $image . '"/></a>';
                                echo '<a href="app/views/home/restaurant.php?resid=' . $event['restaurant_id'] . '"> <h3>' . $event['name'] . '</h3></a>';
                                echo '<p>' . $event['date'] . '</p>';
                                echo '<p>' . $event['description'] . '</p>';
                        ?>
                        <button class="btn btn-info" data-toggle="modal" data-id="<?php echo $event['restaurant_id'] ?>" data-target="#reservation-<?php echo $event['restaurant_id'] ?>" >
                            Reservation
                        </button>
                        <?php
                            //echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                            }
                        ?>
                    </table>
                </div> <!-- End of "panel-body" -->
            </div> <!-- End of panel-info -->
        </div> <!-- End of "frontpage-event" -->
    </div> <!-- End of 2nd Section Row-->
</body>
</html>