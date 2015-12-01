<?php
require_once 'header.php';
require_once __DIR__ . '/../../models/Restaurant_model.php';
require_once __DIR__ . '/../../models/OperationHours_model.php';
require_once __DIR__ . '/../../models/Event_model.php';
require_once __DIR__ . '/../../controllers/Reservation_controller.php';

$reservation;
if(!isset($reservation))
{
      $reservation = new Reservation_controller();
}
if($_POST)
{
      $reservation->add();
}
$restaurantDb = new Restaurant_model();
$resId = (array_key_exists('resid', $_GET) ? htmlspecialchars($_GET['resid']) : 0);
$restaurant = $restaurantDb->findRestaurantById($resId);
if (empty($restaurant)) {
    echo '<h1>Restaurant with $resId=' . $resId . ' does not exist </h1>';
    return;
}

$resName = $restaurant['name'];
$foodCategory = $restaurant['food_category_name'];
$description = $restaurant['description'];
$menu = base64_encode($restaurant['menu']);

//        var_dump($restaurant);
//        echo '<br><br>';
//        var_dump($menu);
//        exit();

$address = $restaurant['address'];
$phone = $restaurant['phone_no'];
//        $imgArray = $db->getRestaurantImages($resId);

$event_model = new Event_model();
$events = $event_model->getEventsByRestaurantId($resId);;

$operating_hours_model = new OperationHours_model();
$oprHours = $operating_hours_model->getOperatingHoursByRestaurantId($resId);

$time_message = null;
$from = NULL;
$to = null;
if (!empty($oprHours)) {
    $oprHours = $oprHours[0];

    date_default_timezone_set("America/Los_Angeles");
    $today = getdate();

    switch ($today["weekday"]) {
        case "Monday":
            $from = $oprHours["monday_from"];
            $to = $oprHours["monday_to"];
            break;
        case "Tuesday":
            $from = $oprHours["tuesday_from"];
            $to = $oprHours["tuesday_to"];
            break;
        case "Wednesday":
            $from = $oprHours["wednesday_from"];
            $to = $oprHours["wednesday_to"];
            break;
        case "Thursday":
            $from = $oprHours ["thursday_from"];
            $to = $oprHours["thursday_to"];
            break;
        case "Friday":
            $from = $oprHours["friday_from"];
            $to = $oprHours["friday_to"];
            break;
        case "Saturday":
            $from = $oprHours["saturday_from"];
            $to = $oprHours["saturday_to"];
            break;
        case "Sunday":
            $from = $oprHours["sunday_from"];
            $to = $oprHours["sunday_to"];
            break;
    }
    //  print_r($today);
    $totime = strtotime($to, time());
    $fromtime = strtotime($from, time());

    if (time() >= $fromtime && time() < $totime) {
        $diff = abs(($totime - time()) / 60);
        if ($diff <= 60) {
            $time_message = "Closing soon.";
        } else {
            $time_message = "Open Now.";
        }
    } else {
        $time_message = "Closed Now.";
    }
}

$cnt = $restaurantDb->getRestaurantImageCount($resId);
$n = intval($cnt[0]) >= 5 ? 5 : intval($cnt[0]); //total number of images for the restaurant in multimedia table

$reviews = $restaurantDb->getRestaurantReviews($resId);
$ratings = array(1=>0, 2=>0, 3=>0, 4=>0, 5=>0);
foreach ($reviews as $review) {
    if ($review['rating'] != null) {
        $ratings[$review['rating']]++;
    }
}
$avgRating = $ratingCount = 0;
for ($i=1; $i<=5; $i++) {
    $avgRating += $i * $ratings[$i];
    $ratingCount += $ratings[$i];
}
if ($ratingCount > 0) {
    $avgRating /= $ratingCount;
}
if ($avgRating >= 1) {
   $restaurantDb->setAverageRating($resId, $avgRating); 
}

