$(document).ready(function () {
	$('#addTag').on('click', function () {
		$('#newTag').modal();
	});
	$('#saveTag').on('click', function(){
		var addNewTag = $('#addNewTag').val();
		if(!addNewTag) { $('#addNewTag').next().fadeIn(); addNewTagOk = 0; } else { $('#addNewTag').next().fadeOut(); addNewTagOk = 1; }
		if(addNewTagOk == 1) {
			$('.spinner-modal').show();
			$.ajax({
				type: "POST",
				url: "/admin/tags/saveNewTagAjax",
				dataType : 'json',
				data : {
					sAddNewTag : addNewTag
				},
				success: function(json)
				{
					if(json['wynik'] == 'success') {
						$('.spinner-modal').fadeOut();
						var id = json['id'];
						var i = json['i'];
						$('#newTag').modal('hide');
						$('#addNewTag').val('');
						$('.mainTable tbody').append('<tr><td class="lp" width="30">'+ i +'</td><td class="name">'+ addNewTag +'</td><td class="action" style="text-align:right;"><button class="btn btn-warning btn-xs editTag" id="'+ id +'"><i class="glyphicon glyphicon-pencil" ></i> Edycja </button> <button class="btn btn-danger btn-xs deleteTag" id="'+id+'"><i class="glyphicon glyphicon-trash" ></i> Usuwanie </button></td></tr>');
					}
				},
				error: function(data){
					console.log(data); 
				}
			});
		}
	});
	$('.mainTable').on('click', '.deleteTag', function () {
		var tmpId = $(this).attr('id');
		var cache = $(this);
		$('.spinner-action').show();
		$.ajax({
			type: "POST",
			url: "/admin/tags/deleteTagAjax",
			dataType : 'json',
			data : {
				sId : tmpId
			},
			success: function(json)
			{
				if(json['wynik'] == 'success') {
					$('.spinner-action').fadeOut();
					$(cache).parent().parent().remove();
				}
			},
			error: function(data){
				console.log(data); 
			}
		});
	});
	$('.mainTable').on('click', '.editTag', function () {
		$('#editTag').modal();
		var tmpEditId = $(this).attr('id');
		var tmpEditName = $(this).parent().prev().text();
		$('#editTag #editNewTag').val(tmpEditName);
		$('#editTag #idEditTag').val(tmpEditId);
	});
	$('#saveEditTag').on('click', function(){
		var editNewTag = $('#editNewTag').val();
		var idEditTag = $('#idEditTag').val();
		if(!editNewTag) { $('#editNewTag').next().fadeIn(); editNewTagOk = 0; } else { $('#editNewTag').next().fadeOut(); editNewTagOk = 1; }
		if(editNewTagOk == 1) {
			$('.spinner-modal').show();
			$.ajax({
				type: "POST",
				url: "/admin/tags/saveEditTagAjax",
				dataType : 'json',
				data : {
					sId : idEditTag,
					sEditNewTag : editNewTag
				},
				success: function(json)
				{
					if(json['wynik'] == 'success') {
						$('.spinner-modal').fadeOut();
						$('#editTag').modal('hide');
						$('#editNewTag').val('');
						$('.mainTable tbody tr td').find('#'+idEditTag).parent().prev().text(editNewTag);
					}
				},
				error: function(data){
					console.log(data); 
				}
			});
		}
	});
})