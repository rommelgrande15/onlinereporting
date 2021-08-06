<div id="newFactory" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ui-front">
  
      <!-- Modal content-->
      <div class="modal-content">
        <form data-parsley-validate='' method="POST" action="">
          {!!csrf_field()!!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add new Factory</h4>
        </div>
        <div class="modal-body">
            <div class="row">
  
  
          <div class="form-group">
  <div class="col-md-4">
    
              <div class="form-group">
                <label for="factory_name"><span class="text-danger">*</span> Factory Name</label><span class="error_messages factory_error"></span>
                <input type="text" name="factory_name" class="form-control" id="factory_name" onchange="textInputValidator(this.id)" required data-parsley-required-message="Please enter a Factory name!" data-parsley-errors-container=".factory_error">
                <div id="factory1" style="display:none" ><p style="color:red;">This field is required! </p></div>
              </div>
  </div>

  <div class="col-md-8">
    <div class="form-group">
      <label for="factory_address_local"><span class="text-danger">*</span> Factory address Local</label><span class="error_messages address_local_error"></span>
      <input type="text" name="factory_address_local" class="form-control" onchange="textInputValidator(this.id)" id="factory_address_local" required data-parsley-required-message="Please enter the factory address local!" data-parsley-errors-container=".address_local_error">
      <div id="factory3" style="display:none" ><p style="color:red;">This field is required! </p></div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="factory_country"><span class="text-danger">*</span> Country</label><span class="error_messages country_error"></span>
      <select class="form-control" required data-parsley-required-message="Please select a country!"  data-parsley-errors-container=".country_error" name="factory_country" id="factory_country">
        <option value="">--Select Country--</option>
      </select>
      <div id="factory4" style="display:none" ><p style="color:red;">This field is required! </p></div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="form-group">
      <label for="factory_state"><span class="text-danger">*</span> Enter State</label><span class="error_messages state_error"></span>

      <input type="text" class="form-control" name="factory_state" id="factory_state" required>
      <input type="hidden" class="form-control" name="hidden_factory_state_id" id="hidden_factory_state_id" required>

      <div id="factory5" style="display:none" ><p style="color:red;">This field is required! </p></div>
    </div>
  </div>
  

   <div class="col-md-4">
    <div class="form-group">
      <label for="factory_city"><span class="text-danger">*</span> Enter City</label><span class="error_messages city_error"></span>

      <input type="text" class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".city_error" name="factory_city" id="factory_city">

      <div id="factory6" style="display:none" ><p style="color:red;">This field is required! </p></div>
    </div>
  </div>
  
  
  <div class="col-md-12">
      <div class="form-group">
          <hr/>
  </div>
  </div>
  
  
  
          <div class="fac-clone">
            <div class="f-clone-inputs">
              <div class="col-md-12">
                  <h4>Factory Contact Person</h4>
                  <hr>
              </div>
                <div class="col-md-4">
                
                  <div class="form-group">
                      <label for="contact_person"><span class="text-danger">*</span> Contact Person</label>
                      <input type="text" name="contact_person" onchange="multipleTextValidator(this.class)" id="contact_person" class="form-control contact_person" required>
                      <div id="factory7" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-group">
                      <label for="contact_person_email"><span class="text-danger">*</span> Email Address</label>
                      <input type="email" name="contact_person_email" onchange="multipleTextValidator(this.class)" id="contact_person_email" class="form-control contact_person_email" required>
                      <div id="factory8" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                      <label for="contact_person_number"><span class="text-danger">*</span> Mobile Number</label>
                      <input type="text" name="contact_person_number" onchange="multipleTextValidator(this.class)" id="contact_person_number" class="form-control numeric contact_person_number" required>
                      <div id="factory9" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                      <label for="f_contact_person_tel_number"><span class="text-danger">*</span> Telephone Number</label>
                      <input type="text" name="f_contact_person_tel_number" onchange="multipleTextValidator(this.class)" id="f_contact_person_tel_number" class="form-control numeric f_contact_person_tel_number" required>
                      <div id="factory9" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="contact_skype">Skype</label>
                        <input type="text" name="contact_skype"  id="contact_skype" class="form-control contact_skype" required onchange="multipleTextValidator(this.class)">
                        <div id="factory10" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </div>
                  </div>
                
                  <div class="col-md-4">
                      <div class="form-group">
                          <label for="contact_wechat">We Chat</label>
                          <input type="text" name="contact_wechat"  id="contact_wechat" class="form-control contact_wechat" required onchange="multipleTextValidator(this.class)">
                          <div id="factory11" style="display:none" ><p style="color:red;">This field is required! </p></div>
                      </div>
                    </div>
                
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="contact_whatsapp">WhatsApp</label>
                            <input type="text" name="contact_whatsapp" id="contact_whatsapp" class="form-control contact_whatsapp" required onchange="multipleTextValidator(this.class)">
                            <div id="factory12" style="display:none" ><p style="color:red;">This field is required! </p></div>
                        </div>
                      </div>
                
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="contact_qqmail">QQ Mail</label>
                              <input type="text" name="contact_qqmail"  id="contact_qqmail" class="form-control contact_qqmail" required onchange="multipleTextValidator(this.class)">
                              <div id="factory13" style="display:none" ><p style="color:red;">This field is required! </p></div>
                          </div>
                        </div>
            </div>
          </div>
  
          <div class="col-md-12">
            <div class="form-group">
                   <button class="btn btn-success" type="button" id="btn_add_more_fields_fact"><i class="fa fa-plus"></i> Add more contact person</button>
            </div>
          </div>
  
          </div>     
          
        </div>
        </div>
        <div class="modal-footer">
          {!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
          {{-- {{ Form::button('<i class="fa fa-floppy-o"></i> Save Client Details', ['class' => 'btn btn-success','type'=>'button','onclick'=>'testtest()']) }} --}}
          {!! Form::button('<i class="fa fa-floppy-o"></i> Save Factory Details', ['class' => 'btn btn-success','type'=>'button','onclick'=>'saveFactoryDetails()']) !!}
        </div>
         </form>
      </div>
  
    </div>
  </div>
  
  
  <script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
        <script>
  
  jQuery(document).ready(function(){
    
  //console.log(/^([a-z0-9]{5,})$/.test('abc12'));
  showAllCountry();
  getFactoryList();
  var max_fields = 10;
      var new_field_html = '<div class="row"><div class="col-md-12"><hr></div><div class="col-md-4"><div class="form-group"><label for="contact_person">Contact Person</label><input type="text" name="contact_person" onchange="checkeds2()" id="contact_person" class="form-control" required><div id="factory7" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_person_email">Email Address</label><input type="email" name="contact_person_email" onchange="checkeds2()" id="contact_person_email" class="form-control" required><div id="factory8" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_person_number">Contact Number</label><input type="text" name="contact_person_number" onchange="checkeds2()" id="contact_person_number" class="form-control numeric" required><div id="factory9" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_skype">Skype</label><input type="text" name="contact_skype"  id="contact_skype" class="form-control" required><div id="factory10" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_wechat">We Chat</label><input type="text" name="contact_wechat"  id="contact_wechat" class="form-control" required><div id="factory11" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_whatsapp">WhatsApp</label><input type="text" name="contact_whatsapp" id="contact_whatsapp" class="form-control" required><div id="factory12" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_qqmail">QQ Mail</label><input type="text" name="contact_qqmail"  id="contact_qqmail" class="form-control" required><div id="factory13" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><button class="btn btn-danger remove_input_button" type="button"><i class="fa fa-trash"></i> Remove </button></div>';
      var input_count = 1;
      // Add button dynamically
      $('.btn_add_more').click(function(){
        if(input_count < max_fields){
          input_count++;
          $('#div_more_factory').append(new_field_html);
        }
      });
  
      // Remove dynamically added button
      $('#div_more_factory').on('click', '.remove_input_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove();
          input_count--;
        });
  
  
  });
  
  
  
  
   /* 
  var fact =[
  'new_client_code',
  'factory_id',
  'contact_person',
  'contact_person_email',
  'contact_person_number'
  
  ]; */ 
  /* 'client_code', */
  var idd =[
 
  'factory_name',
  'factory_address',
  'factory_address_local',
  'factory_country',
  'factory_state',
  'factory_city',
  'contact_person',
  'contact_person_email',
  'contact_person_number'
  ];
  
  

  
  function checkeds2()
          {
          /*   alert("sds"); */
            for(var x=0;x<=10;x++){
            jQuery('#'+idd[x]+'').removeAttr("style");
            }
  
            for(var x=0;x<=10;x++){
              jQuery('#factory'+x+'').css("display","none");
            }
  
            
          }
       
  
       function saveFactoryDetails()
       {
        
         var checked = "";
          var emailValidator=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
            
              var client_code =jQuery('#hidden_client_code').val();
              var factory_name = jQuery('#factory_name').val();
              var factory_address_local = jQuery('#factory_address_local').val();
              var factory_country = jQuery('#factory_country').val();
            /*   var factory_country_name = jQuery('#factory_country option:selected').text();
              var factory_state =  jQuery('#factory_state option:selected').text();
              var factory_city =  jQuery('#factory_city option:selected').text(); */
              var factory_state_id =  jQuery('#hidden_factory_state_id').val();
              var factory_city_id =  jQuery('#factory_city').val();

              var factory_country_name = jQuery('#factory_country option:selected').text();
              var factory_state = jQuery('#factory_state').val();
              //var factory_state =  jQuery('#factory_state').val();
              var factory_city =  jQuery('#factory_city').val();
  
              var factory_address = factory_city +', '+ factory_state +', '+factory_country_name;
  
              var contact_person = jQuery('.contact_person');
              var contact_person_email = jQuery('.contact_person_email');
              var contact_person_number = jQuery('.contact_person_number');
              var f_contact_person_tel_number = jQuery('.f_contact_person_tel_number');
              var factory_contact_skype= jQuery('.contact_skype');
              var factory_contact_wechat = jQuery('.contact_wechat');
              var factory_contact_whatsapp= jQuery('.contact_whatsapp');
              var factory_contact_qqmail = jQuery('.contact_qqmail');
  
              var c_person = [];
              var c_person_email = [];
              var c_person_number = [];
              var c_person_tel_number = [];
              var f_contact_skype= [];
              var f_contact_wechat = [];
              var f_contact_whatsapp = [];
              var f_contact_qqmail = [];
            
          
              var count_null=0; //variable for counting the null values

  
              for(var i = 0; i < factory_contact_skype.length; i++){
                var g_data=$(factory_contact_skype[i]).val();
               
                if(g_data==""){
                  f_contact_skype.push("N/A");
                 
                }else{
                  f_contact_skype.push(g_data);
                }
              }
  
  
              for(var i = 0; i < factory_contact_wechat.length; i++){
                var g_data=$(factory_contact_wechat[i]).val();
               
                if(g_data==""){
                  f_contact_wechat.push("N/A");
                 
                }else{
                  f_contact_wechat.push(g_data);
                }

              }
  
              for(var i = 0; i < factory_contact_whatsapp.length; i++){
                var g_data=$(factory_contact_whatsapp[i]).val();
               

                 if(g_data==""){
                  f_contact_whatsapp.push("N/A");
                 
                }else{
                  f_contact_whatsapp.push(g_data);
                }

              }
              
              for(var i = 0; i < factory_contact_qqmail.length; i++){
                var g_data=$(factory_contact_qqmail[i]).val();
               
                if(g_data==""){
                  f_contact_qqmail.push("N/A");
                 
                }else{
                  f_contact_qqmail.push(g_data);
                }

              }
             
             

              var message;

              
              var array_id_name = ['factory_name','factory_address_local','factory_country','factory_state','factory_city','contact_person','contact_person_email','contact_person_number','f_contact_person_tel_number'];


var message_array = ['factory name','factory address_local','factory country','factory state','factory city','contact person','contact person email','contact person number','Factory contact person tel. number'];


              for (var index = 0; index < array_id_name.length; index++) {
                var element = $('#'+array_id_name[index]+'').val();
                if(array_id_name[index]=='contact_person'||array_id_name[index]=='contact_person_email'||array_id_name[index]=='contact_person_number'||array_id_name[index]=='f_contact_person_tel_number'){
                  var a =contactPerson(array_id_name[index]);
             console.log(a);
             if(a==true){
             }else{ 
              message=message_array[index];
              break;
             }
                }else{
                if(element==""){

                count_null+=1;
                  $('#'+array_id_name[index]+'').css("border","1px solid red");
                message=message_array[index];
                 // console.log(index);
                  break;
                }else{
                  $('#'+array_id_name[index]+'').removeAttr("style");

                }

              }
              }

    function contactPerson(state){
    var returnData=0;
console.log(state);

        if(state=="contact_person"){
      for(var i = 0; i < contact_person.length; i++){
        
                var g_data=$(contact_person[i]).val();
                c_person.push(g_data);
                if(g_data==""){
                  count_null+=1;
                  returnData+=1;
                  $(contact_person[i]).css("border","1px solid red");
                }else{
                  $(contact_person[i]).removeAttr("style");
                }
      }  
   }else if(state=="contact_person_email"){
              for(var i = 0; i < contact_person_email.length; i++){
                var g_data=$(contact_person_email[i]).val();
                c_person_email.push(g_data);
                if(g_data==""){
                  count_null+=1;

                   returnData+=1;
                  $(contact_person_email[i]).css("border","1px solid red");
                }else{
                  $(contact_person_email[i]).removeAttr("style");
                }

               // joe regex
                if(emailValidator.test(g_data) ){
  
                  if(checked=="Not Ok"){

                      }else{
                      checked="ok";
                      }
                    
                }else{
               
                checked="Not Ok"
                }
               
              }
   }else if(state=="contact_person_number"){
              for(var i = 0; i < contact_person_number.length; i++){
                var g_data=$(contact_person_number[i]).val();
                c_person_number.push(g_data);
                if(g_data==""){
                  count_null+=1;
                  returnData+=1;
                  $(contact_person_number[i]).css("border","1px solid red");
                }else{
                  $(contact_person_number[i]).removeAttr("style");
                }
              }
 }else if(state=="f_contact_person_tel_number"){
              for(var i = 0; i < f_contact_person_tel_number.length; i++){
                var g_data=$(f_contact_person_tel_number[i]).val();
                c_person_tel_number.push(g_data);
                if(g_data==""){
                  count_null+=1;
                  returnData+=1;
                  $(f_contact_person_tel_number[i]).css("border","1px solid red");
                }else{
                  $(f_contact_person_tel_number[i]).removeAttr("style");
                }
              }
    }


    if(returnData>=1){
  return false;

}else{
 return true;

} 
      
      
           }       /*   array_id_name.forEach(element => {
              var val=$('#'+element).val();
                if(val==""){
                  
                  count_null+=1;
                  $('#'+element).css("border","1px solid red");
               
                }else{
                  $('#'+element).removeAttr("style");
                }
              }); */
             
              if(count_null==0){

                 if(checked=="Not Ok"){

                for(var i = 0; i < contact_person_email.length; i++){
                  var g_data=$(contact_person_email[i]).val();
                    $(contact_person_email[i]).removeAttr("style");

                     if(emailValidator.test(g_data)){
             
              }else{
               
                $(contact_person_email[i]).css("border","1px solid red");
              
                }
              
    }
    alert("Please Input Corect Email!");
}else{
  $('.send-loading ').show();
                $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
              });

              $.ajax({
                 type:'POST',
                 url:'/client-postnewfactory',
                 data:{
                   client_code:client_code,
                   factory_name:factory_name,
                   factory_address:factory_address,
                   factory_address_local:factory_address_local,
                   factory_country:factory_country,
                   factory_country_name:factory_country_name,
                   factory_city:factory_city,
                   factory_state:factory_state,
                   factory_city_id:factory_city_id,
                   factory_state_id:factory_state_id,
  
                   contact_person:c_person,
                   contact_person_email:c_person_email,
                   contact_person_number:c_person_number,
                   c_person_tel_number:c_person_tel_number,
                   factory_contact_skype:f_contact_skype,
                   factory_contact_wechat:f_contact_wechat,
                   factory_contact_whatsapp:f_contact_whatsapp,
                   factory_contact_qqmail:f_contact_qqmail
                    },
                 success:function(data){        
                  $('.send-loading').hide();
                  swal({
                      title: "Success",
                      text: "Factory successfully added!",
                      type: "success",
                  }, function() {
                    getFactoryList();
                    $('#newFactory').modal('toggle');
                  });
              },
              error: function(){
                alert("Error: Server encountered an error. Please try again or contact your system administrator.");
              }
              });
}
              }else{
                alert(message+" are Required");
              }

              
        
  
       }

      function getFactoryList(){
        var client_code = $('#hidden_client_code').val();

        $.ajax({
           type:'GET',
           url:'/get-factory/'+client_code,
           success:function(data){        
            console.log(data);
            var result=JSON.stringify(data);
            $('.factory').empty();
            $('.factory').append('<option value="">Select Factory</option>');
            data.factories.forEach(element => {
              $('.factory').append('<option value="'+element.id+'">'+element.factory_name+'</option>');
            });
          },
          error: function(data){
            console.log(data);
          }
        });       
      }
  
    function showAllCountry(){
          $('#factory_country').empty();
          $('#factory_country').append('<option value="">Please Wait...</option>');
          $.ajax({         
              url: 'http://world.t-i-c.asia/webapi_world_controller.php'            
            , type: 'POST'
              , datatype: 'json'
              , data: {
                  show_all_country: 1
              }
              , success: function (result) {
                  //localStorage.setItem("result",result);
                
                  $('#factory_country').empty();
                          $('#factory_country').append('<option value="">Select Country</option>');
                //var data_country=  JSON.parse(result);
                data_country=result;
                data_country.forEach(element => {
                      if(element.name=="" || element.name==null){
  
                      }else{
                          $('#factory_country').append('<option value="'+element.id+'">'+element.name+'</option>');
                      }
                     
                  });
                 
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $('#factory_country').empty();
          $('#factory_country').append('<option value="">Something went wrong. Please try again.</option>');
  
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
  
      $('#factory_country').on('change', function() {
        showStateByCountry();
        textInputValidator(this.id);
      });
  
       $('#factory_state').on('change', function() {
        showCityByCountryAndState();
        textInputValidator(this.id);
      });
  
      var source_state=[];

$('#factory_state').autocomplete({
  maxResults: 10,
  source: function(request, response) {
    var results = $.ui.autocomplete.filter(source_state, request.term);
    
    response(results.slice(0, this.options.maxResults));
  },
  select: function (event, ui) {
      $("#factory_state").val(ui.item.label); // display the selected text
      $("#hidden_factory_state_id").val(ui.item.value); // save selected id to hidden input
      //showCityByCountryAndStateInCompany('inspector_country','hidden_inspector_state','');
      return false;
  }
});


  function showStateByCountry(){
          var id = $('#factory_country').val();
          var country_name = $('#factory_country option:selected').text();
          //$('#hcountry_name').val(country_name);
          //$('#factory_state').empty();
          //$('#factory_state').append('<option value="">Please Wait...</option>');
          $("#factory_state").val('Please wait...');
          $.ajax({         
              url: 'http://world.t-i-c.asia/webapi_state_controller.php?id='+id            
              , type: 'GET'
              , datatype: 'json'
              , data: {
                  show_all_country: 1
              }
              , success: function (result) {
                  //console.log(result);
                  //$('#factory_state').empty();
                  //$('#factory_state').append('<option value="">Select State</option>');
                  /* var data_country=  JSON.parse(result); */
                  var data_country= result;
                  source_state.length = 0;
                  data_country.forEach(element => {
                      if(element.name=="" || element.name==null){
  
                      }else{
                          //$('#factory_state').append('<option value="'+element.id+'">'+element.name+'</option>');
                          source_state.push({value:element.id,label:element.name});
                      }                  
                  });
                  $("#factory_state").val('');
                 
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $('#factory_state').empty();
                  $('#factory_state').append('<option value="">Something went wrong. Please try again.</option>');
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

$('#factory_city').autocomplete({
  maxResults: 10,
  source: function(request, response) {
      var results = $.ui.autocomplete.filter(source_city, request.term);
      
      response(results.slice(0, this.options.maxResults));
    }
});

$( "#factory_city" ).autocomplete( "option", "appendTo", ".eventInsForm" );
  
      function showCityByCountryAndState(){
          var cid = $('#factory_country').val();
          var sid = $('#hidden_factory_state_id').val();

          $('#factory_city').val('Please Wait...');
          $.ajax({         
              url: 'http://world.t-i-c.asia/webapi_city_controller.php?state_id='+sid
              , type: 'GET'
              , datatype: 'json'
              , data: {
                  show_all_country: 1
              }
              , success: function (result) {
                  console.log(result);
                  //$('#factory_city').empty();
                  //$('#factory_city').append('<option value="">Select City</option>');
          //var data_city=  JSON.parse(result);
          var data_city=  result;
          source_city.length = 0;
                  data_city.forEach(element => {
                      if(element.name=="" || element.name==null){
  
                      }else{
                         // $('#factory_city').append('<option value="'+element.id+'">'+element.name+'</option>');
                         source_city.push(element.name);
                      }                  
                  });
                  $('#factory_city').val('');
       
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $('#mfactory_city').empty();
                  $('#mfactory_city').append('<option value="">Something went wrong. Please try again.</option>');
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
  
    function addMoreFields(){
      var max_fields = 10;
      var new_field_html = '<div><div class="col-md-4"><div class="form-group"><label for="contact_person">Contact Person</label><input type="text" name="contact_person" onchange="checkeds2()" id="contact_person" class="form-control" required><div id="factory7" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_person_email">Email Address</label><input type="email" name="contact_person_email" onchange="checkeds2()" id="contact_person_email" class="form-control" required><div id="factory8" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_person_number">Contact Number</label><input type="text" name="contact_person_number" onchange="checkeds2()" id="contact_person_number" class="form-control numeric" required><div id="factory9" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_skype">Skype</label><input type="text" name="contact_skype"  id="contact_skype" class="form-control" required><div id="factory10" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_wechat">We Chat</label><input type="text" name="contact_wechat"  id="contact_wechat" class="form-control" required><div id="factory11" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_whatsapp">WhatsApp</label><input type="text" name="contact_whatsapp" id="contact_whatsapp" class="form-control" required><div id="factory12" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div><div class="col-md-4"><div class="form-group"><label for="contact_qqmail">QQ Mail</label><input type="text" name="contact_qqmail"  id="contact_qqmail" class="form-control" required><div id="factory13" style="display:none" ><p style="color:red;">This field is required! </p></div></div></div></div>';
      var input_count = 1;
      // Add button dynamically
      $('#btn_add_more').click(function(){
        if(input_count < max_fields){
          input_count++;
          $('#div_more_factory').append(new_field_html);
        }
      });
  
      // Remove dynamically added button
      $('#div_more_factory').on('click', '.remove_input_button', function(e){
        e.preventDefault();
        $(this).parent('div').remove();
          input_count--;
        });
      }
  
      $('#btn_add_more_fields_fact').click(function() {
          $('.f-clone-inputs:first').clone().appendTo('.fac-clone').find("input").val("");
          $('.f-clone-inputs:last').append('<div class="col-md-1">' +
              '<div class="form-group"><br>' +
              '<button type="button" class="btn btn-danger btn-rm" onclick="removeFields()"><i class="fa fa-times"></i></button>' +
              '</div>' +
              '</div>');
      });
  
      $('body').on('click', '.btn-rm', function() { 
        $(this).closest('.f-clone-inputs').remove();
      });
  
      function textInputValidator(input_id){
       if(jQuery('#'+input_id).val()!=""){
            jQuery('#'+input_id).removeAttr("style");
        }
     }
     function multipleTextValidator(input_class){
       if(jQuery('.'+input_class).val()!=""){
            jQuery('.'+input_class).removeAttr("style");
        }
     }
  
        </script>