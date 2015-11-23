<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User_visited_model
 *
 * @author pooja
 */
require_once 'Database.php';
class User_visited_model extends Database {
    public function addToUserVisited($resId,$user_id,$date,$time){
        echo '  '. $resId.' ' . '  '.$date .' ' .$time. ' '.$user_id;
        $sql = "INSERT INTO user_visited(restaurant_id, user_id,date,time) VALUES(:restaurant_id,:user_id,:date,:time)";
       $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':restaurant_id', $resId);
        $stmt->bindParam(':user_id',$user_id);
        $stmt->bindParam(':date',$date );
         $stmt->bindParam(':time',$time);
        try {
            $this->dbh->beginTransaction();
            if ($stmt->execute()) {
                
                $this->dbh->commit();
                return 1;
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
            echo $ex->getTrace();
        }
        $this->dbh->rollBack();
        return -1;
    }
}

