<div id="aqlModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Quantity</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          {{ Form::label('qty', 'Quantity') }}<span class="error-messages" id="qty_error"></span>
          {{ Form::text('qty', null, ['class' => 'form-control numeric','id'=>'qty']) }}
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              {{ Form::label('sample_level', 'Sample Level') }}<span class="error-messages"></span> 
              {{ Form::text('sample_level', null, ['class' => 'form-control','id'=>'sample_level']) }}
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              {{ Form::label('sampling_size', 'Sampling Size') }}
              {{ Form::text('sampling_size', null, ['class' => 'form-control numeric']) }}
            </div>
          </div>
        </div>
        <hr>
        <div class="row">
          <!--Max Allowed-->
          <div class="col-md-6">
            <div class="col-md-12">
              {{ Form::label('', 'Max Allowed') }}
              <div class="underline"></div>
            </div>
            <div class="row max">
              <div class="form-group">
                {{ Form::label('max_minor', 'Minor',['class'=>'control-label col-sm-3']) }}
                <div class="col-sm-9">
                  {{ Form::text('max_minor', null, ['class' => 'form-control']) }}
                </div>
              </div>
            </div>

            <div class="row max">
              <div class="form-group">
                {{ Form::label('max_major', 'Major',['class'=>'control-label col-sm-3']) }}
                <div class="col-sm-9">
                  {{ Form::text('max_major', null, ['class' => 'form-control']) }}
                </div>
              </div>
            </div>

            <div class="row max">
              <div class="form-group">
                {{ Form::label('max_critical', 'Crtitical',['class'=>'control-label col-sm-3']) }}
                <div class="col-sm-9">
                  {{ Form::text('max_critical', null, ['class' => 'form-control']) }}
                </div>
              </div>
            </div>

            <div class="row max">
              <div class="form-group">
                {{ Form::label('max_functional', 'Minor',['class'=>'control-label col-sm-3']) }}
                <div class="col-sm-9">
                  {{ Form::text('max_functional', null, ['class' => 'form-control']) }}
                </div>
              </div>
            </div>
          </div>
          <!--Acceptable Quality Limit (AQL)-->
          <div class="col-md-6">
            <div class="col-md-12">
              {{ Form::label('', 'Acceptable Quality Limit (AQL)') }}
              <div class="underline"></div>
            </div>
            <div class="row max">
              <div class="form-group">
                {{ Form::label('aql_minor', 'Minor',['class'=>'control-label col-sm-3']) }}
                <div class="col-sm-9">
                   {{ Form::select('aql_minor', [
                        '0' => '0',
                        '0.065' => '0.065',
                        '0.10' => '0.10',
                        '0.15' => '0.15',
                        '0.25' => '0.25',
                        '0.4' => '0.4',
                        '0.65' => '0.65',
                        '1.0' => '1.0',
                        '1.5' => '1.5',
                        '2.5' => '2.5',
                        '4.0' => '4.0',
                        '6.5' => '6.5',
                        '10' => '10',                        
                      ], null, ['class' => 'form-control', 'placeholder'=>'---']) }}
                </div>
              </div>
            </div>

            <div class="row max">
              <div class="form-group">
                {{ Form::label('aql_major', 'Major',['class'=>'control-label col-sm-3']) }}
                <div class="col-sm-9">
                  {{ Form::select('aql_major', [
                        '0' => '0',
                        '0.065' => '0.065',
                        '0.10' => '0.10',
                        '0.15' => '0.15',
                        '0.25' => '0.25',
                        '0.4' => '0.4',
                        '0.65' => '0.65',
                        '1.0' => '1.0',
                        '1.5' => '1.5',
                        '2.5' => '2.5',
                        '4.0' => '4.0',
                        '6.5' => '6.5',
                        '10' => '10',                        
                      ], null, ['class' => 'form-control', 'placeholder'=>'---']) }}
                </div>
              </div>
            </div>

            <div class="row max">
              <div class="form-group">
                {{ Form::label('aql_critical', 'Crtitical',['class'=>'control-label col-sm-3']) }}
                <div class="col-sm-9">
                  {{ Form::select('aql_critical', [
                        '0' => '0',                     
                      ], null, ['class' => 'form-control', 'placeholder'=>'---']) }}
                </div>
              </div>
            </div>

            <div class="row max">
              <div class="form-group">
                {{ Form::label('aql_functional', 'Minor',['class'=>'control-label col-sm-3']) }}
                <div class="col-sm-9">  
                  {{ Form::select('aql_functional', [
                        '0' => '0',
                        '0.065' => '0.065',
                        '0.10' => '0.10',
                        '0.15' => '0.15',
                        '0.25' => '0.25',
                        '0.4' => '0.4',
                        '0.65' => '0.65',
                        '1.0' => '1.0',
                        '1.5' => '1.5',
                        '2.5' => '2.5',
                        '4.0' => '4.0',
                        '6.5' => '6.5',
                        '10' => '10',                        
                      ], null, ['class' => 'form-control', 'placeholder'=>'---']) }}
                </div>
              </div>
            </div>
          </div>

        </div>



      </div>

      <div class="modal-footer">
        {{ Form::button('Confirm', ['class' => 'btn btn-primary', 'id'=>'confirmAql']) }}
      </div>
    </div>

  </div>
</div>