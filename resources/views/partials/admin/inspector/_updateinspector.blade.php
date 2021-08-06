<div id="updateInspectorModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg ui-front">
    <form method="POST" >
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Inspector Details</h4>
        </div>
        <div class="modal-body">
          {!!csrf_field()!!}
          <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="update_username" name="username">
                    <input type="hidden" class="form-control" id="update_id" name="inspector_id">
                  </div>
              </div>
              <div class="col-md-4">
                 <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" name="email" id="update_email">
                  </div>
              </div>
         {{--  </div>

          <div class="row"> --}}
              
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Inspector Name:</label>
                    <input type="text" class="form-control" name="inspector_name" id="update_inspector_name" required>
                    <div id="Updainspector1" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="contact_number">Mobile Number:</label>
                    <input type="text" minlength="11" class="form-control numeric" name="contact_number" id="update_contact_number" required>
                    <div id="Updainspector0" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="update_tel_number">Telephone Number:</label>
                  <input type="text"  class="form-control " name="update_tel_number" id="update_tel_number" required>
                  <div id="Updainspector0" style="display:none" ><p style="color:red;">This field is required! </p></div>
                </div>
            </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="update_skype">Skype:</label>
                    <input type="text" class="form-control" name="update_skype" id="update_skype" required>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="update_wechat">We Chat:</label>
                    <input type="text" class="form-control" name="update_wechat" id="update_wechat" required>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="update_whatsapp">WhatsApp:</label>
                    <input type="text" class="form-control" name="update_whatsapp" id="update_whatsapp" required>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="update_qqmail">QQ Mail:</label>
                    <input type="text" class="form-control" name="update_qqmail" id="update_qqmail" required>
                  </div>
              </div>

          </div>
           <div class="row">
             {{-- <div class="col-md-12">
                  <div class="form-group">
                    <label for="contact_number">Address:</label>
                    <textarea type="text" class="form-control numeric" name="address" id="update_address" required></textarea>
                    <div id="Updainspector2" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    
                  </div>
              </div> --}}
            
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="update_inspector_country">Country</label><span class="error_messages update_inspector_country"></span>
                    <select class="form-control" required data-parsley-required-message="Please select a country!"  data-parsley-errors-container=".update_inspector_country" name="update_inspector_country" id="update_inspector_country" onchange="showStateByCountryChange()" required>
                      <option value="">--Select Country--</option>
                    </select>
                    <input type="hidden" class="form-control" name="update_inspector_country_name" id="update_inspector_country_name">
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="update_inspector_state">Enter State</label><span class="error_messages update_inspector_state"></span>
                    {{-- <select class="form-control" required  name="update_inspector_state" id="update_inspector_state" onchange="showCityByCountryAndStateChangeNew()" required>
                      <option value="">Select State</option>
                    </select> --}}
                    <input type="text" class="form-control"  name="update_inspector_state" id="update_inspector_state" required>

                    <input type="hidden" class="form-control" name="update_inspector_state_id" id="update_inspector_state_id">
                  </div>
                </div>
                
                 <div class="col-md-4">
                  <div class="form-group">
                    <label for="update_inspector_city">Enter City</label><span class="error_messages update_inspector_city"></span>
                    {{-- <select class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".update_inspector_city" name="update_inspector_city" id="update_inspector_city" onchange="getCityName()" required>
                      <option value="">--Select City--</option>
                    </select> --}}
                    <input type="text" class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".update_inspector_city" name="update_inspector_city" id="update_inspector_city" required onchange="getCityName()">

                    <input type="hidden" class="form-control" name="update_inspector_city_name" id="update_inspector_city_name">
                  </div>
                </div>
            
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" onclick="UpdateInspectorData()" class="btn btn-success" >Save Details</button>
          {{-- <button type="submit" onclick="inspectorss()" class="btn btn-success" >Save Details</button> --}}
        </div>
      </div>
      <!-- Modal content end-->
    </form>
  </div>
</div>



<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>


      <script>
