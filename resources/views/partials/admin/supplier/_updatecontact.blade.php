<div id="modalSupplierContactPerson" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<form data-parsley-validate="">
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Edit Supplier Contact Person</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="hidden" name="supplier_contact_id" id="supplier_contact_id">
								{!! Form::label('supplier_contact_person', 'Name') !!}
								{!! Form::text('supplier_contact_person', null, ['placeholder'=>'Name','class' => 'form-control edit_suppliercontact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('supplier_contact_number', 'Contact #') !!}
								{!! Form::text('supplier_contact_number', null, ['placeholder'=>'Contact #','class' => 'form-control edit_suppliercontact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('supplier_tel_number', 'Telephone #') !!}
								{!! Form::text('supplier_tel_number', null, ['placeholder'=>'Telephone #','class' => 'form-control edit_suppliercontact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('supplier_contact_email', 'Email') !!}
								{!! Form::email('supplier_contact_email',null, ['placeholder'=>'Email','class' => 'form-control edit_suppliercontact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('supplier_contact_skype', 'Skype') !!}
								{!! Form::text('supplier_contact_skype', null, ['placeholder'=>'Skype','class' => 'form-control edit_suppliercontact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('supplier_contact_wechat', 'Wechat') !!}
								{!! Form::text('supplier_contact_wechat', null, ['placeholder'=>'Wechat','class' => 'form-control edit_suppliercontact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('supplier_contact_whatsapp', 'WhatsApp') !!}
								{!! Form::text('supplier_contact_whatsapp', null, ['placeholder'=>'WhatsApp','class' => 'form-control edit_suppliercontact','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('supplier_contact_qq', 'QQMail') !!}
								{!! Form::text('supplier_contact_qq', null, ['placeholder'=>'QQ Mail','class' => 'form-control edit_suppliercontact','required'=>'']) !!}
							</div>
						</div>
					</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save changes', ['class' => 'btn btn-success','id'=>'update_supplier']) !!}
				</div>
			</form>
		</div>
	</div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {
		$('#close-err-e-supplier').click(function() {
			$('#edit-show-error').hide();
		});

		$('.phone').keypress(function(key) {
			if (key.charCode < 48 || key.charCode > 57) return false;
		});

		$('#update_supplier').click(function() {
			console.log('Edit Contact Person Details');
			$('#edit-show-error').hide();
			var dis = $(this);
			var add = $('.edit_suppliercontact');
			var add_count_null = 0;
			for (var i = 0; i < add.length; i++) {
				var data = $(add[i]).val();
				if (data == "") {
					$(add[i]).css("border", "1px solid red");
					add_count_null += 1;
				} else {
					$(add[i]).removeAttr("style");
				}
			}
			var email = document.getElementById('supplier_contact_email');
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (add_count_null == 0) {
				if (!filter.test(email.value)) {
					$('#add-show-error-edit-email').show();
					$('#supplier_contact_email').css("border", "1px solid red");
				} else {
					$('#show-error').hide();
					$('#add-show-error-edit-email').hide();
					$(this).text("Saving...");
					$('#update_contact').attr('disabled', true);
					savealldata();
				}

			} else {
				$('#edit-show-error').show();
				$('#add-show-error-edit-email').hide();
			}

		});


		function savealldata() {
			$('#edit-show-error').hide();
			$.ajax({
				url: '/updateSupplier',
				type: 'POST',
				data: {
					_token: token,
					'supplier_contact_id': $('#supplier_contact_id').val(),
					'supplier_contact_person': $('#supplier_contact_person').val(),
					'supplier_contact_number': $('#supplier_contact_number').val(),
					'supplier_tel_number': $('#supplier_tel_number').val(),
					'supplier_email': $('#supplier_contact_email').val(),
					'supplier_contact_skype': $('#supplier_contact_skype').val(),
					'supplier_contact_wechat': $('#supplier_contact_wechat').val(),
					'supplier_contact_whatsapp': $('#supplier_contact_whatsapp').val(),
					'supplier_contact_qq': $('#supplier_contact_qq').val(),
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					console.log(response);
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Supplier Contact Person Details successfully updated!",
						type: "success",
					}, function() {
						$('#changeAQL').modal('hide');
						location.reload();
					});
				},
				error: function() {
					swal({
						title: "Error!",
						text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
						type: "error",
					});
				}
			});
		}
	});
</script>
