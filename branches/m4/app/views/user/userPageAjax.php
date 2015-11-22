<?php
header("Content-Type: application/json");
require_once '../../models/Reservation_model.php';

$reservationDB = new Reservation_model();

$result = array();
if (isset($_GET['functionName']) && isset($_GET['args'])) {
    switch ($_GET['functionName']) {
        case 'cancelReservation':
            $delete = $reservationDB->deleteReservation($_GET['args']);
            if ($delete != null) {
                $result['success'] = '1';
            }
            else {
                $result['error'] = "Error deleting reservation with id=" + $_GET['args'] + "from database";
            }
            break;
        case 'addReview':
            
            break;
        default:
            $result['error'] = 'Not found function '.$_GET['functionName'].'!';
            break;
    }
}
else {
    $result['error'] = 'No function name or arguments!';
}

echo json_encode($result);

?>
