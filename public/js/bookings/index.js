
$(document).ready(function(){
	$('a').tooltip();
	$('#bookingsTable').dataTable({
		"language": {
	      "emptyTable": "You have no bookings yet!"
	    }
	});

	$('body').on('click','.btn-cancel',function(){
		var id = $(this).data('id')
		$('#bookingIdNumber').val(id);
	})

	$('#cancelBookingYes').click(function(){
		$.ajax({
			url: cancel,
			type:'POST',
			data:{
				_token: session,
				id: $('#bookingIdNumber').val()
			},
			success: function(response){
				console.log(response);
			}
		})
	});
});