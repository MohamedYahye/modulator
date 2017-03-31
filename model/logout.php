<?php 

	require("session.php");

	$session = new session();

	$session->destroySession();


	header("Location: http://mo-portfolio.nl/modulator/");

?>