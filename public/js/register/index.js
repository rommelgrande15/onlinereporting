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
	
})