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
     
        $reservation_array = $this->reservation->getReservationById($reservationId);
        $reservation = $reservation_array[0];
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
        $reservation_controller = new Reservation_controller();
        $reservation_controller->add();
    }
    
    public function cancelReservation($resId,$reservationId) {
        $this->reservation->deleteReservation($reservationId);
    }
    
    public function getRestaurant($username){
        $hostess_model = $this->model('Hostess_model');
        $hostess = $hostess_model->getHostessByUserName($username);
        $restaurant_model = $this->model('Restaurant_model');
        
        $restaurant = $restaurant_model->findRestaurantById($hostess['restaurant_id']);
        //$restaurant = $restaurant[0];
        
        $resInfo = array("res_id" => $hostess['restaurant_id'],
                         "res_name" => $restaurant[0]['name'],
                          "thumbnail" =>  base64_encode($restaurant[0]['thumbnail'])
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
        $host_controller = new Host_controller();    
        $reservations =  $host_controller->getReservationsByRestaurantIdAndDate($_POST['date'],$_POST['resId']);
        print_r(json_encode($reservations));
    }
    if (isset($_POST['resId']) && isset($_POST['reservationId'])) {
        $host_controller = new Host_controller();    
        $host_controller->markArrived($_POST['resId'],$_POST['reservationId']);
        
    }
    
?>