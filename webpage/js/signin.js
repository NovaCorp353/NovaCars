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
					$('#signin-err').css('visibility','hidden'); 
					window.location.href = 'dashboard.html'; 
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