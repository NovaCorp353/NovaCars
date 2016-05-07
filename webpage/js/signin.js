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
				if(data) {					
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

	window.location.href = 'dashboard.html'; // TODO or probably ../dashboard.html
	var content = $('#content');
	
	// Get Overview
	$.ajax({
			type: "POST",
			url: "php/dashboard.php",
			cache: false,
			beforeSend: function(){content.html('<p>Retrieving data...</p>');},
			success: function(data){
				if(data == 1) {					
					content.html(data);
				} else {
					// TODO also log out / end session
					$('#signin-err-lb').text('Unable to retrieve data at this time! Try again later.');
					$('#signin-err').css('visibility','visible');   
				}
			}
		});
}