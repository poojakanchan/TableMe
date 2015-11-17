<?php

/* 
 * class to handle http requests related to user.
 */

require_once 'Controller.php';

class User_controller extends Controller {
    
/*
 *  function to handle user registration. It collects all the post variables and
 *  call database function to store login details and user details. 
 */
    public function registerUser() {
         if (isset($_POST['submit'])) {
         
             //retrive post variables.
             $username = htmlspecialchars($_POST["userUsername"]);
            $password = htmlspecialchars($_POST["userPassword"]);
         
            
            $phone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["userPhone"]));
            $name = htmlspecialchars($_POST["userFirstName"]) . " " . htmlspecialchars($_POST["userLastName"]);
            $email = htmlspecialchars($_POST["userEmail"]);
  
            // call to database function.
            $user_model = $this->model('User_model');
            if($user_model->addUser($name,$phone,$email,$username,$password) > 0){
                    $success = 'success';
                    header("Location:login.php/?message=".$success);
            }
            else{
                echo "<p style=\"color:red;text-align:center;font-weight: bold\">Error occured while registestration,Please select different username.</p>";
            }
                
        }
    }

}
?>