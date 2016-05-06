<?php
include 'conn.php'
include 'util.php'

function getCustomerProfile(){
	// TODO

		// Assign content now
		// TODO if no vehicles display none
		// TODO if no history display none
		// TODO check if configured in session
		// TODO do sessions (Burcu)
		// TOOD put this in get customer profile function

		$membershipStatus = // TODO;
		$bonusPoints = // TODO;
		$autoList = // TODO;
		$history = // TODO;

		$content .= 
		'<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">' . $firstName . ' ' . $lastname . '</h1>
		<h3>' . $membershipStatus . ' Customer</h3>
		<h4 class="txt-muted">' . $bonusPoints . '  points collected</h4>

		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Customer profile</div>

					<ul class="list-group">
						<li class="list-group-item"><strong>Email</strong>: ' . $email . '</li>
						<li class="list-group-item"><strong>Password</strong>: <button class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Change</button></li>
					</ul>
				</div>
			</div>

			'. $autoList . '
		</div>

		<h2 class="sub-header">History</h2>
		' . $history . '
	</div>';

}

function getDepartmentInfo(){
	// TODO
}

function getManagerTransactions(){
	// TODO
}

function getClerkTransactions(){
	// TODO
}

function getClerkNewTransactionOperations(){
	// TODO
}

function getClerkSupplierTransactions(){
	// TODO
}

function getCustomerTransactionDetails(){
	// TODO
}

function getSupplierTransactionDetails(){
	// TODO
}

function getSalesManagerSupplierTransactions(){
	// TODO
}

function getSalesManagerNewTransactionSupplierNames(){
	// TODO
}

function getSalesManagerSuppliersInfo(){
	// TODO
}

function getOverview(){

	if(isset($_SESSION['role'])) {
		$role = $_SESSION['role'];
	} else {
		$role = getRole($email); 
		$_SESSION['role'] = $role;
	}
	
	// TODO dunno how to do this. Should this be called before a session variable is accessed?
	session_start();
	$email = $_SESSION['user'];

	// For content
	$fullName = getName($email);
	$firstName = $fullName['first_name'];
	$lastname = $fullName['last_name'];

	// Determine if user is an employee
	$employee = checkRole($email, EMPLOYEE);
	if($employee){

	    // Assign content now
		$employee = getEmployee($email);
		$departmentName = $employee['dept_name'];
		$title = $role . ' in ' . $departmentName;
		$startYear = $employee['since'];
		$salary = $employee['salary'];
		$expertise = $employee['expertise_lvl'];

		$content =
		'<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">'. $firstName . ' ' . $lastname .'</h1>
		<h3>' . $title . '</h3>
		<h4 class="text-muted">Since ' . $startYear . '</h4>

		<div class="panel panel-info" style="width:50%">
			<div class="panel-heading">Employee profile</div> 
			<ul class="list-group">
				<li class="list-group-item"><strong>Email</strong>: ' . $email . '</li>
				<li class="list-group-item"><strong>Password</strong>: <button class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Change</button></li>
				<li class="list-group-item"><strong>Salary</strong>: ' . $salary . '</li>
				<li class="list-group-item"><strong>Expertise Level</strong>: ' . $expertise . '</li>
			</ul>
		</div>
	</div>';

	$rightPanel = getRightPanel($email, OVERVIEW);
	return $rightPanel . $content;

	} else
	return getCustomerProfile($email);
}

