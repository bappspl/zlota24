$(document).ready(function (){
	$('#description').ckeditor({
        toolbar: 'Full'
    });
	var photosQueue = '';
	$('#saveGallery').on('click', function(){
		var checkedVals = $('.check:checkbox:checked').map(function() {
		    return this.value;
		}).get();
		var allIcons = checkedVals.join(",");
		var name = $('#name').val();
		var price = $('#price').val();
		var description = $('#description').val();
		if(!name) { $('#name').next().fadeIn(); nameOk = 0; } else { $('#name').next().fadeOut(); nameOk = 1; }
		if(!price) { $('#price').next().fadeIn(); priceOk = 0; } else { $('#price').next().fadeOut(); priceOk = 1; }
		if(!description) { $('#description').next().fadeIn(); descriptionOk = 0; } else { $('#description').next().fadeOut(); descriptionOk = 1; }
		if(nameOk == 1 && priceOk == 1 && descriptionOk == 1) {
			$('.spinner-action').show();
			$.ajax({
				type: "POST",
				url: "/admin/gallery/saveGalleryInfoAjax",
				dataType : 'json',
				data : {
					sName : name,
					sPrice : price,
					sDescription : description,
					sIcons: allIcons
				},
				success: function(json)
				{
					if(json['wynik'] == 'success') {
						$('.spinner-action').fadeOut();
						$('#step1').hide();
						$('#step2').show();
						$('#idGallery').val(json['idGallery']);
						var idGallery = $('#idGallery').val();
						
						$('#file_upload').uploadify({
							'checkExisting' : '/admin/gallery/checkExistPhotoAjax',
							'multi'    : true,
							'fileTypeExts' : '*.jpg; *.png',
							'formData' : {
								'idGallery' : idGallery
							},
							'swf'      : '/uploadify.swf',
							'uploader' : '/admin/gallery/uploadPhotoGalleryAjax',
							'onUploadSuccess' : function(file, data, response) {
								photosQueue = photosQueue + ',' + file.name;
							},
							'onQueueComplete' : function(queueData) {
					            $('#savePhotosGallery').removeAttr('disabled');
					        }
						});

						$('.stepwizard button').attr('disabled', 'disabled');
						$('.stepwizard button').removeClass('btn-primary');
						$('.stepwizard button').removeClass('btn-default');
						$('.stepwizard .step1, .stepwizard .step3').addClass('btn-default');
						$('.stepwizard .step2').addClass('btn-primary');
						$('.stepwizard .step2').removeAttr('disabled');

						//uzupełnienie step3
						$('#endName').val(name);
						$('#endPrice').val(price);
						$('#endDescription').val(description);
						$('#step3 input[type=checkbox]').each(function () {
							if(allIcons.indexOf($(this).val()) !== -1) { 
								$(this).attr('checked', 'checked');
							}
						});
					}
				},
				error: function(data){
					alert("fatal error"); 
				}
			});
		}
	});
	$('#savePhotosGallery').on('click', function(){
		$('#step2').hide();
		$('#step3').show();
		$('.stepwizard button').attr('disabled', 'disabled');
		$('.stepwizard button').removeClass('btn-primary');
		$('.stepwizard button').removeClass('btn-default');
		$('.stepwizard .step1, .stepwizard .step2').addClass('btn-default');
		$('.stepwizard .step3').addClass('btn-primary');
		$('.stepwizard .step3').removeAttr('disabled');
		
		var slicePhotos = photosQueue.slice(1);
		var tabPhotos = slicePhotos.split(',');
		for(i=0; i<tabPhotos.length; i++) {
			$('#step3 .allPhotos').append('<img src="/img/gallery/'+tabPhotos[i]+'" class="addedPhoto addedPhotoBorder" />')
		}
		$('.addedPhoto').on('click', function (){
			$('.allPhotos img').removeClass('addedPhotoBorder');
			$('.allPhotos img').removeClass('addedPhotoBorderCurrent');
			$(this).addClass('addedPhotoBorderCurrent');
		});
	});
	$('#savePhotosSummary').on('click', function(){
		if($('#step3 .allPhotos img').hasClass('addedPhotoBorderCurrent')) {
			$('.spinner-action').show();
			var fileName;
			$('#step3 .allPhotos img').each(function () {
				if($(this).hasClass('addedPhotoBorderCurrent')) { 
					fileName = $(this).attr('src').slice($(this).attr('src').lastIndexOf("/"), $(this).attr('src').length);
				}
			});
			$('#requiredThumb').removeClass('red');
			var idGallery = $('#idGallery').val();
			$.ajax({
				type: "POST",
				url: "/admin/gallery/saveGalleryThumbAjax",
				dataType : 'json',
				data : {
					idGallery : idGallery,
					sImage : fileName
				},
				success: function(json)
				{
					$('.spinner-action').fadeOut();
					window.location.href = "/admin/gallery";
				}
			});
		} else {
			$('#requiredThumb').addClass('red');
		}
	});

	// usuwanie galerii
	$('.deleteGallery').on('click', function(){
		$('.spinner-action').show();
		var tmpId = $(this).attr('id');
		var cache = $(this);
		$.ajax({
			type: "POST",
			url: "/admin/gallery/deleteGalleryAjax",
			dataType : 'json',
			data : {
				idGallery : tmpId
			},
			success: function(json)
			{
				$('.spinner-action').fadeOut();
				$(cache).parent().parent().fadeOut();
			}
		});
	});
});