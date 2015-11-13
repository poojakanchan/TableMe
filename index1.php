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
    require_once 'app/models/Restaurant_model.php';
    require_once 'app/models/Event_model.php';
    include 'header.php';
    
    define ("N_PER_PAGE", 5); //number of restaurants to display per page
    $db;$restaurant_array; $foodCategoryArray; $restaurantListTitle;
    $nameAddCat = $category = '%';
    $totalCount = 0; //total count of restaurants to display
    $currentPage = $numberOfPages = $startPage = 1; //page number for navigating search results
    if (!isset($db)) {
        $db = new Restaurant_model();
    }

    if (empty($foodCategoryArray)) {
        $foodCategoryArray = $db->getFoodCategories();
    }

    if ($_GET) {
        $nameAddCat = (empty($_GET['searchText']) ? '%' : htmlspecialchars($_GET['searchText']));
        $category = (empty($_GET['foodCategory']) ? '%' : htmlspecialchars($_GET['foodCategory']));
        $currentPage = (isset($_GET['pgnum']) ? htmlspecialchars($_GET['pgnum']) : 1);
        $totalCount = $db->findRestaurantsCount($nameAddCat, $category);
        $restaurant_array = $db->findRestaurantsLimitOffset($nameAddCat, $category, N_PER_PAGE, ($currentPage-1)*N_PER_PAGE);
        if ($nameAddCat=='%' && $category=='%') {
            $restaurantListTitle = "All Restaurants (" . $totalCount . " total)";
        }
        else {
            $restaurantListTitle = "Your search found " . $totalCount . ($totalCount > 1 ? " restaurants" : " restaurant");
        }
    } 
    else {
        $totalCount = $db->getAllRestaurantsCount();
        $restaurantListTitle = "All Restaurants (" . $totalCount . " total)";
        if ($totalCount > N_PER_PAGE) {
            $restaurant_array = $db->getAllRestaurantsLimitOffset(N_PER_PAGE, 0);
        }
    }
    
    $numberOfPages = (int) ceil($totalCount/N_PER_PAGE);
    
    if ($currentPage <= 5) {
        $startPage = 1;
    }
    else if ($currentPage > $numberOfPages-4) {
        $startPage = ($numberOfPages-8<1 ? 1 : $numberOfPages-8);
    }
    
    $pageArray = array();    
    for ($i=0; $i<9 && $i<$numberOfPages; $i++) {
        $pageArray[$i] = $startPage++;
    }
    
    //populates event array
    $db = new Event_model();
    $eventArray = $db->getAllEvents();
    
    ?>

    <div class="jumbotron jumbotron-banner">
        <br><br><br>
        <center><h4> This Web site is for SFSU CSC648/848 Software Engineering Project </h4></center>

        <form class="input-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get"> <!-- Class for Search box -->

            <div class="input-group-btn"> <!-- Class for Dropdown Menu -->
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo ($category==='%' ? "Food Type " : $category." ") ?><span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#">All</a></li>
                    <?php
                    foreach ($foodCategoryArray as $foodCat) {
                        echo '<li><a href="#">' . $foodCat[0] . '</a></li>';
                    }
                    ?>
                </ul></div>  
            <input name="foodCategory" id="foodCategory" value="" hidden />
            <input type="text" class="form-control" name = "searchText" id="searchText" required placeholder="Search Address or Name of the Restaurants." value="<?php echo($nameAddCat==='%' ? "" : $nameAddCat);?>"/>
            <span class="input-group-btn">
                <input class="btn btn-default" type="submit" value="Search" />
            </span>
        </form> <!-- End of the Search box -->
    </div><!-- /.col-lg-6 -->

    <!-- 2nd Section of the Page (contains Ranking page & Events Page -->
    <div class ="container container_main">
        <div class = "row">
            <div class ="col-xs-6">
                <div class ="jumbotron jumbotron-Ranking">
                    <center> <h2> <?php echo $restaurantListTitle ?> </h2> </center>
                    <div class="panel panel-default">

                        <?php
//                         echo '<br><br><br><br>'.var_dump($nameAdd).'<br>'.var_dump($category).'<br>'.var_dump($currentPage).'<br>'.var_dump($totalCount);
                        foreach ($restaurant_array as $restaurant) {
                            $image = base64_encode($restaurant['thumbnail']);
                            $image_src = "data:image/jpeg;base64," . $image;
                            //echo $image_src;  
                            ?>

                            <div class="panel-body"> <!-- Will work on the details later -->
                                <a href="#restaurant view page"> <img width="100" height="100" src="<?php print $image_src; ?>" /> </a>
                                <h3>  <a  href="<?php echo 'app/views/home/restaurant.php?resid=' . $restaurant['restaurant_id'] ?>" > <?php echo $restaurant['name'] ?> </a> </h3>
                                <p> <?php echo $restaurant['address'] ?> </p>
                                <p>  <?php echo $restaurant['description'] ?> </p>
                                <a href="#reservation page" class="btn btn-info" role="button"> Reservation </a>
                            </div>

                            <?php
                        }
                        ?>
                        
                    </div>
                    <?php
                    if ($numberOfPages > 1) {
                        echo '<ul class="pagination pagination-lg">';
                        
                        if ($currentPage==1) {
                            echo '<li class="disabled"><a href="#">&laquo;</a></li>';
                        }
                        else {
                            echo '<li><a href="index.php?searchText='.$nameAddCat.'&foodCategory='.$category.'&pgnum='.($currentPage-1).'">&laquo;</a></li>';
                        }
                        
                        for ($i=0; $i<9 && $i<$numberOfPages; $i++) {
                            if ($pageArray[$i] == $currentPage) {
                                echo '<li class="active"><a href="index.php?searchText='.$nameAddCat.'&foodCategory='.$category.'&pgnum='.$pageArray[$i].'">'. $pageArray[$i] . '</a></li>';
                            }
                            else {
                                echo '<li><a href="index.php?searchText='.$nameAddCat.'&foodCategory='.$category.'&pgnum='.$pageArray[$i].'">'. $pageArray[$i] . '</a></li>';
                            }
                        }
                        
                        if ($currentPage==$numberOfPages) {
                            echo '<li class="disabled"><a href="#">&raquo;</a></li>';
                        }
                        else {
                            echo '<li><a href="index.php?searchText='.$nameAddCat.'&foodCategory='.$category.'&pgnum='.($currentPage+1).'">&raquo;</a></li>';
                        }
                        
                        echo '</ul>';
                    }
                    ?>
<!--                    <ul class="pagination pagination-lg">
                            <li><a href="#">&laquo;</a></li>
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                            <li><a href="#">&raquo;</a></li>
                        </ul>-->
                </div> <!-- End of Jumbotron -->
                
            </div>
            <div class ="col-xs-6">
                <div class ="jumbotron jumbotron-Event">
                    <center> <h2> Upcoming Events </h2> </center> 
                    <div class="panel panel-default">
                        <?php
                        foreach ($eventArray as $event) {
                            $image = base64_encode($event['event_photo']);
                            echo '<div class="panel panel-body">';
                            echo '<a href="app/views/home/restaurant.php?resid='. $event['restaurant_id'] . '"> <img width="200" height="auto" src="data:image/jpeg;base64,' . $image . '"/></a>';
                            echo '<a href="app/views/home/restaurant.php?resid='. $event['restaurant_id'] . '"> <h3>' . $event['name'] . '</h3></a>';
                            echo '<p>' .$event['date'] . '</p>';
                            echo '<p>' . $event['description'] . '</p>';
                            echo '<a href="#reservation page" class="btn btn-info" role="button"> Reservation </a>';
                            echo '</div>';
                        }
                        ?>
<!--                        <div class="panel panel-body">
                            <h3> Event Name at Restaurant Name </h3>
                            <p> Date: xx.xx.xx xx:xx-xx:xx </p>
                            <p> Address <a href="#restaurant view page"> (View More) </a> </p>
                            <a href="#reservation page" class="btn btn-info" role="button"> Reservation </a>
                        </div>-->
                    </div>
                </div> <!-- End of Jumbotron -->
            </div>
        </div> <!-- End of 2nd Section -->
    </div>

    <script>
        $(document).ready(function () {
            initDropdownMenu();
        });
        var initDropdownMenu = function() {
            $("input#foodCategory").val("<?php echo $category; ?>");
            $(".input-group").find(".dropdown-menu li a").click(function () {
                var text = $(this).text();
                $(".btn.btn-default.dropdown-toggle").text(text);
                $("input#foodCategory").val(text==="All" ? "%" : text);
            });
        }
    </script>
    
</body>
</html>