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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- will be merged into js file once everything is done -->
        <script>
            function validateForm() {

                var userFirstName = document.forms["myForm"]["userFirstName"].value;
                var userLastName = document.forms["myForm"]["userLastName"].value;
                var userUsername = document.forms["myForm"]["userUsername"].value;
                var userPassword = document.forms["myForm"]["userPassword"].value;
                var userConfirmPassword = document.forms["myForm"]["userConfirmPassword"].value;
                var userEmail = document.forms["myForm"]["userEmail"].value;
                var checkbox = document.forms["myForm"]["checkbox"].value;

                if (userFirstName === null || userFirstName === "") {
                    alert("First name must be filled out.");
                    return false;
                }

                if (userLastName === null || userLastName === "") {
                    alert("Last name must be filled out.");
                    return false;
                }

                if (userUsername === null || userUsername === "") {
                    alert("Username must be filled out.");
                    return false;
                }

                if (userPassword === null || userPassword === "") {
                    alert("Password must be filled out.");
                    return false;
                }

                if (userConfirmPassword === null || userConfirmPassword === "") {
                    alert("You must confirm the password.");
                    return false;
                }

                if (userEmail === null || userEmail === "") {
                    alert("Email must be filled out.");
                    return false;
                }

                if (checkbox === null || checkbox === "") {
                    alert("You must agree to the privacy policy.");
                    return false;
                }

            }
        </script>
    </head>
    <body>
       <?php
        include 'header.php';
       ?>
<!--        <nav class ="navbar navbar-default">
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
        </nav>-->

        <div class="container">
            <h1 class="well">User Registration Form</h1>
            <div class="col-lg-12 well">
                <div class="row">
                    <form name="myForm" action="#.php"
                          onsubmit="return validateForm()" method="post">
                        <div class="col-sm-12">
                            
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>First Name</label>
                                    <input type="text" name="userFirstName" placeholder="Please enter you first name..." class="form-control" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="userLastName" placeholder="Please enter you last name..." class="form-control" required>
                                </div>
                            </div>										 

                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="userUsername" placeholder="Please pick a username..." class="form-control" required>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Password</label>
                                    <input type="text" name="userPassword" placeholder="Please pick a password..." class="form-control" required>
                                </div>	
                                <div class="col-sm-6 form-group">
                                    <label>Confirm Password</label>
                                    <input type="text" name="userConfirmPassword" placeholder="Please confirm your password..." class="form-control" required>
                                </div>		
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="text" name="userPhone" placeholder="Please enter your phone number..." class="form-control">
                            </div>		
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="userEmail" placeholder="Please enter your email address..." class="form-control" required>
                            </div>
                            
                            <br>
                            <h4><input type="checkbox" name="checkbox" value="privacypolicy" required> 
                                I agree to the Privacy Policy.</h4>
                            <br>

                            <h4>If you do not agree please cancel.
                            <input type="button" class="btn btn-primary" value="Cancel Registration" onclick="index.php">
                            </h4>
                            <br>
                            <br>
                            

                            <button type="reset" class="btn btn-lg btn-primary" value="reset" name="reset">Reset Form</button>
                            <button type="submit" class="btn btn-lg btn-primary" value="submit" name="submit" style="float: right">Register Me</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>
