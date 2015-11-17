<?php

/* 
 * base class to provide common database functions.
 * All models extend this class.
 */
class Database {
public $dbh = null;

    /* Open the database connection when an instance of DB class is created*/
    public function __construct(){
        // MYSQL DB connection details
        $connectionString = "mysql:host=localhost;dbname=student_f15g11";
        $username ="f15g11";
    $password ="CSC648team11";
        // open database connection
        try {
            $this->dbh = new PDO($connectionString, $username, $password);
            //for prior PHP 5.3.6
            //$conn->exec("set names utf8");
        } 
        catch (PDOException $pe) {
            print "Error!: " . $pe->getMessage() . "<br/>";
            die();
        } 
    }
    
    /* close the database connection when an instance of DB class has no pointer*/
    public function __destruct() {
        $this->dbh = null;
    }

    public function insertDB($stmt){
        try {
            $this->dbh->beginTransaction();
            if ($stmt->execute()) {
                $this->dbh->commit();
                return true;
            } else {
                echo "insert operation unsuccessful";
            }
        } catch (Exception $ex) {
            $this->dbh->rollBack();
            echo "Error occurred while adding data ". $ex->getMessage(); 
        }
        return null;

    }
    
    /*
     * function to fetch the results.
     */
    public function selectDB($stmt) {
        if ($stmt->execute()){
            return $stmt->fetchAll();
        } 
        else {
            return null;
        }
    }
 
    /*
     * update the table function.
     */
    public function updateDB($stmt) {
        try {
            $this->dbh->beginTransaction();
            if ($stmt->execute()) {
                $this->dbh->commit();
                return true;
            } else {
                echo "insert operation unsuccessful";
            }
        } catch (Exception $ex) {
            $this->dbh->rollBack();
            echo "Error occurred while adding data ". $ex->getMessage(); 
        }
        return null;
    }
    public function model($model) {
	require_once $model . '.php';
	return new $model;	
        }
}
?>