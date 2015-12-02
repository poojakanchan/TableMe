<?php

// session_start();
require_once 'Controller.php';

class Admin_controller extends Controller {
    private $admin;
    //private $restaurant;
    
    public function __construct() {
        $this->admin = $this->model('Admin_model');
        //$this->restaurant = $this->model('Restaurant_model');
    }
    public function submit() {
        if (isset($_POST['submit-approve'])) {
            $this->approveRestaurant();
        }
        elseif(isset($_POST['submit-disapprove'])){
            $this->deleteRestaurant();
        }
        elseif (isset($_POST['submit-delete'])) {
            $this->deleteRestaurant();
        }
        elseif (isset($_POST['submit-review'])) {
            $this->approveReview();
        }
        elseif (isset($_POST['submit-review-delete'])) {
            $this->deleteReview();
        }
        elseif(isset($_POST['submit-user-delete'])) {
            $this->deleteUser();
        }
    }
    public function approveRestaurant()
    {
        $admin = $this->model('Admin_model');
        $resId = $_POST['resId'];
        $admin->approveRestaurant($resId);
        echo "<meta http-equiv='refresh' content='0'>";
    }
    
    public function approveReview()
    {
        $admin = $this->model('Admin_model');
        $resId = $_POST['resId'];
        $userId = $_POST['userId'];
        $admin->approveReview($resId, $userId);
        echo "<meta http-equiv='refresh' content='0'>";
    }
    
    
    public function deleteRestaurant() {
        $admin = $this->model('Admin_model');
        $resId = $_POST['resId'];
        $userName = $_POST['userName'];
        $admin->removeRestaurant($resId);
        $admin->removeUser($userName);
        echo "<meta http-equiv='refresh' content='0'>";
    }
    
    public function deleteReview() {
        $admin = $this->model('Admin_model');
        $resId = $_POST['resId'];
        $userId = $_POST['userId'];
        $admin->removeReview($resId, $userId);
        echo "<meta http-equiv='refresh' content='0'>";
    }
    
    public function deleteUser(){
        $admin = $this->model('Admin_model');
        $userName = $_POST['userName'];
        
        $admin->removeUser($userName);
        echo "<meta http-equiv='refresh' content='0'>";
    }
}

?>