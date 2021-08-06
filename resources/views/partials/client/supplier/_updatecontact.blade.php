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
          {!!csrf_field()!!}
          <div class="form-group">
              <label for="client_name">Factory Name</label>
               <input type="text" name="factory_name" id="update_factory_name" class="form-control" readonly required>
              <input type="hidden" class="form-control" name="contact_id" id="update_contact_id">
          </div>
     
          <div class="form-group">
              <label for="contact_person">Contact Person</label>
              <input type="text" name="update_contact_person" id="update_contact_person" class="form-control" required>
              <div id="updateFacCon0" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
              <label for="contact_person_email">Email Address</label>
              <input type="email" name="update_contact_person_email" id="update_contact_person_email" class="form-control" required>
              <div id="updateFacCon1" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
              <label for="contact_person_number">Contact Number</label>
              <input type="text" name="contact_person_number" id="update_contact_person_number" class="form-control numeric" required>
              <div id="updateFacCon2" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
        <button class="btn btn-success" id="clicks" type="button"><i class="fa fa-floppy-o"></i> Update Contact Details</button>
      </div>
      </form>
    </div>

  </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

      <script>

function test2()
        {
         
          for(var x=0;x<=4;x++){
          jQuery('#'+fact[x]+'').removeAttr("style");
          }

          for(var x=0;x<=4;x++){
            jQuery('#contactF'+x+'').css("display","none");
          }
        }

jQuery(document).ready(function(){      

var fact =[
'update_contact_person',
'update_contact_person_email',
'update_contact_person_number'

];


function test2keds()
        {
         
          for(var x=0;x<=4;x++){
          jQuery('#'+fact[x]+'').removeAttr("style");
          }

          for(var x=0;x<=4;x++){
            jQuery('#updateFacCon'+x+'').css("display","none");
          }
        }
  
        jQuery('#clicks').click(function(e)
     {
    // alert("sad");
    test2keds();
      for(var x=0;x<=4;x++){
      if(jQuery('#'+fact[x]+'').val()=="")
      {
        jQuery('#updateFacCon'+x+'').css("display","block");
        jQuery('#'+fact[x]+'').css('border-color', 'red');
        x=5;
      }else if(x==4) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var contact_id =jQuery('#update_contact_id').val();
            var contact_person = jQuery('#update_contact_person').val();
            var contact_person_email = jQuery('#update_contact_person_email').val();
            var contact_person_number = jQuery('#update_contact_person_number').val();
            
            $.ajax({
               type:'POST',
               url:'/udpatefactorycontact',
               data:{update_contact_id:contact_id,contact_person:contact_person,contact_person_email:contact_person_email,contact_person_number:contact_person_number },
               success:function(data){
                location.reload();
                alert("updated");
                //redirect()->route('clientcontacts',$client->client_code);
   }
   
            });
$('#clr').click();
      }
    }
     });
});
      </script> 