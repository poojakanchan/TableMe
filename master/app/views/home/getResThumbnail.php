<?php
include './DBFunctions.php';

$rowId = $_GET['rowId'];

if (!empty($rowId)){
    $db = new DB();
    $result = $db->getRestaurantThumbnail($rowId);
    echo $result[0];
    $db = null;
}

?>