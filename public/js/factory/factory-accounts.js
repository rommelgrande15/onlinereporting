$(document).ready(function(){
	$('#accounts_table').DataTable({
        "order": [
            [5, "desc"]
        ],
    });

	$('body')
	.on('click', '.btn-edit', function(){
		$.ajax({
			url		: '/getoneaccount/'+ $(this).data('id'),
			type 	: 'GET',
			beforeSend:function(){
				$('.send-loading ').show();	
			},
			success	: function(response){
				$('.send-loading ').hide();	
				$('#update_id').val(response.account.id);
				$('#update_username').val(response.user.username);
				$('#update_email').val(response.user.email);
				$('#update_contact_number').val(response.account.contact_number);
				$('#update_inspector_name').val(response.account.name);
				$('#update_designation').val(response.account.designation)
				$('#updateAccountModal').modal();			
			},
			error:function(error){
				console.log(error);
				$('.send-loading ').hide();
				swal({
					title: "Error!",
					text: "Someting went wrong. Please try again later",
					type: "error",
				});
			}
				
		});
	})

	.on('click', '.btn-delete', function(){
		$.ajax({
			url		: '/getoneaccount/'+ $(this).data('id'),
			type 	: 'GET',
			beforeSend:function(){
				$('.send-loading ').show();	
			},
			success	: function(response){
				$('.send-loading ').hide();
				$('#del_account_id').val(response.account.id);
				$('#deleteAccountModal').modal();
				
			},
			error:function(error){
				console.log(error);
				$('.send-loading ').hide();
				swal({
					title: "Error!",
					text: "Someting went wrong. Please try again later",
					type: "error",
				});
			}
				
		});
	})

	.on('click', '.btn-privelege', function(){
		var user_id=$(this).data('id');
		$.ajax({
			url		: '/client-getprivelge/'+ user_id,
			type 	: 'GET',
			beforeSend:function(){
				$('.send-loading ').show();	
			},
			success	: function(response){
				console.log(response);
				$('#user_id_priv').val(user_id);
				if (!$.trim(response.privelege)){
					console.log('empty');
					$('#priv_create_order').prop('checked', false);
					$('#priv_edit_order').prop('checked', false);
					$('#priv_copy_order').prop('checked', false);
					$('#priv_cancel_order').prop('checked', false);
					$('#priv_del_order').prop('checked', false);
					$('#priv_create_suppl').prop('checked', false);
					$('#priv_update_suppl').prop('checked', false);
					$('#priv_del_suppl').prop('checked', false);
					$('#priv_create_fact').prop('checked', false);
					$('#priv_update_fact').prop('checked', false);
					$('#priv_del_fact').prop('checked', false);
					$('#priv_create_prod').prop('checked', false);
					$('#priv_update_prod').prop('checked', false);
					$('#priv_del_prod').prop('checked', false);

					$('#priv_create_order').val('no');
					$('#priv_edit_order').val('no');
					$('#priv_copy_order').val('no');
					$('#priv_cancel_order').val('no');
					$('#priv_del_order').val('no');
					$('#priv_create_suppl').val('no');
					$('#priv_update_suppl').val('no');
					$('#priv_del_suppl').val('no');
					$('#priv_create_fact').val('no');
					$('#priv_update_fact').val('no');
					$('#priv_del_fact').val('no');
					$('#priv_create_prod').val('no');
					$('#priv_update_prod').val('no');
					$('#priv_del_prod').val('no');
					
				}else{
					$('#priv_create_order').val(response.privelege.create_order);
					$('#priv_edit_order').val(response.privelege.edit_order);
					$('#priv_copy_order').val(response.privelege.copy_order);
					$('#priv_cancel_order').val(response.privelege.cancel_order);
					$('#priv_del_order').val(response.privelege.delete_order);
					//create
					if(response.privelege.create_order=="yes"){
						$('#priv_create_order').prop('checked', true);
						$('#priv_create_order').val('yes');
					}else{
						$('#priv_create_order').prop('checked', false);
						$('#priv_create_order').val('no');
					}
					//edit
					if(response.privelege.edit_order=='yes'){
						$('#priv_edit_order').prop('checked', true);
						$('#priv_edit_order').val('yes');
					}else{
						$('#priv_edit_order').prop('checked', false);
						$('#priv_edit_order').val('no');
					}
					//copy
					if(response.privelege.copy_order=='yes'){
						$('#priv_copy_order').prop('checked', true);
						$('#priv_copy_order').val('yes');
					}else{
						$('#priv_copy_order').prop('checked', false);
						$('#priv_copy_order').val('no');
					}
					//cancel
					if(response.privelege.cancel_order=='yes'){
						$('#priv_cancel_order').prop('checked', true);
						$('#priv_cancel_order').val('yes');
					}else{
						$('#priv_cancel_order').prop('checked', false);
						$('#priv_cancel_order').val('no');
					}
					//delete
					if(response.privelege.delete_order=='yes'){
						$('#priv_del_order').prop('checked', true);
						$('#priv_del_order').val('yes');
					}else{
						$('#priv_del_order').prop('checked', false);
						$('#priv_del_order').val('no');
					}

					$('#priv_create_suppl').val(response.privelege.create_supplier);
					$('#priv_update_suppl').val(response.privelege.update_supplier);
					$('#priv_del_suppl').val(response.privelege.delete_supplier);
					$('#priv_create_fact').val(response.privelege.create_factory);
					$('#priv_update_fact').val(response.privelege.update_factory);
					$('#priv_del_fact').val(response.privelege.delete_factory);
					//create supplier
					if(response.privelege.create_supplier=='yes'){
						$('#priv_create_suppl').prop('checked', true);
						$('#priv_create_suppl').val('yes');
					}else{
						$('#priv_create_suppl').prop('checked', false);
						$('#priv_create_suppl').val('no');
					}
					//edit supplier
					if(response.privelege.update_supplier=='yes'){
						$('#priv_update_suppl').prop('checked', true);
						$('#priv_update_suppl').val('yes');
					}else{
						$('#priv_update_suppl').prop('checked', false);
						$('#priv_update_suppl').val('no');
					}
					//delete supplier
					if(response.privelege.delete_supplier=='yes'){
						$('#priv_del_suppl').prop('checked', true);
						$('#priv_del_suppl').val('yes');
					}else{
						$('#priv_del_suppl').prop('checked', false);
						$('#priv_del_suppl').val('no');
					}
					//create factory
					if(response.privelege.create_factory=='yes'){
						$('#priv_create_fact').prop('checked', true);
						$('#priv_create_fact').val('yes');
					}else{
						$('#priv_create_fact').prop('checked', false);
						$('#priv_create_fact').val('no');
					}
					//update factory
					if(response.privelege.update_factory=='yes'){
						$('#priv_update_fact').prop('checked', true);
						$('#priv_update_fact').val('yes');
					}else{
						$('#priv_update_fact').prop('checked', false);
						$('#priv_update_fact').val('no');
					}
					//delete factory
					if(response.privelege.delete_factory=='yes'){
						$('#priv_del_fact').prop('checked', true);
						$('#priv_del_fact').val('yes');
					}else{
						$('#priv_del_fact').prop('checked', false);
						$('#priv_del_fact').val('no');
					}

					$('#priv_create_prod').val(response.privelege.create_product);
					$('#priv_update_prod').val(response.privelege.update_product);
					$('#priv_del_prod').val(response.privelege.delete_product);
					//create product
					if(response.privelege.create_product=='yes'){
						$('#priv_create_prod').prop('checked', true);
						$('#priv_create_prod').val('yes');
					}else{
						$('#priv_create_prod').prop('checked', false);
						$('#priv_create_prod').val('no');
					}
					//edit product
					if(response.privelege.update_product=='yes'){
						$('#priv_update_prod').prop('checked', true);
						$('#priv_update_prod').val('yes');
					}else{
						$('#priv_update_prod').prop('checked', false);
						$('#priv_update_prod').val('no');
					}
					//delete product
					if(response.privelege.delete_product=='yes'){
						$('#priv_del_prod').prop('checked', true);
						$('#priv_del_prod').val('yes');
					}else{
						$('#priv_del_prod').prop('checked', false);
						$('#priv_del_prod').val('no');
					}
				}

				$('.send-loading ').hide();	
				$('#privelegeModal').modal();
				
			},
			error:function(error){
				console.log(error);
				$('.send-loading ').hide();
				swal({
					title: "Error!",
					text: "Someting went wrong. Please try again later",
					type: "error",
				});
			}
				
		});
	})

});