<?php

/*
 * Controller class to handle http requests related to restaurant.
 */

// session_start();
require_once 'Controller.php';

class Restaurant_controller extends Controller {
    private $restaurant;

    /*
     * Constructor of the class.
     * Creates an object of resturant model class and stores in the variable for future use.
     */
    public function __construct() {
        $this->restaurant = $this->model('Restaurant_model');
    }

    /*
     * method retrieves restaurants and returns in form of array
     * if search text is not set, it retrives all the restaurants 
     * if search text is set, it filters the results by calling appropriate databasd query
     *  and return them.
     */
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
    
    /*
     * function to return all food categories from database.
     */
    public function getFoodCategories() {
        return $this->restaurant->getFoodCategories();
    }

    /*
     * function to register a  restaurant with the system
     * It gets all post variables, store in arrays and call database functions to store
     *  owner, login details of the owner and restaurant details.
     */
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
                 echo "<p style=\"color:green;text-align:center;font-weight: bold\" >Congratulations!!Restaurant registration is successful!!";
                 echo "</p><br><p style = \"text-align:center;font-weight: bold \" > ";
                 echo "The resturant needs to be approved by site administrator before it can be searched."
                         . "Please contact site administrator for further questions  ";
                 echo "<br> You can <a href =\"login.php\">Login </a> to view or modify restaurant information.</p>";
              //   header("Location:login.php/?message=".'success_restaurant');
            
             } else {
                 echo "\n\n";
                    echo "<p style=\"color:red;text-align:center;font-weight: bold\">Error occurred while registering restaurant. Please try again!</p>";
             }
            
        }
    }
    
    /*
     * 
     */
    
    public function getFoodCategory() {
        $food_category = $this->model('FoodCategory_model');
        return $food_category->getAllFoodCategories();
        
    }

  /*
   * function to get all the user names from login model.
   */
    public function getAllUserNames() {
        $login = $this->model('Login_model');
        
        return $login->getAllUsernames();
    }
    
    /*
     * function to retrive opertaing hours of the provided restaurant ID.
     *  
     */
    public function getOperatingHours($resId) {
        $op_model = $this->model('OperationHours_model');
        return $op_model-> getOperatingHoursByRestaurantId($resId);
    }
}

    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>