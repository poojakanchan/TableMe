<html lang="en">
<head>
	<title>EZ Restaurant</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
    
    <?php
        require_once __DIR__ . '/../../../header.php';
        require_once __DIR__ . '/../../models/Restaurant_model.php';
        $db = new Restaurant_model();
        $resId = (array_key_exists('resid', $_GET) ? htmlspecialchars($_GET['resid']) : 0);
        $restaurant = $db->findRestaurantById($resId);
        $resName = $restaurant[0]['name'];
        $foodCategory = $restaurant[0]['food_category_name'];
        $description = $restaurant[0]['description'];
        $imgArray = $db->getRestaurantImages($resId);
        $n = count($imgArray);
        $i = 0;
        $srcStr= "data:image/jpeg;base64,";
    ?>
    
    <div class="container-fluid">
        <div class="mainInfo col-md-8">
            <div class="restaurantprofile col-md-12">
                <div class="restaurantpic col-md-4">
                    <img src="<?php echo $i<$n ? $srcStr.base64_encode($imgArray[$i]["media"]) : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="200" width="200" />
                </div>
                <div class="restaurantname col-md-8">
                    <h1><?php echo $resName; ?></h1>
                    <h2><?php echo "Food category: " . $foodCategory; ?></h2>
                    <p><?php echo $description; ?></p>
                </div>
            </div>
            
            <div class="col-md-12">
		<br>
		<img src="<?php echo $i<$n ? $srcStr.base64_encode($imgArray[$i]["media"]) : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="75" width="75"/>
                <img src="<?php echo $i<$n ? $srcStr.base64_encode($imgArray[$i]["media"]) : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="75" width="75"/>
                <img src="<?php echo $i<$n ? $srcStr.base64_encode($imgArray[$i]["media"]) : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="75" width="75"/>
                <img src="<?php echo $i<$n ? $srcStr.base64_encode($imgArray[$i]["media"]) : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="75" width="75"/>
                <img src="<?php echo $i<$n ? $srcStr.base64_encode($imgArray[$i]["media"]) : "http://goo.gl/vrq2Cw"; $i++; ?>" class="img-rounded" height="75" width="75"/>
		<br><br>
            </div>
            
            <div class="col-md-12">
		<div class="panel panel-default">
                    <div class="panel-heading">
			<a class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-721564" href="#panel-element-860877">Menu</a>
                    </div>
                    <div id="panel-element-860877" class="panel-collapse collapse">
			<div class="panel-body">We will show the menu here!</div>
                    </div>
		</div>
            </div>
            
            <div class="col-md-12">
                <h1>Make a Reservation!</h1>
                
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                      <!-- Brand and toggle get grouped for better mobile display -->
                      <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                          <span class="sr-only">Toggle navigation</span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                          <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Choose: </a>
                      </div>

                      <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                          <li class="dropdown month">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Month<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="#">1</a></li>
                              <li><a href="#">2</a></li>
                              <li><a href="#">3</a></li>
                            </ul>
                          </li>
                          <li class="dropdown day">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Day<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="#">25</a></li>
                              <li><a href="#">26</a></li>
                              <li><a href="#">27</a></li>
                            </ul>
                          </li>
                          <li class="dropdown time">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Time<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="#">25</a></li>
                              <li><a href="#">26</a></li>
                              <li><a href="#">27</a></li>
                            </ul>
                          </li>
                          <li class="dropdown numberofguest">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Number of guests<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                              <li><a href="#">1</a></li>
                              <li><a href="#">2</a></li>
                              <li><a href="#">3</a></li>
                              <li><a href="#">4</a></li>
                            </ul>
                          </li>
                        </ul>
                        <form class="navbar-form navbar-left reserve" role="search">
                          <button type="submit" class="btn btn-default">Reserve</button>
                        </form>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
                
            </div>
            <br><br><br><br><br>
            <div class="userreview col-md-12">
                <h1>Reviews</h1>
                <div class="media">
                    <a class="media-left" href="#">
                        <img src="https://goo.gl/GOzAhf" alt="user" height="50" width="50">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Larry</h4>
                        <p>I like this restaurant!</p>
                    </div>
                </div>
                <div class="media">
                    <a class="media-left" href="#">
                        <img src="https://goo.gl/GOzAhf" alt="user" height="50" width="50">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">Potter</h4>
                        <p>I like this restaurant too!</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="specialEvent col-md-4">
            <p>This is the special event info</p>
            <div class="list-group">
                <a href="#" class="list-group-item">Band perform</a>
                <a href="#" class="list-group-item">Dancing</a>
                <a href="#" class="list-group-item">Conference meeting</a>
                <a href="#" class="list-group-item">Happy hour</a>
            </div>
        </div>
    </div>

    <div class = "navbar navbar-default navbar-bottom">
        <div class = "container">
            <p class="navbar-text navbar-left">This website belongs to SFSU Course CSC648/CSC848 Fall 15 Group 11</p>
        </div>
    </div>
    
    
</body>
</html>