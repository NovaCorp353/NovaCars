<?php
include('util.php');

function getCustomerProfile()
{
	// TODO
	// ADD AUTO

	$rightPanel = getRightPanel($_SESSION["user"], CUST_PROFILE);
	$header = getCustHeader($_SESSION["user"]);

	$firstName = $header['first_name'];
	$lastName = $header['last_name'];
	$membershipStatus = $header['membership_sts'];
	$bonusPoints = $header['bonus_pts'];

	$history = getCustHistory($_SESSION['user']);

	$content = 
			'<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		    <h1 class="page-header">'.$firstName.' '.$lastName.'</h1>
		    <h3>'.$membershipStatus.' Customer</h3>
		    <h4 class="txt-muted">'.$bonusPoints.' points collected</h4>
		    
		    <div class="row">
		     <div class="col-sm-12 col-md-6">
		      <div class="panel panel-info">
		       <!-- Default panel contents -->
		       <div class="panel-heading">Customer profile</div>

		       <!-- List group -->
		       <ul class="list-group">
		        <li class="list-group-item"><strong>Email</strong>: '.$_SESSION['user'].'</li>
		        <li class="list-group-item"><strong>Password</strong>: <button class="btn btn-default" data-toggle="modal" data-target="#passwordModal"><span class="glyphicon glyphicon-pencil"></span> Change</button></li>
		      </ul>
		    </div>

			<div id="passwordBox" style="visibility: hidden;" class="alert alert-danger" style="width:50%" role="alert">
	    		<p id="passwordBox-lb" class="text-center"/>
			</div>

		  </div>';


		$content .= '<div id="autoPanel">' .getAutoList() .'</div>';

		$content .= 
		'</div>

		<h2 class="sub-header">History</h2>
		<div class="table-responsive">
		  <table class="table table-striped">
		    <thead>
		      <tr>
		        <th>ID</th>
		        <th>Auto</th>
		        <th>Operation</th>
		        <th>Price</th>
		        <th>Date</th>
		        <th>Points Earned</th>
		      </tr>
		    </thead>
		    <tbody>';
    if($history == NULL)
	{
		$content .= "<tr><td>No history</td></tr>";
	}
	else
	{
		while($data = $history->fetch_assoc())
	     {
	     	$auto = $data['model'].' ['.$data['year'].']';
	     	$bonus = $data['amount']/10;
	     	$content .= 
	     	'<tr>
	     		<td>'.$data['id'].'</td>
	     		<td>'.$auto.'</td>
	     		<td>'.$data['op_name'].'</td>
	     		<td>'.$data['amount'].'</td>
	     		<td>'.$data['date'].'</td>
	     		<td>'.$bonus.'</td>
	     	</tr>';
	     }
	 }
	$content .= 
	'	    </tbody>
		  </table>
		</div>
		</div>
		</div>
		</div>

		<!-- Modal for password change -->
		<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModal" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	            <h4 class="modal-title">Update password</h4>
	            </div>
	            <div class="modal-body">
	                <form>
	                	<label for="passField">New Password</label>
	                	<input type="password" class="form-control" id = "passField" placeholder="Type your new password here" required></input>
	                </form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	                <button type="button" class="btn btn-danger" onclick="updatePassword(\''.CHANGE_PASSWORD.'\')">Save new password</button>
	        	</div>
	    	</div>
	  	</div>
		</div>


		<!-- Modal for adding auto -->
		<div class="modal fade" id="addAutoModal" tabindex="-1" role="dialog" aria-labelledby="addAutoModal" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	            <h4 class="modal-title">Add new auto</h4>
	            </div>
	            <div class="modal-body">
	                <form>
	                	<label for="addAuto-plate">Plate</label>
	                	<input type="text" class="form-control" id = "addAuto-plate" placeholder="Enter the plate number" required></input>

	                	<label for="addAuto-model">Model</label>
	                	<input type="text" class="form-control" id = "addAuto-model" placeholder="Enter the car model" required></input>

	                	<label for="addAuto-year">Plate</label>
	                	<input type="number" min="1970" max="'.date("Y").'" class="form-control" id = "addAuto-year" placeholder="Enter the production year" required></input>
	                </form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	                <button type="button" class="btn btn-primary" onclick="addAuto(\''.ADD_AUTO.'\')">Add</button>
	        	</div>
	    	</div>
	  	</div>
		</div>';

	return $rightPanel.$content;
}

