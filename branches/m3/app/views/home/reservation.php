<!DOCTYPE html>
<html>
    <head>
        <title>Reservation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

        <script>
            function validateForm() {

                var firstName = document.forms["myForm"]["reservationFirstName"].value;
                var lastName = document.forms["myForm"]["reservationLastName"].value;
                var email = document.forms["myForm"]["reservationEmail"].value;
                var guests = document.forms["myForm"]["guests"].value;
                var restaurant = document.forms["myForm"]["restaurant"].value;
                var month = document.forms["myForm"]["month"].value;
                var day = document.forms["myForm"]["day"].value;
                var year = document.forms["myForm"]["year"].value;
                var time = document.forms["myForm"]["time"].value;

                if (firstName === null || firstName === "") {
                    alert("First name must be filled out.");
                    return false;
                }

                if (lastName === null || lastName === "") {
                    alert("Last name must be filled out.");
                    return false;
                }

                if (email === null || email === "") {
                    alert("Email must be filled out.");
                    return false;
                }

                if (guests === null || guests === "") {
                    alert("Number of guests must be filled out.");
                    return false;
                }

                if (restaurant === null || restaurant === "") {
                    alert("Restaurant must be filled out.");
                    return false;
                }

                if (month === null || month === "") {
                    alert("Month must be filled out.");
                    return false;
                }

                if (day === null || day === "") {
                    alert("Day must be filled out.");
                    return false;
                }

                if (year === null || year === "") {
                    alert("Year must be filled out.");
                    return false;
                }

                if (time === null || time === "") {
                    alert("Time must be filled out.");
                    return false;
                }
            }
        </script>
    </head>
    <body>
        <nav class ="navbar navbar-default">
            <div class ="container-fluid">
                <div class ="navbar-header">
                    <a class="navbar-brand" href="index.php">TableMe</a>
                </div>
                <div>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Register <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#UserRegister">User</a></li>
                                <li><a href="#RestaurantRegister">Restaurant</a></li>
                            </ul>
                        </li>
                        <li> <a href ="#login">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <form name="myForm" action="action_page.php"
              onsubmit="return validateForm()" method="post">

            <select id="guests" name="guests" required>
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

            <select id="restaurant" name="restaurant" required>
                <option value="" disabled selected>Restaurant</option>
                <option value ="restaurant1">Name1</option>
                <option value ="restaurant2">Name2</option>
                <option value ="restaurant3">Name3</option>
            </select>

            <select id="month" name="month" required>
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

            <select id="day" name="day" required>
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

            <select id="year" name="year" required>
                <option value="" disabled selected>Year</option>
                <option value ="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
            </select>

            <select id="time" name="time" required>
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

            <br>
            <br>
            First Name:
            <br>
            <input type="text" name="reservationFirstName" required>
            <br>
            <br>

            Last Name:
            <br>
            <input type="text" name="reservationLastName" required>
            <br>
            <br>

            Email:
            <br>
            <input type="email" name="reservationEmail" required>
            <br>
            <br>

            Phone Number:
            <br>
            <input type="text" name="reservationPhone">
            <br>
            <br>

            Accommodations:
            <br>
            <textarea name="accommodations">
            </textarea>


            <br>
            <br>
            <input type="submit" value="Make Reservation">
        </form>
    </div>

</body>
</html>



