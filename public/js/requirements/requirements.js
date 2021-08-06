$(document).ready(function(){
	$('#edit_requirements').click(function(){
		$(this).hide();
		$('#save_requirements').show();
		$('#cancel_requirements').show();
		$('.disabled').each(function(){
			$(this).prop('disabled',false);
		});
	});

	$('#cancel_requirements').click(function(){
		$(this).hide();
		$('#save_requirements').hide();
		$('#edit_requirements').show();
		$('.disabled').each(function(){
			$(this).prop('disabled',true);
		});
	});

	$('.disabled').each(function(){
		$(this).prop('disabled',true);
	});
});