?>
<html lang="en">
    <head>
        <title>TableMe</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>

        <!-- Will merge the style and script code into CSS and JS file after all is done. -->
        <style>
            .event-list {
                list-style: none;
                margin: 0px;
                padding: 0px;
            }
            .event-list > li {
                background-color: rgb(255, 255, 255);
                box-shadow: 0px 0px 5px rgb(51, 51, 51);
                box-shadow: 0px 0px 5px rgba(51, 51, 51, 0.7);
                padding: 0px;
                margin: 0px 0px 20px;
            }
            .event-list > li > time {
                display: inline-block;
                width: 100%;
                color: rgb(255, 255, 255);
                background-color: rgb(197, 44, 102);
                padding: 5px;
                text-align: center;
                text-transform: uppercase;
            }
            .event-list > li:nth-child(even) > time {
                background-color: rgb(165, 82, 167);
            }
            .event-list > li > time > span {
                display: none;
            }
            .event-list > li > time > .day {
                display: block;
                font-size: 45pt;
                font-weight: 900;
                line-height: 1;
            }
            .event-list > li time > .month {
                display: block;
                font-size: 24pt;
                font-weight: 900;
                line-height: 1;
            }
            .event-list > li > img {
                width: 100%;
            }
            .event-list > li > .info {
                padding-top: 5px;
                text-align: center;
                color:#000000;
            }
            .event-list > li > .info > .title {
                font-size: 13pt;
                font-weight: 700;
                margin: 0px;
            }
            .event-list > li > .info > .desc {
                font-size: 10pt;
                font-weight: 300;
                margin: 0px;
            }
            .event-list > li > .info > ul{
                display: table;
                list-style: none;
                margin: 10px 0px 0px;
                padding: 0px;
                width: 100%;
                text-align: center;
            }
            .event-list > li > .info > ul > li{
                display: table-cell;
                cursor: pointer;
                color: rgb(30, 30, 30);
                font-size: 11pt;
                font-weight: 300;
                padding: 3px 0px;
            }
            .event-list > li > .info > ul > li > a {
                display: block;
                width: 100%;
                color: rgb(30, 30, 30);
                text-decoration: none;
            }
            .event-list > li > .info > ul > li:hover{
                color: rgb(30, 30, 30);
                background-color: rgb(200, 200, 200);
            }

            @media (min-width: 768px) {
                .event-list > li {
                    position: relative;
                    display: block;
                    width: 100%;
                    height: 150px;
                    padding: 0px;
                }
                .event-list > li > time,
                .event-list > li > img  {
                    display: inline-block;
                }
                .event-list > li > time,
                .event-list > li > img {
                    width: 90px;
                    float: left;
                }
                .event-list > li > .info {
                    background-color: rgb(245, 245, 245);
                    overflow: hidden;
                }
                .event-list > li > time,
                .event-list > li > img {
                    width: 100px;
                    height: 150px;
                    padding: 0px;
                    margin: 0px;
                }
                .event-list > li > .info {
                    position: relative;
                    height: 150px;
                    text-align: left;
                }	
                .event-list > li > .info > .title, 
                .event-list > li > .info > .desc {
                    padding: 0px 10px;
                }
                .event-list > li > .info > ul {
                    position: absolute;
                    left: 0px;
                    bottom: 0px;
                }
            }
            
            /*Rating CSS*/
            .glyphicon { margin-right:5px;}
            .rating .glyphicon {font-size: 22px;}
            .rating-num { margin-top:0px;font-size: 54px; }
            .progress { margin-bottom: 5px;}
            .progress-bar { text-align: left; }
            .rating-desc .col-md-3 {padding-right: 0px;}
            .sr-only { margin-left: 5px;overflow: visible;clip: auto; }
            
            body{
                background: url(background.jpg) no-repeat center center fixed; 
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
                /*background-color:#2E52E0;*/
                /*background-image: url("background.jpg");*/
                color:#FFFFFF;
            }
            .containerMain{
                /*background-color:#2E52E0!important;*/
                background-color:rgba(0,0,0,0)!important;
            }
            .container-fluid{
                margin: 10px 10px 10px 10px;
                border-radius: 25px;
                /*border: 6px solid #2E52E0;*/
                /*background-color:#FFFFFF;*/
                /*background-color:rgba(0,0,0,0.5)*/
            }
            
            .modal{
                color:#000000;
            }
        </style>
        <script>
            $('.selectpicker').selectpicker();

            $('.selectpicker').selectpicker({
                style: 'btn-info',
                size: 4
            });
        </script>

    </head>
    <body>
        <div class="container-fluid containerMain">
            <div class="mainInfo col-md-8">
                <div class="restaurantprofile col-md-12">
                    <div class="restaurantpic col-md-6">
                        <div class="container-fluid">
                            <a href="#" data-toggle="modal" data-target="#modal-logo">
                                <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($restaurant['thumbnail']) ?>" class="img-rounded" height="300" width="300" />
                            </a>
                            <br><br>
                            <a href="#" data-toggle="modal" data-target="#modal-thumbnail1">
                                <img src="<?php $i=0; echo $i < $n ? "./getResImages.php?resId=" . $resId . "&offset=" . $i : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="70" width="70"/>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#modal-thumbnail2">
                                <img src="<?php echo $i < $n ? "./getResImages.php?resId=" . $resId . "&offset=" . $i : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="70" width="70"/>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#modal-thumbnail3">
                                <img src="<?php echo $i < $n ? "./getResImages.php?resId=" . $resId . "&offset=" . $i : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="70" width="70"/>
                            </a>
                            <a href="#" data-toggle="modal" data-target="#modal-thumbnail4">
                                <img src="<?php echo $i < $n ? "./getResImages.php?resId=" . $resId . "&offset=" . $i : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="70" width="70"/>
                            </a>
                            <br><br>
                            <div class="menubar">
                                <button type="button" class="btn btn-default btn-block" data-toggle="modal" data-target="#modal-menu">Menu</button>
                                <div class="modal fade" id="modal-menu" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Menu</h4>
                                            </div>
                                            <div class="modal-body">
                                                <img src="<?php echo "data:image/jpeg;base64," . $menu; ?>" class="img-responsive">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br><br><br>
                            <div class="modal fade" id="modal-logo" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Logo</h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?php echo 'data:image/jpeg;base64,' . base64_encode($restaurant['thumbnail']) ?>" class="img-rounded img-responsive"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal-thumbnail1" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Thumbnail1</h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?php $i=0; echo $i < $n ? "./getResImages.php?resId=" . $resId . "&offset=" . $i : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded img-responsive"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal-thumbnail2" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Thumbnail2</h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?php echo $i < $n ? "./getResImages.php?resId=" . $resId . "&offset=" . $i : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded img-responsive"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal-thumbnail3" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Thumbnail3</h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?php echo $i < $n ? "./getResImages.php?resId=" . $resId . "&offset=" . $i : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded img-responsive"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="modal-thumbnail4" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Thumbnail4</h4>
                                        </div>
                                        <div class="modal-body">
                                            <img src="<?php echo $i < $n ? "./getResImages.php?resId=" . $resId . "&offset=" . $i : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded img-responsive"/>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="restaurantname col-md-6">
                        <div class="container-fluid">
                            <h1><?php echo $resName; ?></h1>
                            <h2><?php echo $foodCategory; ?></h2>
                            <br>
                            <h4><?php echo $description; ?></h4>
                            <br>
                            <h4><?php echo $address; ?></h4>
                            <br>
                            <?php if ($phone != null) { ?>
                            <h4><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span><?php echo $phone; ?></h4>
                            <?php } ?>
                            <br>
                            <h4>                  
                            <?php if ($from != null && $to != null) {
                                echo "Today's Operating Hours: <br>" . date_format(new DateTime($from), "h:i A") . " - " . date_format(new DateTime($to), "h:i A");
                            }?>
                            </h4>

                            <h4>                  
                            <?php
                            if ($time_message != null) {
                                echo $time_message;
                            }?>
                            </h4>

                            <button class="btn btn-info" data-toggle="modal" data-id="<?php echo $resId   ?>" data-target="#reservation-<?php echo $resId   ?>" >
                                Make a Reservation
                            </button>
                            <br><br>
                        </div>
                        <div  class="modal fade" id="reservation-<?php echo $resId   ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <form name="myForm" action="#.php" onsubmit="return validateForm()" method="post">
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
                                                    <div class="col-sm-12">
                                                        <select class="selectpicker" data-width="auto" id="guests" name="guests" required>
                                                            <option value="" disabled selected>Number of Guests</option>
                                                            <option value="2">2</option>
                                                            <option value="4">4</option>
                                                            <option value="6">6</option>
                                                        </select>
                                                        <br><br>
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
                                                            <option value="9:30am">9:30 AM</option>
                                                            <option value="10am">10:00 AM</option>
                                                            <option value="10:30am">10:30 AM</option>
                                                            <option value ="11am">11:00 AM</option>
                                                            <option value="11:30am">11:30 AM</option>
                                                            <option value="12pm">12:00 PM</option>
                                                            <option value="12:30pm">12:30 PM</option>
                                                            <option value="1pm">1:00 PM</option>
                                                            <option value="1:30pm">1:30 PM</option>
                                                            <option value="2pm">2:00 PM</option>
                                                            <option value="2:30pm">2:30 PM</option>
                                                            <option value="3pm">3:00 PM</option>
                                                            <option value="3:30pm">3:30 PM</option>
                                                            <option value="4pm">4:00 PM</option>
                                                            <option value="4:30pm">4:30 PM</option>
                                                            <option value="5pm">5:00 PM</option>
                                                            <option value="5:30pm">5:30 PM</option>
                                                            <option value="6pm">6:00 PM</option>
                                                            <option value="6:30pm">6:30 PM</option>
                                                            <option value="7pm">7:00 PM</option>
                                                            <option value="7:30pm">7:30 PM</option>
                                                            <option value="8pm">8:00 PM</option>
                                                            <option value="8:30pm">8:30 PM</option>
                                                            <option value="9pm">9:00 PM</option>
                                                            <option value="9:30pm">9:30 PM</option>
                                                            <option value="10pm">10:00 PM</option>
                                                            <option value="10:30pm">10:30 PM</option>
                                                            <option value="11pm">11:00 PM</option>
                                                            <option value="11:30pm">11:30 PM</option>
                                                            <option value="12am">12:00 AM</option>
                                                            <option value="12:30am">12:30 AM</option>
                                                            <option value="1am">1:00 AM</option>
                                                            <option value="1:30am">1:30 AM</option>
                                                            <option value="2am">2:00 AM</option>
                                                            <option value="2:30am">2:30 AM</option>
                                                            <option value="3am">3:00 AM</option>
                                                            <option value="3:30am">3:30 AM</option>
                                                            <option value="4am">4:00 AM</option>
                                                            <option value="4:30am">4:30 AM</option>
                                                            <option value="5am">5:00 AM</option>
                                                            <option value="5:30am">5:30 AM</option>
                                                            <option value="6am">6:00 AM</option>
                                                            <option value="6:30am">6:30 AM</option>
                                                            <option value="7am">7:00 AM</option>
                                                            <option value="7:30am">7:30 AM</option>
                                                        </select>
                                                        <br><br>
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
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="userreview col-md-6">
                        <div class="container-fluid">
                            <h3>Reviews</h3>
                            <?php
                            if(empty($reviews)) {
                                echo '<p>No reviews yet</p>';
                            }
                            else {
                                $altImage = "http://www.telikin.com/joomla/components/com_joomblog/images/user.png";
                                foreach ($reviews as $review) {
                                    echo '<div class="media">
                                            <a class="media-left">';
    //                                var_dump($review);
    //                                exit();
                                    echo '<img src="' . (empty($review['user_image']) ? $altImage : "data:image/jpeg;base64,".base64_encode($review['user_image'])) . '" alt="user" height="50" width="50">';
                                    echo '</a>
                                            <div class="media-body">';
                                    echo '<h4 class="media-heading">' . $review['name'] . '</h4>';
                                    echo '<p>' . $review['review_description'] . '</p>';
                                    echo '</div>
                                        </div>';
                                }
                            }
                            ?>
                            <br>
                        </div>
                    </div>
                    <div class="restaurantRating col-md-6">
                        <div class="container-fluid">
                            <h3>Ratings:</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="well-md">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-5 text-center">
                                                <h1 class="rating-num"><?php echo $avgRating>=1 ? round($avgRating, 1) : 'None'; ?></h1>
                                                <div class="rating">
                                                    <?php
                                                    $i;
                                                    for ($i=1; $i<=$avgRating; $i++) {
                                                        echo '<span class="glyphicon glyphicon-star"></span>';
                                                    }
                                                    for (; $i<=5; $i++) {
                                                        echo '<span class="glyphicon glyphicon-star-empty"></span>';
                                                    }
                                                    ?>
