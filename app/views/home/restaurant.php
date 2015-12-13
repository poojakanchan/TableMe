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
//sanitize $_POST array
$_POST = filter_input_array(INPUT_POST);

if($_POST) {
    $reservationArray = $reservation->add();
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

$address = $restaurant['address'];
$phone = $restaurant['phone_no'];
//        $imgArray = $db->getRestaurantImages($resId);

$eventModel = new Event_model();
$events = $eventModel->getEventsByRestaurantId($resId);;

$operatingHoursModel = new OperationHours_model();
$oprHours = $operatingHoursModel->getOperatingHoursByRestaurantId($resId);

$timeMessage = null;
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
    if($fromtime > $totime){
        $totime = strtotime($to .' +1 day',time());
    }
    if ((time() >= $fromtime && time() < $totime)) {
        
        $diff = abs(($totime - time()) / 60);
        if ($diff <= 60) {
            $timeMessage = "Closing soon.";
        } else {
            $timeMessage = "Open Now.";
        }
    } else {
        $timeMessage = "Closed Now.";
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

$userId = "NULL";
if (isset($_SESSION['user_id'])) {
    if($_SESSION['role'] == 'user') {
        $userId = $_SESSION['user_id'];
    }
        
}

$showResDialog = 'none';
if (isset($reservationArray["reservationOutcome"])) {
    $showResDialog = $reservationArray["reservationOutcome"];
}
?>
<html lang="en">
    <head>
        <title>TableMe</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
        
    <!-- this scripts and links are for datepicking -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<!--    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/css/bootstrap-datepicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.0/js/bootstrap-datepicker.min.js"></script>

    
      
    
    <script>
        $(document).ready(function () {
            $('[id=datetimepicker1]').each(function () {
                $(this).datepicker();
                $(this).on('changeDate', function(){
                $(this).datepicker('hide');
                });
            });
            
            var displayResDialog = '<?php echo $showResDialog; ?>';
            switch (displayResDialog) {                    
                case 'none':
                    $("div#reservation-success").modal({show: false});
                    break;
                case 'success':
                case 'full':
                case 'closed':
                    $("div#reservation-success").modal({show: true});
                    break;
                }
                
                $("#firstname").focusout(function () {
                    var inputFirstName = $("#firstname").val();
                    if (!inputFirstName) {
                        $("#firstname").css("border", "#FF0000 1px solid");
                        $("#firstNameLabel").replaceWith ("<label id='firstNameLabel'>First Name *<i style='color:red'>First name cannot be empty</i></label>");
                        return;
                    }
                    $("#firstname").css("border", "");
                    $("#firstNameLabel").replaceWith('<label id="firstNameLabel">First Name *</label>');
                });
                
                $("#lastname").focusout(function () {
                    var inputLastName = $("#lastname").val();
                    if (!inputLastName) {
                        $("#lastname").css("border", "#FF0000 1px solid");
                        $("#lastNameLabel").replaceWith ("<label id='lastNameLabel'>Last Name *<i style='color:red'>Last name cannot be empty</i></label>");
                        return;
                    }
                    $("#lastname").css("border", "");
                    $("#lastNameLabel").replaceWith('<label id="lastNameLabel">Last Name *</label>');
                });
                
                $("#email").focusout(function () {
                    var inputEmail = $("#email").val();
                    if (!inputEmail) {
                        $("#email").css("border", "#FF0000 1px solid");
                        $("#emailLabel").replaceWith ("<label id='emailLabel'>Email *<i style='color:red'>Email cannot be empty</i></label>");
                        return;
                    }
                    $("#email").css("border", "");
                    $("#emailLabel").replaceWith('<label id="emailLabel">Email *</label>');
                });
                
                $("#phone").focusout(function () {
                    var inputPhone = $("#phone").val();
                    if (!inputPhone) {
                        $("#phone").css("border", "#FF0000 1px solid");
                        $("#phoneLabel").replaceWith ("<label id='phoneLabel'>Phone Number *<i style='color:red'>Phone cannot be empty</i></label>");
                        return;
                    }
                    $("#phone").css("border", "");
                    $("#phoneLabel").replaceWith('<label id="phoneLabel">Phone Number *</label>');
                });
        });
    </script> <!-- datepicking end -->

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

            .containerMain{
                /*background-color:#2E52E0!important;*/
                background-color:rgba(0,0,0,0)!important;
                border: none!important;
            }
            .container-fluid{
                margin: 10px 10px 10px 10px;
                border-radius: 25px;
                border: 1px solid #e3e3e3;
                background-color:#f5f5f5;
                /*background-color:rgba(0,0,0,0.5)*/
            }
            .pager{
                margin-bottom: -5;
                margin-top: -5;
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
        <ul class = "pager">
            <li class = "previous"><a href="#" class="pager" onClick="javascript:history.back()">&larr; Back to search result</a></li>
        </ul>
        <!--<a href="#" onClick="javascript:history.back(1)">Back to search result</a>-->
        <div class="container-fluid containerMain">
            <div class="mainInfo col-md-8">
                <div class="restaurantprofile col-md-12">
                    <div class="restaurantpic col-md-6">
                        <div class="container-fluid">
                            <br>
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
                            <br>
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
                                echo "Today's Operating Hours: <br>"?>
                                <p style="color: #009900"><?php echo date_format(new DateTime($from), "h:i A") . " - " . date_format(new DateTime($to), "h:i A"); ?></p><?php
//                                echo "Today's Operating Hours: <br>" . date_format(new DateTime($from), "h:i A") . " - " . date_format(new DateTime($to), "h:i A");
                            }?>
                            </h4>

                            <h4>                  
                            <?php
                            if ($timeMessage == "Closing soon.") {?>
                                <p style="color: #FF9900"><?php echo $timeMessage;?></p><?php
                            }
                            if ($timeMessage == "Open Now.") {?>
                                <p style="color: #009900"><?php echo $timeMessage;?></p><?php
                            }
                            if ($timeMessage == "Closed Now.") {?>
                                <p style="color: #ff0000"><?php echo $timeMessage;?></p><?php
                            }
                            ?>
                            </h4>

                            <button class="btn btn-primary" data-toggle="modal" data-id="<?php echo $resId   ?>" data-target="#reservation-<?php echo $resId   ?>" >
                                Make a Reservation
                            </button>
                            <br><br>
                        </div>
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
                                                        <input type="hidden" name="restaurant" value="<?php echo $resId ?>">
                                                        <input type="hidden" name="restaurant-name" value="<?php echo $restaurant['name']; ?>">
                                                        <input type="hidden" name="userid" value="<?php echo $userId ?>">
                                                        <!-- for debug purposes, displays restaurant ID -->
                                                        <?php //echo $resId ?>
                                                        <div class="col-md-12">
                                                            <p>* indicates required field.</p>
                                                             <div class="row">
                                                            <div class="col-md-6">
                                                            <label>Number of Guests*</label>
                                                                
                                                            <select class="selectpicker" data-width="auto" id="guests" name="guests" required>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                            </select>
                                                             </div>
                                                             </div>
                                                            <br>
                                                          
                                                           
                                                             <div class="row">
                                                            <div class="col-md-6">
                                                            <!-- This is for the datapicking method -->
                                                            <label>Enter Date*</label>
                                                            <div class="input-group date" id="datetimepicker1">
                                                                <input   data-width="auto"  data-format="dd/MM/yyyy hh:mm:ss" type="text" name="date" id="date" placeholder="Please select date" class="form-control"></input>
                                                              <!--  <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>  -->
                                                                <span class="input-group-addon" > <i class="glyphicon glyphicon-calendar" ></i></span> 
                                                            </div>
                                                            </div>
                                                             </div>
                                                             <br>
                                                              
                                                           
                                                            <label>Enter Time*</label>
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
                                                                    <label id="firstNameLabel">First Name *</label>
                                                                    <input type="text" name="reservationFirstName" id="firstname" placeholder="Please enter your first name..." class="form-control" required>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label id="lastNameLabel">Last Name *</label>
                                                                    <input type="text" name="reservationLastName" id="lastname" placeholder="Please enter your last name..." class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 form-group">
                                                                    <label id="emailLabel">Email *</label>
                                                                    <input type="email" name="reservationEmail" id="email" placeholder="Please enter your email address..." class="form-control" required>
                                                                </div>
                                                                <div class="col-md-6 form-group">
                                                                    <label id="phoneLabel">Phone Number *</label>
                                                                    <input type="text" name="reservationPhone" id="phone" placeholder="Please enter your phone number..." class="form-control" required>
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
        
        <div class="modal col-md-12" id="reservation-success" role="dialog">
            <div class="col-md-3"></div>
            <div class="modal-content col-md-6">
<!--                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <label class="modal-title" name ="myModalLabel" id="myModalLabel">Reservation Successful!</label>
                </div> -->
                <div class="modal-body">
                    <?php
                    $reservationArray['time'] = date("g:i a", strtotime($reservationArray['time']));
                    switch ($showResDialog) {
                        case 'success':
                            echo '<center><h1>Reservation Successful!</h1></center>
                                    <hr><br>';
                            echo '<p>Mr/Mrs. '. $reservationArray['user_name'] .'</p><br>';
                            echo '<p>This email is to confirm your reservation for '. $reservationArray['restaurant_name'] . ' Restaurant. The following are the details of your reservation.</p><br>';
                            echo '<p><b>Restaurant: </b><a href="app/views/home/restaurant.php?resid='. $reservationArray['restaurant_id'] . '">'. $reservationArray['restaurant_name'] . '</a></p>';
                            echo '<p><b>Date: </b>' . $reservationArray['date']. '</p>';
                            echo '<p><b>Time: </b>' . $reservationArray['time'] . '</p>';
                            echo '<p><b>Number of guest: </b>' . $reservationArray['no_of_people'] . '</p>';
                            echo '<p><b>Guest Name: </b>'. $reservationArray['user_name'] . '</p><br>';
                            echo '<p><b>Special Instructions: </b>'. $reservationArray['special_instruct'] . '</p><br>';
                            echo '<p>If you are a registered user, you can go to "My Profile" page to view or cancel your reservation</p><br>';
                            echo '<p>We look forward to see you!</p><br><br><hr>';
                            break;
                        case 'full':
                            echo '<center><h1>Reservation Unsuccessful</h1></center>
                                    <hr><br>';
                            echo '<p>The restaurant is full for the selected date and time: ' . $reservationArray['date']. '   ' . $reservationArray['time'] . '</p><br><br><hr>';
                            break;
                        case 'closed':
                            echo '<center><h1>Reservation Unsuccessful</h1></center>
                                    <hr><br>';
                            echo '<p>The restaurant is closed for the selected date and time: ' . $reservationArray['date']. '   ' . $reservationArray['time'] . '</p><br><br><hr>';
                            break;
                        
                    }
        
                    ?>
<!--                    <center><h1>Reservation Successful!</h1></center>
                    <hr><br>
                    <p>Mr/Mrs. Smith</p><br>
                    <p>This email is to confirm your reservation for Little Tokyo’s Restaurant. The following are the details of your reservation.</p><br>
                    <p><b>Restaurant:</b> Little Tokyo</p>
                    <a href="http://sfsuswe.com/~f15g11/app/views/home/restaurant.php?resid=12">http://sfsuswe.com/~f15g11/app/views/home/restaurant.php?resid=12</a>
                    <p><b>Date:</b> 2015/12/12</p>
                    <p><b>Time:</b> 08:00PM</p>
                    <p><b>Number of guest:</b> 2</p>
                    <p><b>Guest Name:</b> Josh Smith</p><br>
                    <p>To view or modify your reservation:</p><br>
                    <a href="http://sfsuswe.com/~f15g11/app/views/user/userpage.php">http://sfsuswe.com/~f15g11/app/views/user/userpage.php</a><br>
                    <p>We look forward to see you!</p><br><br><hr>
                    <center><h4>TableMe Team</h4></center>
                    <center><h4>http://sfsuswe.com/~f15g11/index.php</h4></center>-->
                    <center><h4>TableMe Team</h4></center>
                    <center><h4>http://sfsuswe.com/~f15g11/index.php</h4></center>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="submit" class="btn btn-primary" value="submit-reservation" name="submit-reservation" >OK</button>-->
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </body>
</html>