<?php


/**
 * Description of Host_controller
 *
 * @author pooja
 */


require_once 'Controller.php';
class Host_controller extends Controller{

    private $reservation;
    
    public function __construct() {
        $this->reservation = $this->model('Reservation_model');
        //$this->restaurant = $this->model('Restaurant_model');
    }
    
    public function  getReservationsByRestaurantIdAndDate($date,$resId) {
        return $this->reservation->getReservationByDateAndRestaurantId($date,$resId);
    }
    
    public function markArrived($resId, $reservationId){
     
        $reservationAarray = $this->reservation->getReservationById($reservationId);
        $reservation = $reservationAarray[0];
        $this->reservation->markArrived($reservationId);
       /* $user_visited = $this->model('User_visited_model');
        
        $restaurant_Id = $reservation['restaurant_id'];
        $user_id= $reservation['user_id'];
        echo 'userid ' .$user_id . '  ';
        if($restaurant_Id == $resId && $user_id != null){
            $date = $reservation['date'];
            $time = $reservation['time'];
            echo $date . ' '. $resId. ' ' .$time . ' '.$user_id;
            echo $user_visited->addToUserVisited($resId,$user_id,$date,$time);
        }*/
        
    }
    
    public function makeReservation() {
        require_once 'Reservation_controller.php';
        $reservationController = new Reservation_controller();
        $reservationController->add();
    }
    
    public function cancelReservation($resId,$reservationId) {
        $this->reservation->deleteReservation($reservationId);
    }
    
    public function getRestaurant($username){
        $hostessModel = $this->model('Hostess_model');
        $hostess = $hostessModel->getHostessByUserName($username);
        $restaurantModel = $this->model('Restaurant_model');
       // echo 'hostess ' . $hostess . "  " . $hostess['restaurant_id'];
        $restaurant = $restaurantModel->findRestaurantById($hostess['restaurant_id']);
       //print_r($restaurant); 
        
        $resInfo = array("res_id" => $hostess['restaurant_id'],
                         "res_name" => $restaurant['name'],
                          "thumbnail" =>  base64_encode($restaurant['thumbnail'])
                        );
        return $resInfo;
    }
    public function getReservationDate($reservation_id) {
        $reservation =  $this->reservation->getReservationById($reservation_id);
      //  print_r($reservation);
        return $reservation[0]['date'];
    }
}

if (isset($_POST['date']) && isset($_POST['resId'])) {
        $hostController = new Host_controller();    
        $reservations =  $hostController->getReservationsByRestaurantIdAndDate($_POST['date'],$_POST['resId']);
        print_r(json_encode($reservations));
    }
    if (isset($_POST['resId']) && isset($_POST['reservationId'])) {
        $hostController = new Host_controller();    
        $hostController->markArrived($_POST['resId'],$_POST['reservationId']);
        
    }
    
?>