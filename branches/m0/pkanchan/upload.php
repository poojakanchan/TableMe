<html>
    <head>
  <link rel=stylesheet href="style.css" type="text/css" media=screen />
</head>
<body>
<?php
$error_message;
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if(isset($_POST["submit"])) {
    if(isset($_POST["description"])) {
        $desc = $_POST["description"];
    }
    else { 
            $desc = NULL;
    }
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
   
    if($check !== false) {
        $uploadOk = 1;
    } else {
     
        $error_message= "File is not an image.";
        $uploadOk = 0;
    }
    // Check if file already exists 
    if (file_exists($target_file)) {
        $error_message= "File already exists.";
         $uploadOk = 0;
    }

    if ($uploadOk == 1){
          if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $path_parts = pathinfo($target_file);
                $path1 = $path_parts['dirname']."/".$path_parts['filename']."_resize1.".$path_parts['extension'];
                
                if(resizeImage($target_file,$path1,250)) {
                    $path2 = $path_parts['dirname']."/".$path_parts['filename']."_resize2.".$path_parts['extension'];
                    $baseName = $path_parts['basename'];
                    if(resizeImage($target_file,$path2,150)) {
                    
                        if(saveData($target_file, $desc, $path2, $path1)) {
                                 echo "<p align=\"center\" >Your file was uploaded successfully!!</p>";
                                 echo "<p align=\"center\"> Click <a href=\"index.html\">here</a> to upload more images.</p> ";
                                 echo "<br>";
                                 echo "<p> FileName</p> $baseName </p>";
                               //  echo "<br>";
                                 if($desc == NULL) {
                                     echo "Description was not set.";
                                 } else
                                 {
                                     echo "<p> Description </p> $desc </p>";
                                 }
                                 //echo "<br><br>";
                                 echo "<div class=\"container\">";
                                 echo "<div class=\"row\">";
                               
                                 echo "<div class=\"col-xs-6\">";
                                 echo "<p>Resized image 1</p> ";
                                 echo "<img src=\"$path1\"/> ";
                                 echo "</div>";
                                 echo "<div class=\"col-xs-6\">";
                                 echo "<p>Resized image 2</p> ";
                                 echo "<img src=\"$path2\"/>";
                                 echo " </div>"; 
                                echo " </div>"; 
                                 echo "</div>";
                                 echo "<p> Original image </p>";
                                 echo "<img height =\"300\" width =\"400\" src=\"$target_file \"/>";
                            }
                    }
                }
           } else {
               $error_message = "Error Uploading file.";
           }
    }
    
}

if(!empty($error_message)) {
    echo "<h1 class=\"error\">Sorry, your file was not uploaded</h2>";
    echo "<h1 class=\"error\"> Error: $error_message </h2>";
     echo "<h3  >Click <a href=\"index.html\">here</a> to try again.</h3>";
                                
}

function resizeImage($file_name,$resize_name,$new_height) {
    global $error_message;
     list($width, $height) = getimagesize($file_name);
    
        $new_width = $new_height*$width/$height;
        // Resample
        $image_p = imagecreatetruecolor($new_width, $new_height);
        if($image_p == FALSE) {
              $error_message =" Error in resizing the image";
              return FALSE;
        }
        $image = imagecreatefromjpeg($file_name);
        if($image == FALSE) {
              $error_message =" Error in resizing the image";
              return false;
        }
        
        if(imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height) == FALSE) {
              $error_message =" Error in resizing the image";
              return FALSE;
        }
        if(imagejpeg($image_p,$resize_name , 100) == FALSE) {
              $error_message =" Error in creating new Image";
              return false;
        }
        return TRUE;
        
}

function saveData($name,$desc,$small_img, $med_img) {
    echo "<br><br><br>";
    $servername = "sfsuswe.com";
    $username = "pkanchan";
    $password = "Maths123";
     global $error,$error_message;
    // Create connection
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        $error_message= $conn->connect_error;
        return FALSE;
    } 
   // echo "Connected successfully";
    $sql= "USE student_pkanchan";
    
    if ($conn->query($sql) === FALSE) {
        $error_message= $conn->connect_error;
        echo "Error: ".$error_message;
        return false;
        
    }
    $sql = "INSERT INTO store_image VALUES(\"$name\",\"$desc\",\"$small_img\",\"$med_img\")";
    if ($conn->query($sql) === FALSE) {
        $error_message= $conn->connect_error;
        echo "Error".$error_message;
        return FALSE;
    }
$conn->close();
return TRUE;
}


?>    
</body>
</html>
