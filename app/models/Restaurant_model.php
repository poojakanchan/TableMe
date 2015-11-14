<?php

//session_start();
require_once 'Database.php';
 
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
    
    
    /* find restaurant by name only. Returns results in an array ($arr), with each index
     * ($arr[0], $arr[1]...) being and assoiative array corresponding to a row from the table.
     */
//    public function findRestaurantsByName($name) {
//        $words = explode(" ", $name);
//        $searchStr = "%";
//        foreach ($words as $word) {
//            $searchStr = $searchStr . $word . "%";
//        }
//        $sql = "SELECT * FROM restaurant WHERE name LIKE :resName LIMIT 100";
//        $stmt = $this->dbh->prepare($sql);
//        $stmt->bindParam(':resName', $searchStr);
//        if ($stmt->execute()) {
//            return $stmt->fetchAll();
//        }
//        return null;
//    }
    
    public function findRestaurantById($id) {
        $sql = "SELECT * FROM restaurant WHERE restaurant_id=:resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $id);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
//    public function findRestaurantsByCat($cat) {
//        $sql = "SELECT * FROM restaurant WHERE food_category_name LIKE :str";
//        $stmt = $this->dbh->prepare($sql);
//        $stmt->bindParam(':str', $cat);
//        if ($stmt->execute()) {
//            return $stmt->fetchAll();
//        }
//        return null;
//    }
    
    /* find restaurant by name or address (i.e. any match in name or address will be returned).
     * Returns results in an array ($arr), with each index ($arr[0], $arr[1]...) 
     * being and assoiative array corresponding to a row from the table.
     */
//    public function findRestaurantsByNameAddress($nameAdd) {
//        $words = explode(" ", $nameAdd);
//        $searchStr = "%";
//        foreach ($words as $word) {
//            $searchStr = $searchStr . $word . "%";
//        }
//        $sql = "SELECT * FROM restaurant WHERE name_address LIKE :str";
//        $stmt = $this->dbh->prepare($sql);
//       
//        $stmt->bindParam(':str', $searchStr);
//        
//        if ($stmt->execute()){
//            return $stmt->fetchAll();
//        } 
//        return null;
//    }
    
     /* find restaurant by name/address and category.
     * Returns results in an array ($arr), with each index ($arr[0], $arr[1]...) 
     * being and assoiative array corresponding to a row from the table.
     */
//    public function findRestaurantsByNameAddressAndCategory($nameAdd, $category) {
//        $words = explode(" ", $nameAdd);
//        $searchStr = "%";
//        foreach ($words as $word) {
//            $searchStr = $searchStr . $word . "%";
//        }
//        $sql = "SELECT * FROM restaurant WHERE food_category_name LIKE :str2 AND name_address LIKE :str";
//        $stmt = $this->dbh->prepare($sql);
//        $stmt->bindParam(':str2', $category);
//        $stmt->bindParam(':str', $searchStr);
//        
//        if ($stmt->execute()){
//            return $stmt->fetchAll();
//        } 
//        return null;
//    }
    
    public function findRestaurantsCount($nameAddCat) {
        $sql = "SELECT COUNT(*) FROM restaurant WHERE name_address_category LIKE ";
        $searchWord;
         if($nameAddCat != "%") {
             $words = explode(" ", $nameAddCat);
             $searchWord = " '%". $words[0] . "%' ";
             $sql = $sql . $searchWord;
             for ($i=1; $i<count($words); ++$i) {
                $searchWord = " '%" . $words[$i] ."%' ";
                $sql = $sql . " AND name_address_category LIKE". $searchWord; 
             }
         }
         else {
             $sql = $sql . $nameAddCat;
         }        
        
        $stmt = $this->dbh->prepare($sql);
//        echo '<br><br>'.var_dump($searchStr).'<br>'.var_dump($nameAdd).'<br>'.var_dump($limit).'<br>'.var_dump($offset);
//        exit();
        if ($stmt->execute()){
//            echo var_dump($stmt->fetch());
//            exit();
            $count = $stmt->fetch(PDO::FETCH_NUM);
            return intval($count[0]);
        } 
        return -1;
    }
    
    public function findRestaurantsLimitOffset($nameAddCat, $limit, $offset) {
        $sql = "SELECT * FROM restaurant WHERE name_address_category LIKE "; 
        
        $searchWord;
         if($nameAddCat != "%") {
             $words = explode(" ", $nameAddCat);
             $searchWord = " '%". $words[0] . "%' ";
             $sql = $sql . $searchWord;
             for ($i=1; $i<count($words); ++$i) {
                $searchWord = " '%" . $words[$i] ."%' ";
                $sql = $sql . " AND name_address_category LIKE". $searchWord; 
             }
         }
         else {
             $sql = $sql . $nameAddCat;
         }
         $sql = $sql . " LIMIT :lim OFFSET :off";
        
//         echo "<br><br>".$sql;
//         exit();
        
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':lim', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':off', $offset, PDO::PARAM_INT);
//        echo '<br><br>'.var_dump($searchStr).'<br>'.var_dump($nameAdd).'<br>'.var_dump($limit).'<br>'.var_dump($offset);
//        exit();
        if (!$stmt->execute()){
//            echo var_dump($stmt->fetch());
//            exit();
            print_r ($stmt->errorInfo());
            exit();
            return null;
            
        }         
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllRestaurantsCount() {
        $sql = "SELECT COUNT(*) FROM restaurant";
        $stmt = $this->dbh->prepare($sql);
      
        if ($stmt->execute()){
            $result = $stmt->fetch();
            return intval($result[0]);
        }
        return -1;
    }
    
    public function getAllRestaurantsLimitOffset($limit, $offset) {
        $sql = "SELECT * FROM restaurant LIMIT :lim OFFSET :off";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':lim', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':off', $offset, PDO::PARAM_INT);
        if ($stmt->execute()){
            return $stmt->fetchAll();
        }
        return null;
    }
   
    /* find restaurant by name only. Returns results in an array ($arr), with each index
     * ($arr[0], $arr[1]...) being and assoiative array corresponding to a row from the table.
     */
