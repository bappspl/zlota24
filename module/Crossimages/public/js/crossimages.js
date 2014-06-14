$(document).ready(function () {
	$('#saveEditCrossimages').on('click', function(){
		var id = $('#idCrossimages').val();
		var first_row = $('#first_row').val();
		var second_row = $('#second_row').val();
		var photo = $('.offer-edit-image').attr('src');
		if(!first_row) { $('#first_row').next().fadeIn(); first_rowOk = 0; } else { $('#first_row').next().fadeOut(); first_rowOk = 1; }
		if(!second_row) { $('#second_row').next().fadeIn(); second_rowOk = 0; } else { $('#second_row').next().fadeOut(); second_rowOk = 1; }
		if(first_rowOk == 1 && second_rowOk == 1) {
			$('.spinner-action').show();
			$.ajax({
				type: "POST",
				url: "/admin/crossimages/saveEditCrossimagesAjax",
				dataType : 'json',
				data : {
					sId : id,
					sFirst_row : first_row,
					sSecond_row : second_row,
					sPhoto : photo
				},
				success: function(json)
				{
					if(json['wynik'] == 'success') {
						$('.spinner-action').fadeOut();
						window.location.href = "/admin/crossimages"
					}
				},
				error: function(data){
					alert("fatal error"); 
				}
			});
		}
	});
})