<?php //

/**
 * class to handle database functions of user class.
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
    
    /*
     * function to add login details in the database.
     */
    public function addLogin($username, $password, $role) {
        $sql = "INSERT INTO login(username, password, role) VALUES(:name, :pswd, :role)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $username);
        $stmt->bindParam(':pswd', $password);
        $stmt->bindParam(':role', $role);
        return $stmt;
     //   return $this->insertDB($stmt);
    }
    
    /*
     * function to build database query to add user to database.
     */
    public function prepareUserQuery($name,$email,$phone,$username) {
        $sql = "INSERT INTO user(name,email,contact,username) VALUES(:name,:email, :contact,:username)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':contact',$phone);
        $stmt->bindParam(':username',$username);
       return $stmt;
    }
    
    /*
     * function to add user to database.
     */
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
 //           
        }
        echo $ex->getMessage();
        $this->dbh->rollBack();
        $this->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
        return -1;
            
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

    /*
     * function to retrive profile picture of the user.
     */
    public function getUserImage($username) {
        $sql = "SELECT user_image FROM user WHERE username=:username";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        if ($stmt->execute()) {
            return $stmt->fetch();
        }
        return null;
    }

    /*
     * function to retrive reviews of the provided user.
     */
    public function getUserReviews($userId) {
        $sql = "SELECT r.name, r.restaurant_id, w.review_description, w.date_posted "
                . " FROM review w, restaurant r "
                . " WHERE w.user_id=:userId AND w.restaurant_id=r.restaurant_id";

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /*
     * function to retrive reservations of the provided user.
     */
    public function getUserReservations($userId) {
        $sql = "SELECT n.reservation_id, n.date, n.time, r.name, n.no_of_people FROM reservation n, restaurant r "
                . " WHERE n.user_id=:userId AND n.restaurant_id=r.restaurant_id "
                . " ORDER BY n.date DESC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return null;
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /*
     * function to update user information like email id, password, contact details.
     */
    public function updateUser($username, $newContact, $newEmail, $newPassword, $newImage) {
        if (!empty($newPassword)) {
            $sql = "UPDATE login SET password=:newPassword WHERE username=:username";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(':newPassword', $newPassword);
            $stmt->bindParam(':username', $username);
            if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
                return false;
            }
        }

        if ($newImage != null) {
            $sql = "UPDATE user SET contact=:newContact, email=:newEmail, user_image=:newImage "
                    . "WHERE username=:username";
        } else {
            $sql = "UPDATE user SET contact=:newContact, email=:newEmail "
                    . "WHERE username=:username";
        }

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':newContact', $newContact);
        $stmt->bindParam(':newEmail', $newEmail);
        if ($newImage != null) {
            $stmt->bindParam(':newImage', $newImage, PDO::PARAM_LOB);
        }
        $stmt->bindParam(':username', $username);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            return false;
        }
        return true;
    }
    
    

//    public function getReview($restaurant_id, $user_id) {
//        $sql = "SELECT review_description FROM review "
//                . "WHERE restaurant_id=:restaurant_id AND user_id=:user_id";+
//        $stmt = $this->dbh->prepare($sql);
//        $stmt->bindParam(':restaurant_id', $restaurant_id, PDO::PARAM_INT);
//        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
//        if ($stmt->execute()) {
//            return $stmt->fetch();
//        }
//        return null;
//    }
    
}
?>