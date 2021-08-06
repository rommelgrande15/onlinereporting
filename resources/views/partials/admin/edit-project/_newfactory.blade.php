<div id="newFactory" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form data-parsley-validate=''>
        {{csrf_field()}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add new Factory</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="form-group">
              <label for="client">Client</label><span class="error_messages client_error"></span>
              <select class="form-control" required data-parsley-required-message="Please select a client!" data-parsley-errors-container=".client_error" name="new_client_code_factory" id="new_client_code_factory" required>
              <option  value="">--Select Client--</option>
                @foreach($clients as $client)
                  <option value="{{$client->client_code}}">{{$client->client_name}}</option>
                @endforeach
              </select>
              <div id="field1" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>

            <div class="form-group">
              <label for="factory_name">Factory Name</label><span class="error_messages factory_error"></span>
              <input type="text" name="new_factory_name" class="form-control" id="new_factory_name" required data-parsley-required-message="Please enter a Factory name!" data-parsley-errors-container=".factory_error">
              <div id="field2" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>

            <div class="form-group">
              <label for="factory_address">Factory address</label><span class="error_messages address_error"></span>
              <input type="text" name="new_factory_address" class="form-control" id="new_factory_address" required data-parsley-required-message="Please enter the factory address!" data-parsley-errors-container=".address_error">
              <div id="field3" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>

            <div class="form-group">
              <label for="factory_country">Country</label><span class="error_messages country_error"></span>
              <select class="form-control" required data-parsley-required-message="Please select a country!" data-parsley-errors-container=".country_error" name="new_factory_country" id="new_factory_country">
                <option value="">--Select Country--</option>
                @foreach($countries as $country)
                  <option value="{{$country->id}}">{{$country->nicename}}</option>
                @endforeach
              </select>
              <div id="field4" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>

            <div class="form-group">
              <label for="factory_city">Factory City</label><span class="error_messages city_error"></span>
              <input type="text" name="new_factory_city" class="form-control" id="new_factory_city" required data-parsley-required-message="Please enter the City!" data-parsley-errors-container=".city_error">
              <div id="field5" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
        </div>       
      </div>
      <div class="modal-footer">
        {{ Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) }}
        {{ Form::button('<i class="fa fa-floppy-o"></i> Save Factory Details', ['class' => 'btn btn-success','id'=>'save_factory']) }}
      </div>
       </form>
    </div>

  </div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
      <!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
      <script>
      jQuery(document).ready(function(){
       // jQuery('#save').prop('disabled', true);

        jQuery('#new_client_code_factory').change(function(e){
          if(jQuery('#new_client_code_factory').val()!=""){
            jQuery('#new_client_code_factory').removeAttr("style");
            jQuery('#field1').css("display","none");
          }
        });

jQuery('#new_factory_name').keyup(function(e){
          if(jQuery('#new_factory_name').val()!=""){
            jQuery('#new_factory_name').removeAttr("style");
            jQuery('#field2').css("display","none");
          }
        });

        jQuery('#new_factory_address').keyup(function(e){
          if(jQuery('#new_factory_address').val()!=""){
            jQuery('#new_factory_address').removeAttr("style");
            jQuery('#field3').css("display","none");
          }
        });

        jQuery('#new_factory_country').change(function(e){
          if(jQuery('#new_factory_country').val()!=""){
            jQuery('#new_factory_country').removeAttr("style");
            jQuery('#field4').css("display","none");
          }
        });
        jQuery('#new_factory_city').change(function(e){
          if(jQuery('#new_factory_city').val()!=""){
            jQuery('#new_factory_city').removeAttr("style");
            jQuery('#field5').css("display","none");
          }
        });

        jQuery('#save_factory').click(function(e){
          
          for(var x=0;x<=4;x++)  
              {
              if(jQuery('#new_client_code_factory').val()==""){
                  jQuery('#new_client_code_factory').css('border-color', 'red');
                  document.getElementById('field1').style.display = 'block';
                  x=5;
                  
                }else if(jQuery('#new_factory_name').val()==""){
                  jQuery('#new_factory_name').css('border-color', 'red');
                  jQuery('#field2').css("display","block");
                  x=5;
                }
                else if(jQuery('#new_factory_address').val()==""){
                  jQuery('#new_factory_address').css('border-color', 'red');
                  jQuery('#field3').css("display","block");
                  x=5;
                }
                else if(jQuery('#new_factory_country').val()==""){
                  jQuery('#new_factory_country').css('border-color', 'red');
                  jQuery('#field4').css("display","block");
                  x=5;
                }
                else if(jQuery('#new_factory_city').val()==""){
                  jQuery('#new_factory_city').css('border-color', 'red');
                  jQuery('#field5').css("display","block");
                  x=5;
                }
                else{
                      jQuery("#formData").attr("action", "{{route('addfactorycontact')}}");
         // $('#clr').click();
             alert("Success");
          x=5;
                }
              }
        });
      });

   
      </script>