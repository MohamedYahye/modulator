<!DOCTYPE html>
<html>
<head>
	<title>Register Student</title>

	<link rel="stylesheet" type="text/css" href="controller/css/studentform.css">
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	<script type="text/javascript" src='controller/js/jquery.js'></script>

</head>

	<style type="text/css">
		
		#errorMessage{
			position: absolute;
			top: 250px;
			margin-left: 50px;
			font-family: 'Varela Round', sans-serif;
			color: #fb1b1b;
		}

		#student > button {
			position: absolute;
		    margin-left: 914px;
		    top: 184px;
		    width: 250px;
		    height: 40px;
		    width: 200px;
		    height: 50px;
		    cursor: pointer;
		    font-family: 'Varela Round', sans-serif;
		    font-size: 25px;
		    text-align: center;
		    background-color: #0e83cd;
		    border: 1px solid #fff;
		    color: #fff;
		    outline: none;
		}

		#student > button:hover{
			background-color: #fff;
			color: #0e83cd;
			border-color: #0e83cd;
			transition-delay: 2s;
		    transition: background-color 1s ease;
		}

	</style>

<body>


	<div class="warpper">
			
		<div class="inner_wrap">
			
		<h1>Regsitreren voor studenten</h1>

		<h3 id="message" style="margin-left: 50px; margin-top: 75px; position: absolute; font-family: 'Varela Round', sans-serif;">* = Verplicht</h3>

			<a href="loginStudent.php" id="student"><button id="login_student">Login</button></a>

			<div class="form">
				<form name="studentform" id="studentform" method="POST" action="model/registerstudent.php">
				
				<input type="number" placeholder="* ov-nummer" name="ov" id="ov">
				<input type="text" name="name" placeholder="* Name" id="name"><br /><br />
				<input type="text" name="username" placeholder="* username" id="username">
				<input type="email" name="email" placeholder="* Email" id="email"><br /><br />
				<input type="password" name="password" placeholder="* password" id="password">
				<input type="password" name="passwordrepeat" placeholder="* repeat password" id="passwordrepeat"><br /><br />
				<input type="text" name="opleiding" placeholder="* opleiding" id="opleiding">
				<input type="text" name="uitstroom" placeholder="* uitstroom-richting" id="uitstroom"><br /><br />
				<input type="number" name="leerjaar" placeholder="* leerjaar" id="leerjaar"><br /><br />

				<input type="submit" name="submit" value="Registreren">


				</form>
			</div>

			<p id="errorMessage"></p>

		</div>


	</div>

</body>

	
	<script type="text/javascript">
			
		$(document).ready(function(){

			var proceed = false;
			$(".form").submit(function(event){
				var ov = $("#ov").val();
				var name = $("#name").val();
				var username = $("#username").val();
				var email = $("#email").val();
				var password = $("#password").val();
				var repeat = $("#passwordrepeat").val();
				var opleiding = $("#opleiding").val();
				var uitstroom = $("#uitstroom").val();
				var leerjaar = $("#leerjaar").val();

				if(ov.length >= 4){
					removeBorder("ov");

					if(name.length > 0){
						proceed = true;
						removeBorder("name")
						
					}else{
						errorBorder("name");
						erroMessage("naam kan niet leeg zijn");
						return false;
						
					}

					if(username.length > 0){
						proceed = true;
						removeBorder("username")
					}else{
						errorBorder("username")
						erroMessage("gebruikersnaam kan niet leeg zijn");
						return false;
						
					}

					if(email.length > 0){
						proceed = true;
						removeBorder("email")
					}else{
						errorBorder("email");
						erroMessage("email kan niet leeg zijn");
						return false;
						
					}

					if(password.length > 0 && password.length >= 6){
						proceed = true;
						removeBorder("password")
					}else{
						errorBorder("password")
						erroMessage("wachtwoord kan niet leeg zijn");
						return false;
						
					}

					if(repeat == password){
						proceed = true;
						removeBorder("passwordrepeat")
					}else{
						errorBorder("passwordrepeat");
						erroMessage("wachtwoord komen niet overeen");
						return false;
						
					}

					if(opleiding.length > 0){
						proceed = true;
						removeBorder("opleiding")
					}else{
						errorBorder("opleiding");
						erroMessage("opleiding kan niet leeg zijn");
						return false;
						
					}

					if(uitstroom.length > 0){
						proceed = true;
						removeBorder("uitstroom")
					}else{
						errorBorder("uitstroom");
						erroMessage("uitstroom kan niet leeg zijn");
						return false;
						
					}

					if(leerjaar.length > 0){
						proceed = true;
						removeBorder("leerjaar")
					}else{
						errorBorder("leerjaar");
						erroMessage("leerjaar kan niet leeg zijn");
						return false;
						
					}

				}else{
					errorBorder("ov")

					erroMessage("Ov moet minstens groeter zijn dan 4 cijfers");
					return false;
					

				}
				



				if(proceed){
				}else{
					event.preventDefault();
				}


			})



			

			function errorBorder(id){
				return document.getElementById(id).style.border="1px solid #fb1b1b";
			}

			function removeBorder(id){
				return document.getElementById(id).style.border="1px solid #d4d4d4";
			}


			function erroMessage(message){
				$("#errorMessage").text(message);
			}


		});



	</script>




</html>