var message;
var emailValidator=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
      var array_id=[
        'update_email',
        'update_inspector_name',
        'update_contact_number',
        'update_tel_number',
        'update_inspector_country',
        'update_inspector_state',
        'update_inspector_city'
      ];

          var array_message=[
        'Email',
        'Inspector Name',
        'Contact Number',
        'Tel Number',
        'Inspector Country',
        'Inspector State',
        'Inspector City'
      ];



function UpdateInspectorData(){

var count_null=0;
  for (let index = 0; index < array_id.length; index++) {
  const element = $('#'+array_id[index]+'').val();
              if(element==""){
                count_null+=1;
                jQuery('#'+array_id[index]+'').css("border","1px solid red");
                message=array_message[index];
                break;
              }else{
                jQuery('#'+array_id[index]+'').removeAttr("style");
              }
}

if(count_null==0){
  if(emailValidator.test($('#update_email').val())){
    $('.send-loading ').show();
       var update_username = $('#update_username').val();
       var update_email = $('#update_email').val();
       var update_inspector_name = $('#update_inspector_name').val();
       var update_contact_number= $('#update_contact_number').val();
       var update_tel_number= $('#update_tel_number').val();
       var update_inspector_country = $('#update_inspector_country').val();
       var update_inspector_country_name = $('#update_inspector_country option:selected').text();
       var  update_inspector_state= $('#update_inspector_state').val();
       var  update_inspector_state_id= $('#update_inspector_state_id').val();
       var  update_inspector_city = $('#update_inspector_city').val();
       var  update_inspector_city_name = $('#update_inspector_city_name').val();


            var update_skype = jQuery('#update_skype').val();
            var update_wechat = jQuery('#update_wechat').val();
            var update_whatsapp = jQuery('#update_whatsapp').val();
            var update_qqmail = jQuery('#update_qqmail').val();
            
            if(update_skype==""){

              update_skype="N/A";
            }
            if(update_wechat==""){

              update_wechat="N/A";
              }
              if(update_whatsapp==""){

              update_whatsapp="N/A";
              }

               if(update_qqmail==""){

              update_qqmail="N/A";
              }
       var  inspector_id = $('#update_id').val();
       $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });


            $.ajax({
               type:'POST',
               url:'/updateinspector',
               data:
               { update_username:update_username,
                 email:update_email,
                inspector_name:update_inspector_name,
                contact_number:update_contact_number,
                 update_tel_number:update_tel_number,
                 update_inspector_country:update_inspector_country,
                 update_inspector_country_name:update_inspector_country_name,
                 update_inspector_state:update_inspector_state,
                 update_inspector_state_id:update_inspector_state_id,
                 update_inspector_city:update_inspector_city,
                 inspector_id:inspector_id,
                 update_skype,
                update_wechat,
                update_whatsapp,
                 update_qqmail},
               success:function(data){
                 if(data=="already"){
                  alert("Username Already Exist");
                 }else{
                alert("Client successfully Updated.");
                 }
                $('.send-loading ').hide();
                location.reload();
              },
              error: function(){
                alert("Error: Server encountered an error. Please try again or contact your system administrator.");
              }
              
            });   

  }else{
    alert("Email is not Valid");
  }

}else{
alert(""+message+" are required");
}
}

var updated =[
'update_contact_number',
'update_inspector_name',
'update_address'
];


