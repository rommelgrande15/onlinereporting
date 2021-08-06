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
			success	: function(response){
				$('#update_id').val(response.account.id);
				$('#update_username').val(response.user.username);
				$('#update_email').val(response.user.email);
				$('#update_contact_number').val(response.account.contact_number);
				$('#update_inspector_name').val(response.account.name);
				$('#update_designation').val(response.account.designation)
				$('#updateAccountModal').modal();
				
			}
				
		});
	})

	.on('click', '.btn-delete', function(){
		$.ajax({
			url		: '/getoneaccount/'+ $(this).data('id'),
			type 	: 'GET',
			success	: function(response){
				$('#del_account_id').val(response.account.id);
				$('#deleteAccountModal').modal();
				console.log(response)
			}
				
		});
	})
});