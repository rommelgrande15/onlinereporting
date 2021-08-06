<div id="newInspectorModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg ui-front">
    <!-- <form method="POST" action="{{route('newinspector')}}"> -->
    <form method="" action="">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Inspector</h4>
        </div>
        <div class="modal-body">
          {{-- {{csrf_field()}} --}}
          <div class="row">
            
              <div class="col-md-12">
                  <label class="pull-right"><span class="text-danger">*</span> <i>Indicate required fields</i></label><br/>
                  <div class="form-group">
                    <label for="email"><span class="text-danger">*</span> Inspector Name:</label>
                    <input type="text" class="form-control f" name="inspector_name" id="inspector_name" required onkeyup="textInputValidator(this.id)">
                    <div id="inspector5" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>
          </div>    

          <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="username"><span class="text-danger">*</span> Username</label>
                    <input type="text" class="form-control a" id="username" name="username" required onkeyup="textInputValidator(this.id)">
                    <div id="inspector0" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>
             
              <div class="col-md-4">
                  <div class="form-group">
                    <label for="password"><span class="text-danger">*</span> Password</label>
                    <input type="number" class="form-control b" minlength="6" id="password" name="password" required onkeyup="textInputValidator(this.id)">
                    <div id="inspector2" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="password_confirmation"><span class="text-danger">*</span> Confirm Password</label>
                    <input type="number" minlength="6" class="form-control c" id="password_confirmation" name="password_confirmation" required name="password_confirmation" onkeyup="textInputValidator(this.id)">
                    <div id="inspector3" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>
              
          </div>


          <div class="row">
              {{-- <div class="col-md-12">
                   <div class="form-group">
                     <label for="contact_number">Address:</label>
                     <textarea type="text" class="form-control numeric g" name="address" id="address" required></textarea>
                     <div id="inspector6" style="display:none" ><p style="color:red;">This field is required! </p></div>
                   </div>
               </div> --}}
 
               <div class="col-md-4">
                   <div class="form-group">
                     <label for="inspector_country"><span class="text-danger">*</span> Country</label><span class="error_messages inspector_country"></span>
                     <select class="form-control" name="inspector_country" id="inspector_country" onchange="showStateByCountryInCompany('inspector_country','inspector_state')">
                       <option value="">--Select Country--</option>
                     </select>
                     <div id="#" style="display:none" ><p style="color:red;">This field is required! </p></div>
                   </div>
                 </div>
                 
                 <div class="col-md-4">
                   <div class="form-group">
                     <label for="inspector_state"><span class="text-danger">*</span> Enter State</label><span class="error_messages inspector_state"></span>
                     {{-- <select class="form-control" name="inspector_state" id="inspector_state" onchange="showCityByCountryAndStateInCompany('inspector_country','inspector_state',)">
                       <option value="">Select State</option>
                     </select> --}}
                     <input type="text" class="form-control" required  name="inspector_state" id="inspector_state">
                     <input type="hidden" name="hidden_inspector_state" id="hidden_inspector_state" value="0">
                     <div id="#" style="display:none" ><p style="color:red;">This field is required! </p></div>
                   </div>
                 </div>
                 
                  <div class="col-md-4">
                   <div class="form-group">
                     <label for="inspector_city"><span class="text-danger">*</span> Enter City</label><span class="error_messages inspector_city"></span>
                     {{-- <select class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".inspector_city" name="inspector_city" id="inspector_city" onchange="textInputValidator(this.id)">
                       <option value="">--Select City--</option>
                     </select> --}}
                     <input type="text" class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".inspector_city" name="inspector_city" id="inspector_city">

                     <div id="#" style="display:none" ><p style="color:red;">This field is required! </p></div>
                   </div>
                 </div>
             
             
           </div>

          <div class="row">

              {{-- <div class="col-md-4">
                  <div class="form-group">
                    <label for="email">Inspector Name:</label>
                    <input type="text" class="form-control f" name="inspector_name" id="inspector_name" required>
                    <div id="inspector5" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div> --}}

              <div class="col-md-4">
                  <div class="form-group">
                     <label for="email"><span class="text-danger">*</span> Email address:</label>
                     <input type="email" class="form-control d" name="email" id="email" required onkeyup="textInputValidator(this.id)">
                     <div id="inspector1" style="display:none" ><p style="color:red;">This field is required! </p></div>
                   </div>
               </div>

               <div class="col-md-4">
                  <div class="form-group">
                    <label for="contact_number"><span class="text-danger">*</span> Mobile Number:</label>
                    <input type="text" minlength="11" class="form-control numeric e" name="contact_number" id="contact_number" required onkeyup="textInputValidator(this.id)">
                    <div id="inspector4" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="tel_number"><span class="text-danger">*</span> Telephone Number:</label>
                  <input type="text" class="form-control" name="tel_number" id="tel_number" required onkeyup="textInputValidator(this.id)">
                  <div id="inspector4" style="display:none" ><p style="color:red;">This field is required! </p></div>
                </div>
            </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="inspector_skype">Skype:</label>
                    <input type="text" class="form-control" name="inspector_skype" id="inspector_skype" onkeyup="textInputValidator(this.id)">
                    <div id="inspector4" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="inspector_wechat">We Chat:</label>
                    <input type="text" class="form-control" name="inspector_wechat" id="inspector_wechat" onkeyup="textInputValidator(this.id)">
                    <div id="inspector4" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="inspector_whatsapp">WhatsApp:</label>
                    <input type="text" class="form-control" name="inspector_whatsapp" id="inspector_whatsapp" onkeyup="textInputValidator(this.id)">
                    <div id="inspector4" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>

              <div class="col-md-4">
                  <div class="form-group">
                    <label for="inspector_qqmail">QQ Mail:</label>
                    <input type="text" class="form-control" name="inspector_qqmail" id="inspector_qqmail" onkeyup="textInputValidator(this.id)">
                    <div id="inspector4" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>
              
          </div>


          

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" onclick="inspectors()" class="btn btn-success" >Save Details</button>
        </div>
      </div>
      <!-- Modal content end-->
    </form>
  </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>


      <script>

      $(document).ready(function() {
        showAllCountryInCompany();
      });
