<?php

define("UPLOAD_MAX_SIZE", 2097152); //max image size: 2MB
define("DB_NAME", "student_hduan");
define("DB_USER", "hduan");
define("DB_PASSWORD", "duan1978");
define("DB_HOST", "localhost");
define("TABLE_NAME", "m0_table");
define("SMALL_RATIO", 0.1);
define("MEDIUM_RATIO", 0.4);

$target_dir = "uploads/";
$img_name = basename($_FILES["fileToUpload"]["name"]);
$imgFile = $target_dir . $img_name;
$imgFileSmall;
$imgFileMedium;
$uploadOk = 1;
$imgFileName = pathinfo($imgFile, PATHINFO_FILENAME);
$imgFileType = pathinfo($imgFile, PATHINFO_EXTENSION);
//connect to database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_error) {
    exit("Error: can't connect to database. " . mysql_error());
}

//check file size
if ($_FILES["fileToUpload"]["size"] > UPLOAD_MAX_SIZE) {
    echo "<p>Sorry, your file is too large.</p>";
    $uploadOk = 0;
}
//check for valid file upload
else if (!file_exists($_FILES['fileToUpload']['tmp_name']) ||
        !is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
    echo '<p>Sorry, please select a picture to upload</p>';
    $uploadOk = 0;
}
// Check if image file is a actual image or fake image
else if (@getimagesize($_FILES["fileToUpload"]["tmp_name"]) == false) {
    echo "<p>File is not an image.</p>";
    $uploadOk = 0;
}
// Check if file already exists
else if (file_exists($imgFile)) {
    echo "<p>Sorry, file already exists.</p>";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $imgFile)) {
        //echo "The file " . $img_name . " has been uploaded.";
        updateDB();
        resizeImg();
        displayImg();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

function updateDB() {
    global $img_name, $mysqli;
    $imgDescription = $_POST["imgDescription"];
    $sql = "INSERT INTO " . TABLE_NAME . "(name, description) "
            . "VALUES('$img_name', '$imgDescription')";
    if (!$mysqli->query($sql)) {
        exit("<p>Error querying database.");
    }
}

function resizeImg() {
    global $imgFile, $target_dir, $imgFileName, $imgFileSmall, $imgFileMedium, $imgFileType;
    list ($originalWidth, $originalHeight) = getimagesize($imgFile);
    $smallWidth = $originalWidth * SMALL_RATIO;
    $smallHeight = $originalHeight * SMALL_RATIO;
    $mediumWidth = $originalWidth * MEDIUM_RATIO;
    $mediumHeight = $originalHeight * MEDIUM_RATIO;
    $imgSmall = imagecreatetruecolor($smallWidth, $smallHeight);
    $imgMedium = imagecreatetruecolor($mediumWidth, $mediumHeight);
    $imgOriginal = imagecreatefromjpeg($imgFile);
    imagecopyresampled($imgSmall, $imgOriginal, 0, 0, 0, 0, $smallWidth, $smallHeight, $originalWidth, $originalHeight);
    imagecopyresampled($imgMedium, $imgOriginal, 0, 0, 0, 0, $mediumWidth, $mediumHeight, $originalWidth, $originalHeight);
    $imgFileSmall = $target_dir . $imgFileName . "_small." . $imgFileType;
    if (!imagejpeg($imgSmall, $imgFileSmall)) {
        echo "<p>Error: problem in creating small thumbnail.</p>";
        exit();
    }
    $imgFileMedium = $target_dir . $imgFileName . "_medium." . $imgFileType;
    if (!imagejpeg($imgMedium, $imgFileMedium)) {
        echo "<p>Error: problem in creating medium thumbnail.</p>";
        exit();
    }
}

function displayImg() {
    global $imgFile, $imgFileSmall, $imgFileMedium, $img_name, $mysqli;
    $sql = "SELECT description FROM " . TABLE_NAME . " WHERE id='" . $mysqli->insert_id . "'";
    $queryResult = $mysqli->query($sql);
    if (!$queryResult) {
        exit("<p>Error querying database.</p>");
    }
    $row = $queryResult->fetch_row();    
    echo "<h3>Image description: $row[0] </h3><br><br>";
    echo "<img src= $imgFile />";
    echo"<h3>$imgFile</h3><br>";
    echo "<img src=$imgFileMedium />";
    echo "<h3>$imgFileMedium</h3><br><br>";
    echo "<img src=$imgFileSmall />";
    echo "<h3>$imgFileSmall</h3>";
}

?>
