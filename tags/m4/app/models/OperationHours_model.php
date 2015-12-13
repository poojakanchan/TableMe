<?php

/* 
 * class to handle database functions of the table operating hours.
 */

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
     
    /*
     * funtion to get operating hours of the provided resturant
     */
    public function getOperatingHoursByRestaurantId($resId) {
         $sql = "SELECT * FROM operating_hours where restaurant_id =";
         $sql = $sql. $resId;
        $stmt = $this->dbh->prepare($sql);
        return $this->selectDB($stmt);
        
        
    }
   
}
?>