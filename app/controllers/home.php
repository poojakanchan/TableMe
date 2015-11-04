<?php

class Home extends Controller {
	
	public function __construct() {
	

	}


	public function index($name = '') {
		//echo $name;
		$user = $this->model('User');
		$user->name = $name;
		
                $this->view('home/index',array('name' => $user->name));
                
	}

}

?>
