<div class="modal fade AQLModal44" role="dialog">
    <div class="modal-dialog">
  
      <!-- Modal content-->
      
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Product Quantity and AQLs</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="usr">Quantity:</label>
                <input type="number" class="form-control aql_qty44" name="aql_qty44" id="aql_qty44" oninput="this.value = Math.abs(this.value)" required value={{ $psi_products->aql_qty }}> $psi_products->aql_qty }}> $psi_products->aql_qty }}> $psi_products->aql_qty }}>
                <div id="aqlRequired1" style="display:none" ><p style="color:red;">This field is required! </p></div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                  <label for="quantity_unit44">Unit:</label>
                <select class="form-control aql_qty_unit44" id="aql_qty_unit44" name="aql_qty_unit44" required>
                    <option selected="selected" value="">Select a unit</option>
                    <option value="piece">Piece/s</option>
                    <option value="roll">Roll/s</option>
                    <option value="set">Set/s</option>
                    <option value="pair">Pair/s</option>
                    <option value="box">Box/es</option>
                    <option value="kg">Kilogram/s</option>
                    <option value="pack">Pack/s</option>
					<option value="bag">Bag/s</option>
                    <option value="reel">Reel/s</option>
                    <option value="tray">Tray/s</option>
                </select>
                <div id="aqlRequired2" style="display:none" ><p style="color:red;">This field is required! </p></div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="usr">Normal Level:</label>
                <select class="form-control aql_normal_level44" name="aql_normal_level44" id="aql_normal_level44" required>
                  <option value="">--Select--</option>
                  <option value="I">I</option>
                  <option value="II">II</option>
                  <option value="III">III</option>
                  <option value="special">Special</option>
                  <option value="N/A">N/A</option>
                </select>
                <div id="aqlRequired3" style="display:none" ><p style="color:red;">This field is required! </p></div>
              </div>
            </div>
              
            <div class="col-md-6">
              <div class="form-group">
                <label for="usr">Special Level:</label>
                <select class="form-control aql_special_level44" name="aql_special_level44" id="aql_special_level44" required>
                  <option value="">--Select--</option>
                  <option value="S1">S1</option>
                  <option value="S2">S2</option>
                  <option value="S3">S3</option>
                  <option value="S4">S4</option>
                  <option value="special">Special</option>
                  <option value="N/A">N/A</option>
                </select>
                <div id="aqlRequired4" style="display:none" ><p style="color:red;">This field is required! </p></div>
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
                    <input type="text" name="aql_major44" id="aql_major44" class="form-control aql_select aql_major44" value={{ $psi_products->aql_major }} readonly> 
                    <div id="aqlRequired5" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </td>
                    <td>
                      <input type="text " name="max_major44" id="max_major44" class="form-control max_major44" value={{ $psi_products->max_allowed_major }} readonly>
                      <div id="aqlRequired6" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </td>
                    
                  </tr>
                
                  <tr>
                    <th>Minor</th>
                    <td>
                      <input type="text" name="aql_minor44" id="aql_minor44" class="form-control aql_select aql_minor44" value={{ $psi_products->aql_minor }} readonly>
                      <div id="aqlRequired7" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </td>
                    <td><input type="text" name="max_minor44" id="max_minor44" class="form-control max_minor44" value={{ $psi_products->max_allowed_minor }} readonly>
                    <div id="aqlRequired8" style="display:none" ><p style="color:red;">This field is required! </p></div>
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
                    <td><input type="text" name="aql_normal_letter44" id="aql_normal_letter44" class="form-control aql_normal_letter44" readonly>
                    <div id="aqlRequired9" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </td>
                    
                    <td><input type="text" name="aql_normal_sampsize44" id="aql_normal_sampsize44" class="form-control aql_normal_sampsize44" readonly/>
                    <div id="aqlRequired10" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </td>
                    
                  </tr>
  
                  <tr>
                    <th>Special</th>
                    <td><input type="text" name="aql_special_letter44" id="aql_special_letter44" class="form-control aql_special_letter44" readonly>
                    <div id="aqlRequired11" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </td>
                    
                    <td><input type="text" name="aql_special_sampsize44" id="aql_special_sampsize44" class="form-control aql_special_sampsize44" readonly/>
                    <div id="aqlRequired12" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </td>
                    
                  </tr>
                </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success"  name="Confirm44" id="Confirm44">Confirm</button>
        </div>
      </div>
  
    </div>
  </div>
  
  
  <script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
        <!-- Latest compiled and minified JavaScript -->
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
        <script>
        jQuery(document).ready(function(){
         // $('.max_major').val("asdasd");
         // jQuery('#save').prop('disabled', true);
         jQuery('#aql_qty44').on('change',function(e){
            if(jQuery('#aql_qty44').val()!=""  ){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
           jQuery('#aql_qty_unit44').on('change',function(e){
            if(jQuery('#aql_qty_unit44').val()!=""){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
          
          jQuery('#aql_normal_level44').on('change',function(e){
            if(jQuery('#aql_normal_level44').val()!=""){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
           jQuery('#aql_special_level44').on('change',function(e){
            if(jQuery('#aql_special_level44').val()!=""){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
           jQuery('#aql_major44').on('change',function(e){
           
            if(jQuery('#aql_major44').val()=="N/A"){
              //alert("s");
             
              
            }
            if(jQuery('#aql_major44').val()!=""){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
  
  
          });
  
           jQuery('#max_major44').on('change',function(e){
            if(jQuery('#max_major44').val()!=""){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
          jQuery('#aql_minor44').on('change',function(e){
            if(jQuery('#aql_minor44').val()!="" ){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
          jQuery('#max_minor44').on('change',function(e){
            if(jQuery('#max_minor44').val()!=""){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
           jQuery('#aql_normal_letter44').on('change',function(e){
            if(jQuery('#aql_normal_letter44').val()!=""){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
          jQuery('#aql_normal_sampsize44').on('change',function(e){
            if(jQuery('#aql_normal_sampsize44').val()!=""){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
          jQuery('#aql_special_letter44').on('change',function(e){
            if(jQuery('#aql_special_letter44').val()!=""){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
          jQuery('#aql_special_sampsize44').on('change',function(e){
            if(jQuery('#aql_special_sampsize44').val()!="" ){
              
              jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
              checked();
            }else{
             
              jQuery('#Confirm44').removeClass("confirmAQL44");
            }
          });
  
          function checked()
          {
            
            jQuery('#aql_qty44').removeAttr("style");
            jQuery('#aql_qty_unit44').removeAttr("style");
            jQuery('#aql_normal_level44').removeAttr("style");
            jQuery('#aql_special_level44').removeAttr("style");
            jQuery('#aql_major44').removeAttr("style");
            jQuery('#max_major44').removeAttr("style");
            jQuery('#aql_minor44').removeAttr("style");
            jQuery('#max_minor44').removeAttr("style");
            jQuery('#aql_normal_letter44').removeAttr("style");
            jQuery('#aql_normal_sampsize44').removeAttr("style");
            jQuery('#aql_special_letter44').removeAttr("style");
            jQuery('#aql_special_sampsize44').removeAttr("style");
  
            for(var x=1;x<=13;x++){
              jQuery('#aqlRequired'+x+'').css("display","none");
            }
          }
  
          jQuery('#Confirm44').click(function(e){
            checked();
            
           // alert(jQuery('#aql_special_sampsize').val());
            for(var x=0;x<=13;x++)  
                {
                if(jQuery('#aql_qty44').val()==""){
                    jQuery('#aql_qty44').css('border-color', 'red');
                    jQuery('#aqlRequired1').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                    
                  }else if(jQuery('#aql_qty_unit44').val()==""){
                    jQuery('#aql_qty_unit44').css('border-color', 'red');
                    jQuery('#aqlRequired2').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }else if(jQuery('#aql_normal_level44').val()==""){
                    jQuery('#aql_normal_level44').css('border-color', 'red');
                    jQuery('#aqlRequired3').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else if(jQuery('#aql_special_level44').val()==""){
                    jQuery('#aql_special_level44').css('border-color', 'red');
                    jQuery('#aqlRequired4').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else if(jQuery('#aql_major44').val()==""){
                    jQuery('#aql_major44').css('border-color', 'red');
                    jQuery('#aqlRequired5').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else if(jQuery('#max_major44').val()==""){
                    jQuery('#max_major44').css('border-color', 'red');
                    jQuery('#aqlRequired6').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else if(jQuery('#aql_minor44').val()==""){
                    jQuery('#aql_minor44').css('border-color', 'red');
                    jQuery('#aqlRequired7').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else if(jQuery('#max_minor44').val()==""){
                    jQuery('#max_minor44').css('border-color', 'red');
                    jQuery('#aqlRequired8').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else if(jQuery('#aql_normal_letter44').val()==""){
                    jQuery('#aql_normal_letter44').css('border-color', 'red');
                    jQuery('#aqlRequired9').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else if(jQuery('#aql_normal_sampsize44').val()==""){
                    jQuery('#aql_normal_sampsize44').css('border-color', 'red');
                    jQuery('#aqlRequired10').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else if(jQuery('#aql_special_letter44').val()==""){
                    jQuery('#aql_special_letter44').css('border-color', 'red');
                    jQuery('#aqlRequired11').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else if(jQuery('#aql_special_sampsize44').val()==""){
                    jQuery('#aql_special_sampsize44').css('border-color', 'red');
                    jQuery('#aqlRequired12').css("display","block");
                    jQuery('#Confirm44').removeClass("confirmAQL44");
                    x=14;
                  }
                  else{
                    jQuery('#Confirm44').addClass("btn btn-success confirmAQL44");
           /*  jQuery("#formData").attr("action", "{{route('addclient')}}");
            $('#clr').click(); */
            //alert("Success");
            
                 x=14;
                  }
                }
          });
        });
  
   </script>