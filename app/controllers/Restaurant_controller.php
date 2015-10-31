<?php

// session_start();
require_once 'Controller.php';

class Restaurant_controller extends Controller {
    private $restaurant;
    
    public function __construct() {
        $this->restaurant = $this->model('Restaurant_model');
    }

    public function index() {
        if ($_POST) {
            $nameAdd = htmlspecialchars($_POST["searchText"]);
            $category = htmlspecialchars($_POST['foodCategory']);
            $restaurant_array = $this->restaurant->findRestaurantsByNameAddress($nameAdd);
            return $restaurant_array;
        } else {
            //echo $name;		
            //$user->name = $name;
            $restaurant_array = $this->restaurant->getAllRestaurants();
            return $restaurant_array;
        }
    }
    
    public function getFoodCategories() {
        return $this->restaurant->getFoodCategories();
    }

    public function add() {
        //Add login details
        if (isset($_POST['submit'])) {
            $login = $this->model('Login_model');
            $username = htmlspecialchars($_POST["ownerUsername"]);
            $password = htmlspecialchars($_POST["ownerPassword"]);
            if (!$login->addLogin($username, $password, "owner")) {
                exit("Error adding login information");
            }
           
            //Add Restaurant
        $restaurant = $this->model('Restaurant_model');
     
         $thumbnail = addslashes(file_get_contents($_FILES["profilePic"]["tmp_name"]));
         $menuFile = addslashes(file_get_contents($_FILES["menuFile"]["tmp_name"]));
            $resPhone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["restaurantPhone"]));
            $resArray = array(
                "name" => htmlspecialchars($_POST["restaurantName"]),
               "food_category_name" => htmlspecialchars($_POST["food_category"]),
                
                "phone_no" => $resPhone,
                "address" => htmlspecialchars($_POST["restaurantAddress"]),
                
                "description" => htmlspecialchars($_POST["description"]),
                "flag_new" => 1,
                "thumbnail" => $thumbnail,
                "menu" => $menuFile,
                "capacity" => htmlspecialchars($_POST["restaurantCapacity"]),
                "people_half_hour" => htmlspecialchars($_POST["peopleHalfHour"]),
                "max_party_size" => htmlspecialchars($_POST["maxPartySize"])
                );
            $resId = $restaurant->addRestaurant($resArray);
            if($resId == -1)
                exit("Error adding restaurant to database");
           
         echo $resId;    
            //Add Owner
            $owner = $this->model('Owner_model');
            $ownerName = htmlspecialchars($_POST["ownerFirstName"]) . " " . htmlspecialchars($_POST["ownerLastName"]);
            $ownerPhone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["ownerPhone"]));
            $ownerEmail = htmlspecialchars($_POST["ownerEmail"]);
            $ownerAddress = htmlspecialchars($_POST["ownerAddress"]);
            $ownerArray = array(
                "name" => $ownerName,
                "email" => $ownerEmail,
                "phone" =>  $ownerPhone,
                "address" => $ownerAddress,
                "resId" => $resId,
                "username" => $username
            );
//            echo var_dump($ownerArray)."\n";
            if (!$owner->addOwner($ownerArray)) {
                exit("Error adding owner to database");
            }
             $operation_hours = $this->model('OperationHours_model');
             
              $mondayFrom = htmlspecialchars($_POST["mondayFrom"]);
              $mondayTo = htmlspecialchars($_POST["mondayTo"]);
              $tuesdayFrom = htmlspecialchars($_POST["tuesdayFrom"]);
              $tuesdayTo = htmlspecialchars($_POST["tuesdayTo"]);
              $wednesFrom = htmlspecialchars($_POST["wednesdayFrom"]);
              $wednesdayTo = htmlspecialchars($_POST["wednesdayTo"]);
              $thursdayFrom = htmlspecialchars($_POST["thursdayFrom"]);
              $thursdayTo = htmlspecialchars($_POST["thursdayTo"]);
              $fridayFrom = htmlspecialchars($_POST["fridayFrom"]);
              $fridayTo = htmlspecialchars($_POST["fridayTo"]);
              $saturdayFrom = htmlspecialchars($_POST["saturdayFrom"]);
              $saturdayTo = htmlspecialchars($_POST["saturdayTo"]);
              $sundayFrom = htmlspecialchars($_POST["sundayFrom"]);
              $sundayTo = htmlspecialchars($_POST["sundayTo"]);
           
               $operatinghours = array(
               "resId" => $resId,   
              "mondayFrom" => "'".$mondayFrom."'",
              "mondayTo" => "'".$mondayTo."'",
              "tuesdayFrom" => "'".$tuesdayFrom."'",
              "tuesdayTo" => "'".$tuesdayTo."'",   
              "wednesdayFrom" =>"'". $wednesFrom."'",
              "wednesdayTo" => "'".$wednesdayTo."'",
              "thursdayFrom" => "'".$thursdayFrom."'",
              "thursdayTo" => "'".$thursdayTo."'",
              "fridayFrom" => "'".$fridayFrom."'",
              "fridayTo" => "'".$fridayTo."'",
              "saturdayFrom" => "'".$saturdayFrom."'",
              "saturdayTo" => "'".$saturdayTo."'",
              "sundayFrom" => "'".$sundayFrom."'",
              "sundayTo" => "'".$sundayTo."'"
              );            
            
            $operation_hours->add_operating_hours($operatinghours);
            }
        }
    public function getFoodCategory() {
        $food_category = $this->model('FoodCategory_model');
        return $food_category->getAllFoodCategories();
        
    }

  
    
    
    
        }

    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
