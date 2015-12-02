<?php

/**
 * Description of Host_model
 *
 * @author pooja
 */
require_once 'Database.php';
class Hostess_model extends Database{
    //put your code here
    
     /*
      * function to get host details from database for the provided user name.
      */
     
     public function getHostessByUserName($username) {
        $sql = "SELECT * FROM hostess WHERE username=:username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }
        return null;
    }
    
    public function getHostessByRestaurantId($restaurantId) {
       $sql = "SELECT h.hostess_id, h.username, l.password FROM hostess h, login l "
               . " WHERE h.username=l.username AND h.restaurant_id=:restaurantId";
       $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function removeHostess($hostessUsername) {
        $sql = "DELETE FROM hostess WHERE username=:hostessUsername";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':hostessUsername', $hostessUsername);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function addHostess($username, $restaurantId) {
        $sql = "INSERT INTO hostess(restaurant_id, username) VALUES(:restaurantId, :username)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }
}
