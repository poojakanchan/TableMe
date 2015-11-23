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
}
