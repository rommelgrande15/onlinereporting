<div id="updateContact" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Contact</h4>
      </div>
      <div class="modal-body">
          {{csrf_field()}}
          <div class="form-group">
              <label for="client_name">Client Code</label>
             
            
          <input readonly type="text" name="client_code" id="update_contact_name" class="form-control" required>
            
            
              <input type="hidden" name="contact_id" id="update_contact_id">
          </div>
     
          <div class="form-group">
              <label for="contact_person">Contact Person</label>
              <input type="text" name="contact_person" id="update_contact_person" onchange="checkeds()" class="form-control" required>
              <div id="update0" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
              <label for="contact_person_email">Email Address</label>
              <input type="email" name="contact_person_email" id="update_contact_person_email" onchange="checkeds()" class="form-control" required>
              <div id="update1" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
              <label for="contact_person_number">Contact Number</label>
              <input type="text" name="contact_person_number" id="update_contact_person_number" onchange="checkeds()" class="form-control numeric" required>
              <div id="update2" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
        <button class="btn btn-success" onclick="test()" type="button"><i class="fa fa-floppy-o"></i> Save Contact Details</button>
      </div>
      </form>
    </div>

  </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

      <script>

      
var idd =[
'update_contact_person',
'update_contact_person_email',
'update_contact_person_number'
];


function checkeds()
        {
         
          for(var x=0;x<=2;x++){
          jQuery('#'+idd[x]+'').removeAttr("style");
          }

          for(var x=0;x<=3;x++){
            jQuery('#update'+x+'').css("display","none");
          }
        }
  
     function test()
     {
     
      checkeds();
      for(var x=0;x<=2;x++){
      if(jQuery('#'+idd[x]+'').val()=="")
      {
        jQuery('#update'+x+'').css("display","block");
        jQuery('#'+idd[x]+'').css('border-color', 'red');
        x=4;
      }else if(x==2) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var contact_id =jQuery('#update_contact_id').val();
            var client_code = jQuery('#update_contact_name').val();
            var contact_person = jQuery('#update_contact_person').val();
            var contact_person_email = jQuery('#update_contact_person_email').val();
            var contact_person_number = jQuery('#update_contact_person_number').val();
            $.ajax({
               type:'POST',
               url:'/updatecontact',
               data:{client_code:client_code, contact_person:contact_person,contact_person_email:contact_person_email,contact_person_number:contact_person_number,contact_id:contact_id},
               success:function(data){
              window.location.href = ''+client_code+'';
                alert("success");
                //redirect()->route('clientcontacts',$client->client_code);
   }
   
            });
$('#clr').click();
      }
    }
     }
      </script>