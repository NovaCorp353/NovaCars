$(document).ready(function() {
      $.ajax({
			type: "POST",
			url: "php/session.php",
			success: function(data){
				if(data == 0)
					window.location.href = 'index.html';
			}
		});
	
	// Get content for overview by default
	var content = $('#content');
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
					alert(data);
					content.html(data);
				} else {
					// TODO also log out / end session
					$('#signin-err-lb').text('Unable to retrieve data at this time! Try again later.');
					$('#signin-err').css('visibility','visible');   
				}
			}
		});
}

