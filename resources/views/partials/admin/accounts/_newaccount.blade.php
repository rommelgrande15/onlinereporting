<div id="newAccountModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <form method="POST" action="">
    <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Account</h4>
        </div>
        <div class="modal-body">
          {!!csrf_field()!!}
          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" minlength="6" id="password" name="password" required>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-6">

                  <div class="form-group">
                      <label for="email">Email address:</label>
                      <input type="email" class="form-control" name="email" id="email" required>
                    </div>
              </div>
              <div class="col-md-6">
               
                  <div class="form-group">
                      <label for="password_confirmation">Confirm Password</label>
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" minlength="11" maxlength="15" class="form-control numeric" name="contact_number" id="contact_number" required>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Account Name:</label>
                    <input type="text" class="form-control" name="account_name" id="account_name" required>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Designation:</label>
                    <select name="designation" id="designation" class="form-control" required>
                        <option value="">Select Designation</option>
                        <option value="administrator">System Administrator</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="sales">Sales</option>
                        <option value="reports_review">Reports Review</option>
                        <option value="booking">Booking</option>
                        <option value="client">Client</option>
                        <option value="factory">Factory</option>
                    </select>
                  </div>
              </div>
          </div>

          <div class="row" id="BookingState" style="display:none">
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Group:</label>
                    <select name="GroupSection" id="GroupSection" class="form-control" required>
                        <option value="">Select Group</option>
                        <option value="administrator">TIC</option>
                        <option value="super_admin">SERA</option>
                        <option value="Others">Others</option>
                    </select>
                  </div>
              </div>
          </div>


          <div class="row"  id="groupInput" style="display:none">
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="groupInputdata">Input group name:</label>
                    <input type="text"  class="form-control" name="groupInputdata" id="groupInputdata" required>
                  </div>
              </div>
            
          </div>
       

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" onclick="AddnewAccount()" class="btn btn-success" >Save Details</button>
        </div>
      </div>
      <!-- Modal content end-->
    </form>
  </div>
</div>

<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>

<script>
  $(document).ready(function(){

    $("#designation").change(function() {
      if($("#designation").val()=="booking"){
       $('#BookingState').show();
      }else{
        $('#BookingState').hide();

      }

    });


    $("#GroupSection").change(function() {
      if($("#GroupSection").val()=="Others"){
       $('#groupInput').show();
      }else{
        $('#groupInput').hide();

      }

    });

  });

function AddnewAccount(){
  var emailValidator=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
var count_null=0;
  var array_Id=[
    'username',
    'password',
    'email',
    'password_confirmation',
    'contact_number',
    'account_name',
    'designation'

  ];
var message;
  var array_message=[
    'Username',
    'Password',
    'Email',
    'Password confirmation',
    'Contact number',
    'Account name',
    'Designation'

  ];
  for (let index = 0; index < array_Id.length; index++) {
  
    const element = $('#'+array_Id[index]+'').val();
            if(element==""){
                  count_null+=1;
                  $('#'+array_Id[index]+'').css("border","1px solid red");
                  message=array_message[index];
                  break;
                }else{
                  $('#'+array_Id[index]+'').removeAttr("style");
                }
  }
  if(count_null<=0){
 var username= document.getElementById('username').value;
 var password= document.getElementById('password').value;
 var email= document.getElementById('email').value;
 var contact_number= document.getElementById('contact_number').value;
 var account_name= document.getElementById('account_name').value;
 var designation= document.getElementById('designation').value;

 var GroupSection= document.getElementById('GroupSection').value;
 var groupInputdata = document.getElementById('groupInputdata').value;


 //var address= document.getElementById('address').value;
 
 if(emailValidator.test(email)){
if(password==$('#password_confirmation').val()){
  $('.send-loading ').show();
  $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

                                       $.ajax({
                                                  type:'POST',
                                                  url:'/postnewaccount',
                                                  data:{username:username,email:email,password:password,account_name:account_name,contact_number:contact_number,designation:designation,GroupSection:GroupSection,groupInputdata:groupInputdata},
                                                  success:function(data){
                                                   
                                                   alert("New account successfully created");
                                                   $('.send-loading ').hide();
                                                   location.reload();
                                                   //setTimeout(function(){  location.reload(); }, 1000);
                                                  
                                                   //redirect()->route('clientcontacts',$client->client_code);
                                                   }
   
                                               });

}else{
  alert("Password not Match!");
}
  

 }else{

  alert("Please Input Corect Email!");
  $('#email').css("border","1px solid red");
}
}else{

   alert(message+" are Required");
}

}

</script>