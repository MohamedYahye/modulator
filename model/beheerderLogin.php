<?php 

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


	class BeheerderLogin{


		private $username;
		private $password;

		private $connection;

		private $proceed;


		public function __construct(){

			require("connect.php");
			require("passHash.php");

			$this->connection = false;
			
			$this->proceed = false;


			if(!empty(isset($_POST))){
				if(!empty(isset($_POST['username']))){
					if(strlen($_POST['username']) > 0){
						$this->username = $_POST['username'];

						$this->proceed = true;
					}else{
						return false;
					}
				}else{
					return false;
				}


				if(!empty(isset($_POST['password']))){
					if(strlen($_POST['password']) >= 6){
						$this->password = $_POST['password'];

						$this->proceed = true;
					}else{
						return false;
					}
				}
			}else{
				echo "oeps!!!!";
			}



			if($this->proceed){
				$this->Login();
			}
		

		}



		private function Login(){

			try{

				$username = $this->username;

				echo $username . "<br />";

				$this->connection = new connect();

				$passHash = new passHash();

				$dbh = $this->connection->returnConnection();

				$stmt = $dbh->prepare("SELECT * FROM beheerder WHERE username=:username");

				$stmt->bindParam(":username", $username);

				$stmt->execute();

				if($stmt->rowCount() > 0){

					while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {



						$password = $this->password;

						echo $password . "<br />" . $row['password'] . "<br />";

						
						$check = $passHash->check_password($row['password'], $password);


						if($check){
							echo $row['email'];
						}else{
							echo "incorrect password...... <br />";
						}
					}
				}else{
					echo "username or password incorrect";
				}





			}catch(PDOException $e){
				echo $e->getMessage();
			}


		}

	}


	new BeheerderLogin();


?>