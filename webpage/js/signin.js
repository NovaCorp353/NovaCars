$('#register').click(function(){
	window.location.href = 'register.html';
});	

$('#signin-form').submit(function(event) {
	event.preventDefault();
	var e = $('#inputEmail').val();
	var p = $('#inputPassword').val();
	if(e != null && e != "" && p != null && p != ""){
		$.ajax({
			type: "POST",
			url: "php/signin.php",
			data: {email:e, password:p},
			cache: false,
			beforeSend: function(){ $("#signin-btn").val('Connecting...');},
			success: function(data){
				if(data == 1) {					
					loggedin();
				} else {
					$('#signin-err-lb').text('Login failed. Check credentials!');
					$('#signin-err').css('visibility','visible');   
				}
			}
		});
	} else {
		$('#signin-err-lb').text('All fields are required!');
		$('#signin-err').css('visibility','visible');   
	}
});

function loggedin(){
	$('#signin-err').css('visibility','hidden'); 
	alert('logged in');

	var customer = isCustomer();
	var employee = isEmployee();

	if( !customer && !employee){
		// TODO error
		$('#signin-err-lb').text('Your account is registered neither as a customer nor as an employee.');
		$('#signin-err').css('visibility','visible'); 
	} else if (!customer && employee){
		// TODO only employee
	} else if (customer && !employee){
		// TODo only customer
	} else {
		// TODO both
	}
}


function isCustomer(){
	// TODO
}

function isEmployee(){
	// TODO
}