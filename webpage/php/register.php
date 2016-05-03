<?php

include 'conn.php';

function registerUser(){
	global $conn;
	
	if(!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["firstname"]) && !empty($_POST["lastname"])){
		$email = $_POST["email"];
		$password = $_POST["password"];
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];

		$query = "INSERT INTO users (email, password, name, surname) VALUES ('$email', '$password', '$firstname', '$lastname');";
		if ($conn->query($query) == TRUE) 
		{
			// $_SESSION["user"] = $uname; --> necessary?
			echo 1;
		} else 
		echo 0;
	}
}

$conn = openConn();
$res = registerUser($conn);
closeConn($conn);
return $res;
?>