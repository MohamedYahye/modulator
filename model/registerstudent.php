<?php 
	

	class registerStudent{


		private $ov_number;
		private $name;
		private $username;
		private $email;
		private $password;
		private $repeat;
		private $opleding;
		private $uitstroom;
		private $leerjaar;

		private $errorMessage;

		private $proceed;

		private $connect; 

		

		public function __construct(){
			require("connect.php");
			$this->proceed = false;	
			if(!empty(isset($_POST))){


				if(!empty(isset($_POST['ov']))){
					if(strlen($_POST['ov']) >= 4){
						$this->ov_number = $_POST['ov'];

						$this->proceed = true;
					}else{
						return false;
					}
				}

				if(!empty(isset($_POST['name']))){
					if(strlen($_POST['name']) > 0){
						$this->name = $_POST['name'];

						$this->proceed = true;
					}else{
						return false;
					}
				}

				if(!empty(isset($_POST['username']))){
					if(strlen($_POST['username']) > 0){
						$this->username = $_POST['username'];

						$this->proceed = true;
					}else{
						return false;
					}
				}

				if(!empty(isset($_POST['email']))){
					if(strlen($_POST['email']) > 0){
						$this->email = $_POST['email'];

						$this->proceed = true;
					}else{
						return false;
					}
				}

				if(!empty(isset($_POST['password']))){
					if(strlen($_POST['password']) > 0){
						$this->password = $_POST['password'];

						$this->proceed = true;
					}else{
						return false;
					}
				}

				if(!empty(isset($_POST['passwordrepeat']))){
					if(strlen($_POST['passwordrepeat']) > 0){
						$this->repeat = $_POST['passwordrepeat'];

						$this->proceed = true;
					}else{
						return false;
					}
				}
				if(!empty(isset($_POST['opleiding']))){
					if(strlen($_POST['opleiding']) > 0){
						$this->opleiding = $_POST['opleiding'];

						$this->proceed = true;
					}else{
						return false;
					}
				}


				if(!empty(isset($_POST['leerjaar']))){
					if(strlen($_POST['leerjaar']) > 0){
						$this->leerjaar = $_POST['leerjaar'];

						$this->proceed = true;
					}else{
						return false;
					}
				}

				if(!empty(isset($_POST['uitstroom']))){
					if(strlen($_POST['uitstroom']) > 0){
						$this->uitstroom = $_POST['uitstroom'];

						$this->proceed = true;
					}else{
						return false;
					}
				}
			
			}


			echo $this->registerStudent();
		}




		private function registerStudent(){
			
			require("passHash.php");
			$this->connect = new connect();
			$passHash = new PassHash();

			$unhashed = $this->returnPassword();

			try{
				
				$recht = "1";

				$hash = $passHash->hash($unhashed);

				$dbh = $this->connect->returnConnection();

				$doesUserExist = $this->doesUserExist();

				if($doesUserExist){
					echo "username or ov taken!";
				}else{

					$stmt = $dbh->prepare("INSERT INTO student (ov_nummer, name, 
					username, email, password, opleiding, leerjaar, uitstroom, recht_id)
					values(:ov_nummer, :name, :username, :email, :password, 
					:opleiding, :leerjaar, :uitstroom, :recht_id)");

					$stmt->bindParam(":ov_nummer", $this->returnOv());
					$stmt->bindParam(":name", $this->returnName());
					$stmt->bindParam(":username", $this->returnUsername());
					$stmt->bindParam(":email", $this->returnEmail());
					$stmt->bindParam(":password", $hash);
					$stmt->bindParam(":opleiding", $this->returnOpleiding());
					$stmt->bindParam(":leerjaar", $this->returnLeerjaar());
					$stmt->bindParam(":uitstroom", $this->returnUitstroom());
					$stmt->bindParam(":recht_id", $recht);

					if($stmt->execute()){
						echo "success";
					}else{
						echo "oeps!";
					}



				}
			}catch(PDOException $e) {
			    echo 'ERROR: ' . $e->getMessage();
			}

			
		}





		private function doesUserExist(){
			try{
				$this->connect = new connect();

				$dbh = $this->connect->returnConnection();


				$stmt = $dbh->prepare("SELECT * from  student WHERE ov_nummer = :ov_nummer");
				$stmt->bindParam(":ov_nummer", $this->returnOv());
				$stmt->execute();

				if($stmt->rowCount() > 0){
					return true;
				}else{
					return false;
				}

			}catch(PDOException $e){
				$e->getMessage();
			}
		}
		


		private function returnOv(){
			return $this->ov_number;
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

		private function returnPasswordRepeat(){
			return $this->repeat;
		}

		private function returnOpleiding(){
			return $this->opleiding;
		}

		private function returnLeerjaar(){
			return $this->leerjaar;
		}

		private function returnUitstroom(){
			return $this->uitstroom;
		}

	}


	new registerStudent();
?>