function getAutoList(){
	$content = 
	'<div class="col-sm-12 col-md-6">
		    <div class="panel panel-info">
		     <!-- Default panel contents -->
		     <div class="panel-heading">Owned vehicles</div>

		     <!-- List group -->
		     <ul class="list-group">';

     $autoList = getCustAutos($_SESSION['user']);	
	if($autoList == NULL)
    {
    	$table = "No autos to display";
    }
    else
    {
    	while($data = $autoList->fetch_assoc())
    	{
    		$content .='<li class="list-group-item"><a onclick="removeAuto(\''.REMOVE_AUTO.'\', \''.$data['plate'].'\')"><span class="glyphicon glyphicon-remove text-danger"></span></a><strong> '.$data['model'].' ['.$data['year'].'] '.'</strong>: '.$data['plate'].'</li>';
    	}
	}
	$content .= '</ul>
		  </div>
		  <button class="btn btn-success" data-toggle="modal" data-target="#addAutoModal"><span class="glyphicon glyphicon-plus"></span> Add</button>
		</div>

		<div id="addAutoBox" style="visibility: hidden;" class="alert alert-danger" style="width:50%" role="alert">
    		<p id="addAutoBox-lb" class="text-center"/>
		</div>';

	return $content;
}

function getDepartmentInfo(){
	// Getting right panel
	$rightPanel = getRightPanel($_SESSION['user'], DEPARTMENT_INFO);

	// Getting content
	if(strcmp($_SESSION['role'], MANAGER) == 0){
		$header = getMgrCustTransHeader($_SESSION["user"]);
		$deptName = $header['dept_name'];
		$firstName = $header['first_name'];
		$lastName = $header['last_name'];

		$departmentInfo = getDepartmentDetailed($deptName);
		$budget = $departmentInfo['budget']; 
		$expenditures = $departmentInfo['expenditure']; 
		$revenue = getMgrCustTransStats($deptName)['tot_revenue'];
		$nrEmployees = $departmentInfo['cnt_employees']; 

		$operations = getOperations($deptName);
		$employees = getEmployees($deptName, "");

		$content = 
		'<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		    <h1 class="page-header">'.$deptName.'</h1>
			<h3 class="text-muted">Manager: '.$firstName.' '.$lastName.'</h3>
			
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="panel panel-info">
						  <div class="panel-heading">Quick Information</div>
						  <ul class="list-group">
							<li class="list-group-item"><strong>Allocated Budget</strong>: '.$budget.'</li>
							<li class="list-group-item"><strong>Total Expenditures</strong>:'.$expenditures.'</li>
							<li class="list-group-item"><strong>Total Revenue</strong>: '.$revenue.'</li>
							<li class="list-group-item"><strong>Number of Employees</strong>: '.$nrEmployees.'</li>
						  </ul>
					</div>
				</div>
				
				<div class="col-sm-12 col-md-6">
					<div class="panel panel-info">
						  <div class="panel-heading">Provided Operations</div>
						  <ul class="list-group">';

		while($data = $operations->fetch_assoc()){
			$content .= '<li class="list-group-item"><strong>'.$data['op_name'].'</strong> - Cost: '.$data['cost'].'</li>';

		}	
		$content .=
						  '</ul>
					</div>
				</div>
			</div>
			
			<h2 class="sub-header">Employees</h2>
			<form class="form-inline" role="form">
				<div class="form-group">
					<input type="text" id = "filterin" placeholder="Filter by name" class="form-control">
					<button type="submit" id="filter" onclick="getEmployeesFiltered(\''.FILTER_EMPLOYEE.'\')" class="btn btn-primary">Filter</button>	
				</div>
			</form>
	          <div id="table"class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>#</th>
	                  <th>Name</th>
	                  <th>Email</th>
	                  <th>Salary</th>
	                  <th>Expertise Level</th>
					  <th>Edit</th>
	                </tr>
	              </thead>
	              <tbody>';

	    $count = 1;
	    while($data = $employees->fetch_assoc()){
	    	$content .= '<tr>
                  <td>'.$count.'</td>
				  <td>'.$data['first_name'].' '.$data['last_name'].'</td>
                  <td>'.$data['email'].'</td>
                  <td>'.$data['salary'].'</td>
                  <td>'.$data['expertise_lvl'].'</td>
                  <td><a onclick="editEmployee(\''.$data['email'].'\')"><span class="glyphicon glyphicon-edit"></span></a></td>
                </tr>';
            $count++;
	    }
	    
	    $content .= '</tbody>
	            </table>
	          </div>

			<form class="form">
				  <button type="button" class="btn btn-success" onclick="addEmployee(\''.NEW_EMPLOYEE.'\')">
				  <span class="glyphicon glyphicon-plus"></span> New employee
				</button>
			</form> 
			
	        </div>
	      </div>';
	}
	return $rightPanel . $content; 
}

