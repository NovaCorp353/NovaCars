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

function getCustomerTransactions(){
	// TODO
}

function getNewTransaction(){
	// TODO
}

function getSupplierTransactions(){
	// TODO
}

function getSupplierInfo(){
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
	
	$role = getRole($_SESSION['user']);
	$isCustomer = isCustomer($email);

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
				'<li class="active"><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ')">Department Info <span class="sr-only">(current)</span></a></li> 
				<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Transactions</a></li>';
				
			else if(strcmp($cur_tab, CUST_TRANSACTIONS))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ')">Department Info</a></li> 
				<li class="active"><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Transactions <span class="sr-only">(current)</span></a></li>';

			else
				$rightPanel .=
				'<li><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ')">Department Info</a></li> 
				<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Transactions</a></li>';
		}

		else if(strcmp($role, TECHNICIAN)){

			if(strcmp($cur_tab, DEPARTMENT_INFO))
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ')">Department Info <span class="sr-only">(current)</span></a></li>
				<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Transactions</a></li>';
				
			else if(strcmp($cur_tab, CUST_TRANSACTIONS))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ')">Department Info</a></li>
				<li class="active"><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Transactions <span class="sr-only">(current)</span></a></li>';

			else
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . DEPARTMENT_INFO . ')">Department Info</a></li>
				<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Transactions</a></li>';
		}

		else if(strcmp($role, CLERK)){

			if(strcmp($cur_tab, CUST_TRANSACTIONS))
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Customer Transactions <span class="sr-only">(current)</span></a></li>
				<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ')">Supplier Transactions</a></li>
	            <li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ')">New Transaction</a></li>'; // TODO
				
			else if(strcmp($cur_tab, SUPP_TRANSACTIONS))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Customer Transactions</a></li>
				<li class="active"><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ')">Supplier Transactions <span class="sr-only">(current)</span></a></li>
	            <li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ')">New Transaction</a></li>'; // TODO

			else if(strcmp($cur_tab, NEW_TRANSACTION))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Customer Transactions</a></li>
				<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ')">Supplier Transactions</a></li>
	            <li class="active"><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ')">New Transaction <span class="sr-only">(current)</span></a></li>'; // TODO

			else
				$rightPanel .=
				'<li><a href="#" onclick="getContent( ' . CUST_TRANSACTIONS . ')">Customer Transactions</a></li>
				<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ')">Supplier Transactions</a></li>
	            <li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ')">New Transaction</a></li>'; // TODO
        }

        else if(strcmp($role, SALES_MANAGER)){

        	if(strcmp($cur_tab, SUPP_TRANSACTIONS))
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ')">Supplier Transactions <span class="sr-only">(current)</span></a></li>
	        	<li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ')">New Transaction</a></li>
	        	<li><a href="#" onclick="getContent( ' . SUPP_INFO . ')">Suppliers Info</a></li>';
				
			else if(strcmp($cur_tab, NEW_TRANSACTION))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ')">Supplier Transactions</a></li>
	        	<li class="active"><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ')">New Transaction <span class="sr-only">(current)</span></a></li>
	        	<li><a href="#" onclick="getContent( ' . SUPP_INFO . ')">Suppliers Info</a></li>';

			else if(strcmp($cur_tab, SUPP_INFO))
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . '">Supplier Transactions</a></li>
	        	<li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ')">New Transaction</a></li>
	        	<li class="active"><a href="#" onclick="getContent( ' . SUPP_INFO . ')">Suppliers Info <span class="sr-only">(current)</span></a></li>';
			else
	        	$rightPanel .= 
	        	'<li><a href="#" onclick="getContent( ' . SUPP_TRANSACTIONS . ')">Supplier Transactions</a></li>
	        	<li><a href="#" onclick="getContent( ' . NEW_TRANSACTION . ')">New Transaction</a></li>
	        	<li><a href="#" onclick="getContent( ' . SUPP_INFO . ')">Suppliers Info</a></li>';
        }

        if($isCustomer){

        	if( strcmp($cur_tab, CUST_PROFILE))
	        	$rightPanel .= 
	        	'<ul class="nav nav-sidebar">
	        	<li class="active"><a href="#" onclick="getContent( ' . CUST_PROFILE . ')">Customer Profile <span class="sr-only">(current)</span></a></li>';
	        else
	        	$rightPanel .= 
	        	'<ul class="nav nav-sidebar">
	        	<li><a href="#" onclick="getContent( ' . CUST_PROFILE . ')">Customer Profile</a></li>';
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

	if(!isset($_SESSION['role'])){ // Caching

		// Determine if user is manager
		if(checkRole($email, MANAGER))
			$_SESSION['role'] = MANAGER;

		// Determine if user is technician
		else if(checkRole($email, TECHNICIAN))
			$_SESSION['role'] = TECHNICIAN;

		// Determine if user is clerk
		else if(checkRole($email, CLERK))
			$_SESSION['role'] = CLERK;

		// Determine if user is sales manager
		else if(checkRole($email, SALES_MANAGER))
			$_SESSION['role'] = SALES_MANAGER;

		else 
			$_SESSION['role'] = CUSTOMER;
	}

	return $_SESSION['role'];
}

// Determine if the user is a customer
function isCustomer($email){

	if(!isset($_SESSION['isCustomer'])){ // Caching
		$customer = checkRole($email, CUSTOMER);
		$_SESSION['isCustomer'] = $customer;
	}

	return $_SESSION['isCustomer'];
}

// Execution starts here
$conn = openConn();
$action = $_POST['action'];

// Check what action is required
if(!isset($action))
	$res = getOverview();
else if(strcmp($action, OVERVIEW))
	$res = getOverview();
else if(strcmp($action, DEPARTMENT_INFO))
	$res = getDepartmentInfo();
else if(strcmp($action, CUST_TRANSACTIONS))
	$res = getCustomerTransactions();
else if(strcmp($action, SUPP_TRANSACTIONS))
	$res = getSupplierTransactions();
else if(strcmp($action, NEW_TRANSACTION))
	$res = getNewTrasaction();
else if(strcmp($action, SUPP_INFO))
	$res = getSupplierInfo();
else if(strcmp($ac, CUST_PROFILE))
	$res = getCustomerProfile();
else 
	$res = getOverview();

closeConn($conn);
return $res;
?>	