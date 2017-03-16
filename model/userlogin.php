<?php 
	
	class UserLogin{


		private $ov_number;
		private $password;


		private $connection;

		private $proceed;

		public function __construct(){

			require("connect.php");

			$this->connect = null;

			$this->proceed = false;


			if(!empty(isset($_POST))){

				if(!empty(isset($_POST['ov']))){
					if(count($_POST['ov']) > 0){
						$this->ov_number = $_POST['ov'];

						$this->proceed = true;
					}else{
						$this->proceed = false;
					}
				}

				if(!empty(isset($_POST['password']))){
					if(strlen($_POST['password']) >= 6){
						$this->password = $_POST['password'];

						$this->proceed = true;
					}else{
						$this->proceed = false;
					}
				}
			}
			


			if($this->proceed){
				$this->UserLogin();
			}else{
				echo "no fam";
			}
		}



		private function UserLogin(){

			try{

				require("passHash.php");

				$this->connect = new connect();

				$pashash = new PassHash();


				$dbh = $this->connect->returnConnection();


				$stmt = $dbh->prepare("SELECT * FROM student WHERE ov_nummer=:ov");

				$ov_number = $this->returnov_number();

				$stmt->bindParam(":ov", $ov_number);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$password = $this->returnPassword();
						$check = $pashash->check_password($row['password'], $password);


						if($check){
							echo $row['uitstroom'];
						}else{
							echo "incorrect password <br />";
						}
					}
				}else{
					echo "username or password incorrect";
				}


			}catch(PDOException $e){
				$e->getMessage();
			}





		}


		private function returnov_number(){
			return $this->ov_number;
		}

		private function returnPassword(){
			return $this->password;
		}



	}




	new UserLogin();


?>