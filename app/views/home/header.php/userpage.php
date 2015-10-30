<!DOCTYPE HTML> 
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EZ Restaurant</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

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
    <?include ('header.php');?>
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <img src="#" width="200" height="230">
            </div>
            <div class="col-md-9">
                <ul class="listed-group profile">
                    <li class="list-group-item text-muted"> Profile </li>
                    <li class="list-group-item text-right"> <span class="pull-left"><strong>Name</strong></span>First_Name, Last_Name</li>
                    <li class="list-group-item text-right"> <span class="pull-left"><strong>E-mail</strong></span>ex_username@example.com</li>
                    <li class="list-group-item text-right"> <span class="pull-left"><strong>Username</strong></span>ex_username</li>
                    <li class="list-group-item text-right"> <span class="pull-left"><strong>Phone Number</strong></span>xxx) xxx-xxxx</li>
                </ul>
            </div>
        </div>    

        <br><br>
        <div class="row">
            <div class="col-sm-12">
                <ul class="nav nav-tabs"> <!-- Tab for the UserSection -->
                    <li class="active"><a href="#history">History</a></li>
                    <li> <a href="#favorite">Favorite</a></li>
                    <li> <a href="#edit">Edit Profile</a></li>         
                </ul> <!-- Done with the tab -->

                <div class="tab-content">
                    <div id="history" class="tab-pane fade in active">
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
                                    <tr>
                                        <td>xx.xx.xx</td>
                                        <td>Name_Restaurant</td>
                                        <td>xx:xxpm</td>
                                        <td>#</td>
                                        <td><a href="#review page" class="btn btn-info" role="button"> Review </a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- End of history -->  
                    <div id="favorite" class="tab-pane fade">
                        <br>
                        <div class="col-md-3">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h3> Name of Restaurant </h4>
                                    <br>
                                    <h1><center><a href="" class="label label-default" rel="tooltip">Reservation</a></center></h1>
                                </div>
                                <img src="http://lorempixel.com/400/300/sports/1/">
                            </div>
                        </div>
                    </div>
                    <div id="edit" class="tab-pane fade">
                        <form class="form" action="##" method="post" id="editregistrationform">
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="phone_number"><h4>Phone Number</h4></label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="xxx) xxx-xxxx">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="email"><h4>Email</h4></label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="you@email.com">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="password"><h4>Password</h4></label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="enter your password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <label for="password2"><h4>Verify</h4></label>
                                    <input type="password" class="form-control" name="password2" id="password2" placeholder="re-enter your password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <br>
                                    <button class="btn btn-lg btn-success" type="submit"><i class="glyphicon glyphicon-ok-sign"></i> Save</button>
                                    <button class="btn btn-lg" type="reset"><i class="glyphicon glyphicon-repeat"></i> Reset</button>
                                </div>
                            </div>
                        </form> <!-- End of the edit the profile form -->
                    </div><!-- End of the Setting -->
                </div> <!-- End of Tab Contents -->
            </div> <!-- End of col-sm-12 -->
        </div> <!-- End of Row -->

        <script>
            // Same with css version
            // js for tabs
            $(document).ready(function () {
                $(".nav-tabs a").click(function () {
                    $(this).tab('show');
                });
            });
            
            $("[rel='tooltip']").tooltip();

            $('.thumbnail').hover(
                    function () {
                        $(this).find('.caption').slideDown(250); 
                    },
                    function () {
                        $(this).find('.caption').slideUp(250);
                    }
            );
        </script>   

</body>