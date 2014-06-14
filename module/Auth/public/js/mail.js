$(document).ready(function(){
	$(".sent-mail").on('click', function () {
		$('.mail-loader').fadeIn();
		var name = $("input[name='name']").val();
		var mail = $("input[name='email']").val();
		var phone = $("input[name='phone']").val();
		var text = $("#message").val();
		var defaultReal =  $("#defaultReal").val();
		var defaultRealHash =  $("input[name='defaultRealHash']").val();
		$.ajax({
			type: "POST",
			url: "/admin/index/sendMail",
			dataType : 'json',
			data : {
				name: name,
				mail: mail,
				phone: phone,
				text: text,
				defaultReal:defaultReal,
				defaultRealHash:defaultRealHash
			},
			success: function(json)
			{
				$('.mail-loader').fadeOut();

				if(json['wynik'] == 'error') {
					$("#defaultReal").css('border', '1px solid red');
				} else {
					$("#defaultReal").css('border', '1px solid #999999');
					$("input[name='name']").val('');
					$("input[name='email']").val('');
					$("input[name='phone']").val('');
					$("#defaultReal").val('');
				}	
			},
			error: function(json)
			{
				console.log(json);
			}
		});
	});
});