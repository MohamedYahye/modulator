<?php 


	
	class phpHasher{

		public static function hash($unhashed){


			$password_bcrypt = password_hash($unhashed, PASSWORD_BCRYPT);


			return $password_bcrypt;
		}


		public static function checkPassword($password, $hash){

			return password_verify($password, $hash);
			
		}
	}

?>