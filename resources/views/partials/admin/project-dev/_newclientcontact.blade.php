<div id="newClientContact" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form action="" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Contact</h4>
      </div>
      <div class="modal-body">
          {{csrf_field()}}
          <div class="form-group">
              <input type="hidden" name="client_code" id="add_client_code" class="form-control" readonly>
          </div>
     
          <div class="form-group">
              <label for="contact_person">Contact Person</label> 
              <input type="text" name="add_contact_person" id="add_contact_person" class="form-control" required>
              <div id="field11" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>
          
          <div class="form-group">
              <label for="contact_person_email">Email Addresaaas</label>
              <input type="email" name="add_contact_person_email" id="add_contact_person_email" class="form-control" required>
              <div id="field12" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>

          <div class="form-group">
              <label for="contact_person_number">Contact Number</label>
              <input type="text" name="add_contact_person_number" id="add_contact_person_number" class="form-control numeric" required>
              <div id="field13" style="display:none" ><p style="color:red;">This field is required! </p></div>
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
        <button class="btn btn-success" id="saveclientcontact" type="button"><i class="fa fa-floppy-o"></i> Save Contact Details</button>
      </div>
      </form>
    </div>

  </div>
</div>

<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
      <!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
      <script>
      jQuery(document).ready(function(){
       // jQuery('#save').prop('disabled', true);

        jQuery('#add_contact_person').keyup(function(e){
          if(jQuery('#add_contact_person').val()!=""){
            jQuery('#add_contact_person').removeAttr("style");
            jQuery('#field11').css("display","none");
          }
        });

jQuery('#add_contact_person_email').keyup(function(e){
          if(jQuery('#add_contact_person_email').val()!=""){
            jQuery('#add_contact_person_email').removeAttr("style");
            jQuery('#field12').css("display","none");
          }
        });

        jQuery('#add_contact_person_number').keyup(function(e){
          if(jQuery('#add_contact_person_number').val()!=""){
            jQuery('#add_contact_person_number').removeAttr("style");
            jQuery('#field13').css("display","none");
          }
        });

        jQuery('#saveclientcontact').click(function(e){
          for(var x=0;x<=2;x++)  
              {
              if(jQuery('#add_contact_person').val()==""){
                  jQuery('#add_contact_person').css('border-color', 'red');
                  document.getElementById('field11').style.display = 'block';
                  x=3;
                  
                }else if(jQuery('#add_contact_person_email').val()==""){
                  jQuery('#add_contact_person_email').css('border-color', 'red');
                  jQuery('#field12').css("display","block");
                  x=3;
                }
                else if(jQuery('#add_contact_person_number').val()==""){
                  jQuery('#add_contact_person_number').css('border-color', 'red');
                  jQuery('#field13').css("display","block");
                  x=3;
                }
                else{
          jQuery("#formData").attr("action", "{{route('addclientcontact')}}");
         // $('#clr').click();
          //alert("Success");
          x=3;
                }
              }
        });
      });

   
      </script>