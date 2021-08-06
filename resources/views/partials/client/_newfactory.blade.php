<div id="newFactory" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg ui-front">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add new Factory</h4>
      </div>
      <form data-parsley-validate='' method="POST" action="" id="form_add_factory">
      {!!csrf_field()!!}   
      <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="factory_name"><span class="text-danger">*</span> Factory Name</label>
                <input type="text" name="factory_name" class="form-control validate_input" id="factory_name">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="factory_number"><span class="text-danger">*</span> Factory Code / Number</label>
                <input type="text" name="factory_number" class="form-control validate_input" id="factory_number" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="factory_country"><span class="text-danger">*</span> Country</label>
                <select class="form-control validate_input" required name="factory_country" id="factory_country">
                  <option value="">--Select Country--</option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="factory_address_local"><span class="text-danger">*</span> Factory City (English)</label>
                <input type="text" name="factory_city" class="form-control validate_input" id="factory_city" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="factory_address2"><span class="text-danger">*</span> Factory Address (English)</label>
                <input type="text" name="factory_address2" class="form-control validate_input" id="factory_address2" required>
              </div>
            </div>



            <div class="col-md-6">
              <div class="form-group">
                <label for="factory_address_local">Factory City (Local Language)</label>
                <input type="text" name="factory_city_local" class="form-control " id="factory_city_local" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="factory_address_local">Factory Address (Local Language)</label>
                <input type="text" name="factory_address_local" class="form-control " id="factory_address_local" required>
              </div>
            </div>
    
          <div class="col-md-12">
            <div class="form-group">
              <hr/>
            </div>
          </div>
          <div class="factory-clone">
            <div class="f-clone-inputs">
              <div class="col-md-12">
                  <h4>Factory Contact Person</h4>
                  <hr>
              </div>
              <div class="col-md-4">              
                <div class="form-group">
                    <label for="contact_person"><span class="text-danger">*</span> Contact Person</label>
                    <input type="text" name="contact_person"  id="contact_person" class="form-control contact_person validate_input" required>
                </div>
              </div>              
              <div class="col-md-4">
                <div class="form-group">
                    <label for="contact_person_email"><span class="text-danger">*</span> Email Address</label>
                    <input type="email" name="contact_person_email"  id="contact_person_email" class="form-control contact_person_email validate_input_email" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label for="contact_person_number"><span class="text-danger">*</span> Mobile Number</label>
                    <input type="text" name="contact_person_number" id="contact_person_number" class="form-control numeric contact_person_number validate_input" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label for="f_contact_person_tel_number"><span class="text-danger">*</span> Telephone Number</label>
                    <input type="text" name="f_contact_person_tel_number"  id="f_contact_person_tel_number" class="form-control numeric f_contact_person_tel_number validate_input" required>
                </div>
              </div>          
              <div class="col-md-4">
                <div class="form-group">
                    <label for="contact_skype">Skype</label>
                    <input type="text" name="contact_skype"  id="contact_skype" class="form-control contact_skype" required>
                </div>
              </div>              
              <div class="col-md-4">
                <div class="form-group">
                    <label for="contact_wechat">We Chat</label>
                    <input type="text" name="contact_wechat"  id="contact_wechat" class="form-control contact_wechat" required>
                </div>
              </div>        
              <div class="col-md-4">
                <div class="form-group">
                    <label for="contact_whatsapp">WhatsApp</label>
                    <input type="text" name="contact_whatsapp" id="contact_whatsapp" class="form-control contact_whatsapp " required>
                </div>
              </div>                
              <div class="col-md-4">
                <div class="form-group">
                    <label for="contact_qqmail">QQ Mail</label>
                    <input type="text" name="contact_qqmail"  id="contact_qqmail" class="form-control contact_qqmail " required>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <button class="btn btn-success" type="button" id="f_btn_add_more_fields"><i class="fa fa-plus"></i> Add more contact person</button>
            </div>
          </div>      
        </div>
      </div>
      <div class="modal-footer">
        {!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
        {!! Form::button('<i class="fa fa-floppy-o"></i> Save Factory Details', ['class' => 'btn btn-success','type'=>'button','id'=>'btn_save_factory']) !!}
      <input type="hidden" name="hidden_client_code" id="hidden_client_code" value="{{$client_code}}">
      </div>
    </form>
  </div>
</div>
</div>
  
  
  <script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
  <script>
    $(document).ready(function(){
    showAllCountry();
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

    $('#btn_save_factory').click(function(){
        var add = $('#form_add_factory .validate_input');
        var email_add = $('#form_add_factory .validate_input_email');
        var add_count_null = 0;
        var email_err = 0;
        for (var i = 0; i < add.length; i++) {
            var data = $(add[i]).val();
            if (data == "") {
                $(add[i]).css("border", "1px solid red");
                add_count_null += 1;               
            } else {
                $(add[i]).removeAttr("style");
            }
        }
        //for email
        for (var i = 0; i < email_add.length; i++) {
            var data = $(email_add[i]).val();
            if(!isEmail(data)) { 
              $(email_add[i]).css("border", "1px solid red");
              email_err += 1;   
            }else{
              $(email_add[i]).removeAttr("style");
            }
        }

        if(add_count_null==0 && email_err==0){
          saveFactoryDetails();
          console.log('test');
        }else{
            swal({
                title: "Oops!",
                text: "Please check empty or invalid input fields!",
                type: "warning",
            });
        }
    });
    $('#form_add_factory .validate_input').change(function(){
        var val= $(this).val();
        if(val=='' || val==null){              
            $(this).css("border", "1px solid red");
        }else{
            $(this).removeAttr("style");
        }
    });
    $('#form_add_factory .validate_input_email').change(function(){
        var val= $(this).val();
        if(val=='' || val==null){              
            $(this).css("border", "1px solid red");
        }else{          
            if(!isEmail(val)) { 
              $(this).css("border", "1px solid red");
            }else{
              $(this).removeAttr("style");
            }
        }
    });
    
  });
  
  function saveFactoryDetails(){      
    $('.send-loading ').show();
    var client_code = jQuery('#hidden_client_code').val();
    var supplier_id = jQuery('#supplier').val();
    var factory_name = jQuery('#factory_name').val();
    var factory_number = jQuery('#factory_number').val();
    var factory_address_local = jQuery('#factory_address_local').val();
    var factory_country = jQuery('#factory_country').val();
   /*  var factory_state_id =  jQuery('#hidden_factory_state_id').val(); */
    /* var factory_city_id =  jQuery('#factory_city').val(); */
    var factory_country_name = jQuery('#factory_country option:selected').text();
   /*  var factory_state = jQuery('#factory_state').val(); */


    var factory_city =  jQuery('#factory_city').val(); //eng
    var factory_address = jQuery('#factory_address2').val();//eng
    var factory_city_local = jQuery('#factory_city_local').val();//local
    var factory_address_local = jQuery('#factory_address_local').val();//local

    
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
  
    for(var i = 0; i < contact_person.length; i++){
      var g_data=$(contact_person[i]).val();   
      if(g_data==""){
        c_person.push("N/A");      
      }else{
        c_person.push(g_data);
      }
    } 
    for(var i = 0; i < contact_person_email.length; i++){
      var g_data=$(contact_person_email[i]).val();   
      if(g_data==""){
        c_person_email.push("N/A");      
      }else{
        c_person_email.push(g_data);
      }
    } 
    for(var i = 0; i < contact_person_number.length; i++){
      var g_data=$(contact_person_number[i]).val();   
      if(g_data==""){
        c_person_number.push("N/A");      
      }else{
        c_person_number.push(g_data);
      }
    } 
    for(var i = 0; i < f_contact_person_tel_number.length; i++){
      var g_data=$(f_contact_person_tel_number[i]).val();   
      if(g_data==""){
        c_person_tel_number.push("N/A");      
      }else{
        c_person_tel_number.push(g_data);
      }
    } 
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
    $.ajax({
      type:'POST',
      url:'/client-postnewfactory',
      data:{
        _token: token,
        client_code:client_code,
        supplier_id:supplier_id,
        factory_name:factory_name,
        factory_number:factory_number,
        factory_address:factory_address,
        factory_address_local:factory_address_local,
        factory_country:factory_country,
        factory_country_name:factory_country_name,
       /*  */
       /*  factory_state:factory_state, */
       /*  factory_city_id:factory_city_id, */
      /*   factory_state_id:factory_state_id, */

        factory_city:factory_city, 
        factory_address_local:factory_address_local,
        factory_city_local:factory_city_local,

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
        var fid=data.factory_id;
        $('.send-loading ').hide();
        $('#factory').append('<option value="'+fid+'">'+factory_name+'</option>');
          swal({
              title: "Success",
              text: "Factory successfully added",
              type: "success",
          }, function() {
              $('#newFactory').modal('toggle');
			  $('#form_add_factory')[0].reset();
          });
      },
      error: function(){
        swal({
            title: "Error",
            text: "Error: Server encountered an error. Please try again or contact your system administrator.",
            type: "error",
        });
        $('.send-loading ').hide();
      }
    });    
  }
  
    function showAllCountry(){
          $('#factory_country').empty();
          $('#factory_country').append('<option value="">Please Wait...</option>');
          $.ajax({         
              url: '/get-all-country/1'            
            , type: 'GET'
              , success: function (result) {                
                  $('#factory_country').empty();
                  $('#factory_country').append('<option value="">Select Country</option>');
                //data_country=result;
                var data_country = JSON.parse(result);
                  $.each(data_country, function(i, element) {
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
      return false;
  }
});


  function showStateByCountry(){
          var id = $('#factory_country').val();
          var country_name = $('#factory_country option:selected').text();
          $("#factory_state").val('Please wait...');
          $.ajax({         
              url: '/get-state/'+id            
              , type: 'GET'
              , success: function (result) {
                  //var data_country= result;
                  var data_country = JSON.parse(result);
                  source_state.length = 0;
                  $.each(data_country, function(i, element) {
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
              url: '/get-city/'+sid
              , type: 'GET'
              , success: function (result) {
                  console.log(result);
          //var data_city=  result;
          var data_city = JSON.parse(result);
          source_city.length = 0;
                  $.each(data_city, function(i, element) {
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

      $('#f_btn_add_more_fields').click(function() {
          $('.f-clone-inputs:first').clone().appendTo('.factory-clone').find("input").val("");
          $('.f-clone-inputs:last').append('<div class="col-md-4">' +
              '<div class="form-group"><br>' +
              '<button type="button" class="btn btn-danger f-btn-rm btn-block" style="margin-top:5px;" onclick="removeFields()"><i class="fa fa-times"></i> Delete</button>' +
              '</div>' +
              '</div>');
      });
  
      $('body').on('click', '.f-btn-rm', function() { 
        $(this).closest('.f-clone-inputs').remove();
      });
  

     function isEmail(email) {
      //var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      var regex=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;  
      return regex.test(email);
    }
    
  
        </script>