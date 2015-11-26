<?php

header("Content-Type: application/json");
require_once '../../models/Restaurant_model.php';
require_once '../../models/Owner_model.php';

$restaurantDb = new Restaurant_model();
$ownerDb = new Owner_model();

$result = array();

if (isset($_POST['functionName'])) {
    switch ($_POST['functionName']) {
        case 'updateRestaurant':
            if (isset($_POST['restaurantId']) && isset($_POST['description']) && isset($_POST['address']) && isset($_POST['phoneNum'])) {
                if ($restaurantDb->updateRestaurant($_POST['restaurantId'], $_POST['description'], $_POST['address'], $_POST['phoneNum'])) {
                    $result['success'] = '1';
                }
                else {
                    $result['error'] = 'failed to update restaurant';
                }
            }
            else {
                $result['error'] = 'parameters not set';
            }
            break;
        case 'updateOperatingHours':
            if ($restaurantDb->updateOperatingHours($_POST)) {
                $result['success'] = '1';
            } else {
                $result['error'] = 'failed to updating operating hours';
            }
            break;
        case 'changeOwnerProfile':
            if (isset($_POST['username']) && isset($_POST['phoneNum']) && isset($_POST['email'])) {
                $password = isset($_POST['password']) ? $_POST['password'] : null;
                if ($ownerDb->updateOwnerProfile($_POST['username'], $_POST['phoneNum'], $_POST['email'], $password)) {
                    $result['success'] = '1';
                }
                else {
                    $result['error'] = 'failed to update restaurant';
                }
            }
            else {
                $result['error'] = 'parameters not set';
            }
    }
}
else {
    $result['error'] = 'no function name';
}


echo json_encode($result);
?>

