$(document).ready(function () {
	$('#saveEditVideo').on('click', function(){
		var id = 1;
		var link = $('#link').val();
		if(!link) { $('#link').next().fadeIn(); linkOk = 0; } else { $('#link').next().fadeOut(); linkOk = 1; }
		if(linkOk == 1) {
			$('.spinner-action').show();
			$.ajax({
				type: "POST",
				url: "/admin/video/saveEditVideoAjax",
				dataType : 'json',
				data : {
					sId : id,
					sLink : link
				},
				success: function(json)
				{
					if(json['wynik'] == 'success') {
						$('.spinner-action').fadeOut();
						window.location.href = "/admin/video"
					}
				},
				error: function(data){
					alert("fatal error"); 
				}
			});
		}
	});
})