function getEmplFiltered()
{
	$filter = $_POST['filter'];
	$deptName = getDepartment($_SESSION['user']);
	$trans = getEmployees($deptName['dept_name'], $filter);
	$table = '<div id="table"class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>#</th>
	                  <th>Name</th>
	                  <th>Email</th>
	                  <th>Salary</th>
	                  <th>Expertise Level</th>
					  <th>Edit</th>
	                </tr>
	              </thead>
	              <tbody>';
	if($trans == NULL)
    {
    	$table .= "<tr><td>No employee with the filter</td><tr>";
    }
    else
    {
    	$count = 1;
	    while($data = $trans->fetch_assoc()){
	    	$table .= '<tr>
                  <td>'.$count.'</td>
				  <td>'.$data['first_name'].' '.$data['last_name'].'</td>
                  <td>'.$data['email'].'</td>
                  <td>'.$data['salary'].'</td>
                  <td>'.$data['expertise_lvl'].'</td>
                  <td><a onclick="editEmployee(\''.$data['email'].'\')"><span class="glyphicon glyphicon-edit"></span></a></td>
                </tr>';
            $count++;
	    }
		 $table .= '
	              </tbody>
	            </table>
	          </div>';
    }

    return $table;
}

function getCustFiltered()
{
	$role = $_SESSION['role'];
	if(strcmp($role, MANAGER) == 0)
	{
		$filter = $_POST['filter'];
		$deptName = getDepartment($_SESSION['user']);
		$trans = getMgrCustTrans($deptName['dept_name'], $filter);
		$table = '<div id="table" class="table-responsive">
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
	    if($trans == NULL)
	    {
	    	$table = "No operation with the filter";
	    }
	    else
	    {
	    	while($data = $trans->fetch_assoc())
		     {
		     	$custName = $data['f_name'].' '.$data['l_name'];
		     	$techName = $data['first_name'].' '.$data['last_name'];
		     	$table .= 
		     	'<tr>
		     		<td>'.$data['id'].'</td>
		     		<td>'.$custName.'</td>
		     		<td>'.$data['model'].'</td>
		     		<td>'.$data['op_name'].'</td>
		     		<td>'.$techName.'</td>
		     		<td>'.$data['amount'].'</td>
		     		<td>'.$data['date'].'</td>
		     		<td><a data-toggle="modal" data-target="#detailed_info_modal"><span class="glyphicon glyphicon-info-sign"></span></a></td>
		     	</tr>';
		     }
			 $table .= '
		              </tbody>
		            </table>
		          </div>';
	    }
	}
	else if(strcmp($role, CLERK) == 0)
	{
		$filter = $_POST['filter'];
		$trans = getClerkCustTrans($_SESSION['user'], $filter, FALSE);
		$table = '<div id="table" class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>ID</th>
	                  <th>Customer</th>
					  <th>Auto</th>
	                  <th>Operation</th>
	                  <th>Price</th>
					  <th>Date</th>
					  <th>Details</th>
	                </tr>
	              </thead>
	              <tbody>';
	    if($trans == NULL)
	    {
	    	$table = "No operation with the filter";
	    }
	    else
	    {
	    	while($data = $trans->fetch_assoc())
		     {
		     	$custName = $data['first_name'].' '.$data['last_name'];
		     	$table .= 
		     	'<tr>
		     		<td>'.$data['id'].'</td>
		     		<td>'.$custName.'</td>
		     		<td>'.$data['model'].'</td>
		     		<td>'.$data['op_name'].'</td>
		     		<td>'.$data['amount'].'</td>
		     		<td>'.$data['date'].'</td>
		     		<td><a data-toggle="modal" data-target="#detailed_info_modal"><span class="glyphicon glyphicon-info-sign"></span></a></td>
		     	</tr>';
		     }
			 $table .= '
		              </tbody>
		            </table>
		          </div>';
	    }
	}
	else if(strcmp($role, TECHNICIAN) == 0)
	{
		$filter = $_POST['filter'];
		$trans = getTechCustTrans($_SESSION['user'], $filter);
		$table = '<div id="table" class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>ID</th>
	                  <th>Customer</th>
					  <th>Auto</th>
	                  <th>Operation</th>
	                  <th>Price</th>
					  <th>Date</th>
	                </tr>
	              </thead>
	              <tbody>';
	    if($trans == NULL)
	    {
	    	$table = "No operation with the filter";
	    }
	    else
	    {
	    	while($data = $trans->fetch_assoc())
		     {
		     	$custName = $data['first_name'].' '.$data['last_name'];
		     	$table .= 
		     	'<tr>
		     		<td>'.$data['id'].'</td>
		     		<td>'.$custName.'</td>
		     		<td>'.$data['model'].'</td>
		     		<td>'.$data['op_name'].'</td>
		     		<td>'.$data['amount'].'</td>
		     		<td>'.$data['date'].'</td>
		     	</tr>';
		     }
			 $table .= '
		              </tbody>
		            </table>
		          </div>';
	    }
	}
	else
	{
		$table = "";
	}
	return $table;
}

