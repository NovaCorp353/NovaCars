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

	$res = $conn->query($query);
	if(mysqli_num_rows($res) == 1){
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
	"SELECT salary, expertise_lvl, dept_name, since
	FROM Employee 
	WHERE email = '$email';";

	$res = $conn->query($query);

	if(mysqli_num_rows($res) == 1){
		closeConn($conn);
		return $res->fetch_assoc();
	}

	closeConn($conn);
	return 0;
}

function getMgrCustTransHeader($email)
{
	global $conn;

	$query = 
	"SELECT U.first_name, U.last_name, E.dept_name 
	 FROM manager M JOIN user U ON M.email = U.email JOIN Employee E ON E.email = M.email 
	 WHERE M.email = '$email';";

	 $res = $conn->query($query);

	 if(mysqli_num_rows($res) == 1)
	 	return $res;
	 return 0;
}

function getMgrCustTransStats($dept_name)
{
	$conn = openConn();
	$query = 
	"SELECT COUNT(CO.transaction_id) as trans_count, SUM(T.amount) as tot_revenue
		FROM transaction T JOIN CustomerOperation CO on CO.transaction_id = T.id
		WHERE dept_name = '$dept_name';";

	$res = $conn->query($query);

	if(mysqli_num_rows($res) == 1)
	{
		closeConn($conn);
		return $res;
	}
	
	closeConn($conn);
	return 0;
}

function getMgrCustTrans($dept_name, $filter)
{
	$conn = openConn();

	$query = 
	"SELECT T.id, UC.first_name AS f_name, UC.last_name AS l_name, A.model, CO.op_name, UCl.first_name, UCl.last_name, T.amount, T.date
    	FROM CustomerOperation CO JOIN User UCl ON UCl.email = CO.tech_email
    	JOIN User UC ON UC.email = CO.customer_email
   		JOIN Auto A ON A.plate = CO.auto_plate
    	JOIN Transaction T ON T.id = CO.transaction_id
    	JOIN Employee E1 ON E1.email = CO.tech_email
    	JOIN Employee E2 ON E2.email = CO.clerk_email
   		WHERE (E1.dept_name = '$dept_name' OR E2.dept_name = '$dept_name') AND CO.op_name LIKE '%$filter%'";

	$res = $conn->query($query);

	 if(mysqli_num_rows($res) == 1)
	 {
	 	closeConn($conn);
	 	return $res;
	 }
	 
	 closeConn($conn);
	 return 0;
}
?>