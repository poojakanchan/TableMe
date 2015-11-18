<?php
require_once '../../models/Restaurant_model.php';
$db = new Restaurant_model();

//echo '<br><br><br>in getResImages.php';
//exit();

$resId = intval(htmlspecialchars($_GET['resId']));
$offset = intval(htmlspecialchars($_GET['offset']));
$image = $db->getRestaurantImageWithOffset($resId, $offset); // your code to fetch the image

//var_dump($resId);
//echo'<br>'; var_dump($offset); echo'<br>'; var_dump($image); exit();

header('Content-Type: image/jpeg');
echo $image[0];

?>