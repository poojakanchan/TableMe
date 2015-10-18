<?php

/* 
 * Class for interfacing with the MySQL database
 * To use, construct an instance of the class, such as:
 * $db = new DB();
 * then call member functions, such as:
 * $db->findRestaurantsByName($name);
 * After database use is completed, set the pointer to DB instance to null:
 * $db = null; //will close database connection
 */
class DB
{
    private $dbh = null; //database handler

    /* Open the database connection when an instance of DB class is created*/
    public function __construct(){
        // open database connection
        $connectionString = "mysql:host=localhost;dbname=student_f15g11";
        try {
            $this->dbh = new PDO($connectionString, "f15g11", "CSC648team11");
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
    
    /* add a restaurant to the restaurant table. The restaurant information is in an associative array argument*/
    public function addARestaurant($resArray) {
        $fhThumbnail = $fhMenu = null;
        if (array_key_exists('thumbnail', $resArray)) {
            $fhThumbnail = fopen($resArray['thumbnail'], 'rb');
        }
        if (array_key_exists('menu', $resArray)) {
            $fhMenu = fopen($resArray['menu'], 'rb');
        }
        
        
        $sql = "INSERT INTO  restaurant(name, food_category_name, owner_id, phone_no, address, thumbnail, description, "
                . "flag_new, menu, capacity) VALUES(:name, :food_category_name, :owner_id ,:phone_no, :address, :thumbnail, "
                . ":description, :flag_new, :menu, :capacity)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $resArray['name']);
        $stmt->bindParam(':food_category_name', $resArray['food_category_name']);
        $stmt->bindParam(':owner_id', $resArray['owner_id']);
        $stmt->bindParam(':phone_no', $resArray['phone_no']);
        $stmt->bindParam(':address', $resArray['address']);
        $stmt->bindParam(':thumbnail', $fhThumbnail, PDO::PARAM_LOB);
        $stmt->bindParam(':description', $resArray['description']);
        $stmt->bindParam(':flag_new', $resArray['flag_new']);
        $stmt->bindParam(':menu', $fhMenu, PDO::PARAM_LOB);
        $stmt->bindParam(':capacity', $resArray['capacity']);
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
        }
        return null;
    }
    
    /* find restaurant by name only. Returns results in an array ($arr), with each index
     * ($arr[0], $arr[1]...) being and assoiative array corresponding to a row from the table.
     */
    public function findRestaurantsByName($name) {
        $words = explode(" ", $name);
        $searchStr = "%";
        foreach ($words as $word) {
            $searchStr = $searchStr . $word . "%";
        }
        $sql = "SELECT * FROM restaurant WHERE name LIKE :resName LIMIT 100";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resName', $searchStr);
        if ($stmt->execute())
            return $stmt->fetchAll();
        else
            return null;
    }
    
    /* find restaurant by name or address (i.e. any match in name or address will be returned).
     * Returns results in an array ($arr), with each index ($arr[0], $arr[1]...) 
     * being and assoiative array corresponding to a row from the table.
     */
    public function findRestaurantsByNameAddress($nameAdd) {
        $words = explode(" ", $nameAdd);
        $searchStr = "%";
        foreach ($words as $word) {
            $searchStr = $searchStr . $word . "%";
        }
        $sql = "SELECT name, thumbnail, address, phone_no, food_category_name, description, menu "
                . "FROM restaurant WHERE name_address LIKE :str";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':str', $searchStr);
        if ($stmt->execute()){
            return $stmt->fetchAll();
        } 
        else {
            var_dump($stmt->errorInfo());
            return null;
        }
    }
}

?>