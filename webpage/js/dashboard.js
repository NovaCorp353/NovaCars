$(document).ready(function() {
      $.ajax({
			type: "POST",
			url: "php/session.php",
			success: function(data){
				if(data == 0)
					window.location.href = 'index.html';
			}
		});

    var content = $('#content');
	
	// Get content for overview by default
	$.ajax({
			type: "POST",
			url: "php/dashboard.php",
			cache: false,
			beforeSend: function(){content.html('<p>Retrieving data...</p>');},
			success: function(data){
				if(data) {	
					content.html(data);
				} else {
					// TODO also log out / end session
					$('#signin-err-lb').text('Unable to retrieve data at this time! Try again later.');
					$('#signin-err').css('visibility','visible');   
				}
			}
		});
});

function getContent(contentType){
 	var content = $('#content');
 	$.ajax({
 			type: "POST",
 			url: "php/dashboard.php",
 			data: {action:contentType},
 			cache: false,
 			beforeSend: function(){content.html('<p>Retrieving data...</p>');},
 			success: function(data){
 				if(data) {	
 					content.html(data);
 				} else {
 					// TODO also log out / end session
 					$('#signin-err-lb').text('Unable to retrieve data at this time! Try again later.');
 					$('#signin-err').css('visibility','visible');   
 				}
 			}
 		});
 }

function editEmployee(data){
	// TODO
}

function addEmployee(data){
	// TODO
}
function getCustFiltered(data) 
{
	event.preventDefault();
	var f = $('#filterin').val();
	var table =  $('#table');
	if(f != null){
		$.ajax({
			type: "POST",
			url: "php/dashboard.php",
			data: {filter:f, action:data},
			cache: false,
			success: function(result){
				if(result) {	
					table.html(result);
				} else {
					//todo
					$('#signin-err-lb').text('Login failed. Check credentials!');
					$('#signin-err').css('visibility','visible');   
				}
			}
		});
	} 
}

function getEmployeesFiltered(data)
{
	event.preventDefault();
	var f = $('#filterin').val();
	var table =  $('#table');
	if(f != null){
		$.ajax({
			type: "POST",
			url: "php/dashboard.php",
			data: {filter:f, action:data},
			cache: false,
			success: function(result){
				if(result) {	
					table.html(result);
				} else {
					//todo
					$('#signin-err-lb').text('Login failed. Check credentials!');
					$('#signin-err').css('visibility','visible');   
				}
			}
		});
	} 
}

function addTrans(actionName) 
{
	event.preventDefault();
	//alert(actionName + "b@@@@@@"); 
	var customer = $('#cust_email').val();
	var auto = $('#auto_plate').val();
	var rev = $('#revenue').val();
	var radios = document.getElementsByName('radiop');
	for (var i = 0, length = radios.length; i < length; i++) {
	    if (radios[i].checked) {
	        var oper = radios[i].value;
	        break;
	    }
	}
	var dropDown = document.getElementById(oper);
	if(dropDown!=null)
		var tech = dropDown.options[dropDown.selectedIndex].text;
	//alert("~~~~"+customer + "~" +tech + "~"+ radios.length +"~"+oper+"&&&&");
		
	if(customer != null && customer != "" && auto != null && auto != null && rev != null && rev != "" && oper != null && tech != null)
	{
		$.ajax({
			type: "POST",
			url: "php/dashboard.php",
			data: {cust_email:customer, auto_plate: auto, revenue: rev, operation: oper, tech_email: tech, action: actionName},
			cache: false,
			success: function(data)
			{
				if(data == 1) 
				{	
					alert("Customer transaction successfully added!");
					$('#newtrans-err').css('visibility','hidden');
					window.location.href = 'dashboard.html'; 					
				} 
				else 
				{
					//alert("yo2");
					$('#newtrans-err-lb').text('Transaction is not added. Constraints were not met.');
					$('#newtrans-err').css('visibility','visible');
				}
			}
		});
	} 
	else 
	{
		//alert(customer + auto + rev + "yoooo");
		$('#newtrans-err-lb').text('Transaction is not added. Constraints were not met.');
		$('#newtrans-err').css('visibility','visible');   
	}
}

function updatePassword(data){
	var pass = $('#passField').val();
	var passwordBox = $('#passwordBox');
	if(pass != null && pass != ""){
		$.ajax({
			type: "POST",
			url: "php/dashboard.php",
			data: {action:data, password:pass},
			cache: false,
			success: function(result){
				if(result == 1) {
					$('#passwordBox-lb').text('Password changed successfully!');
					$("#passwordBox").attr('class', 'col-md-8 col-md-offset-2 alert alert-success');   
				} else {
					$('#passwordBox-lb').text('Password change failed! Try another password.');
					$("#passwordBox").attr('class', 'col-md-8 col-md-offset-2 alert alert-danger');   
				}
				$('#passwordModal').modal('toggle');
				$('#passwordBox').css('visibility','visible');
			}
		});
	} 
}

function addAuto(data)
{
	var plate = $('#addAuto-plate').val();
	var model = $('#addAuto-model').val();
	var year = $('#addAuto-year').val();

	var autoPanel = $('#autoPanel');
	if(plate != "" && model != "" && year != ""){
		$.ajax({
			type: "POST",
			url: "php/dashboard.php",
			data: {action:data, plate:plate, model:model, year:year},
			cache: false,
			success: function(result){
				if(result == 1) {
					// Update the auto list
					$.ajax({
						type: "POST",
						url: "php/dashboard.php",
						data: {action:'AutoList'},
						cache: false,
						success: function(result){
							if(result) {
								autoPanel.html();
								autoPanel.html(result);  
							}
						}
					});


					$('#addAutoBox-lb').text('Auto was successfully added!');
					$("#addAutoBox").attr('class', 'col-md-8 col-md-offset-2 alert alert-success');   
				} else {
					$('#addAutoBox-lb').text('Unable to add new auto! Try again.');
					$("#addAutoBox").attr('class', 'col-md-8 col-md-offset-2 alert alert-danger');   
				}
				$('#addAutoModal').modal('toggle');
				$('#addAutoBox').css('visibility','visible');
			}
		});
	} 		
}

function removeAuto(action, plate){

	var autoPanel = $('#autoPanel');
	$.ajax({
			type: "POST",
			url: "php/dashboard.php",
			data: {action:action, plate:plate},
			cache: false,
			success: function(result){
				if(result == 1) {
					// Update the auto list
					$.ajax({
						type: "POST",
						url: "php/dashboard.php",
						data: {action:'AutoList'},
						cache: false,
						success: function(result){
							if(result) {
								autoPanel.html();
								autoPanel.html(result);  
							}
						}
					});


					$('#addAutoBox-lb').text('Auto was successfully removed!');
					$("#addAutoBox").attr('class', 'col-md-8 col-md-offset-2 alert alert-success');   
				} else {
					$('#addAutoBox-lb').text('Unable to remove auto!');
					$("#addAutoBox").attr('class', 'col-md-8 col-md-offset-2 alert alert-danger');   
				}
				$('#addAutoBox').css('visibility','visible');
			}
		});
}
