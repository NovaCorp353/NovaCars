<?php

include 'openconn.php';

function getLoginCredentials($mysqli){
	if(!empty($_POST["email"]) && !empty($_POST["password"])){
		$uname = $_POST["email"];
		$pass = $_POST["password"];

		$query = "SELECT email FROM users WHERE email = '$uname' AND password = '$pass'";
		$res = $mysqli->query($query);
		if (mysqli_num_rows($res) == 1) 
		{
			$_SESSION["user"] = $uname;
			echo 1;
		} else 
		echo 0;
	}
}

$conn = openConn();
return getLoginCredentials($conn);

?>