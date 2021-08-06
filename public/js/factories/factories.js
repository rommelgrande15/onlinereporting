$(document).ready(function(){
	$('#factories_table').dataTable();
	$('#save_factory').click(function(){
	    var empty = $(".required-field").filter(function() {
	        return this.value == "";
	    });
	    if(empty.length) {
	        $(".required-field").each(function(){
	          if ($(this).val() === '') {
	             $(this).css({
	              'background':'#ffcccc'
	              });
	          }
	        });
	        
	    }else{
	      if (isValidEmailAddress($('#new_email_address').val())) {
	        $.ajax({
	          url : newfactory,
	          type : 'POST',
	          data: {
	            _token: token,
	            new_factory_name: $('#new_factory_name').val(),
	            new_factory_address: $('#new_factory_address').val(),
	            new_country: $('#new_country').val(),
	            new_city: $('#new_city').val(),
	            new_contact_person: $('#new_contact_person').val(),
	            new_contact_number: $('#new_contact_number').val(),
	            new_email_address: $('#new_email_address').val(),
	          },
	          success : function(){
	            location.reload();
	          }
	        });

	      }else{
	        $('#email-error').html('Invalid email address!');
	      }
	      
	    }
	});

	$('body').on('click','.btn_factory_details',function(){
		var factory_id = $(this).data('id');
		$('#edit_factory_id').val(factory_id);
		$.ajax({
			url : getfactory,
			type: 'POST',
			data:{
				_token : token,
				id : factory_id
			},
			success: function(response){
				console.log(response);
				$('#edit_factory_name').val(response.factory.factory_name);
				$('#edit_factory_address').val(response.factory.factory_address);
				$('#edit_country').val(response.factory.factory_country);
				$('#edit_city').val(response.factory.factory_city);
				$('#edit_contact_person').val(response.factory.factory_contact_person);
				$('#edit_contact_number').val(response.factory.factory_contact_number);
				$('#edit_email_address').val(response.factory.factory_email);
				$('#updateFactoryModal').modal();
			}
		})
	});

	$('.edit-required-field').each(function(){
		$(this).prop('disabled',true);
	});

	$('#edit_factory').click(function(){
		$(this).hide();
		$('#update_factory').show()
		$('.edit-required-field').each(function(){
			$(this).prop('disabled',false);
		});
	});

	$('#close_factory').click(function(){
		$('#edit_factory').show();
		$('#update_factory').hide()
		$('.edit-required-field').each(function(){
			$(this).prop('disabled',true);
		});
	});	

	$('#update_factory').click(function(){
		if (isValidEmailAddress($('#edit_email_address').val())) {
			$.ajax({
	      		url : updatefactory,
	      		type : 'POST',
	      		data : {
	      			_token : token,
	      			edit_factory_id : $('#edit_factory_id').val(),
	      			edit_factory_name : $('#edit_factory_name').val(),
					edit_factory_address: $('#edit_factory_address').val(),
					edit_country: $('#edit_country').val(),
					edit_city: $('#edit_city').val(),
					edit_contact_person: $('#edit_contact_person').val(),
					edit_contact_number: $('#edit_contact_number').val(),
					edit_email_address: $('#edit_email_address').val(),
	      		},
	      		success : function(){
	      			location.reload();
	      		}
	      	});
		}else{
			 $('#edit-email-error').html('Invalid email address!');
		}

	});

	 $('body').on('click','.btn_factory_delete',function(){
	    var id = $(this).data('id');
	    $('#delete_factory_id').val(id);
	    $('#deleteFactoryModal').modal();
	 });

	$('#delete_factory_details').click(function(){
    	$.ajax({
              url : deletefactory,
              type : 'POST',
              data : {
                _token : token,
                factory_id : $('#delete_factory_id').val(),
               
              },
              success : function(){
                location.reload();
              }
        });
  });

});