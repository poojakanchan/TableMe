<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Controller.php';

class User_controller extends Controller {
    
    public function registerUser() {
         if (isset($_POST['submit'])) {
            $username = htmlspecialchars($_POST["userUsername"]);
            $password = htmlspecialchars($_POST["userPassword"]);
         
            
            $phone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["userPhone"]));
            $name = htmlspecialchars($_POST["userFirstName"]) . " " . htmlspecialchars($_POST["userLastName"]);
            $email = htmlspecialchars($_POST["userEmail"]);
  
            $user_model = $this->model('User_model');
            if($user_model->addUser($name,$phone,$email,$username,$password) > 0){
                    $success = 'success';
                    header("Location:login.php/?message=".$success);
            }
            else{
                echo 'Error occured while registestration,Please select different username.';
            }
                
        }
    }

}
?>
