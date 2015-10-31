<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

  class Controller {

 	public function model($model) {
	require_once $_SESSION['ROOT'] .'/app/models/'. $model . '.php';
	return new $model;	
        }
        public function view($view, $data=array()) {
            require_once $view;
        }  
}

//echo ' in controller';

?>
