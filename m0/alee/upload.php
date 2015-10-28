<?php
$servername = "sfsuswe.com";
$username = "alee8";
$password = "csc648team11";
$db = "student_alee8";

$conn = mysql_connect($servername, $username, $password);
mysql_select_db($db, $conn);
if(!$conn){
    die("Connection failed: " . mysql_error() );
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$filename = pathinfo($target_file,PATHINFO_FILENAME);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    $text = mysql_real_escape_string($_POST['imgDescription']);
    $path = mysql_real_escape_string($target_file);
    $name = mysql_real_escape_string(pathinfo($target_file, PATHINFO_FILENAME));

}
 //Check if file already exists
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
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded. <br>";
        
        $percent = 0.75;
        $image = imagecreatefromjpeg($target_file);
        
        // Get new dimensions
        list($width, $height) = getimagesize($target_file);
        $new_width = $width * $percent;
        $new_height = $height * $percent;
        

        // Resample
        $image_medium = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($image_medium, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        $image_med_path = $target_dir . $filename . "_medium." . $imageFileType;
        
        $percent = 0.5;
        $new_width = $width * $percent;
        $new_height = $height * $percent;
        
        $image_small = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($image_small, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        $image_small_path = $target_dir . $filename . "_small." . $imageFileType;


        // Output
        if(!imagejpeg($image_medium, $image_med_path)) {
            echo "Error creating thumbnail (medium).";
            exit();
        }
        else if(!imagejpeg($image_small, $image_small_path)) {
            echo "Error creating thumbnail (small).";
            exit();
        }
        
        $query = "INSERT INTO image_info ".
                 "VALUES('$filename', '$text', '$path', '$image_med_path', '$image_small_path');";
        $result = mysql_query($query, $conn);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        } 
        $result_retrieve = mysql_query("SELECT * FROM image_info WHERE image_name = '$filename' ;") or die(mysql_error());
        $retrieved = mysql_fetch_array($result_retrieve);
        echo "<br> Your picture name is: ".$retrieved['image_name'].".<br><br>";
        echo "<br> <img src= $retrieved[2] /> <br>";
        echo "Description: ".$retrieved['image_desc'].". <br><br>";
        echo "75% scaled thumbnail: <br>";
        echo "<img src= $retrieved[3] /><br>";
        echo "<br> 50% scaled thumbnail: <br>";
        echo "<img src= $retrieved[4] /><br>";
        

        
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
