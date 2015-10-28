<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Restaurant_model  extends Database{
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
    
    /* add a restaurant to the restaurant table. The restaurant information is in an associative array argument*/
    public function addARestaurant($resArray) {
        $fhThumbnail = $fhMenu = null;
        if (array_key_exists('thumbnail', $resArray)) {
            $fhThumbnail = fopen($resArray['thumbnail'], 'rb');
        }
        if (array_key_exists('menu', $resArray)) {
            $fhMenu = fopen($resArray['menu'], 'rb');
        }        
        
        $sql = "INSERT INTO restaurant(name, food_category_name, owner_id, phone_no, address, thumbnail, description, "
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
        
        return $this->insertDB($stmt);
        
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
        return $this->selectDB($stmt);
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
        $sql = "SELECT restaurant_id, name, address, phone_no, food_category_name, description, menu,thumbnail "
                . "FROM restaurant WHERE name_address LIKE :str";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':str', $searchStr);
        return $this->selectDB($stmt);
    }
    /* find restaurant by name only. Returns results in an array ($arr), with each index
     * ($arr[0], $arr[1]...) being and assoiative array corresponding to a row from the table.
     */
    public function getAllRestaurants() {
        
        $sql = "SELECT * FROM restaurant LIMIT 100";
        $stmt = $this->dbh->prepare($sql);
      
        return $this->selectDB($stmt);
    }
    
    public function getRestaurantThumbnail($resId) {
        $sql = "SELECT thumbnail FROM restaurant WHERE restaurant_id=:id";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id', $resId);
        $stmt->execute();
        return $stmt->fetch();
    }

    
}

?>