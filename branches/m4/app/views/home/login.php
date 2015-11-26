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
        <?php
        include 'header.php';
        require_once '../../models/Login_model.php';
        $db = new Login_model();
        $incorrectLogin = false;
        $loginRole;
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $loginRole = $db->validateLogin($username, $password);
//          var_dump($loginRole);
//          exit();
            if (!$loginRole) {
                $incorrectLogin = true;
            } else {
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['username'] = $username;
                switch ($loginRole['role']) {
                    case "user":
                        $_SESSION['role'] = "user";
                        header('location: ../../../index.php');
                        break;
                    case "owner":
                        $_SESSION['role'] = "owner";
                        header('location: ../owner/ownerpage.php');
                        break;
                    case "host":
                        $_SESSION['role'] = "host";
                        header('location: ../host/hostview.php');
                        break;
                    case "admin":
                        $_SESSION['role'] = "admin";
                        header('location: ../admin/adminpage.php');
                        break;
                }
                
            }
        }

        $msg = (array_key_exists('message', $_GET) ? htmlspecialchars($_GET['message']) : '');

        if ($msg == 'success') {
            echo "<p style=\"color:green;text-align:center;font-weight:bold\"> Registration is successful!</p>"
            . " <p style=\"text-align:center;font-weight: bold\">Please login to continue.</p>";
        }
        ?>

        <div class="container">
            <div class="row">
                <div class="col-md-offset-5 col-md-3">
                    <div class="form-login">
<?php
if ($incorrectLogin) {
    echo '<h4 style="color:red">Incorrect login information</h4>';
} else {
    echo '<h4>Welcome back</h4>';
}
?> 
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="text" id="username" name="username" class="form-control input-sm chat-input" placeholder="username" required />
                            <br>
                            <input type="password" id="password" name="password" class="form-control input-sm chat-input" placeholder="password" required/>
                            <br>
                            <div class="wrapper">
                                <span class="group-btn">     
                                    <button type="submit" class="btn btn-primary btn-md" value="login">Login <i class="fa fa-sign-in"></i></button>
                                </span>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </body>
</html>