function checkeds()
        {
          for(var x=0;x<=2;x++){
          jQuery('.'+updated[x]+'').removeAttr("style");
          }

          for(var x=0;x<=2;x++){
            jQuery('#Updainspector'+x+'').css("display","none");
          }
        }
  
     function inspectorss()
     {
   // console.log(jQuery('.'+update+'').val());
   
      checkeds();
      for(var x=0;x<=2;x++){
        //alert(jQuery('#'+updated[x]+'').val());
      if(jQuery('#'+updated[x]+'').val()=="")
      {
    
        jQuery('#Updainspector'+x+'').css("display","block");
        jQuery('#'+updated[x]+'').css('border-color', 'red');
        x=7;
      }else if(x==2){
        
       alert("Success");
        
      }
      }
     }

  $('#update_inspector_state').autocomplete({
      maxResults: 10,
      source: function(request, response) {
        var results = $.ui.autocomplete.filter(update_source_state, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	},
      select: function (event, ui) {
          $("#update_inspector_state").val(ui.item.label); // display the selected text
          $("#update_inspector_state_id").val(ui.item.value); // save selected id to hidden input
          showCityByCountryAndStateChangeNew();
          return false;
      }
    });

     function showStateByCountryChange() {
       
     var id = $('#update_inspector_country').val();
     var name = $('#update_inspector_country option:selected').text();
     $('#update_inspector_country_name').val(name);

    //$('#update_inspector_state').empty();
    //$('#update_inspector_state').append('<option value="">Please Wait...</option>');
    $('#update_inspector_state').val('Please wait..');
    $.ajax({
        url: '/get-state/' + id,
        type: 'GET',
        success: function(result) {
            //console.log(result);
            //$('#update_inspector_state').empty();
            //$('#update_inspector_state').append('<option value="">Select State</option>');
            /* var data_country=  JSON.parse(result); */
            $('#update_inspector_state').val('');
            //var data_country = result;
            var data_country=  JSON.parse(result);
            update_source_state.length = 0;
            data_country.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    //$('#update_inspector_state').append('<option value="' + element.id + '">' + element.name + '</option>');
                    update_source_state.push({value:element.id,label:element.name});
                }
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_inspector_state').empty();
            $('#update_inspector_state').append('<option value="">Something went wrong. Please try again.</option>');
            $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
        }
    });
}

function showCityByCountryAndStateChange() {
     var sid = $('#update_inspector_state').val();
     $('#update_inspector_state_name').val(name);
}

$('#update_inspector_city').autocomplete({
    maxResults: 10,
		source: function(request, response) {
        var results = $.ui.autocomplete.filter(update_source_city, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	}
  });

 //$( "#inspector_city" ).autocomplete( "option", "appendTo", ".eventInsForm" );

function showCityByCountryAndStateChangeOLD() {
     var cid = $('#update_inspector_country').val();
     var sid = $('#update_inspector_state').val();
     var name = $('#update_inspector_state option:selected').text();
     $('#update_inspector_state_name').val(name);

    $('#update_inspector_city').empty();
    $('#update_inspector_city').append('<option value="">Please Wait...</option>');
    $.ajax({
        url: '/get-city/' + sid,
        type: 'GET',
        success: function(result) {
            //console.log(result);
            $('#update_inspector_city').empty();
            $('#update_inspector_city').append('<option value="">Select City</option>');
            var data_city=  JSON.parse(result);
            //var data_city = result;

            data_city.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    $('#update_inspector_city').append('<option value="' + element.id + '">' + element.name + '</option>');
                }
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_inspector_city').empty();
            $('#update_inspector_city').append('<option value="">Something went wrong. Please try again.</option>');
            $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
        }
    });
}


function showCityByCountryAndStateChangeNew() {
     var cid = $('#update_inspector_country').val();
     var sid = $('#update_inspector_state_id').val();
     //var name = $('#update_inspector_state option:selected').text();
     //$('#update_inspector_state_name').val(name);

    $('#update_inspector_city').val('Please wait...');

    $.ajax({
        url: '/get-city/' + sid,
        type: 'GET',
        success: function(result) {
            //console.log(result);
            $('#update_inspector_city').val('');
  
            //var data_city = result;
            var data_city=  JSON.parse(result);
            update_source_city.length = 0;
            data_city.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                  update_source_city.push(element.name);
                }
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_inspector_city').empty();
            $('#update_inspector_city').append('<option value="">Something went wrong. Please try again.</option>');
            $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
        }
    });
}

  function getCityName() {
     var name = $('#update_inspector_city').val();
     $('#update_inspector_city_name').val(name);
    }

      </script> 