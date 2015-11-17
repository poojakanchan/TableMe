<?php

// session_start();
require_once 'Controller.php';

class Reservation_controller extends Controller {
    private $reservation;
    private $restaurant;
    
    public function __construct() {
        $this->reservation = $this->model('Reservation_model');
        $this->restaurant = $this->model('Restaurant_model');
    }
    public function getRestaurantNamesAll() {
        return $this->reservation->getRestaurantNamesAll();
    }
    public function add() {
        
        if (isset($_POST['submit-reservation']) || isset($_POST['submit'])) {
           
 
            //retrieve user_id if possible
            //retrieve restaurant id
       
        $reservation = $this->model('Reservation_model');

            $reserveName = htmlspecialchars($_POST["reservationFirstName"]) . " " . htmlspecialchars($_POST["reservationLastName"]);
            $reservePhone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["reservationPhone"]));
            $reserveMonth = date_parse(htmlspecialchars($_POST["month"]));
            $reserveYear = htmlspecialchars($_POST["year"]);
            $reserveDay = htmlspecialchars($_POST["day"]);
            
            $reserveDate = $reserveYear . "-" . $reserveMonth['month'] . "-" . $reserveDay;
            $groupSize = htmlspecialchars($_POST["guests"]);
            $reserveTime = date("H:i", strtotime(htmlspecialchars($_POST["time"])));
            $reserve_user_id=1;
            $restaurantID = htmlspecialchars($_POST["restaurant"]);
            
            
            //$testPeople = 4;
            //$testInstruct = "DEAD";
            $reserveArray = array(
               "restaurant_id" => $restaurantID,
               "user_name" => $reserveName,
               "date" => $reserveDate,
                
                "time" => $reserveTime,
                "user_id" => $reserve_user_id,
                
                "no_of_people" => $groupSize,
                "contact_no" => $reservePhone,
                "special_instruct" => htmlspecialchars($_POST["accommodations"])
                );
            if($groupSize == 2)
            {
                $capacity = "num_two_tables";
            }
            else if ($groupSize == 4)
            {
                $capacity = "num_four_tables";
            }
            else if ($groupSize == 6)
            {
                $capacity = "num_six_tables";
            }
            $dayOfWeek=date('l', strtotime($reserveDate));
            $opening=strtolower($dayOfWeek."_from");
            $closing=strtolower($dayOfWeek."_to");
            //$test=60;
            $operatingHoursArray=$this->reservation->getOperatingHoursByDay($opening, $closing, $restaurantID);
           // echo var_dump($operatingHoursArray);
            echo $operatingHoursArray[0][0];
            echo $operatingHoursArray[0][1];
            $openingTime=strtotime($operatingHoursArray[0][0]);
            $closingTime=strtotime($operatingHoursArray[0][1]);
            $reservationTime=strtotime($_POST['time']);
            if($closingTime < $openingTime)
            {
                $closingTime=strtotime("+1 day", $closingTime);
            }
            echo $openingTime."-";
            echo $closingTime;
            
            if($openingTime <= $reservationTime && $reservationTime <= $closingTime)
                echo"VALID TIME RESERVED";
            $reservationCount=$this->reservation->countReservation($reserveDate, $reserveTime, $restaurantID);
            $restaurantCapacity=$this->reservation->getTableCount($restaurantID, $capacity );
            echo "COUNT: ".$reservationCount."\n";
            echo "CAPACITY: ".$restaurantCapacity."\n";

            if($reservationCount < $restaurantCapacity)
            {
               
                if(!$reservation->addReservation($reserveArray)){
                    exit("Error adding reservation.");
                }
                else
                    echo " Reservation added successfully.";
            }
            else
                    echo "Reservations are full for given timeslot.";
            
 
            }
        }
}

?>