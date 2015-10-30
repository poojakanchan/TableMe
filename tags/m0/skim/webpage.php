<!DOCTYPE html>

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
    
    <style type ="text/css">
        
        .navbar-default {
            margin-bottom: 0px;
        }
        
        .jumbotron-banner {
            position: relative;
            width: 100%;
            height: 250px;
            background: url('banner.jpg') center center;
            background-size: cover;
            padding-right: 100px;
            padding-left: 100px;
            margin-bottom: 0px;       
        }
        
        .jumbotron-Ranking {
            padding-top: 5px;
            margin-top: 0px;
            background-color: white;
            //margin-right: 0px;
            
        }
        
        .jumbotron-Event {
            padding-top: 5px;
            margin-top: 0px;
            background-color: white;
            //margin-left: 0px;
            
        }
           
    </style>
    
</head>

<body>
    <!-- Navigation Bar -->
    <?php include('header.php');?>
    
    <div class="jumbotron jumbotron-banner">
        <br><br><br>
            <center><h4> This Website is for SFSU CSC648/848 Software Engineering Project </h4></center>
            <div class="input-group"> <!-- Class for Search box -->
                <div class="input-group-btn"> <!-- Class for Dropdown Menu -->                    
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Food Type <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#">American</a></li>
                        <li><a href="#">British</a></li>
                        <li><a href="#">Caribbean</a></li>
                        <li><a href="#">Chinese</a></li>
                        <li><a href="#">French</a></li>
                        <li><a href="#">Greek</a></li>
                        <li><a href="#">Indian</a></li>
                        <li><a href="#">Italian</a></li>
                        <li><a href="#">Japanese</a></li>
                        <li><a href="#">Mediterranean</a></li>
                        <li><a href="#">Mexican</a></li>
                        <li><a href="#">Moroccan</a></li>
                        <li><a href="#">Spanish</a></li>
                        <li><a href="#">Thai</a></li>
                        <li><a href="#">Turkish</a></li>
                        <li><a href="#">Vietnamese</a></li>
                    </ul></div>  
                <input type="text" class="form-control" name = "searchText" id="searchText" required placeholder="Search Address or Name of the Restaurants."/>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Search</button>
                </span>
            </div> <!-- End of the Search box -->
        </div><!-- /.col-lg-6 -->
        
        
        <!-- 2nd Section of the Page (contains Ranking page & Events Page -->
        <div class = "row">
            <div class ="col-xs-6">
                <div class ="jumbotron jumbotron-Ranking">
                <center> <h2> Top Rated Restaurant </h2> </center>
                <div class="panel panel-default">
                    <div class="panel-body"> <!-- Will work on the details later -->
                        <img src="#something" width="100" height="100"> <!-- Size of the profile pic can be smallar? -->
                        <h3> Name of the Restaurant </h3> 
                        <p> Address of the restaurant </p>
                        <p> Restaurant Detail?? <a href="#restaurant view page"> (View More) </a> </p>
                        <a href="#reservation page" class="btn btn-info" role="button"> Reservation </a>    
                    </div>
                </div>
                </div> <!-- End of Jumbotron -->
            </div>
            <div class ="col-xs-6">
                <div class ="jumbotron jumbotron-Event">
                <center> <h2> Upcoming Events </h2> </center> 
                <div class="panel panel-default">
                    <div class="panel panel-body">
                    <h3> Event Name at Restaurant Name </h3>
                    <p> Date: xx.xx.xx xx:xx-xx:xx </p>
                    <p> Address <a href="#restaurant view page"> (View More) </a> </p>
                    <a href="#reservation page" class="btn btn-info" role="button"> Reservation </a>
                    </div>
                </div>
                </div> <!-- End of Jumbotron -->
            </div>
        </div> <!-- End of 2nd Section -->
   
    
    
    
    
</body>