function getCustomerTransactions(){

	$rightPanel = getRightPanel($_SESSION["user"], CUST_TRANSACTIONS);
	if(isset($_SESSION['role'])) 
	{
		$role = $_SESSION['role'];
	} else {
		$role = getRole($email); 
		$_SESSION['role'] = $role;
	}

	if(strcmp($role, MANAGER) == 0)
	{
		$header = getMgrCustTransHeader($_SESSION["user"]);
		$firstName = $header['first_name'];
		$lastName = $header['last_name'];
		$deptName = $header['dept_name'];
		$stats = getMgrCustTransStats($deptName);
		$noOfTrans = $stats['trans_count'];
		$revenue = $stats['tot_revenue'];
		
		$filter = '';
		$trans = getMgrCustTrans($deptName, $filter);
		$content = '<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">' . $deptName . '</h1>
		  <h3 class="text-muted">Manager: '.$firstName .' '.$lastName.'</h3>
		
		<div class="panel panel-info" style="width:50%">
			  <div class="panel-heading">Customer Transactions</div>
			  <ul class="list-group">
				<li class="list-group-item"><strong>Number of Transactions</strong>: ' . $noOfTrans . '</li>
				<li class="list-group-item"><strong>Total Revenue</strong>: '.$revenue.'</li>
			  </ul>
		</div>
					
		<h2 class="sub-header">Customer Transactions</h2>
		<form class="form-inline" role="form">
			<div class="form-group">
				<input type="text" id="filterin" placeholder="Filter" class="form-control">
				<button type="submit" id="filter" onclick="getCustFiltered(\'' .FILTER_CUST_TRANS. '\')" class="btn btn-primary">Filter</button>	
			</div>
		</form>
          <div id="table" class="table-responsive">
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
     	$content .= 
     	'<tr>
     		<td>'.$data['id'].'</td>
     		<td>'.$custName.'</td>
     		<td>'.$data['model'].'</td>
     		<td>'.$data['op_name'].'</td>
     		<td>'.$techName.'</td>
     		<td>'.$data['amount'].'</td>
     		<td>'.$data['date'].'</td>
     		<td><a data-toggle="modal" data-target="#detailed_info_modal"><span class="glyphicon glyphicon-info-sign"></span></a></td>
     	</tr>';
     }
	 $content .= '</tbody>
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
        </div></div></div>';
	}
	else if(strcmp($role, TECHNICIAN) == 0)
	{
		$header = getTechHeader($_SESSION["user"]);
		$firstName = $header['first_name'];
		$lastName = $header['last_name'];
		$stats = getTechCustTransStats($_SESSION["user"]);
		$noOfTrans = $stats['trans_count'];
		$revenue = $stats['tot_revenue'];

		$content = 
		'<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Customer Transactions</h1>
		  <h3 class="text-muted">Technician: '.$firstName.' '.$lastName.'</h3>
			<div class="panel panel-info" style="width:50%">
				  <!-- Default panel contents -->
				  <div class="panel-heading">Quick Info</div>
				  <!-- List group -->
				  <ul class="list-group">
					<li class="list-group-item"><strong>Number of Transactions</strong>: '.$noOfTrans.'</li>
					<li class="list-group-item"><strong>Total Revenue</strong>: '.$revenue.'</li>
				  </ul>
			</div>		
			<h2 class="sub-header">Customer Transactions</h2>
			<form class="form-inline" role="form">
				<div class="form-group">
					<input type="text" id="filterin" placeholder="Filter" class="form-control">
					<button type="submit" id="filter" class="btn btn-primary" onclick="getCustFiltered(\'' .FILTER_CUST_TRANS. '\')">Filter</button>		
				</div>
			</form>
	          <div id="table" class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>ID</th>
	                  <th>Customer</th>
					  <th>Auto</th>
	                  <th>Operaton</th>
	                  <th>Price</th>
					  <th>Date</th>
	                </tr>
	              </thead>
	              <tbody>';

	    $filter = "";
	    $trans = getTechCustTrans($_SESSION['user'], $filter);
		while($data = $trans->fetch_assoc())
	     {
	     	$custName = $data['first_name'].' '.$data['last_name'];
	     	$content .= 
	     	'<tr>
	     		<td>'.$data['id'].'</td>
	     		<td>'.$custName.'</td>
	     		<td>'.$data['model'].'</td>
	     		<td>'.$data['op_name'].'</td>
	     		<td>'.$data['amount'].'</td>
	     		<td>'.$data['date'].'</td>
	     	</tr>';
	     }

	     $content .=
	     '	     </tbody>
	            </table>
	          </div>
        </div></div></div>';
	}
	else if(strcmp($role, CLERK) == 0)
	{
		$header = getClerkHeader($_SESSION["user"]);
		$firstName = $header['first_name'];
		$lastName = $header['last_name'];
		$stats = getClerkCustTransStats($_SESSION["user"]);
		$noOfTrans = $stats['trans_count'];
		$revenue = $stats['tot_revenue'];

		$content = 
		'<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Customer Transactions</h1>
		  <h3 class="text-muted">Clerk: '.$firstName.' '.$lastName.'</h3>
			<div class="panel panel-info" style="width:50%">
				  <!-- Default panel contents -->
				  <div class="panel-heading">Quick Info</div>
				  <!-- List group -->
				  <ul class="list-group">
					<li class="list-group-item"><strong>Number of Transactions</strong>: '.$noOfTrans.'</li>
					<li class="list-group-item"><strong>Total Revenue</strong>: '.$revenue.'</li>
				  </ul>
			</div>		
			<h2 class="sub-header">Customer Transactions</h2>
			<form class="form-inline" role="form">
				<div class="form-group">
					<input type="text" id="filterin" placeholder="Filter" class="form-control">
					<button type="submit" id="filter" class="btn btn-primary" onclick="getCustFiltered(\'' .FILTER_CUST_TRANS. '\')">Filter</button>		
				</div>
				<form class="form-inline" role="form">
					<div class="form-group pull-right">
						<input data-on-text="Only my transactions" data-off-text="All transactions" data-on-color="success" data-off-color="warning" type="checkbox" id="scope_toggle" checked></input>
					</div>
				</form>
			</form>
	          <div id="table" class="table-responsive">
	            <table class="table table-striped">
	              <thead>
	                <tr>
	                  <th>ID</th>
	                  <th>Customer</th>
					  <th>Auto</th>
	                  <th>Operaton</th>
	                  <th>Price</th>
					  <th>Date</th>
					  <th>Details</th>
	                </tr>
	              </thead>
	              <tbody>';

	    $filter = "";
	    $val = FALSE;
	    $trans = getClerkCustTrans($_SESSION['user'], $filter, $val);
		while($data = $trans->fetch_assoc())
	     {
	     	$custName = $data['first_name'].' '.$data['last_name'];
	     	$content .= 
	     	'<tr>
	     		<td>'.$data['id'].'</td>
	     		<td>'.$custName.'</td>
	     		<td>'.$data['model'].'</td>
	     		<td>'.$data['op_name'].'</td>
	     		<td>'.$data['amount'].'</td>
	     		<td>'.$data['date'].'</td>
	     		<td><a data-toggle="modal" data-target="#detailed_info_modal"><span class="glyphicon glyphicon-info-sign"></span></a></td>
	     	</tr>';
	     }

	     $content .=
	     '	     </tbody>
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
        </div></div></div>';
	}
	else
	{
		$content = "";
	}

	return $rightPanel . $content;
}

