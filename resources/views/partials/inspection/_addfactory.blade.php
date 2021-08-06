<div id="factoryModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add new Factory</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('new_factory_name', 'Factory Name') }}
                {{ Form::text('new_factory_name', null, ['class' => 'form-control required-field','id'=>'new_factory_name']) }}
              </div>
              <div class="form-group">
                  {{ Form::label('new_factory_address', 'Factory Address') }}
                  {{ Form::text('new_factory_address', null, ['class' => 'form-control required-field', 'id'=>"new_factory_address"]) }}
              </div>

              <div class="form-group">
                  {{ Form::label('new_country', 'Factory Country') }}
                  {{Form::select('new_country', $countries ,null, ['placeholder' => '--Select Country--', 'class'=>'form-control required-field','id'=>"new_country" ])}}
              </div>

              <div class="form-group">
                  {{ Form::label('new_city', 'Factory City') }}
                  {{ Form::text('new_city', null, ['class' => 'form-control required-field','id'=>"new_city"]) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('new_contact_person', 'Factory Contact Person') }}
                  {{ Form::text('new_contact_person', null, ['class' => 'form-control required-field','id'=>"new_contact_person"]) }}
              </div>

              <div class="form-group">
                  {{ Form::label('new_contact_number', 'Contact Number') }}
                  {{ Form::text('new_contact_number', null, ['class' => 'form-control numeric required-field',''=>"new_contact_number"]) }}
              </div>

              <div class="form-group">
                  {{ Form::label('new_email_address', 'Email Address') }}
                  {{ Form::text('new_email_address', null, ['class' => 'form-control required-field','id'=>"new_email_address"]) }}
                  <span id="email-error"></span>
              </div>
          </div>
        </div>
        
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save_factory">Save</button>
      </div>
    </div>

  </div>
</div>