<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User_model
 *
 * @author pooja
 */
require_once 'Database.php';
class User_model extends Database{
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
    
    public function addLogin($username, $password, $role) {
        $sql = "INSERT INTO login(username, password, role) VALUES(:name, :pswd, :role)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $username);
        $stmt->bindParam(':pswd', $password);
        $stmt->bindParam(':role', $role);
        return $stmt;
     //   return $this->insertDB($stmt);
    }
    public function prepareUserQuery($name,$email,$phone,$username) {
        $sql = "INSERT INTO user(name,email,contact,username) VALUES(:name,:email, :contact,:username)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':contact',$phone);
        $stmt->bindParam(':username',$username);
       return $stmt;
    }
    
    public function addUser($name,$phone,$email,$username,$password) {
   
    try {
            $this->dbh->beginTransaction();
            $this->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->addLogin($username, $password, "user");
            
            if (!$stmt->execute()) {
                exit("Error adding login information");
            } else {
                $stmt = $this->prepareUserQuery($name, $email, $phone, $username);
                
                if (!$stmt->execute()) {
                    exit("Error adding user information");
                } else {
                    $this->dbh->commit();
                    $this->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
                    return 1;
                }
            }
    }catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $this->dbh->rollBack();
        $this->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
        return -1;
            
     }
    
}