$('#register').click(function(){
	window.location.href = 'register.html';
});	

$('#signin-btn').click(function(event) {
	event.preventDefault();
	var u = $('#inputEmail').val();
	var p = $('#inputPassword').val();
	if(u != null && u != "" && p != null && p != ""){
		$.ajax({
			type: "POST",
			url: "php/login.php",
			data: {username:u, password:p},
			cache: false,
			beforeSend: function(){ $("#signin-btn").val('Connecting...');},
			success: function(data){
				if(data == 1) {					
					loggedin();
				} else {
					$('#signin-err').text('Login failed. Check credentials!');
					$('#signin-err').css('visibility','visible');   
				}
			}
		});
	} else {
		$('#signin-err').text('All fields are required!');
		$('#signin-err').css('visibility','visible');   
	}
});

function loggedin(){
	alert('logged in');
}