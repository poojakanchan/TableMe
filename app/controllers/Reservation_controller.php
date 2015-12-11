<?php

// session_start();
require_once 'Controller.php';

class Reservation_controller extends Controller {
    private $reservation;
    //private $restaurant;
    
    public function __construct() {
        $this->reservation = $this->model('Reservation_model');
        //$this->restaurant = $this->model('Restaurant_model');
    }
    /* accesses method to retrieve all restaurant names.
     * no longer used due to design changes.
     */
    public function getRestaurantNamesAll() {
        return $this->reservation->getRestaurantNamesAll();
    }
    /* Detects if a form is submitted. If so, does all calculations and adds reservation
     * to reservation table.
     */
    public function add() {
        
        //two checks due to reservation form being separate initially.
        if (isset($_POST['submit-reservation']) || isset($_POST['submit'])) {
      
            $reservation = $this->model('Reservation_model');

            //parsing information from form submission
            $reserveName = htmlspecialchars($_POST["reservationFirstName"]) . " " . htmlspecialchars($_POST["reservationLastName"]);
            $reservePhone = preg_replace("/[^0-9]/", "", htmlspecialchars($_POST["reservationPhone"]));
            
            /*OLD FORM FORMAT 
            $reserveMonth = date_parse(htmlspecialchars($_POST["month"]));
            $reserveYear = htmlspecialchars($_POST["year"]);
            $reserveDay = htmlspecialchars($_POST["day"]);
             * 
             */
            
            //parse string and separate date input and format properly for SQL insertion
            $reserveDateElements = explode("/", $_POST['date']);
            $reserveDate = $reserveDateElements[2]."-".$reserveDateElements[0]."-".$reserveDateElements[1];
            //echo $reserveDate;
            
            //$reserveDate = $reserveYear . "-" . $reserveMonth['month'] . "-" . $reserveDay;
            $groupSize = htmlspecialchars($_POST["guests"]);
            $reserveHours = htmlspecialchars($_POST["hours"]);
            //echo "Hours: ".$reserveHours;
            $reserveMinutes = htmlspecialchars($_POST["minutes"]);
            //echo "Minutes: ".$reserveMinutes;
            $reserveAmPm = htmlspecialchars($_POST["ampm"]);
            //echo "am/pm: ".$reserveAmPm;
            $reserveTime = $reserveHours.$reserveMinutes.$reserveAmPm;
            //echo $reserveTime;
            $reserveTime = date("H:i", strtotime($reserveTime));
            //echo $reserveTime;
            $reserve_user_id = htmlspecialchars($_POST['userid']);
            echo $reserve_user_id;
            $restaurantID = htmlspecialchars($_POST["restaurant"]);
            
            
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
            
            //formatting string for $capacity in table count method
            if($groupSize == 2 || $groupSize == 1)
            {
                $groupSize = 2;
                $capacity = "num_two_tables";
            }
            else if ($groupSize == 4 || $groupSize == 3)
            {
                $groupSize = 4;
                $capacity = "num_four_tables";
            }
            else if ($groupSize == 6 || $groupSize == 5)
            {
                $groupSize = 6;
                $capacity = "num_six_tables";
            }
            
            /*/*converts selected date to a day of the week then concats XXday
             * to XXday_from and XXday_to for use in the operating hours method
             */ 
            $dayOfWeek=date('l', strtotime($reserveDate));
            $opening=strtolower($dayOfWeek."_from");
            $closing=strtolower($dayOfWeek."_to");
            
            $operatingHoursArray=$this->reservation->getOperatingHoursByDay($opening, $closing, $restaurantID);
            
           //echo var_dump($operatingHoursArray);
           // OUTPUTS THE OPENING AND CLOSING TIMES AS READ FROM DATABASE
            //echo $operatingHoursArray[0][0];
            //echo $operatingHoursArray[0][1];
            
            /*convert the retrieved operating hours and the reservation time to unix
             * timestamps for comparison and hour checking.
             * 
             */
            $openingTime=strtotime($operatingHoursArray[0][0]);
            $closingTime=strtotime($operatingHoursArray[0][1]);
            $reservationTime=strtotime($reserveTime);
            
            /*if the closing time is past midnight, add 24 hours to the timestamp
             * otherwise time interval comparison will be off
             */
            if($closingTime < $openingTime)
            {
                $closingTime=strtotime("+1 day", $closingTime);
            }
            
            //FOR DEBUGGING, OUTPUTS UNIX TIMESTAMPS FOR THE OPENING/CLOSING/RESERVATION TIMES
            //echo $openingTime."-";
            //echo $closingTime;
            //echo "reservation time: ".$reservationTime;
            
            $reservationCount=$this->reservation->countReservation($reserveDate, $reserveTime, $restaurantID, $groupSize);
            $restaurantCapacity=$this->reservation->getTableCount($restaurantID, $capacity );
            
            //FOR DEBUGGING, OUTPUTS THE CURRENT COUNT OF RESERVATIONS FOR TIMESLOT
            //echo "COUNT: ".$reservationCount."\n";
            //echo "CAPACITY: ".$restaurantCapacity."\n";
            
            //test if reservation time is within operating hours interval for restaurant
            if($reservationTime >= $openingTime && $reservationTime <= $closingTime)
            {
                //check to see if the number of reservations for type of tables does not exceed capacity.
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
            else
                echo "The restaurant is not open at the selected time or date. Please select another.";
        }
    }
    //minor test function to see if header requirements work.
    public function test(){
        echo "TEST COMPLETE.";
    }
}

?>