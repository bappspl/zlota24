$(document).ready(function() {
	$('#savePassword').on('click', function () {
		var oldPassword = $('#oldPassword').val();
		var newPassword = $('#newPassword').val();
		var newPasswordRepeat = $('#newPasswordRepeat').val();
		if(newPassword == newPasswordRepeat && newPassword.length != 0) {
			$('.spinner-action').show();
			$('#newPasswordRepeat').css('border', '1px solid #ccc');
			$.ajax({
		      type: "POST",
		      url: "/admin/cmssettings/checkpasswordajax",
		      dataType : 'json',
		      data : {		        
		        password: oldPassword		           
		      },
		      success: function(json)
		      {
		        if(json['wynik'] == "succes") {
		        	$.ajax({
				      type: "POST",
				      url: "/admin/cmssettings/saveUserAjax",
				      dataType : 'json',
				      data : {				        
				        password: newPasswordRepeat    
				      },
				      success: function(json)
				      {
				        if(json['wynik'] == "succes") {			        	        	
				        	$('.spinner-action').fadeOut();
							$('#oldPassword').val('');
							$('#newPassword').val('');
							$('#newPasswordRepeat').val('');
				        } 
				      },
				      error: function(data){
				      		console.log(data.responseText);
				        //alert("fatal registration error"); 		        
				      }
				    });	 
		        } else {
					$('.spinner-action').fadeOut();
		        	$('#oldPassword').css('border', '1px solid red');
		        }
		      },
		      error: function (data) {
		      	console.log(data.responseText);
		      }
		    });	
		} else {
			$('#newPasswordRepeat').css('border', '1px solid red');
		}
	});
});