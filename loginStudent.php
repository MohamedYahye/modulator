<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="controller/css/login.css">
	<link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">
	<script type="text/javascript" src='controller/js/jquery.js'></script>
</head>
<body>

	<div class="wrap">
		
		<div class="inner_wrap">
			
			<h1>Login</h1>
			<br /><br />

			<p id="errorMessage"></p>

			<form class="form" name="login" method="post" action="model/userlogin.php">
				
				<input type="number" name="ov" placeholder="ov-nummer" id="username"><br /><br />
				<input type="password" name="password" placeholder="wachtoord" id="password"><br /><br />
				<input type="submit" name="submit" value="Inloggen">

			</form>

		</div>


	</div>


	<script type="text/javascript">
			
		$(document).ready(function(){


			var proceed = false;

			$(".form").submit(function(event){

				var username = $("#username").val();
				var password = $("#password").val();

				if(username.length > 0){
					removeBorder("username");

					

					if(password.length > 0 && password.length >= 6){
						proceed = true;
						removeBorder("password")
					}else{
						errorBorder("password")
						erroMessage("wachtwoord moet minstens 6 chars zijn");
						return false;
						
					}

				}else{
					errorBorder("username")

					erroMessage("gebruikersnaam kan niet leeg zijn");
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


</body>
</html>