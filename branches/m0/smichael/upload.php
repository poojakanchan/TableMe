<?php
$target_dir = "uploads/";
$nameOfImg = basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $nameOfImg;
$uploadOk = 1;
$imageFileName = pathinfo($target_file, PATHINFO_FILENAME);
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

$servername = "sfsuswe.com";
$username = "sabreenm";
$password = "911657310";
$database = "student_sabreenm";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connect failed: ".$conn->connect_error);
}

// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    if(isset($_POST["description"])) {
        $desc = $_POST["description"];
    }
    else { 
            $desc = NULL;
    }
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size 
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error 
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
            database();
            resize();
            uploaded();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

function resize() {
    global $smallName, $mediumName, $target_file, $target_dir, $imageFileName, $imageFileType;
    list ($widthO, $heightO) = getimagesize($target_file);
    
    switch($imageFileType){
        case 'jpeg':
        case 'jpg':
            $original = imagecreatefromjpeg($target_file);
            break;
        case 'png':
            $original = imagecreatefrompng($target_file);
            break;
        case 'gif':
            $original = imagecreatefromgif($target_file);
            break;
        default:
            echo("Sorry, only JPG, JPEG, PNG & GIF files are allowed");
            break; 
    }
    
    $widthS = $widthO / 5;
    $widthM = $widthO / 2;
    
    $heightS = $heightO / 5;
    $heightM = $heightO / 2;
    
    $mediumImage = imagecreatetruecolor($widthM, $heightM);
    imagecopyresampled($mediumImage, $original, 0, 0, 0, 0, $widthM, $heightM, $widthO, $heightO);
    $mediumName = $target_dir . $imageFileName . "MEDIUM." . $imageFileType;
    
    $smallImage = imagecreatetruecolor($widthS, $heightS);
    imagecopyresampled($smallImage, $original, 0, 0, 0, 0, $widthS, $heightS, $widthO, $heightO);
    $smallName = $target_dir . $imageFileName . "SMALL." . $imageFileType;
    
    if (imagejpeg($smallImage, $smallName) == false) {
        echo "Error in creation of image.";
        exit();
    }
    
    if (imagejpeg($mediumImage, $mediumName) == false) {
        echo "Error in creation of image.";
        exit();
    }
}

function uploaded() {
    global $target_file, $smallName, $mediumName, $nameOfImg, $conn;
    $sql = "SELECT description FROM images WHERE id='" . $conn->insert_id . "'";
    $queryResult = $conn->query($sql);
    $row = $queryResult->fetch_row();
    
    echo "<h1 align=\"center\">Image Resizing</h1>";
    echo "<h4 align=\"center\">Description: $row[0] </h4>";
    echo"<h4>This is the original sized image:</h4>";
    echo"<p>$nameOfImg</p>";
    echo "<img src= $target_file />";
    
    echo "<h4>This is the medium sized image:</h4>";
    echo"<p>$mediumName</p>";
    echo "<img src=$mediumName />";
    
    echo "<h4>This is the small sized image:</h4>";   
    echo"<p>$smallName</p>";
    echo "<img src=$smallName />";
}

function database() {
    global $nameOfImg, $conn, $desc;        
    $sql = "INSERT INTO images (name, description) VALUES('$nameOfImg', '$desc')";
    if (!$conn->query($sql)) {
        exit("Database error.");
    }
}
?>

