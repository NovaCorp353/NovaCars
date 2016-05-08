<?php
include('util.php');
//include('session.php');

function getCustomerProfile(){
	// TODO

		// Assign content now
		// TODO if no vehicles display none
		// TODO if no history display none
		// TODO check if configured in session
		// TODO do sessions (Burcu)
		// TOOD put this in get customer profile function

		$firstName = '';// TODO;
		$lastName = '';// TODO;

		$membershipStatus = '';// TODO;
		$bonusPoints = '';// TODO;
		$autoList = '';// TODO;
		$history = '';// TODO;

		$content = 
		'<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header">' . $firstName . ' ' . $lastName . '</h1>
		<h3>' . $membershipStatus . ' Customer</h3>
		<h4 class="txt-muted">' . $bonusPoints . '  points collected</h4>

		<div class="row">
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Customer profile</div>

					<ul class="list-group">
						<li class="list-group-item"><strong>Email</strong>: ' . $_SESSION['user'] . '</li>
						<li class="list-group-item"><strong>Password</strong>: <button class="btn btn-default"><span class="glyphicon glyphicon-pencil"></span> Change</button></li>
					</ul>
				</div>
			</div>

			'. $autoList . '
		</div>

		<h2 class="sub-header">History</h2>
		' . $history . '
	</div>';

	return $content;

}

function getDepartmentInfo(){
	// TODO
}

