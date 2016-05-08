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
define("FILTER_EMPLOYEE", "FilterEmployee");
define("NEW_EMPLOYEE", "NewEmployee");
define("FILTER_CUST_TRANS", "FilterCustTrans");
define("ADD_TRANS", "add_trans");
define("CHANGE_PASSWORD", "ChangePassword");
define("ADD_AUTO", "AddAuto");
define("AUTO_LIST", "AutoList");
define("REMOVE_AUTO", "RemoveAuto");


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
	$conn = openConn();

	$query = 
	"SELECT U.first_name, U.last_name, E.dept_name 
	 FROM manager M JOIN user U ON M.email = U.email JOIN Employee E ON E.email = M.email 
	 WHERE M.email = '$email';";

	 $res = $conn->query($query);

	 if(mysqli_num_rows($res) == 1)
	 	return $res->fetch_assoc();
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
		return $res->fetch_assoc();
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
   		WHERE (E1.dept_name = '$dept_name' OR E2.dept_name = '$dept_name') AND (CO.op_name LIKE '%$filter%' OR A.model LIKE '%$filter%' 
   			OR UCL.last_name LIKE '%$filter%' OR UCL.first_name LIKE '%$filter%' OR T.id = '$filter');";

	$res = $conn->query($query);

	 if(mysqli_num_rows($res)>0)
	 {
	 	closeConn($conn);
	 	return $res;
	 }
	 
	 closeConn($conn);
	 return NULL;
}

function getClerkHeader($email)
{
	$conn = openConn();

	$query = 
	"SELECT U.first_name, U.last_name
	 FROM Clerk C JOIN user U ON C.email = U.email
	 WHERE C.email = '$email';";

	 $res = $conn->query($query);

	 if(mysqli_num_rows($res) == 1)
	 	return $res->fetch_assoc();
	 return 0;
}

function getClerkCustTransStats($email)
{
	$conn = openConn();
	$query = 
	"SELECT COUNT(CO.transaction_id) as trans_count, SUM(T.amount) as tot_revenue
		FROM transaction T JOIN CustomerOperation CO on CO.transaction_id = T.id
		WHERE clerk_email = '$email';";

	$res = $conn->query($query);

	if(mysqli_num_rows($res) == 1)
	{
		closeConn($conn);
		return $res->fetch_assoc();
	}
	
	closeConn($conn);
	return 0;
}

function getClerkCustTrans($email, $filter, $all)
{
	$conn = openConn();
	if($all)
	{
		$query = 
		"SELECT T.id, UC.first_name, UC.last_name, A.model, CO.op_name, T.amount, T.date
	    	FROM CustomerOperation CO JOIN User UC ON UC.email = CO.customer_email
	   		JOIN Auto A ON A.plate = CO.auto_plate
	    	JOIN Transaction T ON T.id = CO.transaction_id
	   		WHERE CO.op_name LIKE '%$filter%' OR A.model LIKE '%$filter%' 
	   				OR T.id = '$filter';";
	}
	else
	{
		$query = 
		"SELECT T.id, UC.first_name, UC.last_name, A.model, CO.op_name, T.amount, T.date
	    	FROM CustomerOperation CO JOIN User UC ON UC.email = CO.customer_email
	   		JOIN Auto A ON A.plate = CO.auto_plate
	    	JOIN Transaction T ON T.id = CO.transaction_id
	   		WHERE CO.clerk_email = '$email' AND (CO.op_name LIKE '%$filter%' OR A.model LIKE '%$filter%' 
	   				OR T.id = '$filter');";
	}
		
	 $res = $conn->query($query);
	 if(mysqli_num_rows($res)>0)
	 {
	 	closeConn($conn);
	 	return $res;
	 }
	 
	 closeConn($conn);
	 return NULL;
}

function getDepartment($email)
{
	$conn = openConn();

	$query = "SELECT E.dept_name 
	 FROM Employee E 
	 WHERE E.email = '$email';";

	 $res = $conn->query($query);

	 if(mysqli_num_rows($res) == 1)
	 	return $res->fetch_assoc();
	 return 0;
}

function getTechHeader($email)
{
	$conn = openConn();

	$query = 
	"SELECT U.first_name, U.last_name
	 FROM Technician C JOIN user U ON C.email = U.email
	 WHERE C.email = '$email';";

	 $res = $conn->query($query);

	 if(mysqli_num_rows($res) == 1)
	 	return $res->fetch_assoc();
	 return 0;
}

function getTechCustTransStats($email)
{
	$conn = openConn();
	$query = 
	"SELECT COUNT(CO.transaction_id) as trans_count, SUM(T.amount) as tot_revenue
		FROM transaction T JOIN CustomerOperation CO on CO.transaction_id = T.id
		WHERE tech_email = '$email';";

	$res = $conn->query($query);

	if(mysqli_num_rows($res) == 1)
	{
		closeConn($conn);
		return $res->fetch_assoc();
	}
	
	closeConn($conn);
	return 0;
}

function getTechCustTrans($email, $filter)
{
	$conn = openConn();

	$query = 
	"SELECT T.id, UC.first_name, UC.last_name, A.model, CO.op_name, T.amount, T.date
    	FROM CustomerOperation CO JOIN User UC ON UC.email = CO.customer_email
   		JOIN Auto A ON A.plate = CO.auto_plate
    	JOIN Transaction T ON T.id = CO.transaction_id
   		WHERE CO.tech_email = '$email' AND (CO.op_name LIKE '%$filter%' OR A.model LIKE '%$filter%' 
   				OR T.id = '$filter' OR UC.first_name LIKE '%$filter%' OR UC.last_name LIKE '%$filter%');";
	
		
	 $res = $conn->query($query);
	 if(mysqli_num_rows($res)>0)
	 {
	 	closeConn($conn);
	 	return $res;
	 }
	 
	 closeConn($conn);
	 return NULL;
}

