<div id="addClientContactPerson" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
       {!!Form::open()!!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Contact Person</h4>
      </div>
      <div class="modal-body">
        {{-- <div class="col-md-12">
          <div class="form-group">            
            <h4 class="modal-title">Contact Person</h4>
          </div>
        </div> --}}
        <div class="row">
          <div class="col-md-12">
            
            <label class="pull-right"><span class="text-danger">*</span> <i>Indicate required fields</i></label><br/>
            <label>Add contact person for <span id="add_contact_for"></span></label><br/>
          </div>
      <div class="client-clone-addcontactperson">
        <div class="clone-inputs-addcontactperson">
            <div class="col-md-12">
                <hr>
            </div>
      <div class="col-md-4">

          <div class="form-group">

              {!!Form::label('add_contact_person','<span class="text-danger">*</span> Contact Person',['class'=>''],false)!!}
              {{-- {{Form::text('contact_person',null,['class'=>'form-control contact_person'])}} --}}
              <input type="text" id="add_contact_person" name="add_contact_person" class="form-control add_contact_person" onkeyup="addContactPersonValidator('add_contact_person')">
              

          </div>
      </div>

    <div class="col-md-4">
      <div class="form-group">

          {!!Form::label('add_contact_person_email','<span class="text-danger">*</span> Email Address',['class'=>''],false)!!}
          {{-- {{Form::email('contact_person_email',null,['class'=>'form-control contact_person_email'])}} --}}
         <input type="email" id="add_contact_person_email" name="add_contact_person_email" class="form-control add_contact_person_email" onkeyup="addContactPersonValidator('add_contact_person_email')">

      </div>
      </div>

      <div class="col-md-4">
      <div class="form-group">
          {!!Form::label('add_contact_person_number','<span class="text-danger">*</span> Mobile Number',['class'=>''],false)!!}
          {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
          <input type="text" id="add_contact_person_number" name="add_contact_person_number" class="form-control add_contact_person_number" onkeyup="addContactPersonValidator('add_contact_person_number')">
      </div>
      </div>

      <div class="col-md-4">
          <div class="form-group">
              {!!Form::label('add_tel_number','<span class="text-danger">*</span> Telephone Number',['class'=>''],false)!!}
              {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
              <input type="text" id="add_tel_number" name="add_tel_number" class="form-control add_tel_number" onkeyup="addContactPersonValidator('add_tel_number')">
          </div>
          </div>

      <div class="col-md-4">
          <div class="form-group">
              {!!Form::label('add_client_skype','Skype',['class'=>''])!!}
              {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
              <input type="text" id="add_client_skype" name="add_client_skype" class="form-control add_client_skype" onkeyup="addContactPersonValidator('add_client_skype')">
          </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                {!!Form::label('add_client_wechat','We Chat',['class'=>''])!!}
                {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
                <input type="text" id="add_client_wechat" name="add_client_wechat" class="form-control add_client_wechat" onkeyup="addContactPersonValidator('add_client_wechat')">
            </div>
          </div>

          <div class="col-md-4">
              <div class="form-group">
                  {!!Form::label('add_client_whatsapp','WhatsApp',['class'=>''])!!}
                  {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
                  <input type="text" id="add_client_whatsapp" name="add_client_whatsapp" class="form-control add_client_whatsapp" onkeyup="addContactPersonValidator('add_client_whatsapp')">
              </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {!!Form::label('add_client_qqmail','QQ Mail',['class'=>''])!!}
                    {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
                    <input type="text" id="add_client_qqmail" name="add_client_qqmail" class="form-control add_client_qqmail" onkeyup="addContactPersonValidator('add_client_qqmail')">
                </div>
              </div>

    </div>
  </div>
  <div class="col-md-12">
    <div class="form-group">
           <button class="btn btn-success" type="button" id="btn_add_more_client_contact"><i class="fa fa-plus"></i> Add more contact person</button>
    </div>
  </div>
</div>
      </div>
      <div class="modal-footer">
        {{-- <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
        <button class="btn btn-success" type="button" id="save_client_contact"><i class="fa fa-floppy-o"></i> Save contact person</button> --}}
        <input type="hidden" id="hidden_client_code" >
        <input type="hidden" id="dataID" >
        {!! Form::button('<i class="fa fa-ban"></i> Close', ['class' => 'btn btn-danger clr','data-dismiss' => "modal", 'id'=>'save_client_contact1']) !!}
        {!! Form::button('<i class="fa fa-floppy-o"></i>  Save contact person', ['class' => 'btn btn-success', 'id'=>'save_client_contact']) !!}
      {{--   {{ Form::button('<i class="fa fa-floppy-o"></i>  Save contact person1', ['class' => 'btn btn-success', 'id'=>'save_client_contact1']) }} --}}
      </div>
    </div>

  </div>
</div>






<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script>
  function view(){

    
    $('#addClientContactPerson').modal('toggle');
   
    $.ajax({
            url: '/getoneclients/' + $('#dataID').val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('.client_added_row').remove();
                $('#tr_street_num').remove();

                $('#view_comp_name').text(response.Company_Name);
                $('#view_comp_code').text(response.client_code);
                $('#view_comp_email').text(response.Company_Email);
                $('#view_comp_phone').text(response.Phone_number);

                $('#view_comp_country').text(response.company_country_name);
                $('#view_comp_state').text(response.company_state_name);
                $('#view_comp_city').text(response.company_city_name);
                $('#view_comp_zip_code').text(response.zip_code);
                $('#view_comp_bldg').text(response.company_bldg_num);
                $('#view_comp_house_num').text(response.house_number);
                $('#view_comp_street_num').text(response.street_number);

                $('#view_inv_comp_country').text(response.company_invoice_country_name);
                $('#view_inv_comp_state').text(response.company_invoice_state_name);
                $('#view_inv_comp_city').text(response.company_invoice_city_name);
                $('#view_inv_comp_zip_code').text(response.company_inv_zip_code);
                $('#view_inv_comp_bldg').text(response.company_inv_bldg_num);
                $('#view_inv_comp_house_num').text(response.company_inv_house_num);
                $('#view_inv_comp_street_num').text(response.company_inv_street_num);


                if (response.company_country_name == response.company_invoice_country_name && response.company_state_name == response.company_invoice_state_name && response.company_city_name == response.company_invoice_city_name && response.zip_code == response.company_inv_zip_code && response.company_bldg_num == response.company_inv_bldg_num && response.house_number == response.company_inv_house_num && response.street_number == response.company_inv_street_num) {
                    $('#same_as_address').show();
                    $('.not_same_as_address').hide();
                } else {
                    $('#same_as_address').hide();
                    $('.not_same_as_address').show();
                }

                //var comp_addr = response.house_number + ', ' + response.street_number + ', ' + response.company_city_name + ', ' + response.company_state_name + ', ' + response.company_country_name;

                //var comp_inv_addr = response.company_inv_house_num + ', ' + response.company_inv_street_num + ', ' + response.company_invoice_city_name + ', ' + response.company_invoice_state_name + ', ' + response.company_invoice_country_name;
                //$('#view_comp_address').text(comp_addr);
                //$('#view_comp_inv_address').text(comp_inv_addr);
                var pay_terms = 'Special Terms: ' + response.special_term;
                if (response.payment_term == 'special_terms') {

                    $('#view_comp_payment_terms').text(pay_terms);
                } else {
                    $('#view_comp_payment_terms').text(response.payment_term);
                }



                $('#table_view_client > tbody:last-child').append('<tr class="client_added_row" style="background-color:lightgrey"><th colspan="4"><h4>2. Client Contact Person</h4></th></tr>');
                var count_contact = 0;
                response.client_contact_list.forEach(element => {
                    count_contact += 1;
                    $('#table_view_client > tbody:last-child').append('<tr class="client_added_row">' +
                        '<th>Contact Person ' + count_contact + ' :</th>' +
                        '<td colspan="3">' + element.contact_person + '</td>' +
                        '</tr>' +

                        '<tr class="client_added_row">' +
                        '<th>Contact Person Email :</th>' +
                        '<td>' + element.email_address + '</td>' +
                        '<th>Mobile Number :</th>' +
                        '<td>' + element.contact_number + '</td>' +
                        '</tr>' +

                        '<tr class="client_added_row">' +
                        '<th>Telephone Number :</th>' +
                        '<td>' + element.tel_number + '</td>' +
                        '<th>Skype :</th>' +
                        '<td>' + element.client_skype + '</td>' +
                        '</tr>' +

                        '<tr class="client_added_row">' +
                        '<th>We Chat :</th>' +
                        '<td>' + element.client_wechat + '</td>' +
                        '<th>WhatsApp :</th>' +
                        '<td>' + element.client_whatsapp + '</td>' +
                        '</tr>' +

                        '<tr class="client_added_row">' +
                        '<th>QQ Mail :</th>' +
                        '<td colspan="3">' + element.client_qqmail + '</td>' +
                        '</tr>' +
                        '<tr class="client_added_row">' +
                        '<td colspan="4"></td>' +
                        '</tr>');
                });
                setTimeout(function(){ $('#viewClientDetails').modal('show'); }, 1000);
                
            }

        });
  }
  $(document).ready(function(){

   $('#save_client_contact1').click(function(e){
    view();

   });

    $('#save_client_contact').click(function(e){
      var checked;
      var emailValidator=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
          var add_client_code = $('#hidden_client_code').val();
          var add_c_person = $('.add_contact_person');
          var add_c_person_email = $('.add_contact_person_email');
          var add_c_person_number = $('.add_contact_person_number');
          var add_c_tel_number = $('.add_tel_number');

          var add_c_client_skype = $('.add_client_skype');  
          var add_c_client_wechat = $('.add_client_wechat');       
          var add_c_client_whatsapp = $('.add_client_whatsapp');  
          var add_c_client_qqmail = $('.add_client_qqmail');  

          var add_contact_person = [];
          var add_contact_person_email = [];
          var add_contact_person_number = []; 
          var add_contact_tel_number = []; 

          var add_client_skype = [];  
          var add_client_wechat = [];        
          var add_client_whatsapp = [];  
          var add_client_qqmail = [];  

          var add_count_null=0; //variable for counting the null values

          for(var i = 0; i < add_c_person.length; i++){
            var g_data=$(add_c_person[i]).val();
            add_contact_person.push(g_data);
            if(g_data==""){
              add_count_null+=1;
              $(add_c_person[i]).css("border","1px solid red");
            }else{
              $(add_c_person[i]).removeAttr("style");
            }
          }
          for(var i = 0; i < add_c_person_email.length; i++){
            var g_data=$(add_c_person_email[i]).val();
            add_contact_person_email.push(g_data);
            if(g_data==""){
              add_count_null+=1;
              $(add_c_person_email[i]).css("border","1px solid red");
            }else{
              $(add_c_person_email[i]).removeAttr("style");
            }

            
            if(emailValidator.test(g_data) ){

 if(checked=="Not Ok"){

}else{
checked="ok";
}
}else{

checked="Not Ok"
}


          }
          for(var i = 0; i < add_c_person_number.length; i++){
            var g_data=$(add_c_person_number[i]).val();
            add_contact_person_number.push(g_data);
            if(g_data==""){
              add_count_null+=1;
              $(add_c_person_number[i]).css("border","1px solid red");
            }else{
              $(add_c_person_number[i]).removeAttr("style");
            }
          }

          for(var i = 0; i < add_c_tel_number.length; i++){
            var g_data=$(add_c_tel_number[i]).val();
            add_contact_tel_number.push(g_data);
            if(g_data==""){
              add_count_null+=1;
              $(add_c_tel_number[i]).css("border","1px solid red");
            }else{
              $(add_c_tel_number[i]).removeAttr("style");
            }
          }


           for(var i = 0; i < add_c_client_skype.length; i++){
            var g_data=$(add_c_client_skype[i]).val();
            add_client_skype.push(g_data);
            /* if(g_data==""){
              add_count_null+=1;
              $(add_c_client_skype[i]).css("border","1px solid red");
            }else{
              $(add_c_client_skype[i]).removeAttr("style");
            } */
          }

           for(var i = 0; i < add_c_client_wechat.length; i++){
            var g_data=$(add_c_client_wechat[i]).val();
            add_client_wechat.push(g_data);
            /* if(g_data==""){
              add_count_null+=1;
              $(add_c_client_wechat[i]).css("border","1px solid red");
            }else{
              $(add_c_client_wechat[i]).removeAttr("style");
            } */
          }

          for(var i = 0; i < add_c_client_whatsapp.length; i++){
            var g_data=$(add_c_client_whatsapp[i]).val();
            add_client_whatsapp.push(g_data);
            /* if(g_data==""){
              add_count_null+=1;
              $(add_c_client_whatsapp[i]).css("border","1px solid red");
            }else{
              $(add_c_client_whatsapp[i]).removeAttr("style");
            } */
          }

           for(var i = 0; i < add_c_client_qqmail.length; i++){
            var g_data=$(add_c_client_qqmail[i]).val();
            add_client_qqmail.push(g_data);
           /*  if(g_data==""){
              add_count_null+=1;
              $(add_c_client_qqmail[i]).css("border","1px solid red");
            }else{
              $(add_c_client_qqmail[i]).removeAttr("style");
            } */
          }
          console.log(add_count_null);

          console.log(add_contact_person);
          console.log(add_contact_person_email);
          console.log(add_contact_person_number);
          console.log(add_client_skype);
          console.log(add_client_wechat);
          console.log(add_client_whatsapp);
          console.log(add_client_qqmail);

//add_count_null=1;
if(add_count_null==0){
  console.log(checked);
         if(checked=="Not Ok"){
               // alert("Please Input Corect Email!");

  for(var i = 0; i < add_c_person_email.length; i++){
            var g_data=$(add_c_person_email[i]).val();
           
            $(add_c_person_email[i]).removeAttr("style");

     if(emailValidator.test(g_data)){

        }else{
        alert("Please Input Corect Email!");
        $(add_c_person_email[i]).css("border","1px solid red");
        
        }

                
          }


}else{
  $('.send-loading ').show();
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });

            $.ajax({
               type:'POST',
               url:'/addclientcontact',
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
               success:function(data){
           
                alert("Client contact person successfully added.");
                $('.send-loading ').hide();
               view();
               // location.reload();
                $('.add_contact_person').val('');
                $('.add_contact_person_email').val('');
                $('.add_contact_person_number').val('');
                $('.add_tel_number').val('');
                $('.add_client_skype').val('');  
                $('.add_client_wechat').val('');       
                $('.add_client_whatsapp').val('');  
                $('.add_client_qqmail').val('');  
              },
              error: function(){
                alert("Error: Server encountered an error. Please try again or contact your system administrator.");
              }
            }); 
}
            }else{
            alert("Please fill-up all the fields!");
          } 
    });

     $('#btn_add_more_client_contact').click(function() {
        $('.clone-inputs-addcontactperson:first').clone().appendTo('.client-clone-addcontactperson').find("input").val("");
        $('.clone-inputs-addcontactperson:last').append('<div class="col-md-1">' +
            '<div class="form-group"><br>' +
            '<button type="button" class="btn btn-danger btn-rm-cp"><i class="fa fa-times"></i></button>' +
            '</div>' +
            '</div>');
    });

    $('body').on('click', '.btn-rm-cp', function() {
      $(this).closest('.clone-inputs-addcontactperson').remove();
    });

  }); 

 

    function addContactPersonValidator(class_name){
       if(jQuery('.'+class_name).val()!=""){
            jQuery('.'+class_name).removeAttr("style");
        }
     }

</script>
{!!Form::close()!!}
