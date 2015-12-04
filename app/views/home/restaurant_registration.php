<?php
include 'header.php';
$res = __DIR__ . '/../../controllers/Restaurant_controller.php';
require_once $res;
$restaurant = new Restaurant_controller();
//         $flag = $_GET['checkUsername'];
//  if (isset($_GET['checkUsername']) && !empty($_GET['checkUsername'])) {
if ($_POST) {
    $restaurant->add();
}
$food_category_array = $restaurant->getFoodCategory();
$username_array = $restaurant->getAllUserNames();
// echo $username_array;
// } else {
//             if($restaurant->checkUserName());
// }
?>
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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

        <!-- will be merged into js file once everything is done -->
        <script>
            $('.selectpicker').selectpicker();

            $('.selectpicker').selectpicker({
                style: 'btn-info',
                size: 4
            });

            function validateForm() {
                var ownerUsername = document.forms["form"]["ownerUsername"].value;
                var ownerPassword = document.forms["form"]["ownerPassword"].value;
                var ownerConfirmPassword = document.forms["form"]["ownerConfirmPassword"].value;
                var ownerFirstName = document.forms["form"]["ownerFirstName"].value;
                var ownerLastName = document.forms["form"]["ownerLastName"].value;
                var ownerPhone = document.forms["form"]["ownerPhone"].value;
                var ownerEmail = document.forms["form"]["ownerEmail"].value;
                var restaurantName = document.forms["form"]["restaurantName"].value;
                var restaurantAddress = document.forms["form"]["restaurantAddress"].value;
                var restaurantPhone = document.forms["form"]["restaurantPhone"].value;

                if (ownerUsername === null || ownerUsername === "") {
                    alert("Username must be filled out.");
                    return false;
                }

                if (!/[a-zA-Z0-9]+/.test(ownerUsername)) {
                    alert("Username can only be letters and numbers.");
                    return false;
                }

                if (ownerPassword === null || ownerPassword === "") {
                    alert("Password must be filled out.");
                    return false;
                }

                if (ownerConfirmPassword === null || ownerConfirmPassword === "") {
                    alert("You must confirm your password.");
                    return false;
                }

                if (ownerPassword !== ownerConfirmPassword) {
                    alert("Your passwords don't match.");
                    return false;
                }

                if (ownerFirstName === null || ownerFirstName === "") {
                    alert("First name must be filled out.");
                    return false;
                }

                if (!/[a-zA-Z]+/.test(ownerFirstName)) {
                    alert("First name can only be letters.");
                    return false;
                }

                if (ownerLastName === null || ownerLastName === "") {
                    alert("Last name must be filled out.");
                    return false;
                }

                if (!/[a-zA-Z]+/.test(ownerLastName)) {
                    alert("Last name can only be letters.");
                    return false;
                }

                if (ownerPhone === null || ownerPhone === "") {
                    alert("Phone must be filled out.");
                    return false;
                }

                if (!/[0-9]+/.test(ownerPhone)) {
                    alert("Phone can only be numbers.");
                    return false;
                }

                if (ownerEmail === null || ownerEmail === "") {
                    alert("Email must be filled out.");
                    return false;
                }

                if (restaurantName === null || restaurantName === "") {
                    alert("Restaurant name must be filled out.");
                    return false;
                }

                if (restaurantAddress === null || restaurantAddress === "") {
                    alert("Restaurant address must be filled out.");
                    return false;
                }

                if (restaurantPhone === null || restaurantPhone === "") {
                    alert("Restaurant phone must be filled out.");
                    return false;
                }

                if (!/[0-9]+/.test(restaurantPhone)) {
                    alert("Phone can only be numbers.");
                    return false;
                }
            }

        </script>

    </head>
    <body>
        <div class="container">
            <h1 class="well">Restaurant Registration Form</h1>
            <div class="col-lg-12 well">
                <div class="row">
                    <form name="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                          onsubmit="return validateForm()" method="post" enctype="multipart/form-data"> 
                        <div class="col-sm-12">

                            <p>* indicates required field.</p>
                            <fieldset>
                                <div class="col-lg-12 well">
                                    <legend>Login Information:</legend>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label id="usernameLabel">Username *</label>
                                            <input id="username" type="text" name="ownerUsername" placeholder="Please pick a username..." class="form-control" required> 
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label id="passwordLabel">Password *</label>
                                            <input id="password" type="password" name="ownerPassword" placeholder="Please pick a password..." class="form-control" required>
                                        </div>	
                                        <div class="col-sm-4 form-group">
                                            <label id="confirmPasswordLabel">Confirm Password *</label>
                                            <input id="confirmPassword" type="password" name="ownerConfirmPassword" placeholder="Please confirm your password..." class="form-control" required>
                                        </div>		
                                    </div>
                                </div>
                            </fieldset>

                            <br>

                            <fieldset>
                                <div class="col-lg-12 well">
                                    <legend>Personal Information:</legend>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label id="firstNameLabel">First Name *</label>
                                            <input type="text" name="ownerFirstName" id="firstname" placeholder="Please enter you first name..." class="form-control" required>
                                        </div>
                                        <div class="col-sm-4 form-group">
                                            <label id="lastNameLabel">Last Name *</label>
                                            <input id="lastname" type="text" name="ownerLastName" placeholder="Please enter you last name..." class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label>Address</label>
                                            <input type="text" name="ownerStreet" placeholder="Please enter your address..."
                                                   rows="3" class="form-control">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label>City</label>
                                            <input type="text" name="ownerCity" placeholder="Enter City Name Here.." class="form-control">
                                        </div>	
                                        <div class="col-sm-4 form-group">
                                            <label>State</label>
                                            <input type="text" name="ownerState" placeholder="Enter State Name Here.." class="form-control">
                                        </div>	
                                        <div class="col-sm-4 form-group">
                                            <label>Zip</label>
                                            <input type="number" name="ownerZip" placeholder="Enter Zip Code Here.." class="form-control">
                                        </div>		
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label id="ownerPhoneLabel">Phone Number *</label>
                                            <input id="ownerPhone" type="text" name="ownerPhone" placeholder="Please enter your phone number..." class="form-control" required>
                                        </div>
                                        <div class="col-sm-4 form-group">
                                            <label id="emailLabel">Email *</label>
                                            <input id="email" type="text" name="ownerEmail" placeholder="Please enter you email address..." class="form-control" required>
                                        </div>
                                    </div>  
                                </div>
                            </fieldset>

                            <br>

                            <fieldset>
                                <div class="col-lg-12 well">
                                    <legend>Restaurant Information:</legend>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label>Restaurant Name *</label>
                                            <input type="text" name="restaurantName" placeholder="Please enter the restaurant's name..." class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label>Address*</label>
                                            <input type="text" name="restaurantStreet" placeholder="Please enter the restaurant's address..."
                                                   rows="3" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label>City</label>
                                            <input type="text" name="restaurantCity" placeholder="Enter City Name Here.." class="form-control">
                                        </div>	
                                        <div class="col-sm-4 form-group">
                                            <label>State</label>
                                            <input type="text" name="restaurantState" placeholder="Enter State Name Here.." class="form-control">
                                        </div>	
                                        <div class="col-sm-4 form-group">
                                            <label>Zip</label>
                                            <input type="number" name="restaurantZip" placeholder="Enter Zip Code Here.." class="form-control">
                                        </div>		
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label>Phone Number *</label>
                                            <input type="text" name="restaurantPhone" placeholder="Please enter the restaurant's phone number..." class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label>Description</label>
                                          <!--  <input type="text" name="description" 
                                                   placeholder="Please enter a sentence that describes your restaurant..." class="form-control">
                                            -->
                                            <textarea name="description" id="description" placeholder="Please enter a sentence that describes your restaurant..." class="form-control">
                                            </textarea>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Type of Food</label>
                                        <select class="selectpicker" name ="food_category"><?php
                                            foreach ($food_category_array as $category) {
                                                echo "<option value=" . $category['name'] . ">" . $category['name'] . "</option>";
                                            }
                                            ?><option value ="any" selected="selected">Select Food Type</option>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4 form-group">
                                            <label>Number of Tables for Two *</label>
                                            <input type="number" name="tablesForTwo" 
                                                   placeholder="Please pick the total number of tables for two..." class="form-control" required/>
                                        </div>


                                        <div class="col-sm-4 form-group">
                                            <label>Number of Tables for Four *</label>
                                            <input type="number" name="tablesForFour" 
                                                   placeholder="Please pick the total number of tables for four..." class="form-control" required />
                                        </div>

                                        <div class="col-sm-4 form-group">
                                            <label>Number of Tables for Six *</label>
                                            <input type="number" name="tablesForSix" 
                                                   placeholder="Please pick the total number of tables for six..." class="form-control" required />
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Hours Of Operation *</label>
                                        <br>
                                        <label>Monday</label>
                                        <div class="row">
                                            <div class="col-sm-4 form-group">
                                                <label>From</label>
                                                <input type="time" name="mondayFrom" class="form-control" > 
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <label>To</label>
                                                <input type="time" name="mondayTo" class="form-control" >
                                            </div>
                                        </div>     

                                        <label>Tuesday</label>
                                        <div class="row">
                                            <div class="col-sm-4 form-group">
                                                <label>From</label>
                                                <input type="time" name="tuesdayFrom" class="form-control" > 
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <label>To</label>
                                                <input type="time" name="tuesdayTo" class="form-control" >
                                            </div>
                                        </div>  

                                        <label>Wednesday</label>
                                        <div class="row">
                                            <div class="col-sm-4 form-group">
                                                <label>From</label>
                                                <input type="time" name="wednesdayFrom" class="form-control" > 
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <label>To</label>
                                                <input type="time" name="wednesdayTo" class="form-control" >
                                            </div>
                                        </div> 

                                        <label>Thursday</label>
                                        <div class="row">
                                            <div class="col-sm-4 form-group">
                                                <label>From</label>
                                                <input type="time" name="thursdayFrom" class="form-control" > 
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <label>To</label>
                                                <input type="time" name="thursdayTo" class="form-control" >
                                            </div>
                                        </div> 

                                        <label>Friday</label>
                                        <div class="row">
                                            <div class="col-sm-4 form-group">
                                                <label>From</label>
                                                <input type="time" name="fridayFrom" class="form-control" > 
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <label>To</label>
                                                <input type="time" name="fridayTo" class="form-control" >
                                            </div>
                                        </div> 

                                        <label>Saturday</label>
                                        <div class="row">
                                            <div class="col-sm-4 form-group">
                                                <label>From</label>
                                                <input type="time" name="saturdayFrom" class="form-control" > 
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <label>To</label>
                                                <input type="time" name="saturdayTo" class="form-control" >
                                            </div>
                                        </div> 

                                        <label>Sunday</label>
                                        <div class="row">
                                            <div class="col-sm-4 form-group">
                                                <label>From</label>
                                                <input type="time" name="sundayFrom" class="form-control" > 
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <label>To</label>
                                                <input type="time" name="sundayTo" class="form-control" >
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="form-group">
                                        <label>Profile Picture *</label>
                                        <input type="file" name="profilePic" id="profilePic" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Menu</label>
                                        <input type="file" name="menuFile" id="profilePic"/>
                                    </div>
                                </div>
                            </fieldset>

                            <br>
                            <h4><input type="checkbox" name="checkbox" value="privacypolicy" required> 
                                I agree to the 
                                <a href="JavaScript:newPopup
                                   ('privacy_policy.html');" data-toggle="modal" data-target="#privacy_policy">
                                    Privacy Policy</a>.</h4>
                            <br>
                            <div  class="modal fade"  id = "privacy_policy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <label class="modal-title" name ="myModalLabel" id="myModalLabel">Privacy Policy </label>
                                        </div>
                                        <div class="modal-body">

                                            <p>
                                                <b>
                                                    What Information we collect?
                                                </b>
                                            <p>
                                                While registering on our site, you may be asked to enter:your name, email , contact number.
                                                However you may visit our website anonymously.
                                            </p>
                                            <b>
                                                What do we use Information for?
                                            </b>
                                            <p>
                                                Any Information we collect form you may be used in one of the following ways:</p>
                                            <p>
                                                - To improve customer service (to display history of reservations, to display
                                                already visited restaurants etc.)
                                            </p>
                                            <p>
                                                - To send confirmation emails
                                            </p>

                                            <b>
                                                How do we protect Information
                                            </b>
                                            <p>
                                                We do not sell, transfer or trade your information to outside parties.
                                                However some of the information may be displayed on our website.
                                            </p>

                                            <b>
                                                By using our site, you consent to our privacy policy
                                            </b>    

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                                        </div>
                                    </div>
                                </div>

                            </div>


                            <h4>If you do not agree please cancel.
                                <input type="button" class="btn btn-primary" value="Cancel Registration" onclick="index.php">
                            </h4>
                            <br>
                            <br>

                            <button type="reset" class="btn btn-lg btn-primary" value="reset" name="reset">Reset Form</button>
                            <button type="submit" class="btn btn-lg btn-primary" value="submit" name="submit" style="float: right">Register Restaurant</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#username").focusout(function () {
                var existingUsernames = <?php echo json_encode($username_array) ?>;
                var inputUsername = $("#username").val();
                if (!inputUsername) {
                    $("#username").css("border", "#FF0000 1px solid");
                    $("#usernameLabel").replaceWith("<label id='usernameLabel'>Username *<i style='color:red'>Username cannot be empty</i></label>");
                    return;
                }
                if (jQuery.inArray(inputUsername, existingUsernames) !== -1) {
                    $("#username").css("border", "#FF0000 1px solid");
                    $("#usernameLabel").replaceWith("<label id='usernameLabel'>Username *<i style='color:red'>Username already taken</i></label>");
                    return;
                }
                $("#username").css("border", "");
                $("#usernameLabel").replaceWith('<label id="usernameLabel">Username *</label>');
            });

            $("#password").focusout(function () {
                var inputPassword = $("#password").val();
                if (!inputPassword) {
                    $("#password").css("border", "#FF0000 1px solid");
                    $("#passwordLabel").replaceWith("<label id='passwordLabel'>Password *<i style='color:red'>Password cannot be empty</i></label>");
                    return;
                }
                $("#password").css("border", "");
                $("#passwordLabel").replaceWith('<label id="passwordLabel">Password *</label>');
            });

            $("#confirmPassword").focusout(function () {
                var inputPassword = $("#confirmPassword").val();
                if (!inputPassword) {
                    $("#confirmPassword").css("border", "#FF0000 1px solid");
                    $("#confirmPasswordLabel").replaceWith("<label id='confirmPasswordLabel'>Confirm Password *<i style='color:red'>Confirm password cannot be empty</i></label>");
                    return;
                }
                $("#confirmPassword").css("border", "");
                $("#confirmPasswordLabel").replaceWith('<label id="confirmPasswordLabel">Confirm Password *</label>');
            });

            $("#firstname").focusout(function () {
                var inputFirstName = $("#firstname").val();
                if (!inputFirstName) {
                    $("#firstname").css("border", "#FF0000 1px solid");
                    $("#firstNameLabel").replaceWith("<label id='firstNameLabel'>First Name *<i style='color:red'>First name cannot be empty</i></label>");
                    return;
                }
                $("#firstname").css("border", "");
                $("#firstNameLabel").replaceWith('<label id="firstNameLabel">First Name *</label>');
            });

            $("#lastname").focusout(function () {
                var inputLastName = $("#lastname").val();
                if (!inputLastName) {
                    $("#lastname").css("border", "#FF0000 1px solid");
                    $("#lastNameLabel").replaceWith("<label id='lastNameLabel'>Last Name *<i style='color:red'>Last name cannot be empty</i></label>");
                    return;
                }
                $("#lastname").css("border", "");
                $("#lastNameLabel").replaceWith('<label id="lastNameLabel">Last Name *</label>');
            });
            
            $("#ownerPhone").focusout(function () {
                    var inputPassword = $("#ownerPhone").val();
                    if (!inputPassword) {
                        $("#ownerPhone").css("border", "#FF0000 1px solid");
                        $("#ownerPhoneLabel").replaceWith ("<label id='ownerPhoneLabel'>Phone Number *<i style='color:red'>Phone number cannot be empty</i></label>");
                        return;
                    }
                    $("#ownerPhone").css("border", "");
                    $("#ownerPhoneLabel").replaceWith('<label id="ownerPhoneLabel">Phone Number *</label>');
                });
            
            $("#email").focusout(function () {
                    var inputPassword = $("#email").val();
                    if (!inputPassword) {
                        $("#email").css("border", "#FF0000 1px solid");
                        $("#emailLabel").replaceWith ("<label id='emailLabel'>Email *<i style='color:red'>Email cannot be empty</i></label>");
                        return;
                    }
                    $("#email").css("border", "");
                    $("#emailLabel").replaceWith('<label id="emailLabel">Email *</label>');
                });

        });

    </script>
</html>