function getRightPanel($email, $cur_tab){
	// Get Role and save it in session variables
	$role = getRole($_SESSION['user']);
	$_SESSION['role'] = $role;

	$isCustomer = isCustomer($email);
	$_SESSION['isCustomer'] = $isCustomer;	

	// Determine if user is an employee
	$employee = checkRole($email, EMPLOYEE);
	if($employee){	

		// Assign right panel content
		if(strcmp($cur_tab, OVERVIEW))
			$rightPanel = 
			'<div class="container-fluid">
				<div class="row">
					<div class="col-sm-3 col-md-2 sidebar">
						<ul class="nav nav-sidebar">
							<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>';
		else
			$rightPanel = 
			'<div class="container-fluid">
				<div class="row">
					<div class="col-sm-3 col-md-2 sidebar">
						<ul class="nav nav-sidebar">
							<li><a href="#">Overview</a></li>';

		if(strcmp($role, MANAGER)){

			if(strcmp($cur_tab, DEPARTMENT_INFO))
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ', ' . MANAGER . ')">Department Info <span class="sr-only">(current)</span></a></li> 
				<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . MANAGER . ')">Transactions</a></li>';
				
			else if(strcmp($cur_tab, CUST_TRANSACTIONS))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ', ' . MANAGER . ')">Department Info</a></li> 
				<li class="active"><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . MANAGER . ')">Transactions <span class="sr-only">(current)</span></a></li>';

			else
				$rightPanel .=
				'<li><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ', ' . MANAGER . ')">Department Info</a></li> 
				<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . MANAGER . ')">Transactions</a></li>';
		}

		else if(strcmp($role, TECHNICIAN)){

			if(strcmp($cur_tab, DEPARTMENT_INFO))
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ', ' . TECHNICIAN . ')">Department Info <span class="sr-only">(current)</span></a></li>
				<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . TECHNICIAN . ')">Transactions</a></li>';
				
			else if(strcmp($cur_tab, CUST_TRANSACTIONS))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ', ' . TECHNICIAN . ')">Department Info</a></li>
				<li class="active"><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . TECHNICIAN . ')">Transactions <span class="sr-only">(current)</span></a></li>';

			else
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ', ' . TECHNICIAN . ')">Department Info</a></li>
				<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . TECHNICIAN . ')">Transactions</a></li>';
		}

		else if(strcmp($role, CLERK)){

			if(strcmp($cur_tab, CUST_TRANSACTIONS))
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . CLERK . ')">Customer Transactions <span class="sr-only">(current)</span></a></li>
				<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ', ' . CLERK . ')">Supplier Transactions</a></li>
	            <li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ', ' . CLERK . ')">New Transaction</a></li>'; // TODO
				
			else if(strcmp($cur_tab, SUPP_TRANSACTIONS))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . CLERK . ')">Customer Transactions</a></li>
				<li class="active"><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ', ' . CLERK . ')">Supplier Transactions <span class="sr-only">(current)</span></a></li>
	            <li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ', ' . CLERK . ')">New Transaction</a></li>'; // TODO

			else if(strcmp($cur_tab, NEW_TRANSACTION))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . CLERK . ')">Customer Transactions</a></li>
				<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ', ' . CLERK . ')">Supplier Transactions</a></li>
	            <li class="active"><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ', ' . CLERK . ')">New Transaction <span class="sr-only">(current)</span></a></li>'; // TODO

			else
				$rightPanel .=
				'<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ', ' . CLERK . ')">Customer Transactions</a></li>
				<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ', ' . CLERK . ')">Supplier Transactions</a></li>
	            <li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ', ' . CLERK . ')">New Transaction</a></li>'; // TODO
        }

        else if(strcmp($role, SALES_MANAGER)){

        	if(strcmp($cur_tab, SUPP_TRANSACTIONS))
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ', ' . SALES_MANAGER . ')">Supplier Transactions <span class="sr-only">(current)</span></a></li>
	        	<li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ', ' . SALES_MANAGER . ')">New Transaction</a></li>
	        	<li><a href="#" onclick="getContent( ' . SUPP_INFO . ', ' . SALES_MANAGER . ')">Suppliers Info</a></li>';
				
			else if(strcmp($cur_tab, NEW_TRANSACTION))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ', ' . SALES_MANAGER . ')">Supplier Transactions</a></li>
	        	<li class="active"><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ', ' . SALES_MANAGER . ')">New Transaction <span class="sr-only">(current)</span></a></li>
	        	<li><a href="#" onclick="getContent( ' . SUPP_INFO . ', ' . SALES_MANAGER . ')">Suppliers Info</a></li>';

			else if(strcmp($cur_tab, SUPP_INFO))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ', ' . SALES_MANAGER . ')">Supplier Transactions</a></li>
	        	<li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ', ' . SALES_MANAGER . ')">New Transaction</a></li>
	        	<li class="active"><a href="#" onclick="getContent( ' . SUPP_INFO . ', ' . SALES_MANAGER . ')">Suppliers Info <span class="sr-only">(current)</span></a></li>';
			else
	        	$rightPanel .= 
	        	'<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ', ' . SALES_MANAGER . ')">Supplier Transactions</a></li>
	        	<li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ', ' . SALES_MANAGER . ')">New Transaction</a></li>
	        	<li><a href="#" onclick="getContent( ' . SUPP_INFO . ', ' . SALES_MANAGER . ')">Suppliers Info</a></li>';
        }

        if($isCustomer){

        	if( strcmp($cur_tab, CUST_PROFILE))
	        	$rightPanel .= 
	        	'<ul class="nav nav-sidebar">
	        	<li class="active"><a href="#" onclick="getContent( ' . CUST_PROFILE . ', ' . CUSTOMER . ')">Customer Profile <span class="sr-only">(current)</span></a></li>';
	        else
	        	$rightPanel .= 
	        	'<ul class="nav nav-sidebar">
	        	<li><a href="#" onclick="getContent( ' . CUST_PROFILE . ', ' . CUSTOMER . ')">Customer Profile</a></li>';
        }

        $rightPanel .= 
        '</ul>
   		</div>';
	    return $rightPanel;
	} else {
		$rightPanel = 
		'<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<ul class="nav nav-sidebar">
					<li class="active"><a href="#">Customer Profile <span class="sr-only">(current)</span></a></li>
				</ul>
			</div>';

		return $rightPanel;
	}
}

function getRole($email){
	// Determine the position

	// Determine if user is manager
	if(checkRole($email, MANAGER))
		return MANAGER;

	// Determine if user is technician
	if(checkRole($email, TECHNICIAN))
		return TECHNICIAN;

	// Determine if user is clerk
	if(checkRole($email, CLERK))
		return CLERK;

	// Determine if user is sales manager
	if(checkRole($email, SALES_MANAGER))
		return SALES_MANAGER;

	return CUSTOMER;
}

// Determine if the user is a customer
function isCustomer($email){
	$customer = checkRole($email, CUSTOMER);
	$_SESSION['isCustomer'] = $customer;
	return $customer;
}

$conn = openConn();
// Check what action is required
switch($_POST['action']){
	case 'overview': 
	$res = getOverview();
	break;

	default:
	$res = 0;
	break;
}
closeConn($conn);
return $res;
?>	