<?php

// session_start();
require_once 'Controller.php';

class Restaurant_controller extends Controller {
    private $restaurant;
    
    public function __construct() {
        $this->restaurant = $this->model('Restaurant_model');
    }

    public function index() {
        global $foodCategoryArray;
        if ($_POST) {
            $nameAdd = htmlspecialchars($_POST["searchText"]);
            $category = htmlspecialchars($_POST['foodCategory']);
            echo var_dump($category);
            echo var_dump($foodCategoryArray);
            exit();
            if(in_array($category, $foodCategoryArray)) {
                $restaurant_array = $this->restaurant->findRestaurantsByNameAddressAndCategory($nameAdd, $category);
            }
            else {
                $restaurant_array = $this->restaurant->findRestaurantsByNameAddress($nameAdd);
            }    
            
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
            $username = htmlspecialchars($_POST["ownerUsername"]);
            $password = htmlspecialchars($_POST["ownerPassword"]);
         
            //Add Restaurant
            if (is_uploaded_file($_FILES['profilePic']['tmp_name'])) {
                $thumbnail = file_get_contents($_FILES["profilePic"]["tmp_name"]);
            }
            if(is_uploaded_file($_FILES['menuFile']['tmp_name'])) {
            $menuFile = file_get_contents($_FILES["menuFile"]["tmp_name"]);
            } else {
                $menuFile = null;
            }
            $resPhone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["restaurantPhone"]));
            $rest_address = htmlspecialchars($_POST["restaurantStreet"])." " .
                    htmlspecialchars($_POST["restaurantCity"]). " " .
                    htmlspecialchars($_POST["restaurantState"]). " " .
                    htmlspecialchars($_POST["restaurantZip"]);
            
            $resArray = array(
                "name" => htmlspecialchars($_POST["restaurantName"]),
               "food_category_name" => htmlspecialchars($_POST["food_category"]),            
                "phone_no" => $resPhone,
                "address" => $rest_address,
                "description" => htmlspecialchars($_POST["description"]),
                "flag_new" => 1,
                "capacity" => htmlspecialchars($_POST["restaurantCapacity"]),
                "twos" => htmlspecialchars($_POST["tablesForTwo"]),
               "fours" => htmlspecialchars($_POST["tablesForFour"]),
               "sixes" => htmlspecialchars($_POST["tablesForSix"]),
                );
           
            //Add Owner
            
            $ownerName = htmlspecialchars($_POST["ownerFirstName"]) . " " . htmlspecialchars($_POST["ownerLastName"]);
            $ownerPhone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["ownerPhone"]));
            $ownerEmail = htmlspecialchars($_POST["ownerEmail"]);
            $ownerAddress = htmlspecialchars($_POST["ownerStreet"]). " ".
                            htmlspecialchars($_POST["ownerCity"]) . " ".
                            htmlspecialchars($_POST["ownerState"]) . " ".
                            htmlspecialchars($_POST["ownerZip"]);
                   
            $ownerArray = array(
                "name" => $ownerName,
                "email" => $ownerEmail,
                "phone" =>  $ownerPhone,
                "address" => $ownerAddress,
                "username" => $username
            );
//           
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
            
            $restaurant_registration = $this->model('Restaurant_Registration_model');
            $res = $restaurant_registration->registerRestaurant($resArray,$ownerArray,$operatinghours,$username,$password,$thumbnail,$menuFile);
             if($res > 0) {
                 if($user_model->addUser($name,$phone,$email,$username,$password) > 0){
                    $success = 'success_restaurant';
                    header("Location:login.php/?message=".$success);
            
             } else {
                 echo 'Error occurred while adding restaurant. Please try again!';
             }
            }
        }
    }
    public function getFoodCategory() {
        $food_category = $this->model('FoodCategory_model');
        return $food_category->getAllFoodCategories();
        
    }

  
    public function getAllUserNames() {
        $login = $this->model('Login_model');
        
        return $login->getAllUsernames();
    }
    
}

    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
