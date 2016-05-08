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

function getReportMostPurchased(action){
	event.preventDefault();

	// Check if end year is greater than start year
	var startYear = $('#mostPurchasesStartYear').val();
	var endYear = $('#mostPurchasesEndYear').val();

	if(endYear < startYear){
		$('#reportError-lb').text('Start year should be earlier than end year!');
		$('#reportError').css('visibility','visible');	
	} else {
		// Start ajax
		var content = $('#reportMostPurchased');
		$.ajax({
				type: "POST",
				url: "php/dashboard.php",
				data: {action:action, startMostPurchased:startYear, endMostPurchased:endYear},
				cache: false,
				success: function(result){
					if(result) {
						// Update the list
						content.html(); 
						content.html(result); 
						$('#reportError').css('visibility','hidden');	
					} else {
						$('#reportError-lb').text('Error!');
						$('#reportError').css('visibility','visible');	
					}
				}
			});
	}
}