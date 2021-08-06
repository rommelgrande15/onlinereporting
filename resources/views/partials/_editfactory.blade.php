<div id="updateFactoryModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">View/Edit Factory</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('edit_factory_name', 'Factory Name') }}
                {{ Form::text('edit_factory_name', null, ['class' => 'form-control edit-required-field','id'=>'edit_factory_name']) }}
                {{ Form::hidden('edit_factory_id', null, ['class' => 'form-control edit-required-field','id'=>'edit_factory_id']) }}
              </div>
              <div class="form-group">
                  {{ Form::label('edit_factory_address', 'Factory Address') }}
                  {{ Form::text('edit_factory_address', null, ['class' => 'form-control edit-required-field', 'id'=>"edit_factory_address"]) }}
              </div>

              <div class="form-group">
                  {{ Form::label('edit_country', 'Factory Country') }}
                  {{Form::select('edit_country', $countries ,null, ['placeholder' => '--Select Country--', 'class'=>'form-control edit-required-field','id'=>"edit_country" ])}}
              </div>

              <div class="form-group">
                  {{ Form::label('edit_city', 'Factory City') }}
                  {{ Form::text('edit_city', null, ['class' => 'form-control edit-required-field','id'=>"edit_city"]) }}
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                  {{ Form::label('edit_contact_person', 'Factory Contact Person') }}
                  {{ Form::text('edit_contact_person', null, ['class' => 'form-control edit-required-field','id'=>"edit_contact_person"]) }}
              </div>

              <div class="form-group">
                  {{ Form::label('edit_contact_number', 'Contact Number') }}
                  {{ Form::text('edit_contact_number', null, ['class' => 'form-control numeric edit-required-field',''=>"edit_contact_number"]) }}
              </div>

              <div class="form-group">
                  {{ Form::label('edit_email_address', 'Email Address') }}
                  {{ Form::text('edit_email_address', null, ['class' => 'form-control edit-required-field','id'=>"edit_email_address"]) }}
                  <span id="edit-email-error"></span>
              </div>
          </div>
        </div>
        
          
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" id="close_factory">Close</button>
        <button type="button" class="btn btn-success" id="edit_factory">Edit Details</button>
        <button type="button" class="btn btn-primary" id="update_factory">Save Changes</button>
      </div>
    </div>

  </div>
</div>