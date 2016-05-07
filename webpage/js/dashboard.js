$(document).ready(function() {
      $.ajax({
			type: "POST",
			url: "php/session.php",
			success: function(data){
				if(data == 0)
					window.location.href = 'index.html';
				else
					alert(data);
			}
		});
});