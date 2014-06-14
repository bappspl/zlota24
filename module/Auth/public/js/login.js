$(document).ready(function(){
	$("#btn-login").on('click', function () {	
		$('.login-spinner').fadeIn();
		var login_s = $("input[name='login']").val();
		var pass_s = $("input[name='password']").val();
		$("input[name='login']").val('');
		$("input[name='password']").val('');		
		if(login_s && pass_s) {
			$.ajax({
				type: "POST",
				url: "/admin/index/checkloginajax",
				dataType : 'json',
				data : {
					login: login_s,
					password: pass_s,
					rememberme: 0
				},
				success: function(json)
				{
					$('.spin').fadeOut();
					if(json['wynik'] == 'success') {
						window.location.href = '/admin/cmssettings';
					} else {
						$('.login-spinner').fadeOut();
						$('.alert-danger').fadeIn().html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Zły login lub hasło!');
					}	
				},
				error: function(json)
				{
					console.log(json);
				}
			});
		} else {
			$('.login-spinner').fadeOut();
			$('.alert-danger').fadeIn().html('<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Uzupełnij wszystkie pola!');
		}
	});
	
	
	$('.button2-log').click(function(){
		$('#load2').fadeIn();		
		if (!$('#mail').val()) {
			$('#load2').fadeOut();
			$('#error3-log').fadeIn().html('Brak adresu e-mail!');	
		} else {
			mail = $('#mail').val();
			$.ajax({
		      type: "POST",
		      url: "/admin/registration/forgottenpassword",
		      dataType : 'json',
		      data : {
		        mail: mail    
		      },
		      success: function(json)
		      {
		        if(json['wynik'] == "success") {
		        	$('#load2').html('');
		        	$('#error3-log').fadeIn().html('Wysłano e-mail z hasłem');	
		        }
		      },
		      error: function(data){
		        alert("fatal1 error"); 	        
		      }
		    });	
		}
	});
	
});