<!--                                                    <span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                    </span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star">
                                                    </span><span class="glyphicon glyphicon-star-empty"></span>-->
                                                </div>
                                                <div><span class="glyphicon glyphicon-user"></span><?php echo $ratingCount.' total' ?></div>
                                            </div>
                                            <div class="col-xs-12 col-md-7">
                                                <div class="row rating-desc">
                                                    <div class="col-xs-3 col-md-3 text-right">
                                                        <span class="glyphicon glyphicon-star"></span>5
                                                    </div>
                                                    <div class="col-xs-8 col-md-9">
                                                        <div class="progress progress-striped">
                                                            <div class="progress-bar progress-bar-success" role="progressbar"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 
                                                                    <?php 
                                                                    $formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT); 
                                                                    $percent=$formatter->format($ratings[5]/$ratingCount); 
                                                                    echo $percent; ?>
                                                                    ">
                                                                <span class="sr-only"><?php echo $percent; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end 5 -->
                                                    <div class="col-xs-3 col-md-3 text-right">
                                                        <span class="glyphicon glyphicon-star"></span>4
                                                    </div>
                                                    <div class="col-xs-8 col-md-9">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success" role="progressbar"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 
                                                                <?php 
                                                                    $formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT); 
                                                                    $percent=$formatter->format($ratings[4]/$ratingCount); 
                                                                    echo $percent; ?>
                                                                ">
                                                                <span class="sr-only"><?php echo $percent; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end 4 -->
                                                    <div class="col-xs-3 col-md-3 text-right">
                                                        <span class="glyphicon glyphicon-star"></span>3
                                                    </div>
                                                    <div class="col-xs-8 col-md-9">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-info" role="progressbar"
                                                                aria-valuemin="0" aria-valuemax="100" style="width:
                                                                <?php 
                                                                    $formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT); 
                                                                    $percent=$formatter->format($ratings[3]/$ratingCount); 
                                                                    echo $percent; ?>
                                                                ">
                                                                <span class="sr-only"><?php echo $percent; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end 3 -->
                                                    <div class="col-xs-3 col-md-3 text-right">
                                                        <span class="glyphicon glyphicon-star"></span>2
                                                    </div>
                                                    <div class="col-xs-8 col-md-9">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-warning" role="progressbar"
                                                                aria-valuemin="0" aria-valuemax="100" style="width:
                                                                <?php 
                                                                    $formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT); 
                                                                    $percent=$formatter->format($ratings[2]/$ratingCount); 
                                                                    echo $percent; ?>
                                                                ">
                                                                <span class="sr-only"><?php echo $percent; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end 2 -->
                                                    <div class="col-xs-3 col-md-3 text-right">
                                                        <span class="glyphicon glyphicon-star"></span>1
                                                    </div>
                                                    <div class="col-xs-8 col-md-9">
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-danger" role="progressbar"
                                                                aria-valuemin="0" aria-valuemax="100" style="width: 
                                                                <?php 
                                                                    $formatter = new NumberFormatter('en_US', NumberFormatter::PERCENT); 
                                                                    $percent=$formatter->format($ratings[1]/$ratingCount); 
                                                                    echo $percent; ?>
                                                                ">
                                                                <span class="sr-only"><?php echo $percent; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end 1 -->
                                                </div>
                                                <!-- end row -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="specialEvent col-md-4">
                <div class="col-md-12">
                    <div class="container-fluid">
                        <?php echo empty($events) ? '' : '<h3>Special events:</h3>'; ?>
                        <?php
                        foreach ($events as $event) {
                            echo '<ul class="event-list">';
                            echo '<li>';
                            echo '<time datetime="' . $event['date'] . '">';
                            $dateNum = explode("-", $event['date']);
                            echo '<span class="day">'. $dateNum[2] . '</span>';
                            $dt = DateTime::createFromFormat('!m', $dateNum[1]);
                            echo '<span class="month">' . $dt->format('M') . '</span>';
                            echo '<span class="year">'. $dateNum[0] . '</span>';
                            echo '<span class="time">'. $event['time'] . '</span></time>';
                            echo '<img src="data:image/jpeg;base64,' . base64_encode($event['event_photo']) . '"/>';
                            echo '<div class="info">
                                    <h2 class="title">' . $event['title'] . '</h2>
                                    <p class="desc">' . $event['description'] . '</p>
                                  </div>
                            </li>
                        </ul>';
                        }
                        ?>
                    </div>
                </div>
                <div class="restaurantmap col-md-12">
                    <div class="container-fluid">
                        <h3>Directions:</h3>
                        <div class="row">
                            <iframe
                                width=100%
                                height="300"
                                frameborder="0"
                                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBeVgOJNkJiPXUmp895wxNmaCP2_oP9ERg&q=<?php echo $address ?>" >
                            </iframe>
                        </div> 
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="container-fluid">
                        <h3>Operating Hours</h3>
                        <?php if ($oprHours != null) { ?>
                        <div class="col-md-3"> <h4>Mon: </h4> </div>
                        <div class="col-md-9">
                            <!--<h4> <?php //echo $oprHours["monday_from"] . " - " . $oprHours["monday_to"]; ?> </h4>-->
                            <h4> <?php 
                                    $opHrString = date_format(new DateTime($oprHours["monday_from"]), "h:i A") . " - " . date_format(new DateTime($oprHours["monday_to"]), "h:i A");
                                    echo $opHrString=='12:00 AM - 12:00 AM' ? 'CLOSED' : $opHrString;
                                 ?>
                            </h4>
                        </div>
                        <div class="col-md-3"> <h4>Tue: </h4></div>
                        <div class="col-md-9">
                            <h4> <?php 
                                    $opHrString = date_format(new DateTime($oprHours["tuesday_from"]), "h:i A") . " - " . date_format(new DateTime($oprHours["tuesday_to"]), "h:i A");
                                    echo $opHrString=='12:00 AM - 12:00 AM' ? 'CLOSED' : $opHrString;
                                 ?>
                            </h4>
                        </div>  
                        <div class="col-md-3"> <h4>Wed: </h4> </div>
                        <div class="col-md-9"> 
                            <h4> <?php 
                                    $opHrString = date_format(new DateTime($oprHours["wednesday_from"]), "h:i A") . " - " . date_format(new DateTime($oprHours["wednesday_to"]), "h:i A");
                                    echo $opHrString=='12:00 AM - 12:00 AM' ? 'CLOSED' : $opHrString;
                                 ?>
                            </h4>
                        </div>
                        <div class="col-md-3"> <h4>Thur: </h4> </div>
                        <div class="col-md-9">
                            <h4> <?php 
                                    $opHrString = date_format(new DateTime($oprHours["thursday_from"]), "h:i A") . " - " . date_format(new DateTime($oprHours["thursday_to"]), "h:i A");
                                    echo $opHrString=='12:00 AM - 12:00 AM' ? 'CLOSED' : $opHrString;
                                 ?>
                            </h4>
                        </div>
                        <div class="col-md-3"><h4> Fri: </h4> </div>
                        <div class="col-md-9">
                            <h4> <?php 
                                    $opHrString = date_format(new DateTime($oprHours["friday_from"]), "h:i A") . " - " . date_format(new DateTime($oprHours["friday_to"]), "h:i A");
                                    echo $opHrString=='12:00 AM - 12:00 AM' ? 'CLOSED' : $opHrString;
                                 ?>
                            </h4>
                        </div>
                        <div class="col-md-3"><h4> Sat: </h4> </div>
                        <div class="col-md-9">
                            <h4> <?php 
                                    $opHrString = date_format(new DateTime($oprHours["saturday_from"]), "h:i A") . " - " . date_format(new DateTime($oprHours["saturday_to"]), "h:i A");
                                    echo $opHrString=='12:00 AM - 12:00 AM' ? 'CLOSED' : $opHrString;
                                 ?>
                            </h4>
                        </div>
                        <div class="col-md-3"> <h4> Sun: </h4> </div>
                        <div class="col-md-9">
                            <h4> <?php 
                                    $opHrString = date_format(new DateTime($oprHours["sunday_from"]), "h:i A") . " - " . date_format(new DateTime($oprHours["sunday_to"]), "h:i A");
                                    echo $opHrString=='12:00 AM - 12:00 AM' ? 'CLOSED' : $opHrString;
                                 ?>
                            </h4>
                        </div>
                        <?php } else { ?>
                        <h4> Sorry, Operation Hours are not available.</h4>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class = "navbar navbar-default navbar-bottom">
            <div class = "container">
                <p class="navbar-text navbar-left">This website belongs to SFSU Course CSC648/CSC848 Fall 15 Group 11</p>
            </div>
        </div>
        -->

    </body>
</html>