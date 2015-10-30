<?php
 session_start();
 $controller = $_SESSION['ROOT'].'/app/core/Controller.php';
 require_once $controller;
 
class Restaurant_controller extends Controller
{
    public function index() {
		
        $restaurant = $this->model('Restaurant_model');
            if ($_POST) {
               
            $nameAdd = htmlspecialchars($_POST["searchText"]);
            $restaurant_array = $restaurant->findRestaurantsByNameAddress($nameAdd);  
            return $restaurant_array;
            } else {
                //echo $name;		
		//$user->name = $name;
		$restaurant_array = $restaurant->getAllRestaurants();               
                 return $restaurant_array;
            }
           
          
	}
        
    public function add() {
            //Add login details
        if(isset($_POST['submit'])) {
            $login = $this->model('Login_model');
            $username = htmlspecialchars($_POST["ownerUsername"]);
            $password = htmlspecialchars($_POST["ownerPassword"]);
            if (!$login->addLogin($username, $password, "owner")) {
                exit("Error adding login information");
            }
            
            //Add Restaurant
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
            if(!$this->restaurant->addRestaurant($resArray))
                exit("Error adding restaurant to database");
            
            
            
            //Add Owner
            $owner = $this->model('Owner_model');
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
            if(!$owner->addOwner($ownerArray)) {
                exit("Error adding owner to database");
            }
            
        }
        }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>