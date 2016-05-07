<?php

function openConn(){

	$host = "localhost";
	$user = "";
	$pass = "";
	$db = "project";

	// Create connection
	$mysqli = new mysqli($host, $user, $pass, $db);

	// Check connection
	if (mysqli_connect_errno()) {
		echo("Connection failed: " . mysqli_connect_error());
		exit();
	}

	return $mysqli;
}

function closeConn($conn){
	$conn->close();
}
?>