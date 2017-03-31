<?php


	require_once("student.php");

	$student = new students();



?>


<!DOCTYPE html>
<html>
<head>
	<title>Groepmaken</title>
	<link rel="stylesheet" type="text/css" href="../../controller/css/groepmaken.css">
	<script  type="text/javascript" src="../../controller/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="../../controller/css/font-awesome-4.7.0/css/font-awesome.css">
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
</head>
<body>


	<div class="_wrap">
		
		<div class="_content">
			
			<form name="groepmaken" class="form" method="post" action="tools/creategroep.php">
				

				<h3><label for="groepnaam">Kies groepnaam</label></h3><br /><br />
				<input type="text" name="groepnaam"><br /><br />

				

				<div class="groepsleden">

					<h3><label for="Groepleden">Kies groepleden...</label></h3><br /><br />

					<?php 

						$studentArray = $student->returnStudentArray();

						foreach($studentArray as $student){
							echo "<span id=".$student['student_id']." class='student_name'>".$student['name']."

							<i class='fa fa-plus' aria-hidden='true' id='check'></i></span> 
							<hr><br /><br/>";
						}


					?>
				</div>

				<input type="submit" value="groepmaken">

			</form>


			<div class="existing_group">

				<h3>Existing group</h3>
				<?php 


					require_once("tools/getGroep.php");

					$group = new Group();

					$groupArray = $group->Group();

					foreach($groupArray as $groups){

						$groupName = $group->getgroupName($groups['groep_id']);
						echo "<pre>";
						var_export($groupName);

					}
				?>


			</div>




		</div>


	</div>

</body>


	<script type="text/javascript">
		

		$(document).ready(function(){




			console.log("hello9n");

			$(".fa-plus").click(function(){
				$(this).removeClass("fa fa-plus").addClass("fa fa-check");

				console.log($(this).parent().text());

				$(".form").append("<input type='hidden' name='checked["+$(this).parent().attr("id")+"]'value="+$(this).parent().attr('id')+">");

			})


		})


	</script>

</html>