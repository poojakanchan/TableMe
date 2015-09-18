<?php
    
    if ($_FILES["file"]["error"] > 0){ 
        echo "Error: " . $_FILES["file"]["error"]; 
    }else{
        echo "The description: ";
        echo $_POST['description']."<br><br>";
        
        $description = $_POST['description'];
        $picName = $_FILES["file"]["name"];
        $pic = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
        $picWidth = imagesx($pic);
        $picHeight = imagesy($pic);
        
        if ($picWidth > 1000 || $picHeight > 1000){
            $picNormalWidth = $picWidth * (1 / 5);
            $picNormalHeight = $picHeight * (1 / 5);
            $thumbNormal = imagecreatetruecolor($picNormalWidth, $picNormalHeight);
            imagecopyresampled($thumbNormal, $pic, 0, 0, 0, 0, $picNormalWidth, $picNormalHeight, $picWidth, $picHeight);
            imagejpeg($thumbNormal, $_FILES["file"]["tmp_name"]);
            $picWidth = $picNormalWidth;
            $picHeight = $picNormalHeight;
            $pic = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
        }
        
        $thumbMediumWidth = $picWidth / 2;
        $thumbMediumHeight = $picHeight / 2;
        
        $thumbSmallWidth = $picWidth / 4;
        $thumbSmallHeight = $picHeight / 4;
        
        $thumbMedium = imagecreatetruecolor($thumbMediumWidth, $thumbMediumHeight);
        imagecopyresampled($thumbMedium, $pic, 0, 0, 0, 0, $thumbMediumWidth, $thumbMediumHeight, $picWidth, $picHeight);
        imagejpeg($thumbMedium, "medium".".jpg");
        $medium = "medium.jpg";
        
        $thumbSmall = imagecreatetruecolor($thumbSmallWidth, $thumbSmallHeight);
        imagecopyresampled($thumbSmall, $pic, 0, 0, 0, 0, $thumbSmallWidth, $thumbSmallHeight, $picWidth, $picHeight);
        imagejpeg($thumbSmall, "small".".jpg");
        $small = "small.jpg";
        
        move_uploaded_file($_FILES["file"]["tmp_name"],$_FILES["file"]["name"]);
        
        $servername = "sfsuswe.com";
        $username = "mlee8";
        $password = "open0605";
        $db = "student_mlee8";
        
        $connect = new mysqli($servername, $username, $password, $db);
        
        if($connect -> connect_error){
            die("Connect failed: ".$connect->connect_error);
        }
        
        $sql = "INSERT INTO info VALUES(\"$picName\",\"$description\")";
        $connect->query($sql);
        $connect->close();
        
        echo "File name: ";
        echo $picName."<br><br>";
        
        echo "This is the original image:"."<br>";
        echo '<img src="',$_FILES["file"]["name"],'"/>'."<br>";
        
        echo "This is the medium size image:"."<br>";
        echo '<img src="',$medium,'"/>'."<br>";
        
        echo "This is the small size image:"."<br>";
        echo '<img src="',$small,'"/>'."<br>";
    }

?>
