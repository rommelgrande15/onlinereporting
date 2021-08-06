<div class="row step1">
    
<h3>Inspection Information</h3>
<hr>
<section>
    
    <div class="col-md-8">
        <div class="form-group">
           {{ Form::label('service_type', 'Inspection Service') }}<span id="error-service_type"></span>
           {{ Form::select('service_type', [
                'psi' => 'Pre Shipment Inspection (PSI)'
           ], null, ['class' => 'form-control required', 'data-msg-required'=>"Please select a service type",'id'=>'service_type']) }}
        </div>
{{--         <button type="button" id="test">Test Overlay</button> --}}
        <div class="form-group">
            {{ Form::label('reference_number', 'Project Reference Number') }}
            {{ Form::text('reference_number', null, ['class' => 'form-control ']) }}
        </div>

        <div class="form-group">
            {{ Form::label('inspection_date', 'Desired Inspection Date') }} <span id="error-inspection_date"></span>
            {{ Form::text('inspection_date', null, ['class' => 'form-control required','id'=>'inspection_date','data-msg-required'=>"Please select a date"]) }}
        </div>
        <div class="form-group">
           {{ Form::label('change_date', 'Allow factory to change Inspection date?') }}
           {{ Form::select('change_date', [
                '0' => 'No',
                '1' => 'Yes'
           ], null, ['class' => 'form-control required', 'id'=>'change_date']) }}
        </div>      

        <div class="form-group">
            {{ Form::label('shipment_date', 'Expected Shipment Date') }} <span id="error-shipment_date"></span>
            {{ Form::text('shipment_date', null, ['class' => 'form-control required', 'id'=>'shipment_date','data-msg-required'=>"Please select a date"]) }}
        </div>
    </div>
    <div class="col-md-4" id="alert-me">
        <div class="alert alert-info alert-dismissable fade in " >
            <a href="#" class="close" id="close-me">&times;</a>
            <strong><i class="fa fa-info-circle"></i> Note:</strong>
            <span>You are requesting a Service within 24 hours and our minimun time availability is 48 hours, but we'll do our best to perform this service. However, we may charge you additional fees for immediate inspection.</span> 
        </div>
        
        
    </div>
</section>
<div class="col-md-12">
    <div class="col-md-6 col-md-offset-6 text-right">
        <button class="btn btn-warning" id="first-next" type="button">Next</button>
    </div>
</div>

</div>
