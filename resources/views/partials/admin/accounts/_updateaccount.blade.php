<div id="updateAccountModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form method="POST" action="">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Account Details</h4>
        </div>
        <div class="modal-body">
          {!!csrf_field()!!}
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="update_username" name="update_username" disabled>
                    <input type="hidden" class="form-control" id="update_id" name="update_id">
                  
                  </div>
              </div>
              <div class="col-md-6">
                 <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" name="update_email" id="update_email" readonly>
                 
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" minlength="11" maxlength="15" class="form-control numeric" name="update_contact_number" id="update_contact_number" required>
                    <div id="acc0" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Inspector Name:</label>
                    <input type="text" class="form-control" name="update_inspector_name" id="update_inspector_name" required>
                    <div id="acc1" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Designation:</label>
                    <select name="designation" id="update_designation" name="update_designation" class="form-control" required>
                        <option selected disabled>Select Designation</option>
                        <option value="administrator">System Administrator</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="sales">Sales</option>
                        <option value="reports_review">Reports Review</option>
                        <option value="booking">Booking</option>
                        <option value="client">Client</option>
                        <option value="intern">Intern</option>
                    </select>
                    <div id="acc2" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>
          </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" onclick="updatesAcc()" class="btn btn-success" >Save Details</button>
        </div>
      </div>
      <!-- Modal content end-->
    </form>
  </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

      <script>

      
var idds =[
'update_contact_number',
'update_inspector_name',
'update_designation'
];


function checkeds()
        {
         
          for(var x=0;x<=2;x++){
          jQuery('#'+idds[x]+'').removeAttr("style");
          }

          for(var x=0;x<=2;x++){
            jQuery('#acc'+x+'').css("display","none");
          }
        }
  
     function updatesAcc()
     {
    // alert("sds");
      checkeds();
      for(var x=0;x<=2;x++){
      if(jQuery('#'+idds[x]+'').val()=="")
      {
        jQuery('#acc'+x+'').css("display","block");
        jQuery('#'+idds[x]+'').css('border-color', 'red');
        x=4;
      }else if(x==2) {
        $('.send-loading ').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            
            var account_id = jQuery('#update_id').val();
            var contact_number = jQuery('#update_contact_number').val();
            var inspector_name = jQuery('#update_inspector_name').val();
            var email = jQuery('#update_email').val();
            var designation = jQuery('#update_designation').val();
            $.ajax({
               type:'POST',
               url:'/updateaccount',
               data:{account_id:account_id ,inspector_name:inspector_name,email:email,contact_number:contact_number,designation:designation},
               success:function(data){
                alert("Account successfully updated");
                $('.send-loading ').hide();
                location.reload();
                //setTimeout(function(){  location.reload(); }, 1000);
             
                //redirect()->route('clientcontacts',$client->client_code);
              },
                  error: function(){
                    alert("Error: Server encountered an error. Please try again or contact your system administrator.");
                  }
   
            });
$('#clr').click();
      }
    }
     }
      </script>