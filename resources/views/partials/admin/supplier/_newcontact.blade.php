<div id="modalAddContact" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<!-- Modal content-->
		<div class="modal-content">
			<form data-parsley-validate="">
				{!!csrf_field()!!}
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Add Supplier Contact Person</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input type="hidden" name="client_code" id="client_code" value="{{$supplierInfo->client_code}}">
								<input type="hidden" name="supplier_id" id="supplier_id" value="{{$supplierInfo->id}}">
								{!! Form::label('add_suppliercontact_name', 'Name') !!}
								{!! Form::text('add_suppliercontact_name', null, ['placeholder'=>'Name','class' => 'form-control add_contact','required'=>'required','data-parsley-required-message'=>"Please enter your Name",'autofocus']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_suppliercontact_number', 'Contact #') !!}
								{!! Form::email('add_suppliercontact_number', null, ['placeholder'=>'Contact #','class' => 'form-control add_contact','required'=>'required','data-parsley-required-message'=>"Please enter your contact number"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_suppliercontact_tel', 'Telephone #') !!}
								{!! Form::email('add_suppliercontact_tel', null, ['placeholder'=>'Telephone #','class' => 'form-control add_contact','required'=>'required','data-parsley-required-message'=>"Please enter your contact number"]) !!}
							</div>
						</div>
						 <div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_suppliercontact_email', 'Email') !!} <span id='message_email'></span>
								{!! Form::email('add_suppliercontact_email', null, ['placeholder'=>'Email','class' => 'form-control add_contact','required'=>'required','data-parsley-required-message'=>"Please enter your Email"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_suppliercontact_skype', 'Skype') !!}
								{!! Form::email('add_suppliercontact_skype', null, ['placeholder'=>'Skype','class' => 'form-control ','required'=>'required','data-parsley-required-message'=>"Please enter your contact number"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_suppliercontact_wechat', 'Wechat') !!}
								{!! Form::email('add_suppliercontact_wechat', null, ['placeholder'=>'Wechat','class' => 'form-control ','required'=>'required','data-parsley-required-message'=>"Please enter your contact number"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_suppliercontact_whatsapp', 'Whatsapp') !!}
								{!! Form::email('add_suppliercontact_whatsapp', null, ['placeholder'=>'Whatsapp','class' => 'form-control ','required'=>'required','data-parsley-required-message'=>"Please enter your contact number"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_suppliercontact_qq', 'Contact QQ') !!}
								{!! Form::email('add_suppliercontact_qq', null, ['placeholder'=>'ContactQQ','class' => 'form-control ','required'=>'required','data-parsley-required-message'=>"Please enter your contact number"]) !!}
							</div>
						</div>
						<div class="col-md-12" id="add-show-error" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-contact">&times;</a>
								<strong>Error</strong> Please fill up the required fields.
							</div>
						</div>
						<div class="col-md-12" id="add-show-error-email" style="display:none;">
							<div class="alert alert-danger alert-dismissable" role="alert">
								<a href="#" class="close" id="close-err-a-email">&times;</a>
								<strong>Error</strong> Please provide a valid email address.
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					{!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
					{!! Form::button('<i class="fa fa-floppy-o"></i> Save Contact', ['class' => 'btn btn-success','id'=>'save_contact']) !!}
				</div>
			</form>
		</div>
	</div>
</div>

<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	jQuery(document).ready(function() {
		$('#close-err-e-contact').click(function() {
			$('#add-show-error').hide();
		});
		$('#close-err-e-email').click(function() {
			$('#add-show-error-email').hide();
		});

		$('#save_contact').click(function() {
			$('#add-show-error').hide();
			var dis = $(this);
			var add = $('.add_contact');
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
			var email = document.getElementById('add_suppliercontact_email');
			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (add_count_null == 0) {
				if (!filter.test(email.value)) {
					$('#add-show-error-email').show();
					$('#add_suppliercontact_email').css("border", "1px solid red");
				} else {
					$('#add-show-error').hide();
					$('#add-show-error-email').hide();
					$(this).text("Saving...");
					$('#save_contact').attr('disabled', true);
					//console.log(count);
					//console.log(subcount);
					savealldata();
				}
			} else {
				$('#add-show-error').show();
				$('#add-show-error-email').hide();
			}

		});

		function savealldata() {
			$('#add-show-error').hide();
			$('#add-show-error').hide();
			$.ajax({
				url: '/client-add-suppliercontact',
				type: 'POST',
				data: {
					_token: token,
					'supplier_id': $('#supplier_id').val(),
					'client_code': $('#client_code').val(),
					'supplier_person': $('#add_suppliercontact_name').val(),
					'supplier_person_email': $('#add_suppliercontact_email').val(),
					'supplier_person_tel_number': $('#add_suppliercontact_tel').val(),
					'supplier_person_number': $('#add_suppliercontact_number').val(),
					'supplier_skype': $('#add_suppliercontact_skype').val(),
					'supplier_wechat': $('#add_suppliercontact_wechat').val(),
					'supplier_whatsapp': $('#add_suppliercontact_whatsapp').val(),
					'supplier_qqmail': $('#add_suppliercontact_qq').val(),
				},
				beforeSend: function() {
					$('.send-loading ').show();
				},
				success: function(response) {
					console.log(response);
					$('.send-loading ').hide();
					swal({
						title: "Success!",
						text: "Supplier Contact Person Details successfully Added!",
						type: "success",
					}, function() {
						$('#modalAddContact').modal('hide');
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
