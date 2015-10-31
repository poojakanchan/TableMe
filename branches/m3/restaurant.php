<html lang="en">
<head>
	<title>EZ Restaurant</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>
        
        <!-- Will merge into js file after all is done. -->
        <script>
            $('.selectpicker').selectpicker();

            $('.selectpicker').selectpicker({
                style: 'btn-info',
                size: 4
            });
       </script>
</head>
<body>
    
    <?php
        include ('header.php');
    ?>
    
    <div class="container-fluid">
        <div class="mainInfo col-md-8">
            <div class="restaurantprofile col-md-12">
                <div class="restaurantpic col-md-4">
                    <img alt="Logo" src="http://goo.gl/vrq2Cw" class="img-rounded" height="200" width="200" />
                </div>
                <div class="restaurantname col-md-8">
                    <h1>Little Tokyo</h1>
                    <h2>Japanese food</h2>
                    <p>The greatest Japanese restaurant in town!</p>
                </div>
            </div>
            
            <div class="col-md-12">
		<br>
		<img alt="Restaurant photo" src="https://goo.gl/GOzAhf" class="img-rounded" height="75" width="75"/>
                <img alt="Restaurant photo" src="https://goo.gl/GOzAhf" class="img-rounded" height="75" width="75"/>
                <img alt="Restaurant photo" src="https://goo.gl/GOzAhf" class="img-rounded" height="75" width="75"/>
                <img alt="Restaurant photo" src="https://goo.gl/GOzAhf" class="img-rounded" height="75" width="75"/>
                <img alt="Restaurant photo" src="https://goo.gl/GOzAhf" class="img-rounded" height="75" width="75"/>
		<br><br>
            </div>
            
            <div class="col-md-12">
		<div class="panel panel-default">
                    <div class="panel-heading">
			<a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-721564" href="#panel-element-860877">Menu</a>
                    </div>
                    <div id="panel-element-860877" class="panel-collapse collapse">
			<div class="panel-body">We will show the menu here!</div>
                    </div>
		</div>
            </div>
            
            <div class="col-md-12">
                <h1>Make a Reservation!</h1>
                <div class="container">
                    <form name="myForm" action="#.php" onsubmit="return validateForm()" method="post">

                        <select class="selectpicker" id="month" name="month" required data-width="auto">
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

                        <select class="selectpicker" id="day" name="day" required data-width="auto">
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

                        <select class="selectpicker" id="guests" name="guests" required data-width="auto">
                            <option value="" disabled selected>Number of Guests</option>
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
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                        </select>

                        <select class="selectpicker" id="time" name="time" required data-width="auto">
                            <option value="" disabled selected>Time</option>
                            <option value ="8am">8:00 AM</option>
                            <option value="830am">8:30 AM</option>
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
                        <button type="submit" class="btn btn-default" value="Submit">Make reservation</button>
                    </form>
                </div>
                
            </div>
            <br><br><br><br><br>
            <div class="userreview col-md-12">
                <h1>Reviews</h1>
                <div class="media">
                    <a class="media-left" href="#">
                        <img src="https://goo.gl/GOzAhf" alt="user" height="50" width="50">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Larry</h4>
                        <p>I like this restaurant!</p>
                    </div>
                </div>
                <div class="media">
                    <a class="media-left" href="#">
                        <img src="https://goo.gl/GOzAhf" alt="user" height="50" width="50">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Potter</h4>
                        <p>I like this restaurant too!</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="specialEvent col-md-4">
            <p>This is the special event info</p>
            <div class="list-group">
                <a href="#" class="list-group-item">Band perform</a>
                <a href="#" class="list-group-item">Dancing</a>
                <a href="#" class="list-group-item">Conference meeting</a>
                <a href="#" class="list-group-item">Happy hour</a>
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