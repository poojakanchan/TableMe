<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FoodCategory_model
 *
 * @author pooja
 */


class FoodCategory_model extends Database {
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
 
    public function getAllFoodCategories() {
         $sql = "SELECT * FROM food_category";
        $stmt = $this->dbh->prepare($sql);
        return $this->selectDB($stmt);
        
    }
    
}
