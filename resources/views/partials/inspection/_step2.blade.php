<div class="row step2">
    <h3>Factory Information</h3>
<hr>
<section> 
    <div class="col-md-6">
        <div class="form-group">
           {{ Form::label('factory_name', 'Factory Name') }}<span id="error-factory_name"></span>
           <div class="input-group">
               {{ Form::select('factory_name', $factories, null, ['class' => 'form-control required', 'placeholder'=>'--Select Factory--',
                'data-msg-required'=>"Please select a factory"]) }}
                <span class="input-group-btn">
                    {{ Form::button('<i class="fa fa-plus"></i> Add Factory', ['class' => 'btn btn-success', 'data-toggle'=>'modal', 'data-target'=>'#factoryModal']) }}
                </span>
           </div>
           <div id="factory-loading">
               <img src="{{asset('images/loading.gif')}}">
           </div>
        </div>

        <div class="form-group">
            {{ Form::label('factory_address', 'Factory Address') }}<span id="error-factory_address"></span>
            {{ Form::text('factory_address', null, ['class' => 'form-control required', 'data-msg-required'=>"Please enter the factory address", 'readOnly'=>'',]) }}
        </div>

        <div class="form-group">
            {{ Form::label('country', 'Factory Country') }}<span id="error-country"></span>
            {{Form::select('country', $countries ,null, ['placeholder' => '--Select Country--', 'class'=>'form-control required','data-msg-required'=>"Please select the country of the factory",'disabled'=>'' ])}}
        </div>

        <div class="form-group">
            {{ Form::label('city', 'Factory City') }}<span id="error-city"></span>
            {{ Form::text('city', null, ['class' => 'form-control required','data-msg-required'=>"Please enter the factory city",'readOnly'=>'']) }}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('contact_person', 'Factory Contact Person') }}<span id="error-contact_person"></span>
            {{ Form::text('contact_person', null, ['class' => 'form-control required','data-msg-required'=>"Please enter contact person",'readOnly'=>'']) }}
        </div>

        <div class="form-group">
            {{ Form::label('contact_number', 'Contact Number') }}<span id="error-contact_number"></span>
            {{ Form::text('contact_number', null, ['class' => 'form-control numeric required','data-msg-required'=>"Please enter the contact number",'readOnly'=>'']) }}
        </div>

        <div class="form-group">
            {{ Form::label('email_address', 'Email Address') }}<span id="error-email_address"></span>
            {{ Form::text('email_address', null, ['class' => 'form-control required','data-msg-required'=>"Please enter contact person email",'readOnly'=>'']) }}
        </div>
    </div>
</section>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <button class="btn btn-primary" id="first-back" type="button">Previous</button>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-warning" id="second-next" type="button">Next</button>
        </div>
    </div>
</div>


</div>