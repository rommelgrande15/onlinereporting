<div id="contact-person-modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <form data-parsley-validate='' id="form-order-contact-person">
        {!!csrf_field()!!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Contact Persons</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div id="div_edit_more_fields_client"></div>
        </div>
        <div class="row" id="add_more_contact_person" style="display:none;">
            <div class="col-md-12">
              <hr>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <label for="add_contact_person">Contact Person</label>
                  <input type="text" name="add_contact_person" id="add_contact_person" class="form-control client_contact_person" required>
                </div>
              </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="add_contact_person_email">Contact Person Email</label>
                <input type="text" name="add_contact_person_email" id="add_contact_person_email" class="form-control validate_input_email" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="add_contact_person_mobile">Contact Mobile Number</label>
                <input type="text" name="add_contact_person_mobile" id="add_contact_person_mobile" class="form-control client_contact_person" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="add_contact_person_tel">Contact Telephone Number</label>
                <input type="text" name="add_contact_person_tel" id="add_contact_person_tel" class="form-control client_contact_person" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="add_contact_person_skype">Skype</label>
                <input type="text" name="add_contact_person_skype" id="add_contact_person_skype" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="add_contact_person_wechat">We Chat</label>
                <input type="text" name="add_contact_person_wechat" id="add_contact_person_wechat" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="add_contact_person_whatsapp">WhatsApp</label>
                <input type="text" name="add_contact_person_whatsapp" id="add_contact_person_whatsapp" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="add_contact_person_qq">QQ Mail</label>
                <input type="text" name="add_contact_person_qq" id="add_contact_person_qq" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                  <br/>
                  <button class="btn btn-success btn-block" id="btn-save-new-contact" type="button" style="margin-top:5px;"><i class="fa fa-plus"></i> Save</button>
                </div>
              </div>
        </div>
        <div class="row">
          <div class="col-md-4">
              {!! Form::button('<i class="fa fa-plus"></i> Add New Contact Person', ['class' => 'btn btn-success','id'=>'add_more_contact_person','type'=>'button']) !!}
          </div>
        </div>
      </div>
      <div class="modal-footer">
        {!! Form::button('<i class="fa fa-ban"></i> Close', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
        {{-- {!! Form::button('<i class="fa fa-floppy-o"></i> Save Product Details', ['class' => 'btn btn-success','id'=>'contact_person_']) !!} --}}
      </div>
       </form>
    </div>

  </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>

 function setEnEy(cb_id,text_id,group_class,btn_id){
      if ($('#'+cb_id).prop('checked')==true) {    
        $('#'+text_id).attr('disabled','disabled');
        $('#'+text_id).val('N/A'); 
        $('.'+group_class).remove();   
        $('#'+btn_id).attr('disabled','disabled');
      }else{
        $('#'+text_id).removeAttr("disabled");      
        $('#'+text_id).val('');
        $('#'+btn_id).removeAttr("disabled"); 
      }

    }

  function updateContactData(contact_id){
      var add_client_code =$('#hidden_client_code').val();
      var add_contact_person =$('#update_contact_person'+contact_id).val();
      var add_contact_person_email =$('#update_contact_person_email'+contact_id).val();
      var add_contact_person_number =$('#update_contact_person_number'+contact_id).val();
      var add_contact_tel_number =$('#update_contact_tel_number'+contact_id).val();
      var add_client_skype =$('#update_client_skype'+contact_id).val();
      var add_client_wechat =$('#update_client_wechat'+contact_id).val();
      var add_client_whatsapp =$('#update_client_whatsapp'+contact_id).val();
      var add_client_qqmail =$('#update_client_qqmail'+contact_id).val();

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
       type:'POST',
       url:'/client-updateclientcontact',
       data:
       {
          contact_id:contact_id,
          client_code:add_client_code,
          contact_person:add_contact_person,
          contact_person_email:add_contact_person_email,
          contact_person_number:add_contact_person_number,
          contact_person_tel_number:add_contact_tel_number,
          client_skype:add_client_skype,
          client_wechat:add_client_wechat,
          client_whatsapp:add_client_whatsapp,
          client_qqmail:add_client_qqmail
        
        },
        beforeSend: function() {
          $('.send-loading ').show();
        },
       success:function(data){
        $('.send-loading ').hide();
        swal({
              title: "Success!",
              text: "Contact person has been updated",
              type: "success",
          }, function() {
            $('#contact-person-modal').modal('toggle');
            getClientContactList();
          });
        },
      error: function(response){
        $('.send-loading ').hide();
        console.log(response);
        swal({
            title: "Error!",
            text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
            type: "error",
        });
      }
      }); 
  }
  $('.client_contact_person').change(function() {
      var val = $(this).val();
      if (val == '' || val == null) {
          $(this).css("border", "1px solid red");
      } else {
          $(this).removeAttr("style");
      }
  });

  $('#form-order-contact-person .validate_input_email').change(function(){
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
  $('#btn-save-new-contact').click(function(){
    var cont_req = $('.client_contact_person');
    var email_add = $('#form-order-contact-person .validate_input_email');
    var count_null = 0;
    var email_err = 0;
    for (var i = 0; i < cont_req.length; i++) {
        var data = $(cont_req[i]).val();
        if (data == "") {
            $(cont_req[i]).css("border", "1px solid red");
            count_null += 1;
        } else {
            $(cont_req[i]).removeAttr("style");
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
    if(count_null==0 && email_err==0){
      var add_client_code =$('#hidden_client_code').val();
      var add_contact_person =$('#add_contact_person').val();
      var add_contact_person_email =$('#add_contact_person_email').val();
      var add_contact_person_number =$('#add_contact_person_mobile').val();
      var add_contact_tel_number =$('#add_contact_person_tel').val();
      var add_client_skype =$('#add_contact_person_skype').val();
      var add_client_wechat =$('#add_contact_person_wechat').val();
      var add_client_whatsapp =$('#add_contact_person_whatsapp').val();
      var add_client_qqmail =$('#add_contact_person_qq').val();

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
       type:'POST',
       url:'/client-addclientcontact',
       data:
       {
          client_code:add_client_code,
          contact_person:add_contact_person,
          contact_person_email:add_contact_person_email,
          contact_person_number:add_contact_person_number,
          contact_person_tel_number:add_contact_tel_number,
          client_skype:add_client_skype,
          client_wechat:add_client_wechat,
          client_whatsapp:add_client_whatsapp,
          client_qqmail:add_client_qqmail
        
        },
        beforeSend: function() {
          $('.send-loading ').show();
        },
       success:function(data){
        $('.send-loading ').hide();
        swal({
              title: "Success!",
              text: "New contact person has been added",
              type: "success",
          }, function() {
            $('#contact-person-modal').modal('toggle');
            $('.client_contact_person').val("");
            $('#add_more_contact_person').hide();
            getClientContactList();
          });
        },
      error: function(response){
        $('.send-loading ').hide();
        console.log(response);
        swal({
            title: "Error!",
            text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
            type: "error",
        });
      }
      }); 
    }else{
      swal({
          title: "Oops!",
          text: "Please check empty or invalid input fields",
          type: "warning",
      });
    }
  });

  function getClientContactList(){
      var client_code =$('#hidden_client_code').val();
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
       type:'GET',
       url:'/get-client-contacts/'+client_code,
       success:function(data){
        console.log(data);
        var result=JSON.stringify(data);
        $('.contact_persons').empty();
        $('.contact_persons').append('<option value="">Select Contact</option>');
        $.each(data.contacts, function(i, element) {
          $('.contact_persons').append('<option value="'+element.id+'">'+element.contact_person+'</option>');
        });
        }
      }); 
  }
  function isEmail(email) {
    var regex=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;  
    return regex.test(email);
  }
</script>