function getCustomerTransactions(){


	echo '<pre> Came here to Cutomer Transaction function</pre>';
	// TODO

	$rightPanel = getRightPanel($_SESSION["user"], CUST_TRANSACTIONS);
	if(isset($_SESSION['role'])) {
		$role = $_SESSION['role'];
	} else {
		$role = getRole($email); 
		$_SESSION['role'] = $role;
	}

	if(strcmp($role, MANAGER) == 0)
	{
		echo "<pre>here<pre>";
		$header = getMgrCustTransHeader($_SESSION["user"]);
		$deptName = $header['dept_name'];
		$firstName = $header['first_name'];
		$lastName = $header['last_name'];

		$stats = getMgrCustTransStats($deptName);
		$noOfTrans = $stats['trans_count'];
		$revenue = $stats['tot_revenue'];
		
		$filter = '';
		$trans = getMgrCustTrans($deptName, $filter);
		$content = ' 
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">' . $deptName . '</h1>
		  <h3 class="text-muted">Manager: '.$firstName .' '.$lastName.'</h3>
		
		<div class="panel panel-info" style="width:50%">
			  <div class="panel-heading">Customer Transactions</div>
			  <ul class="list-group">
				<li class="list-group-item"><strong>Number of Transactions</strong>: ' . $noOfTrans . '</li>
				<li class="list-group-item"><strong>Total Revenue</strong>:'.$revenue.'</li>
			  </ul>
		</div>
					
		<h2 class="sub-header">Customer Transactions</h2>
		<form class="form-inline" role="form">
			<div class="form-group">
				<input type="text" placeholder="Filter by operation name" class="form-control">
				<button type="submit" onclick="submitQuery(//HOLY SHIT LOOK AT HERE OMG TODO)" class="btn btn-primary">Filter</button>	
			</div>
		</form>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Customer</th>
				  <th>Auto</th>
                  <th>Operation</th>
                  <th>Technician</th>
                  <th>Price</th>
				  <th>Date</th>
				  <th>Details</th>
                </tr>
              </thead>
              <tbody>';

     while($data = $trans->fetch_assoc())
     {
     	$custName = $data['f_name'].' '.$data['l_name'];
     	$techName = $data['first_name'].' '.$data['last_name'];
     	$content .= '<tr><td>'.$data['id'].'</td><td>'.$custName.'</td><td>'.$data['model']
     				.'</td><td>'.$data['op_name'].'</td><td>'.$techName.'</td><td>'
     				.$data['amount'].'</td><td>'.$data['date'].'</td><td><a data-toggle="modal" data-target="#detailed_info_modal"><span class="glyphicon glyphicon-info-sign"></span></a></td></tr>';
     }
	 $content .= '
              </tbody>
            </table>
          </div>
		  <!-- Modal -->
			<div id="detailed_info_modal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Detailed information about transaction #ID</h4>
					</div>
					<div class="modal-body">
						<p><strong>Transaction was completed by: </strong> Clerk name here</p>
						<p><strong>Total Cost: </strong> XXXX</p>
						<p><strong>Completed on: </strong> Date here</p>
						<h3 class="bg-primary">Customer Information</h3>
						<p><strong>Name:</strong>Name Surname</p>
						<p><strong>Membership status:</strong>Status here</p>
						<p><strong>Bonus points:</strong>XXX</p>
						<h3 class="bg-primary">Vehicle Information</h3>
						<p><strong>Plate number:</strong>XX XX XX</p>
						<p><strong>Model:</strong>Model here</p>
						<p><strong>Year:</strong>XXXX</p>
						<h3 class="bg-primary">Operations Information</h3>
						<h4 class="bg-info">Operation Name 1</h4>
						<p><strong>Department: </strong>Department name here</p>
						<p><strong>Department Manager: </strong>Department manager name here</p>
						<p><strong>Operation Cost: </strong>XXXX</p>
						<p><strong>Operation was performed by: </strong>Technician name here</p>
						<h4 class="bg-info">Operation Name 2</h4>
						<p><strong>Department: </strong>Department name here</p>
						<p><strong>Department Manager: </strong>Department manager name here</p>
						<p><strong>Operation Cost: </strong>XXXX</p>
						<p><strong>Operation was performed by: </strong>Technician name here</p>
					</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
		  
        </div>
      </div>
    </div>';

    	return $rightPanel . $content;
	}
	else if(strcmp($role, TECHNICIAN) == 0)
	{

	}
	else if(strcmp($role, CLERK) == 0)
	{

	}
	else
	{
		//okay
	}

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

	$email = $_SESSION['user'];

	if(isset($_SESSION['role'])) {
		$role = $_SESSION['role'];
	} else {
		$role = getRole($email); 
		$_SESSION['role'] = $role;
	}

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
		if(strcmp($cur_tab, OVERVIEW) == 0)
			$rightPanel = 
			'<div class="container-fluid">
				<div class="row">
					<div class="col-sm-3 col-md-2 sidebar">
						<ul class="nav nav-sidebar">
							<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>';
		}		
		else
			$rightPanel = 
			'<div class="container-fluid">
				<div class="row">
					<div class="col-sm-3 col-md-2 sidebar">
						<ul class="nav nav-sidebar">
							<li><a href="#">Overview</a></li>';

		if(strcmp($role, MANAGER) == 0){

			if(strcmp($cur_tab, DEPARTMENT_INFO) == 0)
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( \'' . DEPARTMENT_INFO . '\')">Department Info <span class="sr-only">(current)</span></a></li> 
				<li><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Transactions</a></li>';
				
			else if(strcmp($cur_tab, CUST_TRANSACTIONS) == 0)
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( \'' . DEPARTMENT_INFO . '\')">Department Info</a></li> 
				<li class="active"><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Transactions <span class="sr-only">(current)</span></a></li>';

			else
				$rightPanel .=
				'<li><a href="#" onclick="getContent( \'' . DEPARTMENT_INFO . '\')">Department Info</a></li> 
				<li><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Transactions</a></li>';
		}

		else if(strcmp($role, TECHNICIAN) == 0){

			if(strcmp($cur_tab, DEPARTMENT_INFO) == 0)
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( \'' . DEPARTMENT_INFO . '\')">Department Info <span class="sr-only">(current)</span></a></li>
				<li><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Transactions</a></li>';
				
			else if(strcmp($cur_tab, CUST_TRANSACTIONS) == 0)
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( \'' . DEPARTMENT_INFO . '\')">Department Info</a></li>
				<li class="active"><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Transactions <span class="sr-only">(current)</span></a></li>';

			else
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( \'' . DEPARTMENT_INFO . '\')">Department Info</a></li>
				<li><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Transactions</a></li>';
		}

		else if(strcmp($role, CLERK) == 0){

			if(strcmp($cur_tab, CUST_TRANSACTIONS) == 0)
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Customer Transactions <span class="sr-only">(current)</span></a></li>
				<li><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '\')">Supplier Transactions</a></li>
	            <li><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction</a></li>'; // TODO
				
			else if(strcmp($cur_tab, SUPP_TRANSACTIONS) == 0)
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Customer Transactions</a></li>
				<li class="active"><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '\')">Supplier Transactions <span class="sr-only">(current)</span></a></li>
	            <li><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction</a></li>'; // TODO

			else if(strcmp($cur_tab, NEW_TRANSACTION) == 0)
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Customer Transactions</a></li>
				<li><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '\')">Supplier Transactions</a></li>
	            <li class="active"><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction <span class="sr-only">(current)</span></a></li>'; // TODO

			else
				$rightPanel .=
				'<li><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Customer Transactions</a></li>
				<li><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '\')">Supplier Transactions</a></li>
	            <li><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction</a></li>'; // TODO
        }

        else if(strcmp($role, SALES_MANAGER) == 0){

        	if(strcmp($cur_tab, SUPP_TRANSACTIONS) == 0)
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '\')">Supplier Transactions <span class="sr-only">(current)</span></a></li>
	        	<li><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction</a></li>
	        	<li><a href="#" onclick="getContent( \'' . SUPP_INFO . '\')">Suppliers Info</a></li>';
				
			else if(strcmp($cur_tab, NEW_TRANSACTION) == 0)
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '\')">Supplier Transactions</a></li>
	        	<li class="active"><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction <span class="sr-only">(current)</span></a></li>
	        	<li><a href="#" onclick="getContent( \'' . SUPP_INFO . '\')">Suppliers Info</a></li>';

			else if(strcmp($cur_tab, SUPP_INFO) == 0)
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '">Supplier Transactions</a></li>
	        	<li><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction</a></li>
	        	<li class="active"><a href="#" onclick="getContent( \'' . SUPP_INFO . '\')">Suppliers Info <span class="sr-only">(current)</span></a></li>';
			else
	        	$rightPanel .= 
	        	'<li><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '\')">Supplier Transactions</a></li>
	        	<li><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction</a></li>
	        	<li><a href="#" onclick="getContent( \'' . SUPP_INFO . '\')">Suppliers Info</a></li>';
        }

        $rightPanel .= 
        '</ul>';

        if($isCustomer){

        	if( strcmp($cur_tab, CUST_PROFILE) == 0)
	        	$rightPanel .= 
	        	'<ul class="nav nav-sidebar">
	        	<li class="active"><a href="#" onclick="getContent( \'' . CUST_PROFILE . '\')">Customer Profile <span class="sr-only">(current)</span></a></li>';
	        else
	        	$rightPanel .= 
	        	'<ul class="nav nav-sidebar">
	        	<li><a href="#" onclick="getContent( \'' . CUST_PROFILE . '\')">Customer Profile</a></li>';
        }

        $rightPanel .= 
   		'</div>';
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
		if(checkRole($email, MANAGER)){
			$_SESSION['role'] = MANAGER;
		}

		// Determine if user is technician
		else if(checkRole($email, TECHNICIAN)){
			$_SESSION['role'] = TECHNICIAN;
		}

		// Determine if user is clerk
		else if(checkRole($email, CLERK)){
			$_SESSION['role'] = CLERK;
		}

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
session_start();
// Check what action is required
if(!isset($_POST['action'])){
	$res = getOverview();
}
else if(strcmp($_POST['action'], OVERVIEW) == 0){
	$res = getOverview();
}
else if(strcmp($_POST['action'], DEPARTMENT_INFO) == 0){
	$res = getDepartmentInfo();
}
else if(strcmp($_POST['action'], CUST_TRANSACTIONS) == 0){
	$res = getCustomerTransactions();
}
else if(strcmp($_POST['action'], SUPP_TRANSACTIONS) == 0){
	$res = getSupplierTransactions();
}
else if(strcmp($_POST['action'], NEW_TRANSACTION) == 0){
	$res = getNewTrasaction();
}
else if(strcmp($_POST['action'], SUPP_INFO) == 0){
	$res = getSupplierInfo();
}
else if(strcmp($_POST['action'], CUST_PROFILE) == 0){
	$res = getCustomerProfile();
}
else 
	$res = getOverview();
echo $res;
?>	