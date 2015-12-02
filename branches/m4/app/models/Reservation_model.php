<?php

/*
 * class to handle database functions of reservation table. 
 */

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
    
    /* adds a reservation to the reservation table in the database.
     * Takes an array containing the restaurant ID, the user's name, the date, 
     * time, number of people, contact number, and any special instructions.
     * If user is logged in, the user ID is added as well, otherwise should be
     * set as empty in the array before passing.
     */
    
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

    
    /* Retrieves all reservations for a specified date. Used for hosts.
     * Requires a date string in the form "xxx-xx-xx"
     * Returns a large array containing all the reservations found for that date.
     */
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
    /* Retrieves all reservations for a specified date and restaurant ID. Used for hosts.
     * Requires a date string in the form "xxx-xx-xx"
     * Returns a large array containing all the reservations found for that date.
     */
    public function getReservationByDateAndRestaurantId($date,$resId)
    {
       $sql = "SELECT * FROM reservation WHERE date=".$date . "and restaurant_id=" . $resId; 
        $stmt = $this->dbh->prepare($sql);
        //$stmt->bindParam(':date', $date);
         //$stmt->bindParam(':resId', $resId);
            
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    /* Retrieves  reservation for a specified Id.  */
    public function getReservationById($reservationId)
    {
        $sql = "SELECT * FROM reservation WHERE reservation_id=$reservationId";
        $stmt = $this->dbh->prepare($sql);
     
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    /* Deletes old reservations. Supposed to be run after a set period on a 
     * normal schedule to delete unused entries in the reservation table.
     */
    public function deleteOldReservation()
    {
        $sql = "DELETE FROM reservation WHERE date < CURRENT_DATE()";
    }
    
    /*
     * Deletes a reservation given a reservation id. Used for the hostess or
     * when sent to the user through confirmation email/user's account management.
     * Returns 1 if successful, otherwise null.
     */
    public function deleteReservation($resId)
    {
        $sql = "DELETE FROM reservation WHERE reservation_id=:resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    /* Counts the reservations in the table for a given date, time, and restaurant.
     * The query also retrieves reservations for times 30 minutes before and 30 minutes after.
     * This is to account for 1 hour eating sessions and can be changed later.
     * Returns the count of the reservations if any or -1 if the query was unsuccessful.
     * NOTE: should return 0 if none are found.
     */
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
    
    /* retrieves the number of tables owner inputted during registration.
     * Tables are either for 2, 4, or 6. Requires a restaurant id and a formatted
     * string in $capacity of the form num_two_tables, num_four_tables, etc.
     * Returns an integer value from the table or -1 if unsuccessful.
     * NOTE: since the column exists and defaults to 0 if the owner did not enter
     * a number, the value returned should be 0 or greater.
     */
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
    
    /* Retrieves any current reservations associated with a user id.
     * This is used specifically to show any reservations for the user under his
     * account management.
     * Returns an array of the user's reservations if any.
     */
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

    /* Retrieves all the names of every restaurant in the restaurant table.
     * Used to fill restaurant names in reservation form.
     * NOTE: no longer used due to design changes.
     */
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
    
    /* Retrieves operating hours of a restaurant by a selected day.
     * Requires a restaurant ID, and two formatted strings in $from and $to in 
     * the form of "xxday_from" and "xxday_to" respectively. Must be preformatted
     * or query will fail.
     * Returns the two columns selected in an array for use.
     */
    public function getOperatingHoursByDay($from, $to, $resId)
    {
        //DATE_FORMAT(mytime, '%l:%i %p')
        $sql = "SELECT DATE_FORMAT(".$from.", '%l:%i %p'), DATE_FORMAT(".$to.", '%l:%i %p') FROM operating_hours WHERE restaurant_id = :resId";
        //echo $sql;
        $stmt=$this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId, PDO::PARAM_INT);
        if($stmt->execute())
        {
            return $stmt->fetchAll();
        }
        return null;
    }
  public function markArrived($reservation_id){
      try{
         $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE reservation SET mark_arrived=1 WHERE reservation_id= " . $reservation_id;
        $stmt = $this->dbh->prepare($sql);
        if($stmt->execute())
        {
            return 1;
        }
        return -1;
      }catch (Exception $ex) {
         //         
        echo $ex->getMessage();
       
        return -1;
            
     }
  }
}

?>