function getNewTransaction()
{
	$rightPanel = getRightPanel($_SESSION["user"], NEW_TRANSACTION);

	$content = 
	'<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <h1 class="page-header">New Transaction</h1>
		<div id="newtrans-err" style="visibility: hidden;" class="col-md-8 col-md-offset-2 alert alert-danger" role="alert">
	    		<p id="newtrans-err-lb" class="text-center"/>
	  	</div>
		<form id="new-cust-trans-form">
			<div style="width:50%">
				<div class="form-group">
					<label for="cust_email">Customer Email</label>
					<input type="email" class="form-control" id="cust_email" placeholder="Email" required>
				</div>
				<div class="form-group">
					<label for="auto_plate">Vehicle Plate Number</label>
					<input type="text" class="form-control" id="auto_plate" placeholder="Plate Number" required>
				</div>
				<div class="form-group">
					<label for="revenue">Revenue</label>
					<input type="number" class="form-control" id="revenue" placeholder="Revenue">
				</div>
			<button onclick="addTrans(\''.ADD_TRANS.'\')" class="btn btn-success">Complete Transaction</button>
			</div>	 
			<div style="width:100%">
				<h2 class="sub-header">Select operation</h2>
				<div class="table-responsive">
	            	<table class="table table-striped">
	              		<thead>
	                		<tr>
	                  			<th></th>
	                  			<th>Operation Name</th>
					  			<th>Providing Department</th>
	                  			<th>Cost</th>
					  			<th>Technician</th>
	                		</tr>
	              		</thead>
	              		<tbody>';
    $ops = getOperations();
    if($ops != NULL)
    {
    	$preO = "null";
    	$preD = "null";
    	 while($data = $ops->fetch_assoc())
    	 {
    	 	if(strcmp($preO, $data['op_name']) || strcmp($preD, $data['dept_name']))
            {
            	if(strcmp($preO, "null"))
            	{
            		$content .=
            		'					</select>
									</div>';
            	}
            	$content .= 
		    	'			<tr>
		    	 				<td><input type="radio" name="radiop" value = "'.$data['op_name'].'-'.$data['dept_name'].'"></td>
	      						<td>'.$data['op_name'].'</td>
								<td>'.$data['dept_name'].'</td>
	                			<td>'.$data['cost'].'</td>
	            				<td class="input-group" style="width:300px">
									<div class="form-group">
  										<select class="form-control" id="'.$data['op_name'].'-'.$data['dept_name'].'">  
											<option>'.$data['tech_email'].'</option>';
				$preO = $data['op_name'];
				$preD = $data['dept_name'];
            }
            else
            {
            	$content .= '				<option>'.$data['tech_email'].'</option>';
            }
	    }
    }
    $content .= 
    '         				</tbody>
            			</table>
          		</div>
          	</div>
        </form>
    </div></div></div>';
	return $rightPanel.$content;
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
		$_SESSION['dept_name'] = $departmentName;
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
				<li class="list-group-item"><strong>Password</strong>: <button class="btn btn-default" data-toggle="modal" data-target="#passwordModal"><span class="glyphicon glyphicon-pencil"></span> Change</button></li>
				<li class="list-group-item"><strong>Salary</strong>: ' . $salary . '</li>
				<li class="list-group-item"><strong>Expertise Level</strong>: ' . $expertise . '</li>
			</ul>
		</div>

		<div id="passwordBox" style="visibility: hidden;" class="alert alert-danger" style="width:50%" role="alert">
    		<p id="passwordBox-lb" class="text-center"/>
		</div>

		</div>
		</div>

		<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModal" aria-hidden="true">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <div class="modal-header">
	            <h4 class="modal-title">Update password</h4>
	            </div>
	            <div class="modal-body">
	                <form>
	                	<label for="passField">New Password</label>
	                	<input type="password" class="form-control" id = "passField" placeholder="Type your new password here" required></input>
	                </form>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	                <button type="button" class="btn btn-danger" onclick="updatePassword(\''.CHANGE_PASSWORD.'\')">Save new password</button>
	        	</div>
	    	</div>
	  	</div>
		</div>';

		$rightPanel = getRightPanel($email, OVERVIEW);
		return $rightPanel . $content;

	} else
		return getCustomerProfile($email);
}

