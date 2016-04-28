<?php
function checkRole($tablename){
	global $conn;

	$email = $_SESSION['user'];
	$query = 
	"SELECT email
	FROM '$tablename'
	WHERE email = '$email'";

	$result = $conn->query($query);
	if(mysqli_num_rows($result) == 1)
		return true;

	return false;
}

function getFirstName(){
	global $conn;

	if(!isset($_SESSION['firstName'])){
		$query = 
		'SELECT first_name, last_name
		 FROM User 
		 WHERE email = ' . $_SESSION['user'];

		$res = $conn->query($query);

		if(mysqli_num_rows($res) == 1){

			$_SESSION['firstName'] = $res['first_name'];
			$_SESSION['lastName'] = $res['last_name'];
			return $_SESSION['firstName'];
		}
		return 0;
	}
	return $_SESSION['firstName'];

}

function getLastName(){
	global $conn;

	if(!isset($_SESSION['lastName'])){
		$query = 
		'SELECT first_name, last_name
		 FROM User 
		 WHERE email = ' . $_SESSION['user'];

		$res = $conn->query($query);

			if(mysqli_num_rows($res) == 1){
			$_SESSION['firstName'] = $res['first_name'];
			$_SESSION['lastName'] = $res['last_name'];
			return $_SESSION['lastName'];
		}
		return 0;
	}
	return $_SESSION['lastName'];
}

function getDepartmentName(){
	global $conn;

	if(!isset($_SESSION['dept_name'])){
		$query = 
		'SELECT dept_name
		 FROM Employee 
		 WHERE email = ' . $_SESSION['user'];

		$res = $conn->query($query);

		if(mysqli_num_rows($res) == 1){

			$_SESSION['dept_name'] = $res['dept_name'];
			return $_SESSION['dept_name'];
		}
		return 0;
	}
	return $_SESSION['dept_name'];
}
?>