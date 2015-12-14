<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * class to handle databse functions of the owner table.
 * @author pooja
 */
require_once 'Database.php';

class Owner_model extends Database {

    public function __construct() {
        try {
            parent::__construct();
        } catch (Exception $ex) {
            echo "connection failed";
        }
    }

    public function __destruct() {

        parent::__destruct();
    }

    public function getOwnerInfo($username) {
        $sql = "SELECT * FROM owner WHERE username=:username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateOwnerProfile($username, $phoneNum, $email, $password) {
        if (!empty($password)) {
            $sql = "UPDATE login SET password=:password WHERE username=:username";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':username', $username);
            if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
                return false;
            }
        }

        $sql = "UPDATE owner SET contact_no=:phoneNum, email=:email WHERE username=:username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':phoneNum', $phoneNum);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }

}

?>