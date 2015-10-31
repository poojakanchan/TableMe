<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Owner_model
 *
 * @author pooja
 */
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
$database = $_SESSION['ROOT'].'/app/core/Database.php';
 require_once $database;

class Owner_model extends Database{
    //put your code here
    
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
    
    public function addOwner($ownerArray) {
        $sql = "INSERT INTO owner(name, email, contact_no, address, restaurant_id, username) "
                . "VALUES(:name, :email, :contact_no, :address, :resId, :username)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $ownerArray['name']);
        $stmt->bindParam(':email', $ownerArray['email']);
        $stmt->bindParam(':contact_no', $ownerArray['phone']);
        $stmt->bindParam(':address', $ownerArray['address']);
        $stmt->bindParam(':resId', $ownerArray['resId'], PDO::PARAM_INT);
        $stmt->bindParam(':username', $ownerArray['username']);
        return $this ->insertDB($stmt);
        
    }
}

    

