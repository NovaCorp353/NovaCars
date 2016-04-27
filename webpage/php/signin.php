<?php

include 'conn.php';

function getLoginCredentials($mysqli){
	if(!empty($_POST["email"]) && !empty($_POST["password"])){
		$email = $_POST["email"];
		$pass = $_POST["password"];

		$query = "SELECT email FROM users WHERE email = '$email' AND password = '$pass'";
		$res = $mysqli->query($query);
		if (mysqli_num_rows($res) == 1) 
		{
			session_start();
			$_SESSION["user"] = $email;
			echo 1;
		} else 
		echo 0;
	}
}

$conn = openConn();
$res = getLoginCredentials($conn);
closeConn($conn);
return $res;
?>