var update =[
'a',
'b',
'c',
'd',
'e',
'f',
'g'
];


function checkeds()
        {
          for(var x=0;x<=6;x++){
          jQuery('.'+update[x]+'').removeAttr("style");
          }

          for(var x=0;x<=6;x++){
            jQuery('#inspector'+x+'').css("display","none");
          }
        }
  
     function inspectors_old()
     {
         
      

      var lnght=jQuery('.'+update[1]+'').val().length;
        var lnght1=jQuery('.'+update[2]+'').val().length;
        var pass=jQuery('.'+update[4]+'').val().length;
    //console.log(jQuery('.'+update[1]+'').val());
      checkeds();
      for(var x=0;x<=6;x++){
      if(jQuery('.'+update[x]+'').val()=="")
      {
      
        
        if(jQuery('.'+update[1]+'').val()!=jQuery('.'+update[2]+'').val())
        {
        alert("password is not match");
        x=7;
        
        jQuery('.'+update[1]+'').css('border-color', 'red');
        jQuery('.'+update[2]+'').css('border-color', 'red');
        }
     

        jQuery('#inspector'+x+'').css("display","block");
        jQuery('.'+update[x]+'').css('border-color', 'red');
        x=7;
      }else if(lnght < 6 && lnght1 < 6)
        {
          alert("Password minimum of 6 Characters");
          jQuery('.'+update[1]+'').css('border-color', 'red'); 
          x=7;  
        }else if(pass < 11){
          alert("Contact number is minimum of 11 Characters");
        jQuery('.'+update[4]+'').css('border-color', 'red'); 
        x=7;  
        }
      else if(x==6 ){


        
      
        
      }
      }
     }


     function inspectors()
     {
      
      var emailValidator=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        

            var username =jQuery('.a').val();
            var email = jQuery('.d').val();
            var password = jQuery('.b').val();
            var password_confirmation = jQuery('.c').val();
            var inspector_name = jQuery('.f').val();
            var contact_number = jQuery('.e').val();

            var tel_number = jQuery('#tel_number').val();


            var user_country_name = jQuery('#inspector_country option:selected').text();
            var user_country_id = jQuery('#inspector_country').val();
           /*  var user_state_name = jQuery('#inspector_state option:selected').text(); */
           var insp_state=jQuery('#inspector_state').val();
           var user_state_name = insp_state;
            var user_state_id = jQuery('#hidden_inspector_state').val();
           /*  var user_city_name = jQuery('#inspector_city option:selected').text(); */
           var user_city_name = jQuery('#inspector_city').val();
            var user_city_id = jQuery('#inspector_city').val();

            var address= user_city_name +' '+ user_state_name +' '+ user_country_name;

            var inspector_skype = jQuery('#inspector_skype').val();
            var inspector_wechat = jQuery('#inspector_wechat').val();
            var inspector_whatsapp = jQuery('#inspector_whatsapp').val();
            var inspector_qqmail = jQuery('#inspector_qqmail').val();
            
            if(inspector_skype==""){

              inspector_skype="N/A";
            }
            if(inspector_wechat==""){

              inspector_wechat="N/A";
              }
              if(inspector_whatsapp==""){

              inspector_whatsapp="N/A";
              }

               if(inspector_qqmail==""){

              inspector_qqmail="N/A";
              }

            var count_null=0; //variable for counting the null values
            var array_id_name =['inspector_name','username','password','password_confirmation','inspector_country','inspector_state','inspector_city','email','contact_number','tel_number'];
            var message;
            var array_message =['Inspector Name','Username','Password','Password Confirmation','Inspector Country','Inspector State','Inspector City','Email','Contact Number','Tel Number'];

            for (let index = 0; index < array_id_name.length; index++) {
              const element = jQuery('#'+array_id_name[index]).val();
              if(element==""){
                count_null+=1;
                jQuery('#'+array_id_name[index]+'').css("border","1px solid red");
                message=array_message[index];
                break;
              }else{
                jQuery('#'+array_id_name[index]+'').removeAttr("style");
              }
            }
           /*  array_id_name.forEach(element => {
            var val=jQuery('#'+element).val();
            if(val==""){
                count_null+=1;
                jQuery('#'+element).css("border","1px solid red");
              }else{
                jQuery('#'+element).removeAttr("style");
              }
            }); */
            console.log(count_null);
            if(count_null==0){
              if(password==password_confirmation){
                if(emailValidator.test(jQuery('.d').val())){
                  $('.send-loading ').show();
                  $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                  $.ajax({
                    type:'POST',
                    url:'/inspectorsDataNew',
                    data:{email:email},
                    success:function(data){  
                      if(data=='[]'){
                          $.ajax({
                            type:'POST',
                            url:'/InspectorsUsernameDataNew',
                            data:{username:username},
                            success:function(data){
                              if(data=='[]'){
                                $.ajaxSetup({
                                  headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                  }
                                });
                                $.ajax({
                                  type:'POST',
                                  url:'/newinspector',
                                  data:{
                                    username:username,
                                    email:email,
                                    password:password,
                                    inspector_name:inspector_name,
                                    contact_number:contact_number,
                                    tel_number:tel_number,
                                    address:address,
                                    user_country_name:user_country_name,
                                    user_country_id:user_country_id,
                                    user_state_name:user_state_name,
                                    user_state_id:user_state_id,
                                    user_city_name:user_city_name,
                                    user_city_id:user_city_id,                                                   
                                    inspector_skype:inspector_skype,
                                    inspector_wechat:inspector_wechat,
                                    inspector_whatsapp:inspector_whatsapp,
                                    inspector_qqmail:inspector_qqmail
                                  },
                                  success:function(data){
                                    console.log(data);
                                    alert("Inspector successfully added.");
                                    $('.send-loading ').hide();                                                 
                                    location.reload();
                                    //redirect()->route('clientcontacts',$client->client_code);
                                  },
                                  error: function(){
                                    alert("Error: Server encountered an error. Please try again or contact your system administrator.");
                                    $('.send-loading ').hide(); 
                                  }  
                                });
                              }else{
                                  alert("Username is already Exist");
                                  $('.send-loading ').hide();  
                              }
                            }
                          });
                 }else{
                   alert("Email is already Exist");
                   $('.send-loading ').hide();  
                 }                       
                }
             }); 
      }else{
        alert("Email are not Valid");
        jQuery('.d').css('border-color', 'red');
     
}
               
              }else{
                alert("Password mismatch!");
                $('#password').css("border","1px solid red");
                $('#password_confirmation').css("border","1px solid red");
              }
            }else{
              alert(""+message+" are required fields.");
            }
     }


     $('#inspector_country').on('change', function() {
      //showStateByCountryInCompany(this.id,'inspector_state');
      textInputValidator(this.id);
    });

    $('#inspector_state').on('change', function() {
      //showCityByCountryAndStateInCompany('inspector_country','inspector_state','inspector_city');
      textInputValidator(this.id);
    });

    
    function textInputValidator(input_id){
       if(jQuery('#'+input_id).val()!=""){
            jQuery('#'+input_id).removeAttr("style");
        }
     }

     function showAllCountryInCompany(){
        $('#inspector_country').empty();
		$('#inspector_country').append('<option value="">Please Wait...</option>');
		$.ajax({         
        	url: '/get-all-country/1'            
          , type: 'GET'
        	, success: function (result) {
                //localStorage.setItem("result",result);
              
                $('#inspector_country').empty();
				        $('#inspector_country').append('<option value="">Select Country</option>');
              var data_country=  JSON.parse(result);
              //data_country=result;
              data_country.forEach(element => {
                    if(element.name=="" || element.name==null){

                    }else{
                        $('#inspector_country').append('<option value="'+element.id+'">'+element.name+'</option>');
                        
                    }
                   
                });
               
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#inspector_country').empty();
        $('#inspector_country').append('<option value="">Something went wrong. Please try again.</option>');

				$('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
        });
    }

    var source_state=[];

    $('#inspector_state').autocomplete({
      maxResults: 10,
      source: function(request, response) {
        var results = $.ui.autocomplete.filter(source_state, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	},
      select: function (event, ui) {
          $("#inspector_state").val(ui.item.label); // display the selected text
          $("#hidden_inspector_state").val(ui.item.value); // save selected id to hidden input
          showCityByCountryAndStateInCompany('inspector_country','hidden_inspector_state','');
          return false;
      }
    });

    function showStateByCountryInCompany(country_id,select_id){
    var id = $('#'+country_id).val();
    $('#'+select_id).val('Please wait..');
		$.ajax({         
        	url: '/get-state/'+id            
        	, type: 'GET'
        	, success: function (result) {
                //var data_country= result;
                var data_country=  JSON.parse(result);
                source_state.length = 0;
                data_country.forEach(element => {
                    if(element.name=="" || element.name==null){

                    }else{
                        source_state.push({value:element.id,label:element.name});
                    }                  
                });
                $('#'+select_id).val('');
               
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#'+select_id).empty();
				$('#'+select_id).append('<option value="">Something went wrong. Please try again.</option>');
				$('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
        });
    }
    
    var source_city=[];

  $('#inspector_city').autocomplete({
    maxResults: 10,
		source: function(request, response) {
        var results = $.ui.autocomplete.filter(source_city, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	}
  });

  $( "#inspector_city" ).autocomplete( "option", "appendTo", ".eventInsForm" );


    function showCityByCountryAndStateInCompany(country_id,state_id,city_id){
        var cid = $('#'+country_id).val();
        var sid = $('#'+state_id).val();
    $('#inspector_city').val('Please Wait...');
		$.ajax({         
        	url: '/get-city/'+sid
        	, type: 'GET'
        	, success: function (result) {
                //console.log(result);
                //$('#'+city_id).val('Please wait...');
                //$('#'+city_id).empty();
				        //$('#'+city_id).append('<option value="">Select City</option>');
        var data_city=  JSON.parse(result);
        //var data_city=  result;
        source_city.length = 0;
                data_city.forEach(element => {
                    if(element.name=="" || element.name==null){

                    }else{
                        //$('#'+city_id).append('<option value="'+element.id+'">'+element.name+'</option>');
                        source_city.push(element.name);
                        //$('#'+city_id).val('');
                    }                  
				});
				$('#inspector_city').val('');
     
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#'+city_id).empty();
				$('#'+city_id).append('<option value="">Something went wrong. Please try again.</option>');
				$('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
        });
	}
      </script> 