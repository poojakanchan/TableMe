<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'Controller.php';
require_once __DIR__ . '/../models/Restaurant_model.php';
require_once __DIR__ . '/../models/Owner_model.php';
require_once __DIR__ . '/../models/Event_model.php';
require_once __DIR__ . '/../models/Hostess_model.php';
require_once __DIR__ . '/../models/Login_model.php';
require_once __DIR__ . '/../models/OperationHours_model.php';

$username = $_SESSION['username'];
$ownerDb = new Owner_model();
$ownerInfo = $ownerDb->getOwnerInfo($username);
$resId = intval($ownerInfo['restaurant_id']);
$restaurantDb = new Restaurant_model();
$restaurantInfo = $restaurantDb->findRestaurantById($resId);
$restaurantImages = $restaurantDb->getRestaurantImages($resId);
$imageCount = count($restaurantImages) >= 4 ? 4 : count($restaurantImages); //total number of images for the restaurant in multimedia table
$foodCategory = $restaurantDb->getFoodCategories();
$reviewArray = $restaurantDb->getRestaurantReviews($resId);

$oprDb = new OperationHours_model();
$oprHours = $oprDb->getOperatingHoursByRestaurantId($resId);

$eventDb = new Event_model();
$eventArray = $eventDb->getEventsByRestaurantId($resId);

$hostessDb = new Hostess_model();
$hostessArray = $hostessDb->getHostessByRestaurantId($resId);

$loginDb = new Login_model();
$existingUsernames = $loginDb->getAllUsernames();

if (!empty($oprHours)) {
    $oprHours = $oprHours[0];
}

if ($_POST) {
    
    /*
     * For uploading images
     */
    if (isset($_POST['image_type'])) {
        switch ($_POST['image_type']) {
            case 'profile':
                if (is_uploaded_file($_FILES['profile-image']['tmp_name'])) {
                    $thumbnail = file_get_contents($_FILES["profile-image"]["tmp_name"]);
                }
                if ($restaurantDb->updateRestaurantThumbnail($resId, $thumbnail)) {
                    $restaurantInfo = $restaurantDb->findRestaurantById($resId);
                }
                break;
            case 'multimedia':
                if (is_uploaded_file($_FILES['multimedia-image']['tmp_name'])) {
                    $img = file_get_contents($_FILES["multimedia-image"]["tmp_name"]);
                    if ($restaurantDb->updateMultimedia($_POST['multimedia-id'], $img, $resId)) {
                        $restaurantImages = $restaurantDb->getRestaurantImages($resId);
                        $imageCount = count($restaurantImages) >= 4 ? 4 : count($restaurantImages);
                    }
                }
                break;
            case 'menu':
                if (is_uploaded_file($_FILES['menu-image']['tmp_name'])) {
                    $menu = file_get_contents($_FILES["menu-image"]["tmp_name"]);
                }
                if ($restaurantDb->updateRestaurantMenu($resId, $menu)) {
                    $restaurantInfo = $restaurantDb->findRestaurantById($resId);
                }
                break;
        }
    }
    
    /**
     * For adding event
     */
    if (isset($_POST['add-event'])) {
        if (is_uploaded_file($_FILES['add-event-image']['tmp_name'])) {
            $eventImage = file_get_contents($_FILES["add-event-image"]["tmp_name"]);
        }
        $newEvent = array('resId' => $resId,
            'title' => $_POST["add-event-name"],
            'desc' => $_POST['add-event-description'],
            'date' => $_POST['add-event-date'],
            'photo' => $eventImage);
        $eventDb->addEvent($newEvent);
        $eventArray = $eventDb->getEventsByRestaurantId($resId);
    }
    
    /*
     * For servicing Ajax requests
     */
    if (isset($_POST['functionName'])) {
        $result = array();
        switch ($_POST['functionName']) {
            case 'updateRestaurant':
                if (isset($_POST['restaurantId']) && isset($_POST['description']) && isset($_POST['address']) && isset($_POST['phoneNum'])) {
                    if ($restaurantDb->updateRestaurant($_POST['restaurantId'], $_POST['description'], $_POST['address'], $_POST['phoneNum'])) {
                        $result['success'] = '1';
                    } else {
                        $result['error'] = 'failed to update restaurant';
                    }
                } else {
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
                    } else {
                        $result['error'] = 'failed to update restaurant';
                    }
                } else {
                    $result['error'] = 'parameters not set';
                }
                break;
            case 'removeEvent':
                if (isset($_POST['eventId'])) {
                    if ($eventDb->removeEvent($_POST['eventId'])) {
                        $result['success'] = '1';
                    } else
                        $result['error'] = 'failed to delete event';
                }
                else {
                    $result['error'] = 'event id not set';
                }
                break;
            case 'removeHostess':
                if (isset($_POST['hostessUsername'])) {
                    if ($hostessDb->removeHostess($_POST['hostessUsername'])) {
                        if ($loginDb->removeLogin($_POST['hostessUsername'])) {
                            $result['success'] = '1';
                        } else
                            $result['error'] = 'failed to delete login';
                    } else
                        $result['error'] = 'failed to delete hostess';
                }
                else {
                    $result['error'] = 'parameters not set';
                }
                break;
            case 'addHostess':
                if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['restaurantId'])) {
                    if ($loginDb->addLogin($_POST['username'], $_POST['password'], 'host')) {
                        if ($hostessDb->addHostess($_POST['username'], $_POST['restaurantId'])) {
                            $result['success'] = '1';
                        } else
                            $result['error'] = 'failed to add host';
                    } else
                        $result['error'] = 'failed to add login';
                }
                else {
                    $result['error'] = 'parameters not set';
                }
                break;
        }
        header("Content-Type: application/json");
        echo json_encode($result);
    }
}

?>