<!DOCTYPE html>
<html>
<head>
	<title>Register Student</title>

	<link rel="stylesheet" type="text/css" href="controller/css/beheerderstyle.css">
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

		#passwordrepeat{
			width: 1062px;
		}

	</style>

<body>


	<div class="warpper">
			
		<div class="inner_wrap">
			
		<h1>Regsitreren voor Beheerders</h1>

		<h3 id="message" style="margin-left: 50px; margin-top: 75px; position: absolute; font-family: 'Varela Round', sans-serif;">* = Verplicht</h3>

			<a href="loginBeheerder.php" id="student"><button id="login_student">Login</button></a>

			<div class="form">
				<form name="studentform" id="studentform" method="POST" action="model/registerbeheerder.php">
				
				<input type="text" name="name" placeholder="* Name" id="name">
				<input type="text" name="username" placeholder="* username" id="username"><br /><br />
				<input type="email" name="email" placeholder="* Email" id="email">
				<input type="password" name="password" placeholder="* password" id="password"><br /><br />
				<input type="password" name="passwordrepeat" placeholder="* repeat password" id="passwordrepeat"><br /><br />

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


				var name = $("#name").val();
				var username = $("#username").val();
				var email = $("#email").val();
				var password = $("#password").val();
				var repeat = $("#passwordrepeat").val();

				if(name.length > 0){
					removeBorder("name");

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


				}else{
					errorBorder("name")

					erroMessage("naam kan niet leeg zijn");
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