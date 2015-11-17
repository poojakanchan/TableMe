<?php

/*
 * class to handle database functions related to restaurant table.
 */
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
  
    /*
     * function to find restaurant by passed Id.
     */
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
    
    /*
     * get count of restaurants for given seeach string.
     */
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
             $sql = $sql . "'" .$nameAddCat . "'";
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
    
    /*
     * get restaurants for passed search string.
     */
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
             $sql = $sql . "'" . $nameAddCat . "'";
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
    
    /*
     * function to retrieve count of total number of restuarants.
     */
    public function getAllRestaurantsCount() {
        $sql = "SELECT COUNT(*) FROM restaurant";
        $stmt = $this->dbh->prepare($sql);
      
        if ($stmt->execute()){
            $result = $stmt->fetch();
            return intval($result[0]);
        }
        return -1;
    }
    
    /*
     * function to get restaurants with given limit.
     */
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
    
    /*
     * function to retrive restuarant's multimedia (all the pictures) from database.
     */
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
    
    /*
     * get count of multimedia images for the given restuarant. 
     */
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
    
    /*
     * function to get login details from database for the provided user.
     */
    public function getLogin($username) {
        $sql = "SELECT * FROM login WHERE username=:name";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $username);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /*
     * function to add login details in the table.
     */
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
   
    /*
     * function to retrive all the images for the restaurant with given type.
     */
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