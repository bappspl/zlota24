$(document).ready(function (){
	$('#description').ckeditor({
        toolbar: 'Full'
    });
	var photosQueue = '';
	var idEditGallery = $('#idEditGallery').val();
	$('#saveEditGallery').on('click', function(){
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
				url: "/admin/gallery/saveEditGalleryInfoAjax",
				dataType : 'json',
				data : {
					sId : idEditGallery,
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
						
						$('#file_upload').uploadify({
							'checkExisting' : '/admin/gallery/checkExistPhotoAjax',
							'multi'    : true,
							'fileTypeExts' : '*.jpg; *.png',
							'formData' : {
								'idGallery' : idEditGallery,
								'edit' : 1
							},
							'swf'      : '/uploadify.swf',
							'uploader' : '/admin/gallery/uploadEditPhotoGalleryAjax',
							'onUploadSuccess' : function(file, data, response) {
								$('#step2 img').each(function (){
									if($(this).attr('src').indexOf(file.name) !== -1) {
										var tmpId = $(this).next().attr('id');
										$('.spinner-action').show();
										$.ajax({
											type: "POST",
											url: "/admin/gallery/deletePhotoAjax",
											dataType : 'json',
											data : {
												idPhoto : tmpId
											},
											success: function(json)
											{ $('.spinner-action').fadeOut(); }
										});
										$(this).next().remove();
										$(this).remove();
									}
								});
								$('.addedPhotosAll').append('<img src="/img/gallery/'+ file.name +'" class="addedPhoto addedPhotoBorder editGalleryPhoto" /><i class="glyphicon glyphicon-trash deletePhoto" id="'+data+'" ></i>');
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
	$('#step2 .addedPhotosAll').on('click','.deletePhoto', function (){
		var tmpId = $(this).attr('id');
		$('.spinner-action').show();
		var cache = $(this);
		$.ajax({
			type: "POST",
			url: "/admin/gallery/deletePhotoAjax",
			dataType : 'json',
			data : {
				idPhoto : tmpId
			},
			success: function(json)
			{ 
				$(cache).prev().remove();
				$(cache).remove();
				$('.spinner-action').fadeOut(); 
			}
		});
	});
	$('#saveEditPhotosGallery').on('click', function(){
		$('#step2').hide();
		$('#step3').show();
		$('.stepwizard button').attr('disabled', 'disabled');
		$('.stepwizard button').removeClass('btn-primary');
		$('.stepwizard button').removeClass('btn-default');
		$('.stepwizard .step1, .stepwizard .step2').addClass('btn-default');
		$('.stepwizard .step3').addClass('btn-primary');
		$('.stepwizard .step3').removeAttr('disabled');
		
		var thumbGalleryPath = $('#thumbGallery').val();
		$('#step2 img').each(function (){
			if($(this).attr('src').indexOf(thumbGalleryPath) !== -1) {
				$('#step3 .allPhotos').append('<img src="'+ $(this).attr('src') +'" class="addedPhoto addedPhotoBorderCurrent" />');
			} else {
				$('#step3 .allPhotos').append('<img src="'+ $(this).attr('src') +'" class="addedPhoto addedPhotoBorder" />')
			}
		});
		$('.addedPhoto').on('click', function (){
			$('.allPhotos img').removeClass('addedPhotoBorder');
			$('.allPhotos img').removeClass('addedPhotoBorderCurrent');
			$(this).addClass('addedPhotoBorderCurrent');
		});
	});
	$('#saveEditPhotosSummary').on('click', function(){
		if($('#step3 .allPhotos img').hasClass('addedPhotoBorderCurrent')) {
			$('.spinner-action').show();
			var fileName;
			$('#step3 .allPhotos img').each(function () {
				if($(this).hasClass('addedPhotoBorderCurrent')) { 
					fileName = $(this).attr('src').slice($(this).attr('src').lastIndexOf("/"), $(this).attr('src').length);
				}
			});
			$('#requiredThumb').removeClass('red');
			var idEditGallery = $('#idEditGallery').val();
			$.ajax({
				type: "POST",
				url: "/admin/gallery/saveGalleryThumbAjax",
				dataType : 'json',
				data : {
					idGallery : idEditGallery,
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
});