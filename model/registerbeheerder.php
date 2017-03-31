<?php 
	
	class RegisterBeheerder{


		private $name;
		private $username;
		private $email;
		private $password;

		private $proceed;

		private $connect;

		public function __construct(){
			
			require("connect.php");

			$this->proceed = false;

			if(!empty(isset($_POST))){
				if(!empty(isset($_POST['name']))){
					if(count($_POST['name']) > 0){

						$this->name = $_POST['name'];

						$this->proceed = true;
					}else{
						$this->proceed = false;
					}
				}

				if(!empty(isset($_POST['username']))){
					if(count($_POST['username']) > 0){
						$this->username = $_POST['username'];
						$this->proceed = true;
					}else{
						$this->proceed = false;
					}
				}

				if(!empty(isset($_POST['email']))){
					if(count($_POST['email']) > 0){
						$this->email = $_POST['email'];

						$this->proceed = true;
					}else{
						$this->proceed = false;
					}

				}


				if(!empty(isset($_POST['password']))){
					if(count($_POST['password']) >= 6){
						$this->password = $_POST['password'];

						$this->proceed = true;
					}else{
						$this->proceed = false;
					}
				}


				if(!empty(isset($_POST['passwordrepeat']))){
					if($_POST["passwordrepeat"] == $_POST['password']){
						$this->proceed = true;
					}else{
						$this->proceed = false;
					}
				}
			}



			if($this->proceed){
				$doesUserExist = $this->doesUserExist();


				if($doesUserExist){
					echo "user allready exists";
				}else{
					$this->RegisterBeheerder();
				}


			}

		}



		private function RegisterBeheerder(){
			//require("passHash.php");

			

			try{

				require("passHash.php");

				$recht_id = "0";

				$passHash = new passHash();

				$unhashed = $this->returnPassword();
				$hash = $passHash->hash($unhashed);
				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();


				$name = $this->returnName();
				$username = $this->returnUsername();
				$email = $this->returnEmail();


				$stmt = $dbh->prepare("INSERT INTO beheerder (name, username, email, password, recht_id) 
					VALUES(:name, :username, :email, :password, :recht_id)");



				$stmt->bindParam(":name", $name);
				$stmt->bindParam(":username", $username);
				$stmt->bindParam(":email", $email);
				$stmt->bindParam(":password", $hash);
				$stmt->bindParam(":recht_id", $recht_id);


				if($stmt->execute()){
					echo "success";
				}else{
					echo "no success";
				}

				$dbh = $this->connect->closeConnection();

			}catch(PDOException $e){
				$e->getMessage();
			}


		}




		private function doesUserExist(){

			try{

				$username = $this->returnUsername();

				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();


				$stmt = $dbh->prepare("SELECT name FROM beheerder WHERE name = :name");

				$stmt->bindParam(":name", $username);


				$stmt->execute();

				if($stmt->rowCount() > 0){
					return true;
				}else{
					return false;
				}


				$dbh = $this->connect->closeConnection();

			}catch(PDOException $e){
				$e->getMessage();
			}
		}



		private function returnName(){
			return $this->name;
		}

		private function returnUsername(){
			return $this->username;
		}

		private function returnEmail(){
			return $this->email;
		}

		private function returnPassword(){
			return $this->password;
		}
	}


	new RegisterBeheerder();

?>