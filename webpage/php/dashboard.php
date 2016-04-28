<?php
include 'conn.php'
include 'util.php'

function getCustomerProfile(){
	// TODO
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
	global $conn;
	$rightPanel = '';
	$content = '';

	// For content
	$firstName = getFirstName();
    $lastname = getLastName();
	
	// TODO
	session_start();
	$email = $_SESSION['user'];

	// Determine if user is a customer
	$customer = checkRole('Customer');

	// Determine if user is an employee
	$employee = checkRole('Employee');
	if($employee){

		// Determine the position

		// Determine if user is manager
		$manager = checkRole('Manager');

		// Determine if user is technician
		$technician = checkRole('Technician');

		// Determine if user is clerk
		$clerk = checkRole('Clerk');

		// Determine if user is sales manager
		$salesmgr = checkRole('SalesManager');

		// Add code here TODO 

		$rightPanel .= 
		'<div class="container-fluid">
	      <div class="row">
	        <div class="col-sm-3 col-md-2 sidebar">
	          <ul class="nav nav-sidebar">
	          	<li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>';

		if($manager){
			$_SESSION['role'] = 'Manager';

			$rightPanel .= 
			'<li><a href="#">Department Info</a></li>
            <li><a href="#">Transactions</a></li>';
      	}

	    else if($technician){
	    	$_SESSION['role'] = 'Technician';

	      	$rightPanel .= 
			'<li><a href="#">Department Info</a></li>
            <li><a href="#">Transactions</a></li>';
        }

        else if($clerk){
        	$_SESSION['role'] = 'Clerk';

        	$rightPanel .=
        	'<li><a href="#">Customer Transactions</a></li>
            <li><a href="#">Supplier Transactions</a></li>
            <li><a href="#">New Transaction</a></li>';
        }

        else if($salesmgr){
        	$_SESSION['role'] = 'Sales Manager';

        	$rightPanel .= 
        	'<li><a href="#">Supplier Transactions</a></li>
            <li><a href="#">New Transaction</a></li>
            <li><a href="#">Suppliers Info</a></li>';
        }

	    if($customer){
	    	$_SESSION['customer'] = 1;

	      	$rightPanel .= 
			'<ul class="nav nav-sidebar">
	           <li><a href="#">Customer Profile</a></li>';
		} else 
			$_SESSION['customer'] = 0;
	    
	    $rightPanel .= 
	    '	</ul>
	    </div>';

	    // Assign content now
	    $departmentName = getDepartmentName();
	    $title = $_SESSION['role'] . ' in ' . $departmentName;
	    $startYear = //TODO;
	    $salary = // TODO;
	    $expertise = // TODO;

	    $content .=
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


	     // TODO close divs
	     // TODO check hyperlinks
	     // TODO add js method calls
	     // TODO decide if a clerk and a manager and stuff... dont repeat information yani
		// TODO make an array for keeping all of them so we dont recalculate

	} else {
		// TODO just give the customer information screen
		$rightPanel .= 
			'<div class="container-fluid">
		      <div class="row">
		        <div class="col-sm-3 col-md-2 sidebar">
				<ul class="nav nav-sidebar">
		           <li class="active"><a href="customer.html">Customer Profile <span class="sr-only">(current)</span></a></li>
		        </ul>
		    </div>';

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


==========================================================================================================================================
$result = $mysqli->query("SELECT apply.cid, cname, quota
	FROM apply, company
						WHERE apply.cid = company.cid AND apply.sid = " . $_SESSION['studentID']); // selecting data through mysql_query()

echo'
<table class="flatTable">
	<tr class="titleTr">
		<td class="titleTd">APPLIED COMPANIES</td>
		<td colspan="2"></td>
		<td class="md-trigger plusTd button" id="new-app"></td>
	</tr>
	<tr class="headingTr">
		<td>COMPANY ID</td>
		<td>COMPANY NAME</td>
		<td>QUOTA</td>
		<td></td>
	</tr>';

	if ($result->num_rows > 0) {
	// output data of each row
		while($data = $result->fetch_assoc()) {
			echo"
			<tr>
				<td>".$data['cid']."</td>
				<td>".$data['cname']."</td>
				<td>".$data['quota']."</td>
				<td class=\"controlTd\" id=\"cancel-app\" onclick=\"cancelApplication('".$data['cid']."')\"/>
			</tr>
			";
		}
		$result->close();
	} else {
		echo'<tr>
		<td colspan="4" align="center">No results.</td>
	</tr>';
}
echo'</table>
</div> <!-- closes the tableDiv -->
<div class="dialog" style="display:none">
	<div class="title">New Application</div>';

	$result = $mysqli->query("	
		SELECT c.cid, c.cname
		FROM company AS c
		WHERE c.cid NOT IN(
		SELECT apply.cid
		FROM apply, company
		WHERE apply.cid = company.cid AND apply.sid = ".$_SESSION['studentID']."
		) AND c.quota > 0"
		);

	$applied_companies = $mysqli->query("
		SELECT COUNT(DISTINCT cid) AS count
		FROM apply
		GROUP BY sid
		HAVING sid = ".$_SESSION['studentID']
		);
	
	$count = $applied_companies->fetch_assoc();
	if($count['count'] == 3)
		echo '<p>You can only apply up to 3 companies.</p>';
	else {
		if ($result->num_rows > 0) {

			echo '<table class="smallTable">';
		// output data of each row
			while($data = $result->fetch_assoc()) {
				echo"
				<tr>
					<td>".$data['cid']."</td>
					<td>".$data['cname']."</td>
					<td id=\"apply\" onclick=\"apply('".$data['cid']."')\"/>
				</tr>"
				;
			}
			echo '</table>';
			$result->close();
		} else {
			echo '<p>No results.</p>';
		}
	}
	echo '</div>';
	$mysqli->close();
	?>