<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Restaurant_registration_model extends Database {
    
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
     public function addOwner($ownerArray) {
        $sql = "INSERT INTO owner(name, email, contact_no, address, restaurant_id, username) "
                . "VALUES(:name, :email, :contact_no, :address, :resId, :username)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $ownerArray['name']);
        $stmt->bindParam(':email', $ownerArray['email']);
        $stmt->bindParam(':contact_no', $ownerArray['phone']);
        $stmt->bindParam(':address', $ownerArray['address']);
       // $stmt->bindParam(':resId', $ownerArray['resId'], PDO::PARAM_INT);
        $stmt->bindParam(':username', $ownerArray['username']);
       // return $this ->insertDB($stmt);
        return $stmt;
    }
     public function add_operating_hours($operArray) {
        $sql = "INSERT INTO operating_hours(restaurant_id,monday_from,tuesday_from,wednesday_from,thursday_from,friday_from,"
                . "saturday_from,sunday_from,monday_to,tuesday_to,wednesday_to,thursday_to,friday_to,"
                . "saturday_to,sunday_to) "
                . "VALUES(:resId, :mon_from, :tues_from, :wednes_from, :thurs_from, :fri_from,:satur_from,:sun_from,"
                . ":mon_to, :tues_to, :wednes_to, :thurs_to, :fri_to,:satur_to,:sun_to)";
        
       
        $stmt = $this->dbh->prepare($sql);
    //    $stmt->bindParam(':resId', $operArray['resId']);
        $stmt->bindParam(':mon_from', $operArray['mondayFrom']);
        $stmt->bindParam(':tues_from', $operArray['tuesdayFrom']);
        $stmt->bindParam(':wednes_from', $operArray['wednesdayFrom']);
        $stmt->bindParam(':thurs_from', $operArray['thursdayFrom']);
        $stmt->bindParam(':fri_from', $operArray['fridayFrom']);
        $stmt->bindParam(':satur_from',$operArray['saturdayFrom']);
        $stmt->bindParam(':sun_from', $operArray['sundayFrom']);
        $stmt->bindParam(':mon_to', $operArray['mondayTo']);
        $stmt->bindParam(':tues_to', $operArray['tuesdayTo']);
        $stmt->bindParam(':wednes_to', $operArray['wednesdayTo']);
        $stmt->bindParam(':thurs_to', $operArray['thursdayTo']);
        $stmt->bindParam(':fri_to', $operArray['fridayTo']);
        $stmt->bindParam(':satur_to', $operArray['saturdayTo']);
        $stmt->bindParam(':sun_to', $operArray['sundayTo']);
        return $stmt;
       // return $this ->insertDB($stmt);
        
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
    
    /* add a restaurant to the restaurant table. The restaurant information is in an associative array argument*/
    public function addRestaurant($resArray,$thumbnail,$menuFile) {
        
       /* $fhThumbnail = $fhMenu = null;
        if (!empty($resArray['thumbnail'])) {
            $fhThumbnail = fopen($resArray['thumbnail'], 'rb');
        }
        if (!empty($resArray['menu'])) {
            $fhMenu = fopen($resArray['menu'], 'rb');
        }        
       */
        
        $sql = "INSERT INTO restaurant(name, food_category_name, phone_no, address, thumbnail, description, flag_new, menu, capacity, num_two_tables, num_four_tables,num_six_tables, name_address) VALUES(:name, :food_category_name, :phone_no, :address, :thumbnail, :description, :flag_new, :menu, :capacity, :num_two_tables, :num_four_tables,:num_six_tables, :name_address)";
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':name', $resArray['name']);
        $stmt->bindParam(':food_category_name', $resArray['food_category_name']);
        $stmt->bindParam(':phone_no', $resArray['phone_no']);
        $stmt->bindParam(':address', $resArray['address']);
        $stmt->bindParam(':thumbnail', $thumbnail);
        $stmt->bindParam(':description', $resArray['description']);
        $stmt->bindParam(':flag_new', $resArray['flag_new']);
        $stmt->bindParam(':menu', $menuFile);
        $stmt->bindParam(':capacity', $resArray['capacity']);
        $stmt->bindParam(':num_two_tables', $resArray['twos']);
        $stmt->bindParam(':num_four_tables', $resArray['fours']);
        $stmt->bindParam(':num_six_tables', $resArray['sixes']);
        $nameAddress = $resArray['name']." ".$resArray['address'];
        $stmt->bindParam(':name_address', $nameAddress);
        return $stmt;
    }
    
    
    public function registerRestaurant($resArray,$ownerArray,$operatinghours,$username, $password,$thumbnail,$menuFile) {
        
    
    
    try {
            $this->dbh->beginTransaction();
            $this->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT,0);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $this->addLogin($username, $password, "owner");
            if (!$stmt->execute()) {
                exit("Error adding login information");
            } else 
            {
                
                $stmt = $this->addRestaurant($resArray,$thumbnail,$menuFile);
           
                if (!$stmt->execute()) {          
                       exit("Error adding restaurant information");
                }
                else  {
                      //  $stmt->debugDumpParams();

                        $resId = intval($this->dbh->lastInsertId());
                        $stmt = $this->addOwner($ownerArray);
                        $stmt->bindParam(':resId', $resId, PDO::PARAM_INT);
                        if (!$stmt->execute()) {
                            exit("Error adding owner to database");
                        }
                   else {
                       // $stmt->debugDumpParams();

                       
                        $stmt = $this->add_operating_hours($operatinghours);
                        $stmt->bindParam(':resId',$resId, PDO::PARAM_INT);
                         if (!$stmt->execute()) {
                            exit("Error adding operation hours of rstaurant to database");
                        }
                      
                        $this->dbh->commit();
                        $this->dbh->setAttribute(PDO::ATTR_AUTOCOMMIT,1);
                          return 1;
                   }
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