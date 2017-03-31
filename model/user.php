<?php 
	

	class User{

		public static function returnUserInfo(){

			require("session.php");
			require("connect.php");

			try{

				$session = new session();

				$user_id = $session->returnUsername();

				if($user_id != false){


					$connection = new connect();

					$dbh = $connection->returnConnection();

					$stmt = $dbh->prepare("SELECT * FROM student WHERE student_id=:student_id");

					$stmt->bindParam(":student_id", $user_id);

					$stmt->execute();

					if($stmt->rowCount() > 0 ){
						

						$result = $stmt->fetchAll();
						return $result;


					}else{
						return false;
					}



				}else{
					return false;
				}


				$connection->closeConnection();

			}catch(PDOException $e){
				return $e->getMessage();
			}
		}
	}



?>