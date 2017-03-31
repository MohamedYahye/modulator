<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);


	require("menu.php");



	class EditGroup{

		private $groupName;
		private $groupMembers;

		private $proceed;

		private $conncetion;


		private $data;

		public function __construct(){

			require_once("../connect.php");


			$this->proceed = false;
			$this->conncetion = null;

			$this->groupName = null;
			
			if(!empty(isset($_GET['group']))){

				$this->groupName = base64_decode($_GET['group']);

				$this->proceed = true;


			}else{
				return false;

				echo "oeps....";
			}


			if($this->proceed){

				//echo $this->groupName;
			}else{
				echo "oeps something went wrong";
			}



		}



		public function returnGroupId(){


			try{

				$groupName = $this->returnGroupName();


				

				$this->conncetion = new connect();


				$dbh = $this->conncetion->returnConnection();


				$stmt = $dbh->prepare("SELECT groep_id FROM groep WHERE groep_naam = :groep_naam");

				$stmt->bindParam(":groep_naam", $groupName);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetch();

					return $result['groep_id'];
				}

				$this->conncetion->closeConnection();
			}catch(PDOException $e){
				return $e->getMessage();
			}

		}



		public function getGroupMemebersById(){

			try{

				$group_id = $this->returnGroupId();


				$this->conncetion = new connect();

				$dbh = $this->conncetion->returnConnection();

				$stmt = $dbh->prepare("SELECT student_id FROM koppeltabel WHERE groep_id=:groep_id");

				$stmt->bindParam(":groep_id", $group_id);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll();

					return $result;
				}
				$this->conncetion->closeConnection();
			}catch(PDOException $e){
				return $e->getMessage();
			}


		}


		public function getGroupMemebersByName(){

			try{

				$student_id = $this->getGroupMemebersById();

				$this->conncetion = new connect();

				$dbh = $this->conncetion->returnConnection();

				$stmt = $dbh->prepare("SELECT username FROM student WHERE student_id=:student_id");

				$result_set = array();



				for($i = 0; $i < count($student_id); $i++){

					foreach($student_id as $i){

						$stmt->bindParam(":student_id", $i['student_id']);
						$stmt->execute();
						$result = $stmt->fetch(PDO::FETCH_ASSOC);


						foreach($result as $fuck){
							echo "<tr><td><input type='text' readonly='true'value=".$fuck."></td>

									<td><i class='fa fa-trash ' aria-hidden='true'>
									<input type='hidden' value=".$fuck.">
									</i></td>
									</td>";
						}

						
					}
				}

			}catch(PDOException $e){
				return $e->getMessage();
			}

		}



		public function returnLeftMembers(){
			try{

				require_once("student.php");

				$students = new students();

				$returnStudentArray = $students->returnStudentArray();

				$groupId = $this->returnGroupId();


				$this->conncetion = new connect();

				$dbh = $this->conncetion->returnConnection();



					//"SELECT student_id from student WHERE recht_id != 0 AND student.student_id NOT IN(SELECT student_id FROM koppeltabel WHERE koppeltabel.groep_id = 81)"


				$stmt = $dbh->prepare("SELECT username, student_id from student WHERE recht_id != 0 AND student.student_id NOT 
					IN(SELECT student_id FROM koppeltabel WHERE koppeltabel.groep_id = :groep_id)");

				$stmt->bindParam(":groep_id", $groupId);

				$stmt->execute();

				if($stmt->rowCount() > 0){
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $result;
				}



				



				
				$this->conncetion->closeConnection();
			}catch(PDOException $e){
				return $e->getMessage();
			}
		}


		public function returnGroupName(){
			return $this->groupName;
		}





	}


	$group = new EditGroup();

?>



<!DOCTYPE html>
<html>
<head>
	<title>Bewerk groep</title>
	<link rel="stylesheet" type="text/css" href="../../controller/css/groepmaken.css">
	<link rel="stylesheet" type="text/css" href="../../controller/css/editgroep.css">
	<link rel="stylesheet" type="text/css" href="../../controller/css/pure-table.css">
	<script  type="text/javascript" src="../../controller/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="../../controller/css/font-awesome-4.7.0/css/font-awesome.css">
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
</head>
<body>


	<div class="_wrap">
		
		<div class="_content">
			
			<form name="groepmaken" class="form" method="post" action="tools/creategroep.php">
				
				<?php 

					

					$group_name = $group->returnGroupName();

				?>

					<?php echo "<h1 id='groepnaam'>Bewerk groep #'".$group_name."'</h1>";?>
					<input type="text" name="groepnaam" value="<?php echo $group_name;?>"><br /><br />
				

				<div class="groep-leden">
					<h3>Groep leden</h3>

					<table class="pure-table pure-table-bordered">
					    <thead>
					        <tr>
					            <th>Leden</th>
					            <th>verwijderen</th>
					        </tr>
					    </thead>

					    <tbody>
					       
					   

							<?php 


							$group_members = $group->getGroupMemebersByName();


							?>
					</tbody>
					</table>

					<div class="add-members">
						
						<button id="add_members">Leden toevoegen</button>



					</div>

				</div>

				<input type="submit" value="Verzenden">

			</form>
		</div>


	</div>



</body>


	<script type="text/javascript">
		

		$(document).ready(function(){


			$("#add_members").click(function(e){

				 e.preventDefault();

				 var dataAdded = false;

				if($(this).hasClass("test")){
					dataAdded = true;

				}else{
					dataAdded = false;
				}

				 if(!dataAdded){
				 	var data = jQuery("<?php


				 			

				 			$testData = $group->returnLeftMembers();

				 			if(is_array($testData)){
				 				echo "<table id='data-table'class='pure-table pure-table-bordered'><thead><th>Beschikbare leden</th><th>toevoegen</th></tr></thead><tbody>";
				 				foreach($testData as $notMembers){
				 					echo "<tr><td>" . $notMembers['username']. "</td><td><i class='fa fa-pencil-square-o _edit' aria-hidden='true'></i></td></tr>";
				 				}
				 				echo "</tbody></table><br />";
				 			}else{
				 				echo "<span>deze groep bevat alle Beschikbare leden</span>";
				 			}

				 			

				 		?>");

					 $(".add-members").append(data);
					 $(this).addClass("test");

					 console.log("data added");
				 }

			})

	
		})
			

	</script>

</html>