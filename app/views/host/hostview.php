<html lang="en">
<head>
	<title>TableMe</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
        
        <!-- Will merge into js file after all is done. -->
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
        </style>
        <script>
            $(document).ready(function() {
 
    $(window).on('focus', function(event) {
        $('.show-focus-status > .alert-danger').addClass('hidden');
        $('.show-focus-status > .alert-success').removeClass('hidden');
    }).on('blur', function(event) {
        $('.show-focus-status > .alert-success').addClass('hidden');
        $('.show-focus-status > .alert-danger').removeClass('hidden');
    });    
    
    $('.date-picker').each(function () {
        var $datepicker = $(this),
            cur_date = ($datepicker.data('date') ? moment($datepicker.data('date'), "YYYY/MM/DD") : moment()),
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
        $(function () {
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
            updateDisplay();
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
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i>');
            }
        }
        init();
    });
});

        </script>
       
</head>
<body>
    
    <?php
        include 'header.php';
    ?>
    
    <div class="container-fluid">
        <div class="mainInfo col-md-12">
            <div class="row col-md-offset-6">
                <h1>Little Tokyo</h1>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <img alt="Logo" src="http://goo.gl/vrq2Cw" class="img-rounded" height="300" width="300"/>
                </div>
                <div class="restaurant-detail1 col-md-4">
                    <h3>Food type:</h3>
                    <p>The restaurant Food type from db should be here!</p>
                    <h3>Description:</h3>
                    <p>The restaurant description from db should be here!</p>
                </div>
                <div class="restaurant-detail2 col-md-4">
                    <h3>Address:</h3>
                    <p>The restaurant address from db should be here!</p>
                    <h3>Phone:</h3>
                    <p>The restaurant phone number from db should be here!</p>
                </div>
            </div>
            <br><br>
            <h1>Reservations:</h1>
            <button class="btn btn-info pull-right" data-toggle="modal" data-id="<?php //echo $restaurant['restaurant_id'] ?>" data-target="#reservation-<?php //echo $restaurant['restaurant_id'] ?>" >
                                Make a Reservation
                    </button>
                    <div  class="modal fade" id="reservation-<?php //echo $restaurant['restaurant_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                                                        option value="31">31</option>
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
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="date-picker pagination-centered"  data-date="2015/11/09" data-keyboard="true">
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
            <div class="row">
                <div class="mainInfo col-md-6 col-md-offset-3">
                <div class="list-group">
                    <br><br>
                    <a href="#" class="list-group-item">
                        <div class="media">
                            <div class="pull-left">
                                <img class="media-object" src="https://goo.gl/GOzAhf" alt="user" height="120" width="120">
                            </div>
                            <div class="media-body">
                                <h2 class="media-heading">John Smith</h2>
                                <h3>2 people</h3>
                                <h4>Accommodations</h4>
                            </div>
                            <span class="button-checkbox pull-right">
                                <button type="button" class="btn" data-color="primary">Arrived</button>
                                <input type="checkbox" class="hidden"/>
                            </span>
                        </div>
                    </a></div>
        </div>
            </div>
    </div>
    </div>

    <div class = "navbar navbar-default navbar-bottom">
        <div class = "container">
            <p class="navbar-text navbar-left">This website belongs to SFSU Course CSC648/CSC848 Fall 15 Group 11</p>
        </div>
    </div>
    
</body>
</html>