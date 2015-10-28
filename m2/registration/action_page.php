<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <?php
        include '../DBFunctions.php';
        if(isset($_POST['submit'])) {
            $db = new DB();
            $username = htmlspecialchars($_POST["ownerUsername"]);
            $password = htmlspecialchars($_POST["ownerPassword"]);
            if (!$db->addLogin($username, $password, "owner")) {
                exit("Error adding login information");
            }
            
            $imgFile = null;
            if (!empty($_FILES["menuFile"]["name"])) {
                $imgFile = "../uploads/" . basename($_FILES["profilePic"]["name"]);
                if (!move_uploaded_file($_FILES["profilePic"]["tmp_name"], $imgFile)) {
                    exit("Error processing image file");
                }
            }
            $imgFile = "../uploads/" . basename($_FILES["profilePic"]["name"]);
            if (!move_uploaded_file($_FILES["profilePic"]["tmp_name"], $imgFile)) {
                exit("Error processing image file");
            }
            $menuFile = null;
            if (!empty($_FILES["menuFile"]["name"])) {
                $menuFile = "../uploads/" . basename($_FILES["menuFile"]["name"]);
                if (!move_uploaded_file($_FILES["menuFile"]["tmp_name"], $menuFile)) {
                    exit("Error processing menu file");
                }
            }
            $resPhone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["restaurantPhone"]));
            $resArray = array(
                "name" => htmlspecialchars($_POST["restaurantName"]),
                "food_category_name" => htmlspecialchars($_POST["typeofFood"]),
                "phone_no" => $resPhone,
                "address" => htmlspecialchars($_POST["restaurantAddress"]),
                "thumbnail" => $imgFile,
                "description" => htmlspecialchars($_POST["description"]),
                "flag_new" => 1,
                "menu" => $menuFile,
                "capacity" => htmlspecialchars($_POST["restaurantCapacity"]),
                "people_half_hour" => htmlspecialchars($_POST["peopleHalfHour"]),
                "max_party_size" => htmlspecialchars($_POST["maxPartySize"])
                );
            $resId = $db->addRestaurant($resArray);
            if($resId < 0) {
                exit("Error adding restaurant to database");
            }
            $ownerName = htmlspecialchars($_POST["ownerFirstName"])." ".htmlspecialchars($_POST["ownerLastName"]);
            $ownerPhone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["ownerPhone"]));
            $ownerEmail = htmlspecialchars($_POST["ownerEmail"]);
            $ownerAddress = htmlspecialchars($_POST["ownerAddress"]);
            $ownerArray = array(
                "name" => $ownerName,
                "email" => $ownerEmail,
                "phone" => $ownerPhone,
                "address" => $ownerAddress,
                "resId" => $resId,
                "username" => $username
            );
//            echo var_dump($ownerArray)."\n";
            if($db->addOwner($ownerArray) < 0) {
                exit("Error adding owner to database");
            }
            
        }
        
        ?>
        <ul>
            <li><a href="#home">EZ Restaurant</a></li>
            <li><a href="#login">Register</a></li>
            <li><a href="#login">Login</a></li>
        </ul>
        <p>Thank you for registering. Please click "EZ Restaurant" to go back to the home page.</p><br>
    </body>
</html>
