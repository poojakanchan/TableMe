<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    </head>
    <body>
        <nav class ="navbar navbar-default">
            <div class ="container-fluid">
                <div class ="navbar-header">
                    <a class="navbar-brand" href="homepage.php">TableMe</a>
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
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-md-offset-5 col-md-3">
                    <div class="form-login">
                        <h4>Welcome back.</h4>
                        <input type="text" id="userName" class="form-control input-sm chat-input" placeholder="username" />
                        </br>
                        <input type="text" id="userPassword" class="form-control input-sm chat-input" placeholder="password" />
                        </br>
                        <div class="wrapper">
                            <span class="group-btn">     
                                <a href="#" class="btn btn-primary btn-md">login <i class="fa fa-sign-in"></i></a>
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </body>
</html>









