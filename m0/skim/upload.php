<?php

$servername = "sfsuswe.com";
$username = "tjdrms";
$password = "rlatjdrms";
$db = "student_tjdrms";

$connect = new mysqli($servername, $username, $password, $db);

if ($connect->connect_error) {
    die("Connect failed: " . $connect->connect_error);
}

if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"];
} else { // Check if user input wrong file then say display the description
    echo "Descrition of this Image: ";
    echo $_POST['description'] . "<br><br>";

    // Get the Description of the file (picture)
    $description = $_POST['description'];
    // Get the Name of the file (picture)
    $Nameofpicture = $_FILES["file"]["name"];

    $picture = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
    $picW = imagesx($picture);
    $picH = imagesy($picture);

    // Medium Size of the picture will be 1/2 size of the picture
    $W_medPic = $picW / 2;
    $H_medPic = $picH / 2;

    // Small Size of the picture will be 1/4 size of the picture
    $W_smlPic = $picW / 4;
    $H_smlPic = $picH / 4;

    // Creating Medium Size Picture
    $thumbMedium = imagecreatetruecolor($W_medPic, $H_medPic);
    imagecopyresampled($thumbMedium, $picture, 0, 0, 0, 0, $W_medPic, $H_medPic, $picW, $picH);
    imagejpeg($thumbMedium, "Resized_Med" . ".jpg");
    $medium = "Resized_Med.jpg";

    // Creating Small Size Picture
    $thumbSmall = imagecreatetruecolor($W_smlPic, $H_smlPic);
    imagecopyresampled($thumbSmall, $picture, 0, 0, 0, 0, $W_smlPic, $H_smlPic, $picW, $picH);
    imagejpeg($thumbSmall, "Resized_Sml" . ".jpg");
    $small = "Resized_Sml.jpg";

    move_uploaded_file($_FILES["file"]["tmp_name"], $_FILES["file"]["name"]);

    $sql = "INSERT INTO Image (Filename, Descript) VALUES ('" . $Nameofpicture . "', '" . $description . "')";
    $connect->query($sql);
    $connect->close();

    echo "Name of image: ";
    echo $Nameofpicture . "<br><br>";

    echo "Original Image:" ."<br><br>";
    echo '<img src="', $_FILES["file"]["name"], '"/>' . "<br><br>";

    echo "Med-Size Image:" . "<br><br>";
    echo '<img src="', $medium, '"/>' . "<br><br>";

    echo "Sml-Size Image:" . "<br><br>";
    echo '<img src="', $small, '"/>' . "<br><br>";
}
?>