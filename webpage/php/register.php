<?php

include 'conn.php';

function registerUser(){
	global $conn;
	
	if(!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["firstname"]) && !empty($_POST["lastname"])){
		$email = $_POST["email"];
		$password = $_POST["password"];
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];

		$query = "INSERT INTO User (email, password, first_name, last_name) VALUES ('$email', '$password', '$firstname', '$lastname');";
		if ($conn->query($query) == FALSE) 
			echo 0;
		else
		{
			$query = "INSERT INTO Customer (email, membership_sts, bonus_pts) VALUES ('$email', 'Classic', 0);";

			if ($conn->query($query) == FALSE) 
				echo 0;
			else
				echo 1;
		} 
	}
}

$conn = openConn();
$res = registerUser($conn);
closeConn($conn);
return $res;
?>