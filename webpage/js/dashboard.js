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
