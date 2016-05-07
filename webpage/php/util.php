<?php

// Role constants
define("USER", "User");
define("EMPLOYEE", "Employee");
define("CUSTOMER", "Customer");
define("MANAGER", "Manager");
define("CLERK", "Clerk");
define("TECHNICIAN", "Technician");
define("SALES_MANAGER", "SalesManager");

// Content type constants
define("OVERVIEW", "Overview");
define("DEPARTMENT_INFO", "DepartmentInfo");
define("CUST_TRANSACTIONS", "CustomerTransactions");
define("SUPP_TRANSACTIONS", "SupplierTransactions");
define("NEW_TRANSACTION", "NewTransaction");
define("SUPP_INFO", "SupplierInfo");
define("CUST_PROFILE", "CustomerProfile");

function checkRole($email, $tablename){
	global $conn;

	$query = 
	"SELECT email
	FROM '$tablename'
	WHERE email = '$email'";

	$result = $conn->query($query);
	if(mysqli_num_rows($result) == 1)
		return true;

	return false;
}

function getName($email){
	global $conn;

	$query = 
	"SELECT first_name, last_name
	FROM User 
	WHERE email = '$email'";

	$res = $conn->query($query);

	if(mysqli_num_rows($res) == 1)
		return $res;
	return 0;
}

function getEmployee($email){
	global $conn;

	$query = 
	"SELECT salary, role, expertise_lvl, dept_name, since
	FROM Employee 
	WHERE email = '$email'";

	$res = $conn->query($query);

	if(mysqli_num_rows($res) == 1)
		return $res;
	return 0;
}
?>