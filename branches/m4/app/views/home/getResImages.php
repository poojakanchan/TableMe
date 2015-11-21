<?php
session_start();
require_once '../../models/Restaurant_model.php';
$db = new Restaurant_model();

//echo '<br><br><br>in getResImages.php';
//exit();

$resId = intval(htmlspecialchars($_GET['resId']));
$offset = intval(htmlspecialchars($_GET['offset']));
if (isset($_SESSION['resId'])) {
    if ($resId != intval($_SESSION['resId'])) { //different resId, get new image array
        $_SESSION['resId'] = $resId;
        $_SESSION['resImages'] = $db->getRestaurantImages($resId);
    }
}
else { //resId not set yet
    $_SESSION['resId'] = $resId;
    $_SESSION['resImages'] = $db->getRestaurantImages($resId);
}

$image = $_SESSION['resImages'][$offset]['media'];

//var_dump($resId);
//echo'<br>'; var_dump($offset); echo'<br>'; var_dump($image); exit();

header('Content-Type: image/jpeg');
echo $image;

?>