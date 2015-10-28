<!DOCTYPE html>
<html>
    <head>
        <title>Restaurant Registration</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    </head>
    <body>
        <nav class ="navbar navbar-default">
            <div class ="container-fluid">
                <div class ="navbar-header">
                    <a class="navbar-brand" href="homepage.php">EZ Restaurant</a>
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


        <div id="form">
            <form action="action_page.php" method="post" enctype="multipart/form-data">

                <fieldset>
                    <legend>Login Information:</legend>
                    
                    Username:
                    <input type="text" name="ownerUsername" required />
                    <br>
                    <br>
                    
                    Password:
                    <input type="text" name="ownerPassword" required />

                    Confirm Password:
                    <input type="text" name="ownerConfirmPassword" required />
                    <br>
                </fieldset>

                <br>
                <fieldset>
                    <legend>Personal Information:</legend>
                    
                    First Name:
                    <input type="text" name="ownerFirstName" required />

                    Last Name:
                    <input type="text" name="ownerLastName" required />
                    <br>
                    <br>
                    
                    Phone Number:
                    <input type="text" name="ownerPhone" required />

                    Email:
                    <input type="text" name="ownerEmail" required />
                    
                    Address:
                    <input type="text" name="ownerAddress" />
                    <br>
                </fieldset>

                <br>
                <fieldset>
                    <legend>Restaurant Information:</legend>
                    
                    Restaurant Name:
                    <input type="text" name="restaurantName" required />

                    Address: 
                    <input type="text" name="restaurantAddress" required />
                    <br>
                    <br>
                    
                    Phone:
                    <input type="text" name="restaurantPhone" required />

                    Description:
                    <input type="text" name="description" />

                    Type of Food:
                    <input type="text" name="typeofFood" required />
                    <br>
                    <br>

                    Number of people allowed every half Hour:
                    <input type="text" name="peopleHalfHour" />
                    <br>
                    <br>
                    
                    Maximum party size per reservation:
                    <input type="text" name="maxPartySize" />
                    <br>
                    <br>

                    Total Restaurant Capacity:
                    <input type="text" name="restaurantCapacity" />
                    <br>
                    <br>

                    Hours Of Operation:
                    <br>
                    Monday:
                    <input type="text" name="monday">
                    <br>
                    Tuesday:
                    <input type="text" name="tuesday">
                    <br>
                    Wednesday:
                    <input type="text" name="wednesday">
                    <br>
                    Thursday:
                    <input type="text" name="thursday">
                    <br>
                    Friday:
                    <input type="text" name="friday">
                    <br>
                    Saturday:
                    <input type="text" name="saturday">
                    <br>
                    Sunday:
                    <input type="text" name="sunday">
                    <br>

                    <p>Profile Picture:</p>
                    <input type="file" name="profilePic" id="profilePic" required />
                    <br>
                    
                    <p>Menu:</p>
                    <input type="file" name="menuFile" id="menuFile">
                    <br>

                </fieldset>
                <h3>Privacy Policy</h3>
                <p>Talk about what they are agreeing to and how we are going to use their information.</p>
                <p>If you agree please click "Register Restaurant" if not, please click "Cancel".</p>
                
                <button type="reset" value="reset" name="reset">Reset Form</button>
                <button type="submit" value="submit" name="submit">Register Me</button>
            </form>
        </div>
    </body>
</html>

