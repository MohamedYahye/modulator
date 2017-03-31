<?php 
	
	include_once("menu.php");
?>
<?php


	class createGroep {
		
		public function __construct(){

			require_once("../user.php");

			$current_user = new User();

			$current_user_info = $current_user->returnUserInfo();


			foreach($current_user_info as $user){
				if($user['recht_id'] == 1){
					echo "user is an student";
				}else{
					require("groepmaken.php");
				}
			}
		}

	}



	new createGroep();
?>