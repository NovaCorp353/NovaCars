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
	WHERE email = '$email';";

	if($conn->query($query))
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

function getMgrCustTransHeader($email)
{
	global $conn;

	$query = 
	"SELECT first_name, last_name, dept_name
	 FROM manager NATURAL JOIN user
	 WHERE email = '$email';";

	 $res = $conn->query($query);

	 if(mysqli_num_rows($res) == 1)
	 	return $res;
	 return 0;
}

function getMgrCustTransStats($dept_name)
{
	global $conn;

	$query = 
	"SELECT COUNT(transaction_id) as trans_count, SUM(amount) as tot_revenue
		FROM transaction NATURAL JOIN CustomerOperation
		WHERE dept_name = '$dept_name';"

	$res = $conn->query($query);

	if(mysqli_num_rows($res) == 1)
	 	return $res;
	return 0;
}

function getMgrCustTrans($dept_name, $filter)
{
	global $conn;

	$query = 
	"SELECT T.transaction_id, UC.first_name, UC.last_name, A.model, CO.op_name, 
			UCl.first_name, UCl.last_name, T.date
			FROM ((((CustomerOperation CO JOIN User UCl ON UCl.email = CO.clerk_email)
					JOIN User UC ON UC.email = CO.customer_email)
					JOIN Auto A ON A.plate = CO.auto_plate)
					JOIN Transaction T ON T.id = CO.transaction_id)
					JOIN Employee E ON E.email = CO.clerk_email
			WHERE E.dept_name = '$dept_name' AND CO.op_name LIKE "%'$filter'%";";

	$res = $conn->query($query);

	 if(mysqli_num_rows($res) == 1)
	 	return $res;
	 return 0;
}

?>