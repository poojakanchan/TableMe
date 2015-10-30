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

</head>
<body>
<?php
  //  $GLOBALS['__ROOT__'] = dirname(dirname(__FILE__));
   // echo $GLOBALS['__ROOT__'];
   include_once '/home/pkanchan/public_html/non-mvc/config.php';
   session_start();
   $_SESSION['ROOT'] = __DIR__;
   echo __DIR__;
   //echo $_SESSION['ROOT'];
    $res = 'app/controllers/Restaurant_controller.php';
    require_once $res;
   $restaurant = new Restaurant_controller();
    $restaurant_array =$restaurant->index();
?>
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
                        <li><a href="app/views/home/restaurant_registration.php">Restaurant</a></li>
                    </ul>
                    </li>
                    <li> <a href ="#login">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <img alt="Logo" src="http://lorempixel.com/140/140/" class="img-rounded" />

                <nav class="navbar navbar-default" role="navigation">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Please Choose Type of food<strong class="caret"></strong></a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li>
                                        <a href="#1">American food</a>
                                    </li>
                                    <li>
                                        <a href="#2">Italian</a>
                                    </li>
                                    <li>
                                        <a href="#3">Chinese</a>
                                    </li>
                                    <li>
                                        <a href="#4">Japanese</a>
                                    </li>
                                    <li>
                                        <a href="#2">Fast food</a>
                                    </li>
                                    <li>
                                        <a href="#2">Middle eastern</a>
                                    </li>
                                    <li>
                                        <a href="#2">All</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <form class="navbar-form navbar-left" role="search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchText" id="searchText" required/>
                            </div> 
                            <button type="submit" class="btn btn-default">
                                Search
                            </button>
                        </form>
                    </div>
                </nav>


                <br>
                <?php
                        foreach ($restaurant_array as $restaurant) {
                            $image = base64_encode($restaurant['thumbnail']);
                            $image_src = "data:image/jpeg;base64," . $image;
                            //echo $image_src;  
                            ?>
                            <div class="media well">
                                <a href="#" class="pull-left"><img height="50" width ="50" alt="Bootstrap Media Preview" src="<?php print $image_src; ?>" class="media-object" /></a>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $restaurant['name'] ?></h4>
                                    <?php echo $restaurant['address'] ?>
                                </div>
                            </div>
                            <?php
                        }
                ?>
                <div class="media well" hidden>
                    <a href="#" class="pull-left"><img class="media-object" height="80" width="80"/></a>
                    <div class="media-body">
                        <h4 class="media-heading"></h4>
                        <p class="address"></p>
                        <p class="category"></p>
                    </div>
                </div>

                <ol class="list-unstyled">
                    <li>
                        Special Event 1
                    </li>
                    <li>
                        Special Event 2
                    </li>
                    <li>
                        Special Event 3
                    </li>
                </ol>

            </div>
        </div>
    </div>

   
    <div class = "Footer">
        <div class ="panel panel-default">
            <div class ="panel-body"> This website belongs to SFSU Course CSC648/CSC848 Fall 15 Group 11 </div>
        </div>
    </div>
    
    
</body>
</html>