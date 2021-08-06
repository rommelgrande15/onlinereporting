$(document).ready(function(){
	var country = $('#country_select');
	$('.number').on('input', function (event) { 
		if (country.val() != 44) {
			this.value = this.value.replace(/[^0-9]/g, '');
		}
	});

	country.change(function(){
		$('#area_code').val($(this).val());
	});

	$('.disabled').each(function(){
		$(this).prop('disabled',true);
	});

	$('#update_btn').click(function(){
		$(this).hide();
		$('.disabled').each(function(){
			$(this).prop('disabled',false);
		});
		$('#cancel_btn, #save_btn').show();
	});

	$('#cancel_btn').click(function(){
		$('#cancel_btn, #save_btn').hide();
		$('.disabled').each(function(){
			$(this).prop('disabled',true);
		});
		$('#update_btn').show();
	});

	$('body').on('click','.settings_btn', function(){
		window.location.href="/settings";
	})
});