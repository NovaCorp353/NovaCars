$("#register-form").submit(function(event){
	event.preventDefault();
	var f = $('#inputFirstName').val();
	var l = $('#inputLastName').val();
	var e = $('#inputEmail').val();
	var p = $('#inputPassword').val();
	if(e != null && e != "" && p != null && p != ""){
		$.ajax({
			type: "POST",
			url: "php/register.php",
			data: {firstname: f, lastname: l, email:e, password:p},
			cache: false,
			beforeSend: function(){ $("#register-btn").val('Connecting...');},
			success: function(data){
				if(data == 1) {					
					$('#register-err').css('visibility','hidden');   
					window.location.href = 'index.html';
				} else {
					$('#register-err-lb').text('This email is already registered!');
					$('#register-err').css('visibility','visible');   
				}
			}
		});
	} else {
		$('#register-err-lb').text('All fields are required!');
		$('#register-err').css('visibility','visible');   
	}
});