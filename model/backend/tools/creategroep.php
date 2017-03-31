<?php 
	

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	class createGroep{

		private $groupName;
		private $studentId;
		private $connection;
		private $proceed;


		public function __construct(){

			$this->groupName = null;
			$this->studentId = array();
			$this->connection = null;
			$this->proceed = false;


			require_once("../../connect.php");

			if(!empty(isset($_POST))){
				if(!empty(isset($_POST['groepnaam']))){
					if(strlen($_POST['groepnaam']) > 0){
						$this->groupName = $_POST['groepnaam'];
						$this->proceed = true;

					}else{
						$this->proceed = false;
					}
				}
				
				if(!empty($_POST['checked']) && (isset($_POST['checked']))){

					foreach($_POST['checked'] as $checked){
						$this->studentId[] = $checked;

						$this->proceed = true;
					}
				}else{
					$this->proceed = false;
				}

			}


			if($this->proceed){
				$this->createGroep();
				
			}else{
				echo "oeps...";
			}


			
		}


		private function createGroep(){
			try{

			

				$this->connection = new connect();

				$dbh = $this->connection->returnConnection();

				$studentIdArray = array();


				$groep_id = $this->saveGroup();


				$studentIdArray = $this->returnStudentIdArray();


				$stmt = $dbh->prepare("INSERT INTO koppeltabel (groep_id, student_id) VALUES(:groep_id, :student_id)");
				$stmt->bindParam(":groep_id", $groep_id);
				foreach($studentIdArray as $student){
					$stmt->bindParam(":student_id", $student);
					
					if($stmt->execute()){
						header("Location:../groepen.php");
					}else{
						echo "oeps.. group not made";
					}

					//echo $dbh->lastInsertId();
				}				



			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function saveGroup(){
			try{


				

				$this->connection = new connect();

				$dbh = $this->connection->returnConnection();

				$groep_name = $this->returnGroupName();


				$stmt = $dbh->prepare("INSERT INTO groep (groep_naam) VALUES(:groep_naam)");

				$stmt->bindParam(":groep_naam", $groep_name);

				if($stmt->execute()){
					return $dbh->lastInsertId();
				}else{
					return false;
				}


			$this->connection->closeConnection();
			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		private function returnStudentIdArray(){
			return $this->studentId;
		}

		private function returnGroupName(){
			return $this->groupName;
		}

	}



	new createGroep();

?>