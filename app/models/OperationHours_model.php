<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$database = $_SESSION['ROOT'].'/app/core/Database.php';
 require_once $database;*/
class OperationHours_model extends Database {
    
       public function __construct() {
        try{
            parent::__construct();
        } catch (Exception $ex) {
            echo "connection failed";
        }
    }
  
    public function __destruct() {
        
        parent::__destruct();
    }
     
    public function getOperatingHoursByRestaurantId($resId) {
         $sql = "SELECT * FROM operating_hours where restaurant_id =";
         $sql = $sql. $resId;
        $stmt = $this->dbh->prepare($sql);
        return $this->selectDB($stmt);
        
        
    }
   
}

