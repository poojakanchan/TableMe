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
                
                if(userPassword !== userConfirmPassword) {
                    alert("Your passwords don't match.");
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
       /*
        include 'header.php';
       
        $user = __DIR__ . '/../../controllers/User_Controller.php';
        require_once $user;
        require_once '../../models/Login_model.php';
        $db = new Login_model();
        //         $flag = $_GET['checkUsername'];
        //  if (isset($_GET['checkUsername']) && !empty($_GET['checkUsername'])) {
        if ($_POST) {
            $user_controller = new User_controller();
            $user_controller->registerUser();
        }
        $existingUsernames = $db->getAllUsernames();
        */
        ?>

        <div class="container">
            <h1 class="well">User Registration Form</h1>
            <div class="col-lg-12 well">
                <div class="row">
                    <form name="myForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                          onsubmit="return validateForm()" method="post">
                        <div class="col-sm-12">
                            
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>First Name*</label>
                                    <input type="text" name="userFirstName" placeholder="Please enter you first name..." class="form-control" required>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>Last Name*</label>
                                    <input type="text" name="userLastName" placeholder="Please enter you last name..." class="form-control" required>
                                </div>
                            </div>										 

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                <label id="usernameLabel">Username*</label>
                                <input type="text" name="userUsername" id="username" placeholder="Please pick a username..." class="form-control" required>
                                </div>
                                
                            </div>

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Password*</label>
                                    <input type="password" name="userPassword" placeholder="Please pick a password..." class="form-control" required>
                                </div>	
                                <div class="col-sm-6 form-group">
                                    <label>Confirm Password*</label>
                                    <input type="password" name="userConfirmPassword" placeholder="Please confirm your password..." class="form-control" required>
                                </div>		
                            </div>

                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label>Phone Number</label>
                                    <input type="text" name="userPhone" placeholder="Please enter your phone number..." class="form-control">
                                </div>
                          	
                                <div class="col-sm-6 form-group">
                                    <label>Email Address*</label>
                                    <input type="email" name="userEmail" placeholder="Please enter your email address..." class="form-control" required>
                                </div>
                            </div>
                            
                            <script type="text/javascript">
                                // Popup window code
                                function newPopup(url) {
                                    popupWindow = window.open(
                                    url,'popUpWindow','height=300,width=400,\n\
                                    left=10,top=10,resizable=yes,scrollbars=yes,toolbar=yes,\n\
                                    menubar=no,location=no,directories=no,status=yes')
                                }
                            </script>
                                                                                                                                                                   
                            <br>
                            <h4><input type="checkbox" name="checkbox" value="privacypolicy" required> 
                                I agree to the 
                                <a href="JavaScript:newPopup
                                   ('sfsuswe.com/~f15g11/m3/app/views/home/privacy_policy.html');">
                                    Privacy Policy</a>.</h4>
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
        
        
        <script>
            $(document).ready(function () {
                $("#username").focusout(function () {
                    var existingUsernames = <?php echo json_encode($existingUsernames) ?>;
                    var inputUsername = $("#username").val();
                    if (!inputUsername) {
                        $("#username").css("border", "#FF0000 1px solid");
                        $("#usernameLabel").replaceWith ("<label id='usernameLabel'>Username*<i style='color:red'>Username cannot be empty</i></label>");
                        return;
                    }
                    if (jQuery.inArray(inputUsername, existingUsernames) !== -1) {
                        $("#username").css("border", "#FF0000 1px solid");
                        $("#usernameLabel").replaceWith ("<label id='usernameLabel'>Username*<i style='color:red'>Username already taken</i></label>");
                        return;
                    }
                    $("#username").css("border", "");
                    $("#usernameLabel").replaceWith('<label id="usernameLabel">Username*</label>');
                });
            });
            function validateUserName() {
                
            }
        </script>   
    </body>
</html>
