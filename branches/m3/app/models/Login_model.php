<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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
    
public function validateLogin($username, $password) {
        $sql = "SELECT * FROM login WHERE username=:username AND password=:password";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        if ($stmt->execute()) {
            $result = $stmt->fetch();
            if (!empty($result))
                return true;
        }
        return false;
    }
    
    public function addLogin($username, $password, $role) {
        $sql = "INSERT INTO login(username, password, role) VALUES(:name, :pswd, :role)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $username);
        $stmt->bindParam(':pswd', $password);
        $stmt->bindParam(':role', $role);
        return $stmt;
     //   return $this->insertDB($stmt);
    }
    
    public function getAllUsernames() {
        $sql = "SELECT * FROM login";
        $stmt = $this->dbh->prepare($sql);
        
        if ($stmt->execute()) {
            echo 'called!!';
            return $stmt->fetchAll();
        }
        
        return null;
    }
     
    
}

?>

