<div id="updateContact" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="{{route('updatecontact')}}" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Contact</h4>
      </div>
      <div class="modal-body">
          {{csrf_field()}}
          <div class="form-group">
              <label for="client_name">Client Name</label>
              <select class="form-control" id="update_contact_name" name="client_name">
                @foreach($clients as $cl)
                  <option value="{{$cl->client_code}}">{{$cl->client_name}}</option>
                @endforeach
              </select>
              <input type="hidden" name="contact_id" id="update_contact_id">
          </div>
     
          <div class="form-group">
              <label for="contact_person">Contact Person</label>
              <input type="text" name="contact_person" id="update_contact_person" class="form-control" required>
          </div>

          <div class="form-group">
              <label for="contact_person_email">Email Address</label>
              <input type="email" name="contact_person_email" id="update_contact_person_email" class="form-control" required>
          </div>

          <div class="form-group">
              <label for="contact_person_number">Contact Number</label>
              <input type="text" name="contact_person_number" id="update_contact_person_number" class="form-control numeric" required>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
        <button class="btn btn-success" type="submit"><i class="fa fa-floppy-o"></i> Save Client Details</button>
      </div>
      </form>
    </div>

  </div>
</div>


<div id="updateFactory" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form data-parsley-validate='' method="POST" action="">
        
        {{csrf_field()}}
         
       
        
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Factory Information</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <div class="form-group">
              <label for="client">Client</label><span class="error_messages client_error"></span>
              <input type="text" name="update_client_code" class="form-control" id="update_client_code"readonly>
              <!-- <select class="form-control" required data-parsley-required-message="Please select a client!" data-parsley-errors-container=".client_error" name="update_client_code" id="update_client_code">
              <option disabled selected>--Select Client--</option>
                @foreach($clients as $client)
                  <option value="{{$client->client_code}}">{{$client->client_name}}</option>
                @endforeach
              </select> -->
              <div id="updateFac0" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
            
            <div class="form-group">
              <label for="factory_name">Factory Name</label><span class="error_messages factory_error"></span>
              <input type="text" name="update_factory_name" class="form-control" id="update_factory_name" required data-parsley-required-message="Please enter a Factory name!" data-parsley-errors-container=".factory_error">
            
                <input type="hidden" name="update_factory_id" id="update_factory_id"  class="form-control">
                <div id="updateFac1" style="display:none" ><p style="color:red;">This field is required! </p></div>
              
            </div>

            <div class="form-group">
              <label for="factory_address">Factory address</label><span class="error_messages address_error"></span>
              <input type="text" name="update_factory_address" class="form-control" id="update_factory_address" required data-parsley-required-message="Please enter the factory address!" data-parsley-errors-container=".address_error">
              <div id="updateFac2" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>

            <div class="form-group">
              <label for="factory_country">Country</label><span class="error_messages country_error"></span>
              <select class="form-control" required data-parsley-required-message="Please select a country!" data-parsley-errors-container=".country_error" name="update_factory_country" id="update_factory_country">
                <option disabled selected>--Select Country--</option>
                @foreach($countries as $country)
                  <option value="{{$country->id}}">{{$country->nicename}}</option>
                @endforeach
              </select>
              <div id="updateFac3" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>

            <div class="form-group">
              <label for="factory_city">Factory City</label><span class="error_messages city_error"></span>
              <input type="text" name="update_factory_city" class="form-control" id="update_factory_city" required data-parsley-required-message="Please enter the City!" data-parsley-errors-container=".city_error">
              <div id="updateFac4" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
        </div>       
      </div>
      <div class="modal-footer">
        {{ Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) }}
        {{ Form::button('<i class="fa fa-floppy-o"></i> Save Client Details', ['class' => 'btn btn-success','type'=>'button','onclick'=>'test()']) }}
      </div>
       </form>
    </div>

  </div>
</div>



<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

      <script>

      
var upFac =[
'update_client_code',
'update_factory_name',
'update_factory_address',
'update_factory_country',
'update_factory_city'
];


function checkeds()
        {
         
          for(var x=0;x<=4;x++){
          jQuery('#'+upFac[x]+'').removeAttr("style");
          }

          for(var x=0;x<=4;x++){
            jQuery('#updateFac'+x+'').css("display","none");
          }
        }
  
     function test()
     {
     //alert("sdfsd");
      checkeds();
      for(var x=0;x<=4;x++){
      if(jQuery('#'+upFac[x]+'').val()=="")
      {
        jQuery('#updateFac'+x+'').css("display","block");
        jQuery('#'+upFac[x]+'').css('border-color', 'red');
        x=5;
      }else if(x==4) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            var update_factory_id =jQuery('#update_factory_id').val();
            var update_client_code =jQuery('#update_client_code').val();
            var update_factory_name = jQuery('#update_factory_name').val();
            var update_factory_address = jQuery('#update_factory_address').val();
            var update_factory_country = jQuery('#update_factory_country').val();
            var update_factory_city = jQuery('#update_factory_city').val();
            $.ajax({
               type:'POST',
               url:'/postupdatefactory',
               data:{update_factory_id:update_factory_id,update_client_code:update_client_code,update_factory_name:update_factory_name,update_factory_address:update_factory_address,update_factory_country:update_factory_country,update_factory_city:update_factory_city},
               success:function(data){
              window.location.href = 'factorylist';
                alert("Updated");
                //redirect()->route('clientcontacts',$client->client_code);
   }
   
            });
$('#clr').click();
      }
    }
     }
      </script>