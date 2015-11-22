<!DOCTYPE HTML> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TableMe</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.min.js"></script>

    <!--
    Leave the CSS file in the .php file for now.
    After everything is done, we will merge every singe css into one big file. 
    -->
    <script>
        $(document).ready(function () {
            $(".nav-tabs a").click(function () {
                $(this).tab('show');
            });
        });
    </script>   

    <style type ="text/css">

        .thumbnail {
            position: relative;
            overflow: hidden;
        }
        .caption {
            position: absolute;
            top:0;
            right:0;
            background:rgba(66, 139, 202, 0.75);
            width:100%;
            height:100%;
            padding:2%;
            display: none;
            text-align:center;
            color:#fff !important;
            z-index:2;
        }
        .col-xs-12 {
            padding-bottom: 25px;
        }

    </style>

</head>

<body>
    <!-- Navigation Bar -->
    <?php
    require_once 'header.php';
    require_once '../../models/User_model.php';
//    session_start();

    if (!isset($_SESSION['username'])) {
        header('location: ../home/login.php');
    }

    $db = new User_model();
    $username = $_SESSION['username'];
    $userInfo = $db->getUser($username);
    $userReservations = $db->getReservationHistory($userInfo['user_id']);


    if ($_POST) {
        $newPhoneNum = htmlspecialchars($_POST['phone_number']);
        $newEmail = htmlspecialchars($_POST['email']);
        $newPassword = htmlspecialchars($_POST['password']);
        $newImage = null;
        $db->updateUser($username, $newPhoneNum, $newEmail, $newPassword, $newImage);
        $userInfo = $db->getUser($username);
    }
    ?>
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-3">

                <?php
                echo '<img width="200" height="auto" src="data:image/jpeg;base64,' . base64_encode($userInfo['user_image']) . '"/>';
                ?>
            </div>
            <div class="col-md-9">
                <ul class="listed-group profile">
                    <li class="list-group-item text-muted"> Profile </li>
                    <li class="list-group-item text-right"> <span class="pull-left"><strong>Name</strong></span><?php echo $userInfo['name']; ?></li>
                    <li class="list-group-item text-right"> <span class="pull-left"><strong>E-mail</strong></span><?php echo $userInfo['email']; ?></li>
                    <li class="list-group-item text-right"> <span class="pull-left"><strong>Username</strong></span><?php echo $userInfo['username']; ?></li>
                    <li class="list-group-item text-right"> <span class="pull-left"><strong>Phone Number</strong></span><?php echo $userInfo['contact']; ?></li>
                </ul>
            </div>
        </div>    

        <br><br>
        <div class="row">
            <div class="col-sm-12">
                <ul class="nav nav-tabs"> <!-- Tab for the UserSection -->
                    <li class="active"><a href="#reservation">Reservation</a></li>
                    <li><a href="#history">History</a></li>
                    <li> <a href="#edit">Edit Profile</a></li>         
                </ul> <!-- Done with the tab -->

                <div class="tab-content">
                    <div id="reservation" class="tab-pane fade in active">
                        <div class="table-resposive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>TIME</th>
                                        <th>Name of Restaurant</th>
                                        <th># of People</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>date</td>
                                        <td>time</td>
                                        <td>Name of the Restaurant</td>
                                        <td>4</td>
                                        <td>
                                            <a href="#cancel" class="btn btn-info" role="button"> Cancel Reservation </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="history" class="tab-pane fade">
                        <div class="table-responsive">
                            <table class="table table hover">
                                <thead>
                                    <tr>
                                        <th>DATE</th>
                                        <th>Restaurant Name</th>
                                        <th>Time</th>
                                        <th>Number of People</th>
                                        <th>Review</th>
                                    </tr>
                                </thead>
                                <tbody id="items">
                                    <?php
                                    if (!empty($userReservations)) {
                                        foreach ($userReservations as $reservation) {
                                            echo '<tr>';
                                            echo '<td>' . $reservation['date'] . '</td>';
                                            echo '<td>' . $reservation['name'] . '</td>';
                                            echo '<td>' . $reservation['time'] . '</td>';
                                            echo '<td>' . $reservation['no_of_people'] . '</td>';
                                            if (empty($reservation['review_description']))
                                                echo '<td><a href="#review page" class="btn btn-info" data-toggle="modal" data-target="#modal-review" role="button"> Write A Review </a>';
                                            else
                                                echo '<td>' . $reservation['review_description'] . '</td>';
                                            echo '</tr>';
                                        }
                                    }
                                    ?>
                                    <div class="modal fade" id="modal-review" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Review</h4>
                                            </div>
                                            <div class="modal-body">
                                                
                                                    <div class="row row-name">
                                                        <div class="col-md-12">
                                                            <h4> Name of the Restaurant </h4>  
                                                        </div>
                                                                                                          
                                                    </div>
                                                    <div class="row row-rating">
                                                        <div class="col-md-12">
                                                            <p> Where we should have the rating (Uploaded Later)</p>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="row row-content">
                                                        <div class="col-md-12">
                                                            <textarea class = "form-control" rows = "5"></textarea>
                                                        </div>
                                                        
                                                    </div>  
                                                
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" value="submit-reservation" name="submit-reservation">Submit Review</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- End of history -->  
                    <div id="edit" class="tab-pane fade">
                        <form class="form" action="##" method="post" id="editregistrationform">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="phone_number"><h4>Phone Number</h4></label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" value="<?php echo $userInfo['contact']; ?>"  placeholder="(xxx) xxx-xxxx" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="email"><h4>Email</h4></label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?php echo $userInfo['email']; ?>" placeholder="you@email.com" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="password"><h4>Password</h4></label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="enter new password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="password2"><h4>Reenter password</h4></label>
                                    <input type="password" class="form-control" name="password2" id="password2" placeholder="re-enter new password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-lg btn-success" type="submit" id="submit_button"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                    <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                                </div>
                            </div>
                        </form> <!-- End of the edit the profile form -->
                    </div><!-- End of the Setting -->
                </div> <!-- End of Tab Contents -->
            </div> <!-- End of col-sm-12 -->
        </div> <!-- End of Row -->

        <script>
            // js for tabs
            $(document).ready(function () {
                $(".nav-tabs a").click(function () {
                    $(this).tab('show');
                });
                $("#submit_button").click(function () {
                    var validated = true;
                    if ($("#password").val() != $("#password2").val()) {
                        alert('Passwords do not match');
                        validated = false;
                    }
                    if (!validateEmail($('#email').val())) {
                        $('#email').css("border", "#FF0000 1px solid");
                        validated = false;
                    }
                    else {
                        $('#email').css("border", "");
                    }

                    if (!validatePhoneNumber($('#phone_number').val())) {
                        $('#phone_number').css("border", "#FF0000 1px solid");
                        validated = false;
                    }
                    else {
                        $('#phone_number').css("border", "");
                    }
                    return validated;
                });
            });

            function validateEmail(email) {
                var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                return re.test(email);
            }

            function validatePhoneNumber(phoneNumber) {
                var re = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
                return re.test(phoneNumber);
            }

            $("[rel='tooltip']").tooltip();
            
        </script>   

</body>