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
         <?php
        session_start();
       echo $_SESSION['ROOT'];
       //include_once '/home/pkanchan/public_html/non-mvc/config.php';
         $res = $_SESSION['ROOT'] .'/app/controllers/Restaurant_controller.php';
         
         require_once $res;
         $restaurant = new Restaurant_controller();
         $restaurant->add();
        
        ?>
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
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">

                <fieldset>
                    <legend>Login Information:</legend>
                    
                    Username:
                    <input type="text" name="ownerUsername" required />
                    <br>
                    <br>
                    
                    Password:
                    <input type="password" name="ownerPassword" required />

                    Confirm Password:
                    <input type="password" name="ownerConfirmPassword" required />
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
                    <br>
                    Type of Food:
                    <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Please Choose Type of food<strong class="caret"></strong></a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" name="typeOfFood">
                                    <li>
                                        <a href="#1">American food</a>
                                    </li>
                                    <li>
                                        <a href="#2">Italian</a>
                                    </li>
                                    <li>
                                        <a href="#3">Chinese</a>
                                    </li>
                                    <li>
                                        <a href="#4">Japanese</a>
                                    </li>
                                    <li>
                                        <a href="#2">Fast food</a>
                                    </li>
                                    <li>
                                        <a href="#2">Middle eastern</a>
                                    </li>
                                    <li>
                                        <a href="#2">All</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    
                    
                    
                    <!-- <input type="text" name="typeofFood" required /> -->
                    <br>
                    <br>

                    Number of people allowed every half Hour:
                    <input type="number" name="peopleHalfHour" />
                    <br>
                    <br>
                    
                    Maximum party size per reservation:
                    <input type="number" name="maxPartySize" />
                    <br>
                    <br>

                    Total Restaurant Capacity:
                    <input type="number" name="restaurantCapacity" />
                    <br>
                    <br>

                    Hours Of Operation:
                    <br>
                    Monday
                    From:
                    <input type="text" name="mondayFrom"> 
                   To:
                    <input type="text" name="mondayTo">
                    <br>
                    Tuesday:
                    From:
                    <input type="text" name="tuesdayFrom"> 
                    To:
                    <input type="text" name="tuesdayTo">
                    <br>
                    Wednesday:
                    From:
                    <input type="text" name="wednesdayFrom"> 
                    To:
                    <input type="text" name="wednesdayTo">
                   <br>
                    Thursday:
                    From:
                    <input type="text" name="thursdayFrom"> 
                    To:
                    <input type="text" name="thursdayTo">
                   <br>
                   Friday:
                   From:
                    <input type="text" name="fridayFrom"> 
                    To:
                    <input type="text" name="fridayTo">
                   
                    <br>
                    Saturday:
                    From:
                    <input type="text" name="saturdayFrom"> 
                    To:
                    <input type="text" name="saturdayTo">
                    <br>
                    Sunday:
                    From:
                    <input type="text" name="sundayFrom"> 
                    To:
                    <input type="text" name="sundayTo">
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

