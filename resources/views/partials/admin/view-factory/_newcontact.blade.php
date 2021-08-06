<!-- <div id="newContact" class="modal fade" role="dialog">
  <div class="modal-dialog"> -->

    <!-- Modal content-->
    <!-- <div class="modal-content">
      <form action="{{route('addnewfactory')}}" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Contacts</h4>
      </div>
      <div class="modal-body">
          {{csrf_field()}}
          <div class="form-group">
            <label for="factory_id">Client Name</label>
            <select class="form-control" name="new_client_code" onchange="test2()" id="new_client_code">
                <option value="" >--Select Client--</option>
              {{--   @foreach($clients as $client)
                  <option value="{{$client->client_code}}">{{$client->client_name}}</option>
                @endforeach --}}
            </select>
            <div id="contactF0" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
            <label for="factory_id">Factory Name</label>
            <select class="form-control" name="factory_id" onchange="test2()" id="factory_id">
              <option value="">--Select Factory--</option>
            </select>
            <div id="contactF1" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>
        
     
          <div class="form-group">
              <label for="contact_person">Contact Person</label>
              <input type="text" name="contact_person" onchange="test2()" id="contact_person" class="form-control" required>
              <div id="contactF2" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
              <label for="contact_person_email">Email Address</label>
              <input type="email" name="contact_person_email" onchange="test2()" id="contact_person_email" class="form-control" required>
              <div id="contactF3" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
              <label for="contact_person_number">Contact Number</label>
              <input type="text" name="contact_person_number" onchange="test2()" id="contact_person_number" class="form-control numeric" required>
              <div id="contactF4" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
        <button class="btn btn-success" type="button" onclick="test()" id="clicks"><i class="fa fa-floppy-o"></i> Save Client Details</button>
      </div>
      </form>
    </div>

  </div>
</div>

 

<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
      </script>

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
'new_client_code',
'factory_id',
'contact_person',
'contact_person_email',
'contact_person_number'

];


function test2keds()
        {
         
          for(var x=0;x<=4;x++){
          jQuery('#'+fact[x]+'').removeAttr("style");
          }

          for(var x=0;x<=4;x++){
            jQuery('#contactF'+x+'').css("display","none");
          }
        }
  
        jQuery('#clicks').click(function(e)
     {
    // alert("sad");
    test2keds();
      for(var x=0;x<=4;x++){
      if(jQuery('#'+fact[x]+'').val()=="")
      {
        jQuery('#contactF'+x+'').css("display","block");
        jQuery('#'+fact[x]+'').css('border-color', 'red');
        x=5;
      }else if(x==4) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            var client_code =jQuery('#new_client_code').val();
            var factory_id = jQuery('#factory_id').val();
            var contact_person = jQuery('#contact_person').val();
            var contact_person_email = jQuery('#contact_person_email').val();
            var contact_person_number = jQuery('#contact_person_number').val();
            $.ajax({
               type:'POST',
               url:'/addnewfactory',
               data:{client_code:client_code,factory_id:factory_id,contact_person:contact_person,contact_person_email:contact_person_email,contact_person_number:contact_person_number },
               success:function(data){
                window.location.href = 'factorycontacts/'+factory_id+'';
                alert("success");
                //redirect()->route('clientcontacts',$client->client_code);
   }
   
            });
$('#clr').click();
      }
    }
     });
});
      </script>  -->