function getRightPanel($email, $cur_tab)
{
	$role = getRole($_SESSION['user']);
	$isCustomer = isCustomer($email);

	// Determine if user is an employee
	$employee = checkRole($email, EMPLOYEE);
	if($employee)
	{	
		// Assign right panel content
		if(strcmp($cur_tab, OVERVIEW) == 0)
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
							<li><a href="#" onclick="getContent( \'' . OVERVIEW . '\')">Overview</a></li>';

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

			if(strcmp($cur_tab, CUST_TRANSACTIONS) == 0)
				$rightPanel .= 
				'<li class="active"><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Transactions <span class="sr-only">(current)</span></a></li>';

			else
				$rightPanel .= 
				'<li><a href="#" onclick="getContent( \'' . CUST_TRANSACTIONS . '\')">Transactions</a></li>';
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
				'<li><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '\')">Supplier Transactions</a></li>
	        	<li><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction</a></li>
	        	<li class="active"><a href="#" onclick="getContent( \'' . SUPP_INFO . '\')">Suppliers Info <span class="sr-only">(current)</span></a></li>';
			else
	        	$rightPanel .= 
	        	'<li><a href="#" onclick="getContent( \'' . SUPP_TRANSACTIONS . '\')">Supplier Transactions</a></li>
	        	<li><a href="#" onclick="getContent( \'' . NEW_TRANSACTION . '\')">New Transaction</a></li>
	        	<li><a href="#" onclick="getContent( \'' . SUPP_INFO . '\')">Suppliers Info</a></li>';
        }

        $rightPanel .= '</ul>';
        if($isCustomer)
	    {
	    	if( strcmp($cur_tab, CUST_PROFILE) == 0)
	        	$rightPanel .= 
	        	'<ul class="nav nav-sidebar">
	        	<li class="active"><a href="#" onclick="getContent( \'' . CUST_PROFILE . '\')">Customer Profile <span class="sr-only">(current)</span></a></li>';
	        else
	        	$rightPanel .= 
	        	'<ul class="nav nav-sidebar">
	        	<li><a href="#" onclick="getContent( \'' . CUST_PROFILE . '\')">Customer Profile</a></li>';
	        $rightPanel .=	'</ul></div>';
	   		return $rightPanel;
	    } 
	    else 
	    {
	    	$rightPanel .=	'</div>';
	    	return $rightPanel;
	    }

    }    
	else 
	{
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

function getRole($email)
{
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
function isCustomer($email)
{

	if(!isset($_SESSION['isCustomer'])){ // Caching
		$customer = checkRole($email, CUSTOMER);
		$_SESSION['isCustomer'] = $customer;
	}

	return $_SESSION['isCustomer'];
}

function addNewTransactionDash()
{
	$string = $_POST['operation'];
	$token = strtok($string, "-");
	$yo = 0;
	while ($token !== false)
	{
		if($yo === 0)
		{
			$op_name = $token;
			$yo++;
		}
		else
		{
			$dept_name = $token;
		}
		$token = strtok("-");
	} 
	$res = addNewTransaction($_POST['revenue'], $op_name, $dept_name, $_POST['tech_email'], $_SESSION['user'], $_POST['cust_email'], $_POST['auto_plate']);
	return $res;
}
// Execution starts here
session_start();

// Check what action is required
if(!isset($_POST['action']))
	$res = getOverview();
else if(strcmp($_POST['action'], OVERVIEW) == 0)
	$res = getOverview();
else if(strcmp($_POST['action'], DEPARTMENT_INFO) == 0)
	$res = getDepartmentInfo();
else if(strcmp($_POST['action'], CUST_TRANSACTIONS) == 0)
	$res = getCustomerTransactions();
else if(strcmp($_POST['action'], SUPP_TRANSACTIONS) == 0)
	$res = getSupplierTransactions();
else if(strcmp($_POST['action'], NEW_TRANSACTION) == 0)
	$res = getNewTransaction();
else if(strcmp($_POST['action'], SUPP_INFO) == 0)
	$res = getSupplierInfo();
else if(strcmp($_POST['action'], CUST_PROFILE) == 0)
	$res = getCustomerProfile();
else if(strcmp($_POST['action'], FILTER_EMPLOYEE) == 0)
	$res = getEmplFiltered();
else if(strcmp($_POST['action'], NEW_EMPLOYEE) == 0)
	$res = getNewEmployee();
else if(strcmp($_POST['action'], FILTER_CUST_TRANS) == 0)
	$res = getCustFiltered();
else if(strcmp($_POST['action'], ADD_TRANS) == 0)
	$res = addNewTransactionDash();
else if(strcmp($_POST['action'], CHANGE_PASSWORD) == 0)
	$res = changePassword();
else if(strcmp($_POST['action'], ADD_AUTO) == 0)
	$res = addAuto();
else if(strcmp($_POST['action'], AUTO_LIST) == 0)
	$res = getAutoList();
else if(strcmp($_POST['action'], REMOVE_AUTO) == 0)
	$res = removeAuto();
else 
	$res = getOverview();
echo $res;
?>	