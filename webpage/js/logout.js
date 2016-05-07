$('#logout-btn').click(function(event){
	$.ajax({
			type: "POST",
			url: "php/logout.php",
			cache: false,
			beforeSend: function(){ $("#logout-btn").val('Logging out...');},
			success: function(data){
				window.location.href = 'index.html';
			}
		});
});