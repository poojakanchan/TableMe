<?php

//session_start();

  class Controller {

 	public function model($model) {
	require_once __DIR__ . '/../models/'. $model . '.php';
	return new $model;	
        }
        public function view($view, $data=array()) {
            require_once $view;
        }  
}

//echo ' in controller';

?>
