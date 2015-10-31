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
    <?php

    require_once 'app/controllers/Restaurant_controller.php';
    include 'header.php';
    $restaurant = new Restaurant_controller();
    $restaurant_array = $restaurant->index();
    $foodCategoryArray = $restaurant->getFoodCategories();
    ?>
    
    <div class="jumbotron jumbotron-banner">
        <br><br><br>
        <center><h4> This Web site is for SFSU CSC648/848 Software Engineering Project </h4></center>
        
        <form class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> <!-- Class for Search box -->

            <div class="input-group-btn"> <!-- Class for Dropdown Menu -->
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Food Type<span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#">All</a></li>
                    <?php
                    foreach ($foodCategoryArray as $foodCat) {
                        echo '<li><a href="#">' . $foodCat[0] . '</a></li><br>';
                    }
                    ?>
                </ul></div>  
            <input name="foodCategory" id="foodCategory" value="" hidden />
            <input type="text" class="form-control" name = "searchText" id="searchText" required placeholder="Search Address or Name of the Restaurants."/>
            <span class="input-group-btn">
                <input class="btn btn-default" value="Search" type="submit" name="submit"/>
            </span>
        </form> <!-- End of the Search box -->
    </div><!-- /.col-lg-6 -->


    <!-- 2nd Section of the Page (contains Ranking page & Events Page -->
    <div class ="container container_main">
    <div class = "row">
        <div class ="col-xs-6">
            <div class ="jumbotron jumbotron-Ranking">
                <center> <h2> Top Rated Restaurant </h2> </center>
                <div class="panel panel-default">

                    <?php
                    foreach ($restaurant_array as $restaurant) {
                        $image = base64_encode($restaurant['thumbnail']);
                        $image_src = "data:image/jpeg;base64," . $image;
                        //echo $image_src;  
                        ?>

                        <div class="panel-body"> <!-- Will work on the details later -->
                            <a href="#restaurant view page"> <img width="100" height="100" src="<?php print $image_src; ?>" /> </a>
                            <h3> <a href="#restaurant view page"> <?php echo $restaurant['name'] ?> </a> </h3>
                            <p> <?php echo $restaurant['address'] ?> </p>
                            <p>  <?php echo $restaurant['description'] ?> </p>
                            <a href="#reservation page" class="btn btn-info" role="button"> Reservation </a>
                        </div>

                        <?php
                    }
                    ?>

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
    </div>

<script>
        $(document).ready(function () {
            $(".dropdown-menu li a").click(function () {
                $(".btn.btn-default.dropdown-toggle").text($(this).text());
                $("input#foodCategory").val($(this).text());
            });
        });
    </script>
</body>
</html>