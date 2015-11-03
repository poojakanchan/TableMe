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
    
    public function add_operating_hours($operArray) {
        $sql = "INSERT INTO operating_hours(restaurant_id,monday_from,tuesday_from,wednesday_from,thursday_from,friday_from,"
                . "saturday_from,sunday_from,monday_to,tuesday_to,wednesday_to,thursday_to,friday_to,"
                . "saturday_to,sunday_to) "
                . "VALUES(:resId, :mon_from, :tues_from, :wednes_from, :thurs_from, :fri_from,:satur_from,:sun_from,"
                . ":mon_to, :tues_to, :wednes_to, :thurs_to, :fri_to,:satur_to,:sun_to)";
        
       
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $operArray['resId']);
        $stmt->bindParam(':mon_from', $operArray['mondayFrom']);
        $stmt->bindParam(':tues_from', $operArray['tuesdayFrom']);
        $stmt->bindParam(':wednes_from', $operArray['wednesdayFrom']);
        $stmt->bindParam(':thurs_from', $operArray['thursdayFrom']);
        $stmt->bindParam(':fri_from', $operArray['fridayFrom']);
        $stmt->bindParam(':satur_from',$operArray['saturdayFrom']);
        $stmt->bindParam(':sun_from', $operArray['sundayFrom']);
        $stmt->bindParam(':mon_to', $operArray['mondayTo']);
        $stmt->bindParam(':tues_to', $operArray['tuesdayTo']);
        $stmt->bindParam(':wednes_to', $operArray['wednesdayTo']);
        $stmt->bindParam(':thurs_to', $operArray['thursdayTo']);
        $stmt->bindParam(':fri_to', $operArray['fridayTo']);
        $stmt->bindParam(':satur_to', $operArray['saturdayTo']);
        $stmt->bindParam(':sun_to', $operArray['sundayTo']);
        
        return $this ->insertDB($stmt);
        
    }
    
}

