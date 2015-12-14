<?php

/* 
 * class to handle database functions of login table.
 */

 require_once 'Database.php';
 
class Login_model extends Database {
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
     * function to validate login credentials: username and password.
     */
public function validateLogin($username, $password) {
        $sql = "SELECT * FROM login WHERE username=:username AND password=:password";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        if ($stmt->execute()) {
            $result = $stmt->fetch();
            if (!empty($result))
                return $result;
        }
        return false;
    }
    
    /*
     * function to add login details to database.
     */
    public function addLogin($username, $password, $role) {
        $sql = "INSERT INTO login(username, password, role) VALUES(:name, :pswd, :role)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $username);
        $stmt->bindParam(':pswd', $password);
        $stmt->bindParam(':role', $role);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }
    
    /*
     * get all user names from the table.
     */
    public function getAllUsernames() {
        $sql = "SELECT username FROM login";
        $stmt = $this->dbh->prepare($sql);
        
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        }
        else {
            print_r($stmt->errorInfo());
            return null;
        }
    }
    
    public function removeLogin($username) {
        $sql = "DELETE FROM login WHERE username=:username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    /*
      * function to get user details from database for the provided user name.
      */
     
     public function getUser($username) {
        $sql = "SELECT * FROM user WHERE username=:username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }
        return null;
    }
     
    
}

?>

