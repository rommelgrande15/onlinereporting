<div id="newContact" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="" id ="formData"  name ="formData" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Contact</h4>
      </div>
      <div class="modal-body">
          {{csrf_field()}}
          <div class="form-group">
              <label for="client_name">Client Name</label>
              <select name="new_client_name" class="form-control" onchange="checkeds()"; id="new_client_name">
                  <option>--Select Client---</option>
                  @foreach($clients as $c)
                    <option value="{{$c->client_code}}">{{$c->client_name}}</option>
                  @endforeach
              </select>
              <div id="field0" style="display:none" ><p style="color:red;">This field is required! </p></div>
              <input type="hidden" value="" name="new_client_code" id="new_client_code"class="form-control" readonly>
          </div>
     
          <div class="form-group">
              <label for="contact_person">Contact Person</label>
              <input type="text" name="contact_person" id="contact_person" onkeyup="checkeds()"  class="form-control" required>
              <div id="field1" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
              <label for="contact_person_email">Email Address</label>
              <input type="email" id="contact_person_email" name="contact_person_email" onkeyup="checkeds()"  class="form-control" required>
              <div id="field2" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
              <label for="contact_person_number">Contact Number</label>
              <input type="text" name="contact_person_number"id="contact_person_number"  onkeyup="checkeds()"  class="form-control numeric" required>
              <div id="field3" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" id="clr" name="clr" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
        <button class="btn btn-success"  onclick="test()" type="button"><i class="fa fa-floppy-o"></i> Save Contact Details</button>
      </div>
      </form>
    </div>

  </div>
</div>

<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

      <script>

      
var id =[
'new_client_name',
'contact_person',
'contact_person_email',
'contact_person_number'
];


function checkeds()
        {
         
          for(var x=0;x<=3;x++){
          jQuery('#'+id[x]+'').removeAttr("style");
          }

          for(var x=0;x<=3;x++){
            jQuery('#field'+x+'').css("display","none");
          }
        }
  
     function test()
     {
      
      checkeds();
      for(var x=0;x<=3;x++){
      if(jQuery('#'+id[x]+'').val()=="" || jQuery('#'+id[x]+'').val()=="--Select Client---" )
      {
        jQuery('#field'+x+'').css("display","block");
        jQuery('#'+id[x]+'').css('border-color', 'red');
        x=4;
      }else if(x==3) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            
            var client_code = jQuery('#new_client_code').val();
            var client_name = jQuery('#new_client_name').val();
            var contact_person = jQuery('#contact_person').val();
            var contact_person_email = jQuery('#contact_person_email').val();
            var contact_person_number = jQuery('#contact_person_number').val();

            $.ajax({
               type:'POST',
               url:'/addclientcontact',
               data:{client_code:client_code,client_name:client_name, contact_person:contact_person,contact_person_email:contact_person_email,contact_person_number:contact_person_number},
               success:function(data){
                window.location.href = 'clientcontacts/'+client_code+'';
                alert("success");
                //redirect()->route('clientcontacts',$client->client_code);
   }
   
            });
$('#clr').click();
      }
    }
     }
      </script>