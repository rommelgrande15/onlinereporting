<div class="row step4">
	<h3>Other Information</h3>
<hr>
<section>
<div class="row">
	<div class="col-md-8">
		<div class="form-group">
			{{ Form::label('reference_sample', 'Reference Sample') }}<span id="error-reference_sample"></span>
			{{ Form::select('reference_sample', [
				'No Sample'=>'No Sample',
				'Sample was already in Factory'=>'Sample was already in Factory',
				'Sample was/will be sent in Factory'=>'Sample was/will be sent in Factory',
				'Sample already sent in Factory'=>'Sample already sent in Factory',
				'Sample will be sent to InspectOne'=>'Sample will be sent to InspectOne',
			], null, ['class' => 'form-control','id'=>'reference_sample']) }}
		</div>
		<div class="with-sample">
			<div class="form-group">
				{{ Form::label('courier', 'Courier') }}<span id="error-courier"></span>
				{{ Form::select('courier', [
					'Chronopost'=>'Chronopost',
					'DHL'=>'DHL',
					'FedEx'=>'FedEx',
					'HKDC'=>'HKDC',
					'SF Express'=>'SF Express',
					'Others'=>'Please indicate in the comment box',
				], null, ['class' => 'form-control','id'=>'courier','placeholder'=>'Select Courier']) }}
			</div>
			<div class="form-group">
				{{ Form::label('tracking_number', 'Tracking Number') }}<span id="error-tracking_number"></span>
				{{ Form::text('tracking_number', null, ['class' => 'form-control','id'=>'tracking_number']) }}
			</div>
			<div class="form-group">
				{{ Form::label('change_inspection_schedule', 'Should we change the inspection schedule if samples do not arrive on time?') }}<span id="error-change_inspection_schedule"></span>
				{{ Form::select('change_inspection_schedule', [
					'1'=>'Yes',
					'0'=>'No',
				], null, ['class' => 'form-control','id'=>'change_inspection_schedule', 'placeholder'=>'Select']) }}
			</div>
			<div class="form-group">
				{{ Form::label('more_info', 'Additional Information') }}<span id="error-tracking_number"></span>
				{{ Form::textarea('more_info', null, ['class' => 'form-control', 'rows'=>'5', 'placeholder'=>'You can add additional remarks about your sample here. Also indicate here your courier if it is not in the list above','id'=>'more_info']) }}
			</div>
		</div>
		
	</div>
	
</div>

</section>
<div class="row">
	<div class="col-md-12">
	    <div class="col-md-6">
	        <button class="btn btn-primary" id="third-back" type="button">Previous</button>
	    </div>
	    <div class="col-md-6 text-right">
	        <button class="btn btn-warning" id="fourth-next" type="button">Next</button>
	    </div>
	</div>
</div>

</div>