function getCustHeader($email)
{
	$conn = openConn();

	$query = 
	"SELECT U.first_name, U.last_name, C.membership_sts, C.bonus_pts
	 FROM Customer C JOIN User U ON C.email = U.email
	 WHERE C.email = '$email';";

	 $res = $conn->query($query);

	 if(mysqli_num_rows($res) == 1)
	 	return $res->fetch_assoc();
	 return 0;
}

function getDepartmentDetailed($dept_name){
	$conn = openConn();
	
	$query = 
	"SELECT department.budget, department.expenditure, COUNT(employee.email) AS cnt_employees
	FROM Department JOIN Employee ON department.name = employee.dept_name 
	WHERE department.name = '$dept_name' GROUP BY department.name, department.budget, department.expenditure;";
 
	$res = $conn->query($query);

	if(mysqli_num_rows($res) == 1)
	{
	 	closeConn($conn);
	 	return $res->fetch_assoc();
	}
	 
	closeConn($conn);
	return 0;
}

function getOperations(){
	$conn = openConn();
	
	$query = "SELECT O.dept_name, O.op_name, O.cost, T.tech_email\n"
    . "FROM Operation O JOIN technicianoperation T ON O.dept_name = T.dept_name AND O.op_name = T.op_name";
 
	$res = $conn->query($query);

	if(mysqli_num_rows($res) > 0)
	{
	 	closeConn($conn);
	 	return $res;
	}
	 
	closeConn($conn);
	return null;
}

function getEmployees($dept_name, $filter){
	$conn = openConn();
	
	$query = 
	 "SELECT user.email, first_name, last_name, salary, expertise_lvl 
	 FROM User JOIN Employee ON user.email = employee.email 
	 WHERE dept_name = '$dept_name' AND (user.email LIKE '%$filter%' OR first_name LIKE '%$filter%' 
   				OR last_name LIKE '%$filter%' OR expertise_lvl LIKE '%$filter%');";
 
	$res = $conn->query($query);

	if(mysqli_num_rows($res) > 0)
	{
	 	closeConn($conn);
	 	return $res;
	}
	 
	closeConn($conn);
	return null;
}

function getCustAutos($email)
{
	$conn = openConn();

	$query = 
	"SELECT A.model, A.year, A.plate
    	FROM Auto A JOIN Customer C ON C.email = A.customer_email
   		WHERE C.email = '$email';";
	
		
	 $res = $conn->query($query);
	 if(mysqli_num_rows($res)>0)
	 {
	 	closeConn($conn);
	 	return $res;
	 }
	 
	 closeConn($conn);
	 return NULL;
}

function getCustHistory($email)
{
	$conn = openConn();

	$query = 
	"SELECT T.id, A.model, A.year, CO.op_name, T.amount, T.date
    	FROM CustomerOperation CO JOIN User UC ON UC.email = CO.customer_email
   		JOIN Auto A ON A.plate = CO.auto_plate
    	JOIN Transaction T ON T.id = CO.transaction_id
   		WHERE CO.customer_email = '$email'";
	
		
	 $res = $conn->query($query);
	 if(mysqli_num_rows($res)>0)
	 {
	 	closeConn($conn);
	 	return $res;
	 }
	 
	 closeConn($conn);
	 return NULL;
}

function addNewTransaction($amount, $op_name, $dept_name, $tech_email, $clerk_email, $cust_email, $auto_plate)
{
	$conn = openConn();

	$date = date('Y-m-d H:i:s');

	$query = 
	"INSERT INTO `transaction` (`id`, `amount`, `date`) VALUES (NULL, '$amount', '$date')";

	if($conn->query($query)!=FALSE)
	{
		/*$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
		$txt = $dept_name.$op_name.$tech_email.$clerk_email.$cust_email.$auto_plate.$conn->insert_id;
		fwrite($myfile, $txt);
		fclose($myfile);*/
		
		$query =
		"INSERT INTO `customeroperation` (`transaction_id`, `dept_name`, `op_name`, `tech_email`, `clerk_email`, `customer_email`, `auto_plate`) 
		VALUES ('".$conn->insert_id."', '$dept_name', '$op_name', '$tech_email', '$clerk_email', '$cust_email', '$auto_plate')";

		if($conn->query($query) == FALSE)
		{
			$query =
			"DELETE FROM transaction where id = ".$conn->insert_id.";";
			$conn->query($query);
			closeConn($conn);
			return 0;
		}
		else
		{
			closeConn($conn);
			return 1;
		}
	}
	else
	{
		closeConn($conn);
		return 0;
	}
}

function changePassword(){
	$conn = openConn();

	$query = 
	"UPDATE User
	SET password = '".$_POST['password']."' 
	WHERE User.email = '" . $_SESSION['user'] . "'";
	
	 if($conn->query($query))
	 	return 1;
	 
	 closeConn($conn);
	 return 0;
}

function addAuto(){
	$conn = openConn();

	$query = 
	"INSERT INTO Auto(plate, model, year, customer_email) 
	VALUES ('".$_POST['plate']."', '".$_POST['model']."', '".$_POST['year']."', '".$_SESSION['user']."');";
	
	 if($conn->query($query)){
	 	return 1;
	 }
	 
	 closeConn($conn);
	 return 0;
}

function removeAuto(){
	$conn = openConn();

	$query = 
	"DELETE FROM Auto 
	WHERE plate = '".$_POST['plate']."' AND customer_email = '".$_SESSION['user']."';";
	
	 if($conn->query($query)){
	 	return 1;
	 }
	 
	 closeConn($conn);
	 return 0;
}
?>