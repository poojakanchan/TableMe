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
    include('header.php');
    ?>
   
    <!-- <nav class ="navbar navbar-default navbar-fixed-top">
        <div class ="container-fluid">
            <div class ="navbar-header">
                <a class="navbar-brand" href="homepage.php">EZ Restaurant</a>
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
    </nav> -->
    
    <br> <br> <br>
    <div class="container">
        <div class="jumbotron">
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Food Type <span class="caret"></span></button>
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
                <input type="text" class="form-control" name = "searchText" id="searchText" required placeholder="Search Address or Keyword of the Restaurants."/>
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Search</button>
                </span>
            </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
    </div><!-- /.row -->  


    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <nav class="navbar navbar-default" role="navigation">
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Please Choose Type of food<strong class="caret"></strong></a>
                                <ul class="dropdown-menu" role="menu">
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
                                </ul>
                            </li>
                        </ul>
                        <form class="navbar-form navbar-left" role="search" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="searchText" id="searchText" required/>
                            </div> 
                            <button type="submit" class="btn btn-default">
                                Search
                            </button>
                        </form>
                    </div>
                </nav>

                <?php
                include './DBFunctions.php';
                if (!$_POST) {
                    $db = new DB();
                    $result = $db->getAllRestaurants();
                    if (!empty($result)) {
                        foreach ($result as $restaurant) {
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
                    }
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

        <?php
        $result;
        if ($_POST) {
            $nameAdd = htmlspecialchars($_POST["searchText"]);
            $db = new DB();
            $result = $db->findRestaurantsByNameAddress($nameAdd);
        }
        ?>

        <?php if ($_POST && !empty($result)): ?>
            <script>
                $("div.media.well").each(function () {
                    $(this).hide();
                });
                var resultArray = <?php echo json_encode($result) ?>; //getting php array into js
                for (var i = 0; i < resultArray.length; i++) {

                    var lastItem = $("div.media.well").last();
                    var clone = lastItem.clone();
                    clone.find("h4").text(resultArray[i]['name']).siblings("p.address").text(resultArray[i]['address'])
                            .siblings("p.category").text(resultArray[i]['food_category_name']);
                    var imgSrc = "getResThumbnail.php?rowId=" + resultArray[i]['restaurant_id'];
                    clone.find("img.media-object").attr("src", imgSrc);
                    lastItem.before(clone.show());
                }


            </script>
        <?php endif ?>

        <div class = "navbar navbar-default navbar-fixed-bottom">
            <p class="navbar-text"> <center>This website belongs to SFSU Course CSC648/CSC848 Fall 15 Group 11</center> </p>
        </div>

</body>
</html>