<?php

class Restaurant_controller extends Controller
{
    public function index() {
		
        $restaurant = $this->model('Restaurant_model');
            if ($_POST) {
               
            $nameAdd = htmlspecialchars($_POST["searchText"]);
            $restaurant_array = $restaurant->findRestaurantsByNameAddress($nameAdd);            
            } else {
              
                //echo $name;		
		//$user->name = $name;
		$restaurant_array = $restaurant->getAllRestaurants();               
            }
            $this->view('home/index',array('restaurants' => $restaurant_array));
	}
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>