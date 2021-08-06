<div id="modalAddSupplierContact" class="modal fade" role="dialog">
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
								{!! Form::label('add_contact_name', 'Name') !!}
								{!! Form::text('add_contact_name', null, ['placeholder'=>'Name','class' => 'form-control add_contact','required'=>'required','data-parsley-required-message'=>"Please enter your Company Name",'autofocus']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_contact_email', 'Email') !!} <span id='message_email'></span>
								{!! Form::email('add_contact_email', null, ['placeholder'=>'Email','class' => 'form-control add_contact','required'=>'required','data-parsley-required-message'=>"Please enter your Email"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_contact_tel', 'Telephone #') !!}
								{!! Form::text('add_contact_tel', null, ['placeholder'=>'Telephone #','class' => 'form-control add_contact','required'=>'required','data-parsley-required-message'=>"Please enter your Telephone"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_contact_mobile', 'Mobile #') !!}
								{!! Form::text('add_contact_mobile', null, ['placeholder'=>'Mobile #','class' => 'form-control add_contact','required'=>'required','data-parsley-required-message'=>"Please enter your Mobile Number"]) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_contact_skype', 'Skype') !!}
								{!! Form::text('add_contact_skype', null, ['placeholder'=>'Skype','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_contact_wechat', 'Wechat') !!}
								{!! Form::text('add_contact_wechat', null, ['placeholder'=>'Wechat','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_contact_whatsapp', 'WhatsApp') !!}
								{!! Form::text('add_contact_whatsapp', null, ['placeholder'=>'WhatsApp','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{!! Form::label('add_contact_qq', 'QQ Mail') !!}
								{!! Form::text('add_contact_qq', null, ['placeholder'=>'QQ Mail','class' => 'form-control','required'=>'']) !!}
							</div>
						</div>
						<div class="col-md-6 pull-right">
							<div class="form-group">
								{!! Form::label('report_notify', 'Report Notification') !!}
								<select class="form-control" id="report_notify">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
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

