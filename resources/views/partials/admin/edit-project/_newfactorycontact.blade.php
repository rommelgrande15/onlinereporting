<div id="newFactoryContact" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add new Factory Contact</h4>
      </div>
      <div class="modal-body">
            <div class="form-group">
              <input type="hidden" name="new_factory_id" class="form-control" id="new_factory_id">
              <input type="hidden" name="new_factory_client_code" class="form-control" id="new_factory_client_code">
            </div>
            <div class="form-group">
              <label for="factory_name">Contact Person</label><span class="error_messages error_factory_contact_name"></span>
              <input type="text" name="new_factory_contact_name" class="form-control" id="new_factory_contact_name">
              <div id="remarks1" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
            <div class="form-group">
              <label for="factory_name">Contact Number</label><span class="error_messages error_factory_contact_number"></span>
              <input type="text" name="new_factory_contact_number" class="form-control numeric" id="new_factory_contact_number">
              <div id="remarks2" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
            <div class="form-group">
              <label for="factory_name">Factory Email</label><span class="error_messages error_factory_contact_email"></span>
              <input type="text" name="new_factory_contact_email" class="form-control" id="new_factory_contact_email">
              <div id="remarks3" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
      </div>
      <div class="modal-footer">
        {{ Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) }}
        {{ Form::button('<i class="fa fa-floppy-o"></i> Save Factory Details', ['class' => 'btn btn-success','id'=>'save_factory_contact']) }}
      </div>
       </form>
    </div>

  </div>
</div>

<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
      <!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
      <script>
      jQuery(document).ready(function(){
       // jQuery('#save').prop('disabled', true);

        jQuery('#new_factory_contact_name').keyup(function(e){
          if(jQuery('#new_factory_contact_name').val()!=""){
            jQuery('#new_factory_contact_name').removeAttr("style");
            jQuery('#remarks1').css("display","none");
          }
        });

jQuery('#new_factory_contact_number').keyup(function(e){
          if(jQuery('#new_factory_contact_number').val()!=""){
            jQuery('#new_factory_contact_number').removeAttr("style");
            jQuery('#remarks2').css("display","none");
          }
        });

        jQuery('#new_factory_contact_email').keyup(function(e){
          if(jQuery('#new_factory_contact_email').val()!=""){
            jQuery('#new_factory_contact_email').removeAttr("style");
            jQuery('#remarks3').css("display","none");
          }
        });

        jQuery('#save_factory_contact').click(function(e){
          
          for(var x=0;x<=2;x++)  
              {
              if(jQuery('#new_factory_contact_name').val()==""){
                  jQuery('#new_factory_contact_name').css('border-color', 'red');
                  document.getElementById('remarks1').style.display = 'block';
                  x=3;
                  
                }else if(jQuery('#new_factory_contact_number').val()==""){
                  jQuery('#new_factory_contact_number').css('border-color', 'red');
                  jQuery('#remarks2').css("display","block");
                  x=3;
                }
                else if(jQuery('#new_factory_contact_email').val()==""){
                  jQuery('#new_factory_contact_email').css('border-color', 'red');
                  jQuery('#remarks3').css("display","block");
                  x=3;
                }
                else{
        //  jQuery("#formData").attr("action", "{{route('addclientcontact')}}");
         // $('#clr').click();
          //alert("Success");
          x=3;
                }
              }
        });
      });

   
      </script>