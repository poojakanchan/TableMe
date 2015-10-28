<!DOCTYPE html>
<html>
    <head>
        <title>User Registration</title>
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
            <form action="action_page.php">
                <br>
                    First Name:
                    <input type="text" name="userFirstName">

                    Last Name:
                    <input type="text" name="userLastName">
                    <br>
                    <br>

                    Username:
                    <input type="text" name="userUsername">
                    <br>
                    <br>
                    
                    Password:
                    <input type="text" name="userPassword">

                    Confirm Password:
                    <input type="text" name="userConfirmPassword">
                    <br>
                    <br>
                    
                    Phone Number:
                    <input type="text" name="userPhone">
                    <br>
                    <br>
                    
                    Email:
                    <input type="text" name="userEmail">
                    <br>
   
                <h3>Privacy Policy</h3>
                <p>Talk about what they are agreeing to and how we are going to use their information.</p>
                <p>If you agree please click "Register Account" if not, please click "Cancel".</p>

                <input type="submit" value="Cancel">
                <input type="submit" value="Register Account">
            </form>
        </div>
    </body>
</html>

