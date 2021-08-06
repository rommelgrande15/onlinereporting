


<div id="updateFactory" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg ui-front">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Factory Information</h4>
      </div>
      <form data-parsley-validate='' method="POST" action="" id="form_edit_factory">       
        {!!csrf_field()!!}      
        <div class="modal-body">
          <div class="row">   
            <div class="col-md-4">
              <div class="form-group">
                <label for="factory_name">Factory Name</label>
                <input type="text" name="update_factory_name" class="form-control validate_input" id="update_factory_name" required >   
                  <input type="hidden" name="update_factory_id" id="update_factory_id"  class="form-control">
                  <input type="hidden" name="update_country_id" id="update_country_id"  class="form-control">
                  <input type="hidden" name="update_state_id" id="update_state_id"  class="form-control">
                  <input type="hidden" name="update_city_id" id="update_city_id"  class="form-control">            
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="factory_number"><span class="text-danger">*</span> Factory Code / Number</label>
                <input type="text" name="update_factory_number" class="form-control validate_input" id="update_factory_number" required>
              </div>
            </div>
           
              <div class="col-md-4">
                <div class="form-group">
                  <label for="factory_country">Country</label>
                  <select class="form-control validate_input" required  name="update_factory_country" id="update_factory_country" >
                    <option disabled selected>--Select Country--</option>            
                  </select>
                </div>
              </div>



              <div class="col-md-6">
              <div class="form-group">
                <label for="update_factory_address_local"><span class="text-danger">*</span> Factory City (English)</label>
                <input type="text" name="update_factory_city" class="form-control validate_input"  id="update_factory_city" required onchange="textInputValidator(this.id)">
              </div>
            </div>


            <div class="col-md-6">
              <div class="form-group">
                <label for="update_factory_address"><span class="text-danger">*</span> Factory Address (English)</label>
                <input type="text" name="update_factory_address" class="form-control validate_input"  id="update_factory_address" required onchange="textInputValidator(this.id)">
              </div>
            </div>



            <div class="col-md-6">
              <div class="form-group">
                <label for="update_factory_address_local">Factory City (Local Language)</label>
                <input type="text" name="update_factory_city_local" class="form-control "  id="update_factory_city_local" required onchange="textInputValidator(this.id)">
              </div>
            </div>


            <div class="col-md-6">
              <div class="form-group">
                <label for="update_factory_address_local">Factory Address (Local Language)</label>
                <input type="text" name="update_factory_address_local" class="form-control "  id="update_factory_address_local" required onchange="textInputValidator(this.id)">
              </div>
            </div>



              <div id="div_edit_more_fields">
              </div>
              <div class="cold-md-12">
                <button type="button" class="btn btn-success pull-left btn-add2"  title="Add More Contact Person" id="btn_add_more_contact_factory_id" style="margin-left:15px;"><i class="fa fa-plus"></i> Add More Contact Person </button>
              </div>
          </div>       
        </div><!-- end of modal body -->
        <div class="modal-footer">
           
          {!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
          {!! Form::button('<i class="fa fa-floppy-o"></i> Update Factory Details', ['class' => 'btn btn-success','type'=>'button','id'=>'btn_update_factory']) !!}
          <input type="hidden" id="contact_added" value="0">
          <input type="hidden" id="update_client_code" value="">
        </div>
      </form>
    </div>
  </div>
</div>



<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script>
  $(document).ready(function(){
    $('#btn_update_factory').click(function(){
      var add = $('#form_edit_factory .validate_input');
      var email_add = $('#form_edit_factory .validate_input_email');
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
        updateFactory();
        console.log('test');
      }else{
          swal({
              title: "Oops!",
              text: "Please check empty or invalid input fields!",
              type: "warning",
          });
      }
    });

    $('#btn_add_more_contact_factory_id').click(function(){
      $('#div_edit_more_fields').append('<div class="factory-clone">'+
            '<div class="clone-inputs">'+
            '  <div class="col-md-12">'+
            '      <h4>Factory Contact Person</h4>'+
            '      <hr>'+
            '  </div>'+
            '  <div class="col-md-4">'+              
            '    <div class="form-group">'+
            '        <label for="contact_person"><span class="text-danger">*</span> Contact Person</label>'+
            '        <input type="text" name="contact_person"  class="form-control new_contact_person validate_input" required>'+
            '    </div>'+
            '  </div>'+              
            '  <div class="col-md-4">'+
            '    <div class="form-group">'+
            '        <label for="contact_person_email"><span class="text-danger">*</span> Email Address</label>'+
            '        <input type="email" name="contact_person_email"  class="form-control new_contact_person_email validate_input_email" required>'+
            '    </div>'+
            '  </div>'+
            '  <div class="col-md-4">'+
            '    <div class="form-group">'+
            '        <label for="contact_person_number"><span class="text-danger">*</span> Mobile Number</label>'+
            '        <input type="text" name="contact_person_number"  class="form-control numeric new_contact_person_number validate_input" required>'+
            '    </div>'+
            '  </div>'+
            '  <div class="col-md-4">'+
            '    <div class="form-group">'+
            '        <label for="f_contact_person_tel_number"><span class="text-danger">*</span> Telephone Number</label>'+
            '        <input type="text" name="f_contact_person_tel_number"  class="form-control numeric new_contact_tel_person_number validate_input" required>'+
            '    </div>'+
            '  </div>'+          
            '  <div class="col-md-4">'+
            '    <div class="form-group">'+
            '        <label for="contact_skype">Skype</label>'+
            '        <input type="text" name="contact_skype"  class="form-control new_contact_skype" required>'+
            '    </div>'+
            '  </div>'+              
            '  <div class="col-md-4">'+
            '    <div class="form-group">'+
            '        <label for="contact_wechat">We Chat</label>'+
            '        <input type="text" name="contact_wechat"  class="form-control new_contact_wechat" required>'+
            '    </div>'+
            '  </div>'+        
            '  <div class="col-md-4">'+
            '    <div class="form-group">'+
            '        <label for="contact_whatsapp">WhatsApp</label>'+
            '        <input type="text" name="contact_whatsapp" class="form-control new_contact_whatsapp " required>'+
            '    </div>'+
            '  </div>'+                
            '  <div class="col-md-4">'+
            '    <div class="form-group">'+
            '        <label for="contact_qqmail">QQ Mail</label>'+
            '        <input type="text" name="contact_qqmail"  id="contact_qqmail" class="form-control new_contact_qqmail " required>'+
            '    </div>'+
            '  </div>'+
            ' <div class="col-md-4">'+
            '   <div class="form-group">'+
            '     <br><button type="button" class="btn btn-danger edit-btn-rm btn-block" style="margin-top:5px;"><i class="fa fa-times"></i> Delete</button>'+
            '   </div>'+
            ' </div>'+
            '</div>'+
          '</div>');
          var temp=parseInt($('#contact_added').val());
          var is_added=temp+1;
          $('#contact_added').val(is_added);
    });
    $('body').on('click', '.edit-btn-rm', function() { 
      $(this).closest('.clone-inputs').remove();
      var temp=parseInt($('#contact_added').val());
      var is_added=temp-1;
      $('#contact_added').val(is_added);
    });
  });

  function deleteFactoryCP(id){
    var sure_delete = confirm("Are you sure you want to delete this contact person?");
    var dis_btn = this;
    if (sure_delete) {
      $('.send-loading').show();                   
      $.ajax({
         type:'POST',
         url:'/delete-factory-cp',
         data:{
          _token: token,
          id:id
        },
         success:function(data){
           console.log(data);
           $('.send-loading ').hide();
            /* swal({
              title: "Success",
              text: "Successfully deleted",
              type: "success",
            }, function() {
              $('#'+id).remove();
            }); */
            swal({
              title: "Success",
              text: "Successfully deleted",
              type: "success",
            }, function() {
              $('#'+id).remove();
            });
          },
          error: function(err){
            console.log(err);
            $('.send-loading ').hide();
            swal({
                title: "Error",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
            
          }                             
      });
    }else{}
  }    
  function updateFactory(){
    $('.send-loading ').show();
    var IdcontactFactory = [];
    var update_contact_person =[];
    var update_contact_person_email =[];
    var update_contact_person_number =[];
    var update_contact_person_tel_number =[];
    var update_contact_skype = [];
    var update_contact_wechat =[];
    var update_contact_whatsapp =[];
    var update_contact_qqmail =[];
    var cIdcontactFactory = jQuery('.IdcontactFactory');
    var cupdate_contact_person = jQuery('.update_contact_person');
    var cupdate_contact_person_email = jQuery('.update_contact_person_email');
    var cupdate_contact_person_number = jQuery('.update_contact_person_number');
    var cupdate_contact_person_tel_number = jQuery('.update_contact_tel_person_number');
    var cupdate_contact_skype = jQuery('.update_contact_skype');
    var cupdate_contact_wechat = jQuery('.update_contact_wechat');
    var cupdate_contact_whatsapp = jQuery('.update_contact_whatsapp');
    var cupdate_contact_qqmail = jQuery('.update_contact_qqmail');

    var new_contact_person =[];
    var new_contact_person_email =[];
    var new_contact_person_number =[];
    var new_contact_person_tel_number =[];
    var new_contact_skype = [];
    var new_contact_wechat =[];
    var new_contact_whatsapp =[];
    var new_contact_qqmail =[];
    var cnew_contact_person = jQuery('.new_contact_person');
    var cnew_contact_person_email = jQuery('.new_contact_person_email');
    var cnew_contact_person_number = jQuery('.new_contact_person_number');
    var cnew_contact_person_tel_number = jQuery('.new_contact_tel_person_number');
    var cnew_contact_skype = jQuery('.new_contact_skype');
    var cnew_contact_wechat = jQuery('.new_contact_wechat');
    var cnew_contact_whatsapp = jQuery('.new_contact_whatsapp');
    var cnew_contact_qqmail = jQuery('.new_contact_qqmail');

    for(var i = 0; i < cIdcontactFactory.length; i++){
      var g_data=$(cIdcontactFactory[i]).val();
      IdcontactFactory.push(g_data);    
    }
    update_contact_person = classGetData(cupdate_contact_person);
    update_contact_person_email = classGetData(cupdate_contact_person_email);
    update_contact_person_number = classGetData(cupdate_contact_person_number);
    update_contact_person_tel_number = classGetData(cupdate_contact_person_tel_number);
    update_contact_skype = classGetData(cupdate_contact_skype);
    update_contact_wechat = classGetData(cupdate_contact_wechat);
    update_contact_whatsapp = classGetData(cupdate_contact_whatsapp);
    update_contact_qqmail = classGetData(cupdate_contact_qqmail);

    new_contact_person = classGetData(cnew_contact_person);
    new_contact_person_email = classGetData(cnew_contact_person_email);
    new_contact_person_number = classGetData(cnew_contact_person_number);
    new_contact_person_tel_number = classGetData(cnew_contact_person_tel_number);
    new_contact_skype = classGetData(cnew_contact_skype);
    new_contact_wechat = classGetData(cnew_contact_wechat);
    new_contact_whatsapp = classGetData(cnew_contact_whatsapp);
    new_contact_qqmail = classGetData(cnew_contact_qqmail);

    console.log(new_contact_person);
    

    var update_factory_id =jQuery('#update_factory_id').val();      
    var update_factory_name = jQuery('#update_factory_name').val();     
    var update_factory_number = jQuery('#update_factory_number').val();      
    
    var update_factory_country = jQuery('#update_factory_country').val();
    var update_factory_country_name = jQuery('#update_factory_country option:selected').text();        
    var update_factory_state_id= jQuery('#update_factory_state_id').val();           
    var update_factory_city_id = jQuery('#update_factory_city').val();

    var update_factory_city = jQuery('#update_factory_city').val();
    var update_factory_address_local = jQuery('#update_factory_address_local').val();

    var update_factory_address = jQuery('#update_factory_address').val();
    var update_factory_city_local = jQuery('#update_factory_city_local').val();




    var update_factory_state= jQuery('#update_factory_state').val();
    //var update_factory_address = update_factory_city +' '+ update_factory_state +' '+ update_factory_country_name;
    var contact_added= jQuery('#contact_added').val();
    var client_code= jQuery('#update_client_code').val();      
    $.ajax({
      type:'POST',
      url:'/admin-updatefactory',
      data:{
        _token: token,
        client_code:client_code,
        update_factory_id:update_factory_id,
        update_factory_name:update_factory_name,
        update_factory_number:update_factory_number,
        update_factory_address:update_factory_address,
        update_factory_address_local:update_factory_address_local,
        update_factory_country:update_factory_country,
        update_factory_country_name:update_factory_country_name,

        update_factory_city_local:update_factory_city_local,
        update_factory_address:update_factory_address,

        update_factory_state:update_factory_state,
        update_factory_state_id:update_factory_state_id,
        update_factory_city:update_factory_city,
        update_factory_city_id:update_factory_city_id,
        IdcontactFactory:IdcontactFactory,
        update_contact_person:update_contact_person,
        update_contact_person_email:update_contact_person_email,
        update_contact_person_number:update_contact_person_number,
        update_contact_person_tel_number:update_contact_person_tel_number,
        update_contact_skype:update_contact_skype,
        update_contact_wechat:update_contact_wechat,
        update_contact_whatsapp:update_contact_whatsapp,
        update_contact_qqmail:update_contact_qqmail,
        contact_added:contact_added,
        new_contact_person:new_contact_person,
        new_contact_person_email:new_contact_person_email,
        new_contact_person_number:new_contact_person_number,
        new_contact_person_tel_number:new_contact_person_tel_number,
        new_contact_skype:new_contact_skype,
        new_contact_wechat:new_contact_wechat,
        new_contact_whatsapp:new_contact_whatsapp,
        new_contact_qqmail:new_contact_qqmail
      },
      success:function(data){            
        $('.send-loading ').hide();
        swal({
            title: "Success",
            text: "Factory successfully updated",
            type: "success",
        }, function() {
            location.reload();
        });
      },
      error: function(err){
        console.log(err);
        swal({
            title: "Error",
            text: "Error: Server encountered an error. Please try again or contact your system administrator.",
            type: "error",
        });
        $('.send-loading ').hide();
      }
    });
  }

  function classGetData(cname){
    var array_data= new Array();
    for(var i = 0; i < cname.length; i++){
      var g_data=$(cname[i]).val();
      if(g_data==""){
        array_data.push('N/A');
      }else{
        array_data.push(g_data);
      }
    }
    return array_data;
  }

     function updateFCPerson(id)
     {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var update_contact_person = jQuery('#update_contact_person'+id).val();
            var update_contact_person_email = jQuery('#update_contact_person_email'+id).val();
            var update_contact_person_number = jQuery('#update_contact_person_number'+id).val();

             var update_contact_skype = jQuery('#update_contact_skype'+id).val();
            var update_contact_wechat = jQuery('#update_contact_wechat'+id).val();
            var update_contact_whatsapp = jQuery('#update_contact_whatsapp'+id).val();
            var update_contact_qqmail = jQuery('#update_contact_qqmail'+id).val();
            
            $.ajax({
               type:'POST',
               url:'/postupdatefactorycontactperson',
               data:{
                 update_contact_person:update_contact_person,
                 update_contact_person_email:update_contact_person_email,
                 update_contact_person_number:update_contact_person_number,
                 update_contact_id:id,
                 update_contact_skype:update_contact_skype,
                 update_contact_wechat:update_contact_wechat,
                 update_contact_whatsapp:update_contact_whatsapp,
                 update_contact_qqmail:update_contact_qqmail
                },
               success:function(data){
              window.location.href = 'factorylist';
                alert("Updated");
                //redirect()->route('clientcontacts',$client->client_code);
            }
   
            });

     }

    $('#update_factory_state').autocomplete({
      maxResults: 10,
      source: function(request, response) {
        var results = $.ui.autocomplete.filter(update_source_state, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	},
      select: function (event, ui) {
          $("#update_factory_state").val(ui.item.label); // display the selected text
          $("#update_factory_state_id").val(ui.item.value); // save selected id to hidden input
          showCityByCountryAndStateChange();
          return false;
      }
    });

     function showStateByCountryChange() {
     var id = $('#update_factory_country').val();
     textInputValidator('update_factory_country');
     $('#update_factory_state').val('Please wait...');
    $.ajax({
        url: '/get-state/' + id,
        type: 'GET',
        success: function(result) {
          update_source_state.length = 0;
            //var data_country = result;
            var data_country = JSON.parse(result);
            $('#update_factory_state').val('');
            $.each(data_country, function(i, element) {
                if (element.name == "" || element.name == null) {

                } else {
                    //$('#update_factory_state').append('<option value="' + element.id + '">' + element.name + '</option>');
                    update_source_state.push({ value: element.id, label: element.name });
                }
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_factory_state').empty();
            $('#update_factory_state').append('<option value="">Something went wrong. Please try again.</option>');
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

$('#update_factory_city').autocomplete({
    maxResults: 10,
		source: function(request, response) {
        var results = $.ui.autocomplete.filter(update_source_city, request.term);
        
        response(results.slice(0, this.options.maxResults));
    	}
  });

function showCityByCountryAndStateChange() {

     var cid = $('#update_factory_country').val();
     var sid = $('#update_factory_state_id').val();
     textInputValidator('update_factory_state');
     $('#update_factory_city').val('Please wait...');
    //$('#update_factory_city').empty();
    //$('#update_factory_city').append('<option value="">Please Wait...</option>');
    $.ajax({
        url: '/get-city/' + sid,
        type: 'GET',
        success: function(result) {
            //console.log(result);
            //$('#update_factory_city').empty();
            //$('#update_factory_city').append('<option value="">Select City</option>');
            var data_city=  JSON.parse(result);
            $('#update_factory_city').val('');
            //var data_city = result;
            update_source_city.length = 0;
            $.each(data_city, function(i, element) { 
                if (element.name == "" || element.name == null) {

                } else {
                    //$('#update_factory_city').append('<option value="' + element.id + '">' + element.name + '</option>');
                    update_source_city.push(element.name);
                }
            });


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_factory_city').empty();
            $('#update_factory_city').append('<option value="">Something went wrong. Please try again.</option>');
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


      </script>