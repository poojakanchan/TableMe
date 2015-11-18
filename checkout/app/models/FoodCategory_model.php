<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * class to handle database functions of food category table.
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
 
    /*
     * database function to get all food categories.
     */
    public function getAllFoodCategories() {
         $sql = "SELECT * FROM food_category";
        $stmt = $this->dbh->prepare($sql);
        return $this->selectDB($stmt);
        
    }
    
} ?>