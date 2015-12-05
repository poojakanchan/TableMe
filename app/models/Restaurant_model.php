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
    
  
    /*
     * function to find restaurant by passed Id.
     */
    public function findRestaurantById($id) {
        $sql = "SELECT * FROM restaurant WHERE restaurant_id=:resId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $id);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return null;
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
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
        if ($stmt->execute()){
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
        
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':lim', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':off', $offset, PDO::PARAM_INT);

        if (!$stmt->execute()){
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
    
    public function getRestaurantReviews($resId) {
        $sql = "SELECT * FROM review INNER JOIN user "
                . " ON review.user_id=user.user_id AND review.restaurant_id=:resId "
                . " ORDER BY date_posted DESC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':resId', $resId, PDO::PARAM_INT);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateRestaurant($restaurantId, $description, $address, $phoneNum) {
        $sql = "UPDATE restaurant SET description=:description, address=:address, phone_no=:phoneNum "
                . " WHERE restaurant_id=:restaurantId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':restaurantId', $restaurantId);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phoneNum', $phoneNum);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }
    
    public function updateRestaurantThumbnail($restaurantId, $thumbnail) {
        $sql = "UPDATE restaurant SET thumbnail=:thumbnail "
                . " WHERE restaurant_id=:restaurantId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $stmt->bindParam(':thumbnail', $thumbnail, PDO::PARAM_LOB);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }
    
    public function updateRestaurantMenu($resId, $menu) {
        $sql = "UPDATE restaurant SET menu=:menu "
                . " WHERE restaurant_id=:restaurantId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $stmt->bindParam(':menu', $menu, PDO::PARAM_LOB);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }
    
    public function updateMultimedia($multimediaId, $img, $restaurantId) {
        if (intval($multimediaId) > 0) {
            $sql = "UPDATE multimedia SET media=:media WHERE multimedia_id=:multimediaId";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':multimediaId', $multimediaId, PDO::PARAM_INT);
            $stmt->bindParam(':media', $img, PDO::PARAM_LOB);
        }
        else {
            $sql = "INSERT INTO multimedia(restaurant_id, type, media) "
                    . " VALUES(:restaurantId, 'image', :media)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmt->bindParam(':media', $img, PDO::PARAM_LOB);
        }
        
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }
    
    public function updateOperatingHours($opHrs) {
        $sql = "UPDATE operating_hours SET monday_from=:mondayFrom, monday_to=:mondayTo, "
                . " tuesday_from=:tuesdayFrom, tuesday_to=:tuesdayTo, wednesday_from=:wednesdayFrom, "
                . " wednesday_to=:wednesdayTo, thursday_from=:thursdayFrom, thursday_to=:thursdayTo, "
                . " friday_from=:fridayFrom, friday_to=:fridayTo, saturday_from=:saturdayFrom, "
                . " saturday_to=:saturdayTo, sunday_from=:sundayFrom, sunday_to=:sundayTo "
                . " WHERE restaurant_id=:restaurantId";
        $stmt = $this->dbh->prepare($sql);
        $result = $stmt->execute(array(
            ':restaurantId' => $opHrs['restaurantId'],
            ':mondayFrom' => $opHrs['mondayFrom'],
            ':mondayTo' => $opHrs['mondayTo'],
            ':tuesdayFrom' => $opHrs['tuesdayFrom'],
            ':tuesdayTo' => $opHrs['tuesdayTo'],
            ':wednesdayFrom' => $opHrs['wednesdayFrom'],
            ':wednesdayTo' => $opHrs['wednesdayTo'],
            ':thursdayFrom' => $opHrs['thursdayFrom'],
            ':thursdayTo' => $opHrs['thursdayTo'],
            ':fridayFrom' => $opHrs['fridayFrom'],
            ':fridayTo' => $opHrs['fridayTo'],
            ':saturdayFrom' => $opHrs['saturdayFrom'],
            ':saturdayTo' => $opHrs['saturdayTo'],
            ':sundayFrom' => $opHrs['sundayFrom'],
            ':sundayTo' => $opHrs['sundayTo']
        ));
        
        if (!$result) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }
    
    public function setAverageRating ($restaurantId, $averageRating) {
        $sql = "UPDATE restaurant set average_rating=:averageRating "
                . " WHERE restaurant_id=:restaurantId";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $stmt->bindParam(':averageRating', $averageRating);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }
}

?>