<?php

function openConn(){
	session_start();

	$host = "localhost";
	$user = "";
	$pass = "";
	$db = "test";

	// Create connection
	$mysqli = new mysqli($host, $user, $pass, $db);

	// Check connection
	if (mysqli_connect_errno()) {
		echo("Connection failed: " . mysqli_connect_error());
		exit();
	}

	return $mysqli;
}
?>