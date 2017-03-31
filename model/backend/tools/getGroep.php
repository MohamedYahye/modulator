<?php 

	
	class Group{
		public function __construct(){
			$this->Group();
		}


		public function Group(){


			try{

				require_once("../connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$stmt = $dbh->prepare("SELECT DISTINCT groep_id FROM koppeltabel");

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

					return $result;
				}

			}catch(PDOException $e){
				return $e->getMessage();
			}


		}


		public function getgroupName($id){
			try{

				require_once("../connect.php");

				$connect = new connect();

				$dbh = $connect->returnConnection();

				$stmt = $dbh->prepare("SELECT groep_naam FROM groep where groep_id=:id");

				$stmt->bindParam(":id", $id);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetch(PDO::FETCH_ASSOC); 

					return $result;
				}

			}catch(PDOException $e){
				return $e->getMessage();
			}

		}



		
	}



?>