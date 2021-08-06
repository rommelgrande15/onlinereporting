<div class="modal fade AQLModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Product Quantity and AQL</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="usr">Quantity:</label>
            <input type="number" class="form-control new_aql_qty" name="new_aql_qty" id="new_aql_qty" min="1" oninput="this.value = Math.abs(this.value)" value="{!! $product->aql_qty !!}" required>
              <div id="aqlRequired1" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              {{-- <label for="usr">Normal Level:</label> --}}
              {!! Form::label('new_aql_normal_level', '--Select--') !!}
							{!! Form::select('new_aql_normal_level', $normal, $product->aql_normal_level, ['class' => 'form-control new_aql_normal_level']) !!}
             {{--  <select class="form-control new_aql_normal_level" name="new_aql_normal_level" id="new_aql_normal_level" required>
                <option value="">--Select--</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
              </select> --}}
              <div id="aqlRequired2" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
          </div>
            
          <div class="col-md-4">
            <div class="form-group">
              {{-- <label for="usr">Special Level:</label> --}}
             {{--  <select class="form-control new_aql_special_level" name="new_aql_special_level" id="new_aql_special_level" required>
                <option value="">--Select--</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
                <option value="S4">S4</option>
              </select> --}}
              {!! Form::label('new_aql_special_level', '--Select--') !!}
							{!! Form::select('new_aql_special_level', $special, $product->aql_special_level, ['class' => 'form-control new_aql_special_level']) !!}
              <div id="aqlRequired3" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <table class="table-bordered table-condensed" width="100%">
                <tr>
                  <th></th>
                  <th class="text-center">AQL</th>
                  <th class="text-center">Max Allowed</th>
                </tr>

                <tr>
                  <th>Major</th>
                  <td>
                  {{-- <select type="text" name="new_aql_major" id="new_aql_major" class="form-control new_aql_major"required ></select> --}}
                  {{-- {!! Form::label('new_aql_major', '--Select--') !!} --}}
							    {!! Form::select('new_aql_major', $aql_major, $product->aql_major, ['class' => 'form-control new_aql_major', 'placeholder'=>'--Select--']) !!}
                  
                  <div id="aqlRequired4" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  <td><input type="text " name="new_max_major" id="new_max_major" class="form-control new_max_major" value="{!! $product->max_allowed_major !!}"/>
                  <div id="aqlRequired5" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>

                <tr>
                  <th>Minor</th>
                  <td>
                    {{-- <select type="text" name="new_aql_minor" id="new_aql_minor" class="form-control new_aql_minor"></select> --}}
                    {!! Form::select('new_aql_minor', $aql_major, $product->aql_minor, ['class' => 'form-control new_aql_minor', 'placeholder'=>'--Select--']) !!}
                    <div id="aqlRequired6" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  <td><input type="text" name="new_max_minor" id="new_max_minor" class="form-control new_max_minor" value="{!! $product->max_allowed_minor !!}"/>
                  <div id="aqlRequired7" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>
              </table>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
              <table class="table-bordered table-condensed" width="100%">
                <tr>
                  <th></th>
                  <th class="text-center">Code Letter</th>
                  <th class="text-center">Sample Size</th>
                </tr>

                <tr>
                  <th>Normal</th>
                  <td><input type="text" name="new_aql_normal_letter" id="new_aql_normal_letter" class="form-control new_aql_normal_letter" value="{!! $product->aql_normal_letter !!}">
                  <div id="aqlRequired8" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                  <td><input type="text" name="new_aql_normal_sampsize" id="new_aql_normal_sampsize" class="form-control new_aql_normal_sampsize" value="{!! $product->aql_normal_sampsize!!}"/>
                  <div id="aqlRequired9" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>

                <tr>
                  <th>Special</th>
                  <td><input type="text" name="new_aql_special_letter" id="new_aql_special_letter" class="form-control new_aql_special_letter" value="{!! $product->aql_special_letter !!}">
                  <div id="aqlRequired10" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                  <td><input type="text" name="new_aql_special_sampsize" id="new_aql_special_sampsize" class="form-control new_aql_special_sampsize" value="{!! $product->aql_special_sampsize !!}"/>
                  <div id="aqlRequired11" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>
              </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success draft_confirm_aql"  name="draft_confirm_aql" id="draft_confirm_aql">Confirm</button>
        
        <!-- <button type="button" class="btn btn-success confirm_aql"  name="Confirm" id="Confirm">Confirm</button> -->
      </div>
    </div>

  </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
      <!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
      <script>
      jQuery(document).ready(function(){

      }); 

 </script>