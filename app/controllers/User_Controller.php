<?php

/*
 * class to handle http requests related to user.
 */

require_once 'Controller.php';
require_once __DIR__ . '/../models/Reservation_model.php';
require_once __DIR__ . '/../models/User_model.php';

class User_controller extends Controller {
    /*
     *  function to handle user registration. It collects all the post variables and
     *  call database function to store login details and user details. 
     */

    public function registerUser() {
        if (isset($_POST['submit'])) {

            //retrive post variables.
            $username = htmlspecialchars($_POST["userUsername"]);
            $password = htmlspecialchars($_POST["userPassword"]);


            $phone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["userPhone"]));
            $name = htmlspecialchars($_POST["userFirstName"]) . " " . htmlspecialchars($_POST["userLastName"]);
            $email = htmlspecialchars($_POST["userEmail"]);

            // call to database function.
            $userModel = $this->model('User_model');
            if ($userModel->addUser($name, $phone, $email, $username, $password) > 0) {
                $success = 'success';
                header("Location:login.php/?message=" . $success);
            } else {
                echo "<p style=\"color:red;text-align:center;font-weight: bold\">Error occured while registestration,Please select different username.</p>";
            }
        }
    }

}

/*
 * for servicing Ajax requests
 */
if (isset($_GET['functionName'])) {
    $reservationDB = new Reservation_model();
    $userDb = new User_model();
    $result = array();
    switch ($_GET['functionName']) {
        case 'cancelReservation':
            if (!isset($_GET['reservationId'])) {
                $result['error'] = 'No reservation Id specified!';
                break;
            }
            $delete = $reservationDB->deleteReservation($_GET['reservationId']);
            if ($delete != null) {
                $result['success'] = '1';
            } else {
                $result['error'] = "Error deleting reservation with id=" + $_GET['reservationId'] + "from database";
            }
            break;

        case 'submitReview':
            if (!isset($_GET['restaurantId']) || !isset($_GET['userId']) || !isset($_GET['reviewText'])) {
                $result['error'] = 'Missing restaurant id, user id or review text!';
                break;
            }
            $review = $userDb->submitReview($_GET['restaurantId'], $_GET['userId'], $_GET['reviewText']);
            if ($review) {
                $result['success'] = '1';
                $result['dateTime'] = $review;
            } else {
                $result['error'] = "Error submitting review to database";
            }
            break;

        default:
            $result['error'] = 'Not found function ' . $_GET['functionName'] . '!';
            break;
    }
    header("Content-Type: application/json");
    echo json_encode($result);
}
?>