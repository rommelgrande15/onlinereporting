<div class="modal fade AQLModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Product Quantity and AQL</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="usr">Quantity:</label>
              <input type="number" class="form-control aql_qty" name="aql_qty" id="aql_qty" required>
              <div id="aqlRequired1" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="quantity_unit">Unit:</label>
            <select class="form-control aql_qty_unit" id="aql_qty_unit" name="aql_qty_unit" required>
                <option selected="selected" value="">Select a unit</option>
                <option value="piece">Piece/s</option>
                <option value="roll">Roll/s</option>
                <option value="set">Set/s</option>
                <option value="pair">Pair/s</option>
                <option value="box">Box/es</option>
                <option value="kg">Kilogram/s</option>
            </select>
          </div>
        </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="usr">Normal Level:</label>
              <select class="form-control aql_normal_level" name="aql_normal_level" id="aql_normal_level" required>
                <option value="">--Select--</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
                <option value="special">Special</option>
                <option value="N/A">N/A</option>
              </select>
              <div id="aqlRequired2" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
          </div>
            
          <div class="col-md-6">
            <div class="form-group">
              <label for="usr">Special Level:</label>
              <select class="form-control aql_special_level" name="aql_special_level" id="aql_special_level" required>
                <option value="">--Select--</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
                <option value="S4">S4</option>
                <option value="special">Special</option>
                <option value="N/A">N/A</option>
              </select>
              <div id="aqlRequired3" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
              <table class="table-bordered table-condensed" width="100%">
                <tr>
                  <th></th>
                  <th class="text-center">AQL</th>
                  <th class="text-center">Max Allowed</th>
                </tr>

                <tr>
                  <th>Major</th>
                  <td>
                  <select type="text" name="aql_major" id="aql_major" class="form-control aql_select aql_major"required ></select>
                  <div id="aqlRequired4" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  <td><input type="text " name="max_major" id="max_major" class="form-control max_major" />
                  <div id="aqlRequired5" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>

                <tr>
                  <th>Minor</th>
                  <td><select type="text" name="aql_minor" id="aql_minor" class="form-control aql_select aql_minor"></select>
                  <div id="aqlRequired6" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  <td><input type="text" name="max_minor" id="max_minor" class="form-control max_minor" />
                  <div id="aqlRequired7" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>
              </table>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-12">
              <table class="table-bordered table-condensed" width="100%">
                <tr>
                  <th></th>
                  <th class="text-center">Code Letter</th>
                  <th class="text-center">Sample Size</th>
                </tr>

                <tr>
                  <th>Normal</th>
                  <td><input type="text" name="aql_normal_letter" id="aql_normal_letter" class="form-control aql_normal_letter" >
                  <div id="aqlRequired8" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                  <td><input type="text" name="aql_normal_sampsize" id="aql_normal_sampsize" class="form-control aql_normal_sampsize" />
                  <div id="aqlRequired9" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>

                <tr>
                  <th>Special</th>
                  <td><input type="text" name="aql_special_letter" id="aql_special_letter" class="form-control aql_special_letter">
                  <div id="aqlRequired10" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                  <td><input type="text" name="aql_special_sampsize" id="aql_special_sampsize" class="form-control aql_special_sampsize" />
                  <div id="aqlRequired11" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>
              </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success edit_confirm_aql"  name="Confirm" id="Confirm">Update</button>
        <input type="hidden" name="aql_product_id" id="aql_product_id" class="form-control aql_product_id">
        <!-- <button type="button" class="btn btn-success confirm_aql"  name="Confirm" id="Confirm">Confirm</button> -->
      </div>
    </div>

  </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
      <!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
      <script>
      jQuery(document).ready(function(){

       // jQuery('#save').prop('disabled', true);
       jQuery('#aql_qty').on('change',function(e){
          if(jQuery('#aql_qty').val()!=""  ){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

         jQuery('#aql_normal_level').on('change',function(e){
          if(jQuery('#aql_normal_level').val()!=""){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

         jQuery('#aql_special_level').on('change',function(e){
          if(jQuery('#aql_special_level').val()!=""){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

         jQuery('#aql_major').on('change',function(e){
          if(jQuery('#aql_major').val()!=""){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

         jQuery('#max_major').on('change',function(e){
          if(jQuery('#max_major').val()!=""){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

        jQuery('#aql_minor').on('change',function(e){
          if(jQuery('#aql_minor').val()!="" ){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

        jQuery('#max_minor').on('change',function(e){
          if(jQuery('#max_minor').val()!=""){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

         jQuery('#aql_normal_letter').on('change',function(e){
          if(jQuery('#aql_normal_letter').val()!=""){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

        jQuery('#aql_normal_sampsize').on('change',function(e){
          if(jQuery('#aql_normal_sampsize').val()!=""){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

        jQuery('#aql_special_letter').on('change',function(e){
          if(jQuery('#aql_special_letter').val()!=""){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

        jQuery('#aql_special_sampsize').on('change',function(e){
          if(jQuery('#aql_special_sampsize').val()!="" ){
            
            jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
            checked();
          }else{
           
            jQuery('#Confirm').removeClass("edit_confirm_aql");
          }
        });

        function checked()
        {

          jQuery('#aql_qty').removeAttr("style");
          jQuery('#aql_normal_level').removeAttr("style");
          jQuery('#aql_special_level').removeAttr("style");
          jQuery('#aql_major').removeAttr("style");
          jQuery('#max_major').removeAttr("style");
          jQuery('#aql_minor').removeAttr("style");
          jQuery('#max_minor').removeAttr("style");
          jQuery('#aql_normal_letter').removeAttr("style");
          jQuery('#aql_normal_sampsize').removeAttr("style");
          jQuery('#aql_special_letter').removeAttr("style");
          jQuery('#aql_special_sampsize').removeAttr("style");

          for(var x=1;x<=12;x++){
            jQuery('#aqlRequired'+x+'').css("display","none");
          }
        }

        jQuery('#Confirm').click(function(e){
          checked();
          
         // alert(jQuery('#aql_special_sampsize').val());
          for(var x=0;x<=12;x++)  
              {
              if(jQuery('#aql_qty').val()==""){
                  jQuery('#aql_qty').css('border-color', 'red');
                  jQuery('#aqlRequired1').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                  
                }else if(jQuery('#aql_normal_level').val()==""){
                  jQuery('#aql_normal_level').css('border-color', 'red');
                  jQuery('#aqlRequired2').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else if(jQuery('#aql_special_level').val()==""){
                  jQuery('#aql_special_level').css('border-color', 'red');
                  jQuery('#aqlRequired3').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else if(jQuery('#aql_major').val()==""){
                  jQuery('#aql_major').css('border-color', 'red');
                  jQuery('#aqlRequired4').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else if(jQuery('#max_major').val()==""){
                  jQuery('#max_major').css('border-color', 'red');
                  jQuery('#aqlRequired5').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else if(jQuery('#aql_minor').val()==""){
                  jQuery('#aql_minor').css('border-color', 'red');
                  jQuery('#aqlRequired6').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else if(jQuery('#max_minor').val()==""){
                  jQuery('#max_minor').css('border-color', 'red');
                  jQuery('#aqlRequired7').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else if(jQuery('#aql_normal_letter').val()==""){
                  jQuery('#aql_normal_letter').css('border-color', 'red');
                  jQuery('#aqlRequired8').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else if(jQuery('#aql_normal_sampsize').val()==""){
                  jQuery('#aql_normal_sampsize').css('border-color', 'red');
                  jQuery('#aqlRequired9').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else if(jQuery('#aql_special_letter').val()==""){
                  jQuery('#aql_special_letter').css('border-color', 'red');
                  jQuery('#aqlRequired10').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else if(jQuery('#aql_special_sampsize').val()==""){
                  jQuery('#aql_special_sampsize').css('border-color', 'red');
                  jQuery('#aqlRequired11').css("display","block");
                  jQuery('#Confirm').removeClass("edit_confirm_aql");
                  x=13;
                }
                else{
                  //alert("test");
                  jQuery('#Confirm').addClass("btn btn-success edit_confirm_aql");
         /*  jQuery("#formData").attr("action", "{{route('addclient')}}");
          $('#clr').click(); */
          //alert("Success");
          /* $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            var aql_qty = $('#aql_qty').val();
            var aql_normal_level = $('#aql_normal_level').val();
            var aql_special_level = $('#aql_special_level').val();
            var aql_major = $('#aql_major').val();
            var max_major = $('#max_major').val();                
            var aql_minor = $('#aql_minor').val();
            var max_minor = $('#max_minor').val();
            var aql_normal_letter = $('#aql_normal_letter').val();
            var aql_normal_sampsize = $('#aql_normal_sampsize').val();
            var aql_special_letter = $('#aql_special_letter').val();
            var aql_special_sampsize = $('#aql_special_sampsize').val();
            var aql_product_id = $('#aql_product_id').val();
            

            $.ajax({
               type:'POST',
               url:'/updatedraftaql',
               data:
               {
                aql_product_id:aql_product_id,
                aql_qty:aql_qty,
                aql_normal_level:aql_normal_level,
                aql_special_level:aql_special_level,
                aql_major:aql_major,
                max_major:max_major,                
                aql_minor:aql_minor,
                max_minor:max_minor,
                aql_normal_letter:aql_normal_letter,
                aql_normal_sampsize:aql_normal_sampsize,
                aql_special_letter:aql_special_letter,
                aql_special_sampsize:aql_special_sampsize
                
                },
               success:function(data){
                alert("AQL successfully upudated.");
              }
              });    */
          
               x=13;
                }
              }
        });
        
      });

 </script>