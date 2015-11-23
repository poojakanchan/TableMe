<?php
header("Content-Type: application/json");
require_once '../../models/Reservation_model.php';
require_once '../../models/User_model.php';

$reservationDB = new Reservation_model();
$userDb = new User_model();

$result = array();
if (isset($_GET['functionName'])) {
    switch ($_GET['functionName']) {
        case 'cancelReservation':
            if (!isset($_GET['reservationId'])) {
                $result['error'] = 'No reservation Id specified!';
                break;
            }
            $delete = $reservationDB->deleteReservation($_GET['reservationId']);
            if ($delete != null) {
                $result['success'] = '1';
            }
            else {
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
            }
            else {
                $result['error'] = "Error submitting review to database";
            }
            break;
        
        default:
            $result['error'] = 'Not found function '.$_GET['functionName'].'!';
            break;
    }
}
else {
    $result['error'] = 'No function name!';
}

echo json_encode($result);

?>
