<?php
    require_once 'header.php';
    if(!isset($_SESSION['username'])) {
        header('location: ../home/login.php');
    }
    require_once "../../controllers/Host_controller.php";
   $host_controller = new Host_controller();
    $restuarant = $host_controller -> getRestaurant($_SESSION['username']);
    $resId = $restuarant['res_id'];
    $res_name = $restuarant['res_name'];
    $thumbnail = $restuarant['thumbnail'];
    date_default_timezone_set("America/Los_Angeles");
    $date = date('Y/m/d');
    
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
         if(isset($_POST['reservation_id'])){
         $reservation_id = $_POST['reservation_id'];
        // echo 'reservation id' . $reservation_id;
         $date = $host_controller ->getReservationDate($reservation_id);
        $host_controller->cancelReservation($resId,$reservation_id);
         }else if(isset($_POST['reservationFirstName'])) {
             $host_controller->makeReservation();
         }
    }
   
?>
<html lang="en">
<head>
	<title>TableMe</title>
	
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        
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
        
        <!-- Will merge the style and script code into CSS and JS file after all is done. -->
        <style>
            @import url(http://fonts.googleapis.com/css?family=Roboto:400,300);
            @import url(http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css);

            .fa.pull-right {
                margin-left: 0.1em;   
            }

            .date-picker,
            .date-container {
                position: relative;
                display: inline-block;
                width: 100%;
                color: rgb(75, 77, 78);
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                
                color:#FFFFFF;
            }
            .date-container {
                padding: 0px 40px;   
            }
            .date-picker h2, .date-picker h4 {
                margin: 0px;
                padding: 0px;
                font-family: 'Roboto', sans-serif;
                font-weight: 200;
            }
            .date-container .date {
                text-align: center;
            }
            .date-picker span.fa {
                position: absolute;
                font-size: 4em;
                font-weight: 100;
                padding: 8px 0px 7px;
                cursor: pointer;
                top: 0px;
            }
            .date-picker span.fa[data-type="subtract"] {
                left: 0px;
            }
            .date-picker span.fa[data-type="add"] {
                right: 0px;
            }
            .date-picker span[data-toggle="calendar"] {
                display: block;
                position: absolute;
                top: -7px;
                right: 45px;
                font-size: 1em !important;
                cursor: pointer;
            }

            .date-picker .input-datepicker {
                display: none;
                position: absolute;
                top: 50%;
                margin-top: -17px;
                width:100%;
            }
            .date-picker .input-datepicker.show-input {
                display: table;
            }

            @media (min-width: 768px) and (max-width: 1010px) {
                .date-picker h2{
                    font-size: 1.5em; 
                    font-weight: 400;  
                }    
                .date-picker h4 {
                    font-size: 1.1em;
                }  
                .date-picker span.fa {
                    font-size: 3em;
                } 
            }
            
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
            //Date picker function
            $(document).ready(function() {
                $(window).on('focus', function(event) {
                    $('.show-focus-status > .alert-danger').addClass('hidden');
                    $('.show-focus-status > .alert-success').removeClass('hidden');
                }).on('blur', function(event) {
                    $('.show-focus-status > .alert-success').addClass('hidden');
                    $('.show-focus-status > .alert-danger').removeClass('hidden');
                });    

                $('.date-picker').each(function () {
                    var $datepicker = $(this), cur_date = ($datepicker.data('date') ? moment($datepicker.data('date'), "YYYY/MM/DD") : moment()),
                        format = {
                            "weekday" : ($datepicker.find('.weekday').data('format') ? $datepicker.find('.weekday').data('format') : "dddd"),                
                            "date" : ($datepicker.find('.date').data('format') ? $datepicker.find('.date').data('format') : "MMMM Do"),
                            "year" : ($datepicker.find('.year').data('year') ? $datepicker.find('.weekday').data('format') : "YYYY")
                        };

                    function updateDisplay(cur_date) {    
                        $datepicker.find('.date-container > .weekday').text(cur_date.format(format.weekday));
                        $datepicker.find('.date-container > .date').text(cur_date.format(format.date));
                        $datepicker.find('.date-container > .year').text(cur_date.format(format.year));
                        $datepicker.data('date', cur_date.format('YYYY/MM/DD'));
                        $datepicker.find('.input-datepicker').removeClass('show-input');
                     
                        $.ajax({
                            url: "../../controllers/Host_controller.php",
                            type:"POST",
                            async:false,
                            data: {date: JSON.stringify(cur_date.format('YYYY/MM/DD')),resId:JSON.stringify(<?php echo $resId ?>)},
                            dataType:"html",
                            success: function(response) {
                                $('[id=reservation_info]').each(function(){
                                $(this).hide();
                             //   alert('hide');
                            });
                               // console.log(response);
                              //  alert(response);
                               var reservations = $.parseJSON(response);
                                
                                for (var i = 0; i < reservations.length; i++) {
                                     var clone = $('#reservation_info').first().clone();
                                    
                                    var first = $('#reservation_info').first();
                                    
                                            first.after(clone.show());
                                            var time = reservations[i]['time'].toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                                             if (time.length > 1) { // If time format correct
                                             time = time.slice (1);  // Remove full string match value
                                              time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
                                                 time[0] = +time[0] % 12 || 12; // Adjust hours
                                                
                                                 time[3] = "";
                                             }
                                        var formattedTime= time.join (''); // return adjusted time or original string
                                      
                                     clone.find("#time").text(formattedTime);
                                      clone.find("#guest_name").text(reservations[i]['user_name']);
                                      clone.find("#no_of_people").text('Number of People: ' + reservations[i]['no_of_people']);
                                      
                                        if(reservations[i]['special_instruct'] === "" || reservations[i]['special_instruct'].trim().length === 0){
                                        clone.find("#accomodations").text('Special Instructions: None');
                                        } else {
                                        clone.find("#accomodations").text('Special Instructions: ' + reservations[i]['special_instruct']);
                                        
                                        }
                                        clone.find("#reservation_id").attr('value',reservations[i]['reservation_id']);
                                        clone.find("#user_id").attr('value',reservations[i]['user_id']);
                                    //   alert('marked ' + reservations[i]['mark_arrived']);
                                        if(reservations[i]['mark_arrived'] == 1){
                                             //alert('if');
                                         clone.find("#cancel_reservation").addClass('disabled');
                                       //  alert(clone.find("input:checkbox").is(':checked'));
                                         clone.find("input:checkbox").prop('checked',true);
                                         clone.find("#mark_arrived")
                                         .removeClass('btn-default')
                                            .addClass('disabled');
                                         } else {
                                             
                                        /* clone.find("#cancel_reservation").removeClass('disabled');
                                           clone.find("#mark_arrived")
                                         .removeClass('disabled')
                                            .addClass('btn-default');
                                          clone.find("input:checkbox").prop('checked', false);*/
                                         }
                                    //    alert(clone.find("#user_id").val());
                                    }
                                    initCheckbox();
                                },
                            error: function(jqXHR, textStatus, errorThrown){
                                         alert(textStatus, errorThrown);
                             }
                        });
                        
                     }

                    updateDisplay(cur_date);
                    
                    $datepicker.on('click', '[data-toggle="calendar"]', function(event) {
                        event.preventDefault();
                        $datepicker.find('.input-datepicker').toggleClass('show-input');
                    });

                    $datepicker.on('click', '.input-datepicker > .input-group-btn > button', function(event) {
                        event.preventDefault();
                        var $input = $(this).closest('.input-datepicker').find('input'),
                            date_format = ($input.data('format') ? $input.data('format') : "YYYY/MM/DD");
                        if (moment($input.val(), date_format).isValid()) {
                           updateDisplay(moment($input.val(), date_format));
                        }else{
                            alert('Invalid Date');
                        }
                    });

                    $datepicker.on('click', '[data-toggle="datepicker"]', function(event) {
                        event.preventDefault();

                        var cur_date = moment($(this).closest('.date-picker').data('date'), "YYYY/MM/DD"),
                            date_type = ($datepicker.data('type') ? $datepicker.data('type') : "days"),
                            type = ($(this).data('type') ? $(this).data('type') : "add"),
                            amt = ($(this).data('amt') ? $(this).data('amt') : 1);

                        if (type == "add") {
                            cur_date = cur_date.add(date_type, amt);
                        }else if (type == "subtract") {
                            cur_date = cur_date.subtract(date_type, amt);
                        }

                        updateDisplay(cur_date);
                    });
        
                    if ($datepicker.data('keyboard') == true) {
                        $(window).on('keydown', function(event) {
                            if (event.which == 37) {
                                $datepicker.find('span:eq(0)').trigger('click');  
                            }else if (event.which == 39) {
                                $datepicker.find('span:eq(1)').trigger('click'); 
                            }
                        });
                    }
                });
        });    
                //Check box function
           // $(function () {
          function initCheckbox(){
                $('.button-checkbox').each(function () {

                    // Settings
                    var $widget = $(this),
                        $button = $widget.find('button'),
                        $checkbox = $widget.find('input:checkbox'),
                        color = $button.data('color'),
                        settings = {
                            on: {
                                icon: 'glyphicon glyphicon-check'
                            },
                            off: {
                                icon: 'glyphicon glyphicon-unchecked'
                            }
                        };

                    // Event Handlers
                    $button.on('click', function () {
                        $checkbox.prop('checked', !$checkbox.is(':checked'));
                        $checkbox.triggerHandler('change');
                        updateDisplay();
                    });
                    $checkbox.on('change', function () {
                    //    updateDisplay();
                    });

                    // Actions
                    function updateDisplay() {
                        var isChecked = $checkbox.is(':checked');
                        // Set the button's state
                        $button.data('state', (isChecked) ? "on" : "off");
                        // Set the button's icon
                        $button.find('.state-icon')
                            .removeClass()
                            .addClass('state-icon ' + settings[$button.data('state')].icon);
                        // Update the button's color
                        if (isChecked) {
                         //   alert('checked');
                                 $button
                                    .removeClass('btn-default')
                                    .addClass('btn-' + color + ' disabled');
                                    
                                  
                                 var parent = $checkbox.closest('div');
                            
                               parent.find("#cancel_reservation").addClass('disabled');
                                // alert(parent.find("#user_id").val());
                                     
                                    
                                 $.ajax({
                                url: "../../controllers/Host_controller.php",
                                type:"POST",
                                async:false,
                                data: {resId: JSON.stringify(<?php echo $resId ?>),
                                    reservationId:JSON.stringify(parent.find("#reservation_id").val())},
                                dataType:"html",
                                success: function(response) {
                                 //   alert(response);
                                }
                               });
                          
                        }
                        else {
                            $button
                                .removeClass('btn-' + color + ' active')
                                .addClass('btn-default');
                        }
                        
                    }

                    function init() {
                        updateDisplay();
                        // Inject the icon if applicable
                        if ($button.find('.state-icon').length == 0) {
                            $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i>');
                        }
                    }
                    init();
                });
            }
         //   });
 
        </script>
</head>
<body>
    <div class="container-fluid">
        <div class="mainInfo col-md-12">
            <div class="row">
                <div class="col-md-1">
                    <img alt="Logo" src="<?php echo 'data:image/jpeg;base64,' . $thumbnail ?>" class="img-rounded" height="100" width="100"/>
                </div>
                <div class="col-md-11">
                    <h1><?php echo $res_name ?></h1>
                </div>
            </div>
            
            <!--Reservation-->
            <br><br>
            <h1>Reservations:</h1>
            
            <!--Date picker-->
            <div class="row">
                <div class="datePicker col-md-4 col-md-offset-4">
                    <div class="date-picker pagination-centered"  data-date="<?php echo $date; ?>" data-keyboard="true">
                        <div class="date-container pull-left">
                            <h4 class="weekday">Monday</h4>
                            <h2 class="date">November 9th</h2>
                            <h4 class="year pull-right">2015</h4>
                        </div>
                        <span data-toggle="datepicker" data-type="subtract" class="fa fa-angle-left"></span>
                        <span data-toggle="datepicker" data-type="add" class="fa fa-angle-right"></span>
                        <div class="input-group input-datepicker">
                            <input type="text" class="form-control" data-format="YYYY/MM/DD" placeholder="YYYY/MM/DD">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                        <span data-toggle="calendar" class="fa fa-calendar"></span>
                    </div>
                </div>
            </div>
            
            <!--Make reservation button-->
            <button class="reservationButton btn btn-info col-md-offset-8" data-toggle="modal" data-id="<?php echo $resId ?>" data-target="#reservation-<?php echo $resId ?>" >
                Make a Reservation
            </button>
             
            <!--Make reservation pop up-->
            <div  class="modal fade" id="reservation-<?php echo $resId ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <form name="myForm" action="#.php"
                                      onsubmit="return validateForm()" method="post">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <label class="modal-title" name ="myModalLabel" id="myModalLabel">Make reservation at <?php echo $res_name ?></label>
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
            
            <!--List of reservations-->
            
            
            <div class="row" id ="reservation_info" hidden>
              <form method = "post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                              
                <div class="reservationInfo col-md-6 col-md-offset-3">
                <div class="list-group">
                    <br><br>
                    <h2 id="time">12:00 PM</h2>
                   
                        <div class="media">
                            
                            <!--Arrived check box-->
                            <span class="button-checkbox pull-right">
                                <button id="mark_arrived" type="button" class="btn btn-success" data-color="primary">Arrived</button>
                                <input type="checkbox" class="hidden"/>
                            </span>
                            
                             
                            <!--Reservation info-->
                            <div class="pull-left">
                                <img class="media-object" src="https://goo.gl/GOzAhf" alt="user" height="120" width="120">
                            </div>
                            <div class="media-body">
                                <h2 class="media-heading" id ="guest_name">John Smith</h2>
                                <h3 id ="no_of_people"> 2 people</h3>
                                <h4 id="accomodations">Accommodations</h4>
                              <!--  <h2 hidden id="reservation_id">1</h2>
                                <h2 hidden id="user_id">1</h2> -->
                                <input type="hidden" id="reservation_id" name="reservation_id" value="">
                                 <input type="hidden" id="user_id" name="user_id" value="">
                            </div>
                             <!--Cancellation-->
                            
                            <button id="cancel_reservation" class="cancelButton btn btn-danger pull-right" data-toggle="modal" data-target="#confirmDelete">
                                Cancel Reservation
                            </button>
                            
                             
                            <!--Cancel pop up-->
                            <div class="cancelPopup modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                      <h4 class="modal-title">Cancel Reservation </h4>
                                    </div>
                                    <div class="modal-body">
                                      <p>Are you sure about this?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                      <button type="button" class="btn btn-danger" id="confirm">OK </button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                              
                        </div>
                    </div>
                </div>
              </form>  
           
            </div>
            
        </div>
    </div>
</body>
</html>