<?php



/**
 * Provides access to special_event table
 *
 * @author Haichuan Duan
 */
 require_once 'Database.php';

class Event_model extends Database{
   
    
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
     * function to add special event to database.
     */
    public function addEvent($eventArray) {
        $sql = "INSERT INTO special_event(restaurant_id, description, date, time, event_photo) "
                . "VALUES(:resId, :desc, :date, :time, :photo)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $eventArray['resId'], PDO::PARAM_INT);
        $stmt->bindParam(':desc', $eventArray['desc']);
        $stmt->bindParam(':date', $eventArray['date']);
        $stmt->bindParam(':time', $eventArray['time']);
        $stmt->bindParam(':photo', $eventArray['photo']);
        
        return $this ->insertDB($stmt);
    }
    
    /*
     * function to retrive all the special events for restaurant.
     */
    public function getAllEvents() {
        $sql = "SELECT e.restaurant_id, e.description, e.date, e.time, e.event_photo, r.name "
                . "FROM special_event e "
                . "INNER JOIN restaurant r "
                . "WHERE e.restaurant_id=r.restaurant_id "
                . "ORDER BY e.date ASC";
        $stmt = $this->dbh->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    
    public function getEventsByRestaurantId($resId) {
        $sql = "SELECT e.restaurant_id, e.title, e.description, e.date, e.time, e.event_photo, r.name "
                . "FROM special_event e "
                . "INNER JOIN restaurant r "
                . "WHERE e.restaurant_id=r.restaurant_id and r.restaurant_id ="
                . $resId
                . " ORDER BY e.date ASC";
        $stmt = $this->dbh->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
}