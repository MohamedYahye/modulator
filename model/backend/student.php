<?php 

	

	class students{

		private $connection;

		private $studentArray;

		public function __construct(){

			$this->connection = null;
			$this->studentArray = [];



			$this->getStudents();

		}


		private function getStudents(){

			try{

				require_once("../connect.php");

				$this->connection = new connect();

				$dbh = $this->connection->returnConnection();


				$stmt = $dbh->prepare("SELECT username, name, student_id FROM student WHERE recht_id=:recht_id");

				$recht_id = 1;

				$stmt->bindParam(":recht_id", $recht_id);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll();

					$this->studentArray = $result;
				}


			}catch(PDOException $e){
				return $e->getMessage();
			}


		}


		public function returnStudentArray(){
			return $this->studentArray;
		}
	}


?>