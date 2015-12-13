
<?php

/*
 * class to handle database functions of reservation table. 
 */

//session_start();
require_once 'Database.php';
 
class Admin_model  extends Database{
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
    
    public function getAdminInfo($user_id) {
        $sql = "SELECT * FROM admin WHERE user_id = :user_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        if($stmt->execute())
        {
            return $stmt->fetchAll();
           
        }
        return null;
    }
    public function getAllUsers() {
        $sql = "SELECT * FROM login WHERE role = 'user'";
        $stmt = $this->dbh->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    public function getUserByRoleAndName($username, $role) {
        if($role == "host") {
            $role = "hostess";
        }
        $sql = "SELECT * FROM ".$role." WHERE username = :username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }
        return null;
    }
    
    public function getNewRestaurants() {
        $sql = "SELECT * from restaurant where flag_new = 1";
        $stmt = $this->dbh->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    public function getAllRestaurants() {
        $sql = "SELECT * from restaurant where flag_new = 0";
        $stmt = $this->dbh->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    public function getFlaggedReviews() {
        $sql = "SELECT * from review where flag_report = 1";
        $stmt = $this->dbh->prepare($sql);
        if($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    public function getOwnerByResId($resId) {
        $sql = "SELECT name, username FROM owner WHERE restaurant_id = :resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId);
        if($stmt->execute()){
            return $stmt->fetch();
        }
        return null;
    }
    
    public function getRestaurantNameFromId($resId) {
        $sql = "SELECT name FROM restaurant WHERE restaurant_id = :resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId);
        if($stmt->execute()){
            return $stmt->fetch();
        }
        return null;
    }
    
    public function getAdminProfile($userName){
        $sql = "SELECT * FROM admin WHERE username = :userName";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':userName', $userName);
        if($stmt->execute()){
            return $stmt->fetch();
        }
        return null;
    }
    public function approveRestaurant($resId){
        $sql = "UPDATE restaurant SET flag_new = 0 WHERE restaurant_id = :resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId);
        if($stmt->execute()){
            return $stmt->fetch();
        }
        return null;
    }
    
    public function approveReview($resId, $userId) {
        $sql = "UPDATE review SET flag_report = 0 WHERE restaurant_id = :resId AND user_id = :userId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId);
        $stmt->bindParam(':userId', $userId);
        if ($stmt->execute()) {
                return $stmt->fetchAll();
        }
        return null;
        
    }
    public function removeRestaurant($restaurant_id) {
        $sql = "DELETE FROM restaurant WHERE restaurant_id = :restaurant_id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':restaurant_id', $restaurant_id);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    //look into using just username should cascade if set up properly
    public function removeUser($user_name){
        //$sql = "DELETE FROM user WHERE user_id = :user_id";
        $sql2 = "DELETE FROM login WHERE username = :user_name";
        //echo $sql2."\n";
        //echo $user_name;
        //$stmt = $this->dbh->prepare($sql);
        $stmt2 = $this->dbh->prepare($sql2);
        //$stmt->bindParam(':user_id', $user_id);
        $stmt2->bindParam(':user_name', $user_name);
        //if ($stmt->execute()) {
            if($stmt2->execute()) {
                return $stmt2->fetchAll();
            }
        //}
        return null;
    }
    
    public function removeReview($resId, $userId) {
        $sql = "DELETE FROM review WHERE restaurant_id = :resId AND user_id = :userId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId);
        $stmt->bindParam(':userId', $userId);
        if ($stmt->execute()) {
                return $stmt->fetchAll();
        }
        return null;
    }
    
    public function removeOwnerByResId($resId) {
        $sgl = "DELETE FROM owner WHERE restaurant_id = :resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId);
        if($stmt->execute()){
            return $stmt->fetchAll();
        }
        return null;
    }
    
}

?>