<?php

//session_start();
require_once 'Database.php';
 
class Reservation_model  extends Database{
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
    
    public function addReservation($reserveArray) {
       
        $sql = "INSERT INTO reservation(restaurant_id, user_name, date, time, user_id, no_of_people, contact_no, special_instruct) VALUES(:restaurant_id, :user_name, :date, :time, :user_id, :no_of_people, :contact_no, :special_instruct)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':restaurant_id', $reserveArray['restaurant_id'], PDO::PARAM_INT);
        $stmt->bindParam(':user_name', $reserveArray['user_name']);
        $stmt->bindParam(':date', $reserveArray['date']);
        $stmt->bindParam(':time', $reserveArray['time']);
        $stmt->bindParam(':user_id', $reserveArray['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':no_of_people', $reserveArray['no_of_people']);
        $stmt->bindParam(':contact_no', $reserveArray['contact_no']);
        $stmt->bindParam(':special_instruct', $reserveArray['special_instruct']);
        try {
            $this->dbh->beginTransaction();
            if ($stmt->execute()) {
                $lastId = intval($this->dbh->lastInsertId());
                $this->dbh->commit();
                return $lastId;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $this->dbh->rollBack();
        return -1;
    }
    //get restaurant id from name --> restaurant model
    
    //get reservations for date
    public function getReservation($date)
    {
        $sql = "SELECT * FROM reservation WHERE date=:date";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':date', $date);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    //del old reservations
    
    public function deleteOldReservation()
    {
        $sql = "DELETE FROM reservation WHERE date < CURRENT_DATE()";
    }
    public function deleteReservation($resId)
    {
        $sql = "DELETE FROM reservation WHERE reservation_id=:resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    //get count for reservation validity
    public function countReservation($date, $time, $resId)
    {
        $sql = "SELECT COUNT(*) FROM reservation WHERE restaurant_id = :resId AND date=:date AND time IN(:time, SUBTIME(:time, '00:30:00'), ADDTIME(:time, '00:30:00'))";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':resId', $resId, PDO::PARAM_INT);
        if ($stmt->execute()){
            $result = $stmt->fetch();
            //return $result;
            return intval($result[0]);
        }
        return -1;
    }
    
    public function getTableCount($resId, $capacity)
    {
        $sql = "SELECT ".$capacity." FROM restaurant WHERE restaurant_id = :resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $result = $stmt->fetch();
            //echo var_dump($result)."\n\n";
            return intval($result[0]);
            //return $result;
        }
        return -1;
    }
    
    public function getUserReservations($user_id)
    {
        $sql = "SELECT * FROM reservations WHERE user_id = :user_id";
        $stmt = $this->dbh->prepare(sql);
        $stmt->bindParam(':user_id', $user_id);
        if($stmt->execute())
        {
            return $stmt->fetchAll();
           
        }
        return null;
    }

    public function getRestaurantNamesAll()
    {
        $sql = "SELECT restaurant_id, name FROM restaurant";
        $stmt = $this->dbh->prepare($sql);
        if($stmt->execute())
        {
            return $stmt->fetchAll();
           
        }
        return null;
    }
    //Add retrieval for user reservations
}

?>