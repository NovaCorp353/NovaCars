<?php
include('conn.php');

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
	$conn = openConn();

	$query = 
	"SELECT email
	FROM $tablename
	WHERE email = '$email';";

	if($conn->query($query) == TRUE){
		closeConn($conn);
		return 1;
	}

	closeConn($conn);
	return 0;
}

function getName($email){
	$conn = openConn();

	$query = 
	"SELECT first_name, last_name
	FROM User 
	WHERE email = '$email';";

	$res = $conn->query($query);

	if(mysqli_num_rows($res) == 1){
		closeConn($conn);
		return $res->fetch_assoc();
	}

	closeConn($conn);
	return 0;
}

function getEmployee($email){
	$conn = openConn();

	$query = 
	"SELECT salary, role, expertise_lvl, dept_name, since
	FROM Employee 
	WHERE email = '$email';";

	if($conn->query($query) == TRUE){
		closeConn($conn);
		return $res->fetch_assoc();
	}

	closeConn($conn);
	return 0;
}
?>