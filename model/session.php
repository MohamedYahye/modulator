<?php 
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


	class session{

		function __construct(){
			session_start();
		}


		public function setUser($user_id){
			
			$_SESSION['user_id'] = $user_id;
		}


		public function returnUsername(){

			if(!empty($_SESSION['user_id'])){
				return $_SESSION['user_id'];
			}else{
				return false;
			}

			
		}


		public function destroySession(){
			session_destroy();
		}
	}

?>