//    public function getAllRestaurants() {
//        
//        $sql = "SELECT * FROM restaurant LIMIT 100";
//        $stmt = $this->dbh->prepare($sql);
//      
//        if ($stmt->execute()){
//            return $stmt->fetchAll();
//        }
//        return null;
//    }
    
    public function getRestaurantImageWithOffset ($resId, $offset) {
        $sql = "SELECT media FROM multimedia WHERE restaurant_id=:resId LIMIT 1 OFFSET :offset";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            print_r ($stmt->errorInfo());
            return false;
        }
        return $stmt->fetch(PDO::FETCH_NUM);
    }
    
    public function getRestaurantImageCount ($resId) {
        $sql = "SELECT COUNT(*) FROM multimedia WHERE restaurant_id=:resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId);
        if (!$stmt->execute()) {
            print_r ($stmt->errorInfo());
            return false;
        }
        return $stmt->fetch(PDO::FETCH_NUM);
    }
    
    public function getLogin($username) {
        $sql = "SELECT * FROM login WHERE username=:name";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $username);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function addLogin($username, $password, $role) {
        $sql = "INSERT INTO login(username, password, role) VALUES(:name, :pswd, :role)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $username);
        $stmt->bindParam(':pswd', $password);
        $stmt->bindParam(':role', $role);
        try {
            $this->dbh->beginTransaction();
            if ($stmt->execute()) {
                $this->dbh->commit();
                return true;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        $this->dbh->rollBack();
        return false;
    }
    
    public function addOwner($ownerArray) {
        $sql = "INSERT INTO owner(name, email, contact_no, address, restaurant_id, username) "
                . "VALUES(:name, :email, :contact_no, :address, :resId, :username)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $ownerArray['name']);
        $stmt->bindParam(':email', $ownerArray['email']);
        $stmt->bindParam(':contact_no', $ownerArray['phone']);
        $stmt->bindParam(':address', $ownerArray['address']);
        $stmt->bindParam(':resId', $ownerArray['resId'], PDO::PARAM_INT);
        $stmt->bindParam(':username', $ownerArray['username']);
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
    
    public function getRestaurantImages($resId) {
        $sql = "SELECT * FROM multimedia WHERE restaurant_id=:resId AND type='image'";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
    
    public function getFoodCategories() {
        $sql = "SELECT name FROM food_category";
        $stmt = $this->dbh->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll();
        }
        return null;
    }
}

?>