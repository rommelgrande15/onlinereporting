<div class="modal fade AQLModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Product Quantity and AQL</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="usr">Quantity:</label>
              <input type="number" class="form-control aql_qty" name="cbpi_aql_qty" id="cbpi_aql_qty" min="1" oninput="this.value = Math.abs(this.value)" required>
              <div id="aqlRequired1" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="quantity_unit">Unit:</label>
              <select class="form-control aql_qty_unit" id="cbpi_aql_qty_unit" name="cbpi_aql_qty_unit" required>
                  <option selected="selected" value="">Select a unit</option>
                  <option value="piece">Piece/s</option>
                  <option value="roll">Roll/s</option>
                  <option value="set">Set/s</option>
                  <option value="pair">Pair/s</option>
                  <option value="box">Box/es</option>
              </select>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="usr">Normal Level:</label>
              <select class="form-control aql_normal_level" name="cbpi_aql_normal_level" id="cbpi_aql_normal_level" required>
                <option value="">--Select--</option>
                <option value="I">I</option>
                <option value="II">II</option>
                <option value="III">III</option>
              </select>
              <div id="aqlRequired2" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>
          </div>
            
          <div class="col-md-6">
            <div class="form-group">
              <label for="usr">Special Level:</label>
              <select class="form-control aql_special_level" name="cbpi_aql_special_level" id="cbpi_aql_special_level" required>
                <option value="">--Select--</option>
                <option value="S1">S1</option>
                <option value="S2">S2</option>
                <option value="S3">S3</option>
                <option value="S4">S4</option>
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
                  <select type="text" name="cbpi_aql_major" id="cbpi_aql_major" class="form-control aql_select aql_major"required ></select>
                  <div id="aqlRequired4" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  <td><input type="text " name="cbpi_max_major" id="cbpi_max_major" class="form-control max_major" />
                  <div id="aqlRequired5" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>

                <tr>
                  <th>Minor</th>
                  <td><select type="text" name="cbpi_aql_minor" id="cbpi_aql_minor" class="form-control aql_select aql_minor"></select>
                  <div id="aqlRequired6" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  <td><input type="text" name="cbpi_max_minor" id="cbpi_max_minor" class="form-control max_minor" />
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
                  <td><input type="text" name="cbpi_aql_normal_letter" id="cbpi_aql_normal_letter" class="form-control aql_normal_letter" >
                  <div id="aqlRequired8" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                  <td><input type="text" name="cbpi_aql_normal_sampsize" id="cbpi_aql_normal_sampsize" class="form-control aql_normal_sampsize" />
                  <div id="aqlRequired9" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>

                <tr>
                  <th>Special</th>
                  <td><input type="text" name="cbpi_aql_special_letter" id="cbpi_aql_special_letter" class="form-control aql_special_letter">
                  <div id="aqlRequired10" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                  <td><input type="text" name="aql_special_sampsize" id="cbpi_aql_special_sampsize" class="form-control aql_special_sampsize" />
                  <div id="aqlRequired11" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </td>
                  
                </tr>
              </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-success"  name="cbpi_confirm" id="cbpi_confirm">Confirm</button>
        
        <!-- <button type="button" class="btn btn-success cbpi_confirm_aql"  name="cbpi_confirm" id="cbpi_confirm">cbpi_confirm</button> -->
      </div>
    </div>

  </div>
</div>


<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
      </script>
      <!-- Latest compiled and minified JavaScript -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
      <script>
      jQuery(document).ready(function(){

       // jQuery('#save').prop('disabled', true);
       jQuery('#cbpi_aql_qty').on('change',function(e){
          if(jQuery('#cbpi_aql_qty').val()!=""  ){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

         jQuery('#cbpi_aql_normal_level').on('change',function(e){
          if(jQuery('#aql_normal_level').val()!=""){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

         jQuery('#cbpi_aql_special_level').on('change',function(e){
          if(jQuery('#aql_special_level').val()!=""){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

         jQuery('#cbpi_aql_major').on('change',function(e){
          if(jQuery('#cbpi_aql_major').val()!=""){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

         jQuery('#cbpi_max_major').on('change',function(e){
          if(jQuery('#cbpi_max_major').val()!=""){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

        jQuery('#cbpi_aql_minor').on('change',function(e){
          if(jQuery('#cbpi_aql_minor').val()!="" ){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

        jQuery('#cbpi_max_minor').on('change',function(e){
          if(jQuery('#cbpi_max_minor').val()!=""){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

         jQuery('#cbpi_aql_normal_letter').on('change',function(e){
          if(jQuery('#cbpi_aql_normal_letter').val()!=""){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

        jQuery('#cbpi_aql_normal_sampsize').on('change',function(e){
          if(jQuery('#cbpi_aql_normal_sampsize').val()!=""){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

        jQuery('#cbpi_aql_special_letter').on('change',function(e){
          if(jQuery('#cbpi_aql_special_letter').val()!=""){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

        jQuery('#cbpi_aql_special_sampsize').on('change',function(e){
          if(jQuery('#aql_special_sampsize').val()!="" ){
            
            jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
            checked();
          }else{
           
            jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
          }
        });

        function checked()
        {

          jQuery('#cbpi_aql_qty').removeAttr("style");
          jQuery('#cbpi_aql_normal_level').removeAttr("style");
          jQuery('#aql_special_level').removeAttr("style");
          jQuery('#cbpi_aql_major').removeAttr("style");
          jQuery('#cbpi_max_major').removeAttr("style");
          jQuery('#cbpi_aql_minor').removeAttr("style");
          jQuery('#cbpi_max_minor').removeAttr("style");
          jQuery('#cbpi_aql_normal_letter').removeAttr("style");
          jQuery('#cbpi_aql_normal_sampsize').removeAttr("style");
          jQuery('#cbpi_aql_special_letter').removeAttr("style");
          jQuery('#cbpi_aql_special_sampsize').removeAttr("style");

          for(var x=1;x<=12;x++){
            jQuery('#aqlRequired'+x+'').css("display","none");
          }
        }

        jQuery('#cbpi_confirm').click(function(e){
          checked();
          
         // alert(jQuery('#aql_special_sampsize').val());
          for(var x=0;x<=12;x++)  
              {
              if(jQuery('#cbpi_aql_qty').val()==""){
                  jQuery('#cbpi_aql_qty').css('border-color', 'red');
                  jQuery('#aqlRequired1').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                  
                }else if(jQuery('#cbpi_aql_normal_level').val()==""){
                  jQuery('#cbpi_aql_normal_level').css('border-color', 'red');
                  jQuery('#aqlRequired2').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else if(jQuery('#acbpi_ql_special_level').val()==""){
                  jQuery('#cbpi_aql_special_level').css('border-color', 'red');
                  jQuery('#aqlRequired3').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else if(jQuery('#cbpi_aql_major').val()==""){
                  jQuery('#cbpi_aql_major').css('border-color', 'red');
                  jQuery('#aqlRequired4').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else if(jQuery('#cbpi_max_major').val()==""){
                  jQuery('#cbpi_max_major').css('border-color', 'red');
                  jQuery('#aqlRequired5').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else if(jQuery('#cbpi_aql_minor').val()==""){
                  jQuery('#cbpi_aql_minor').css('border-color', 'red');
                  jQuery('#aqlRequired6').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else if(jQuery('#cbpi_max_minor').val()==""){
                  jQuery('#cbpi_max_minor').css('border-color', 'red');
                  jQuery('#aqlRequired7').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else if(jQuery('#cbpi_aql_normal_letter').val()==""){
                  jQuery('#cbpi_aql_normal_letter').css('border-color', 'red');
                  jQuery('#aqlRequired8').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else if(jQuery('#cbpi_aql_normal_sampsize').val()==""){
                  jQuery('#cbpi_aql_normal_sampsize').css('border-color', 'red');
                  jQuery('#aqlRequired9').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else if(jQuery('#cbpi_aql_special_letter').val()==""){
                  jQuery('#cbpi_aql_special_letter').css('border-color', 'red');
                  jQuery('#aqlRequired10').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else if(jQuery('#cbpi_aql_special_sampsize').val()==""){
                  jQuery('#aql_special_sampsize').css('border-color', 'red');
                  jQuery('#aqlRequired11').css("display","block");
                  jQuery('#cbpi_confirm').removeClass("cbpi_confirm_aql");
                  x=13;
                }
                else{
                  jQuery('#cbpi_confirm').addClass("btn btn-success cbpi_confirm_aql");
         /*  jQuery("#formData").attr("action", "{{route('addclient')}}");
          $('#clr').click(); */
          //alert("Success");
          
               x=13;
                }
              }
        });
      });

 </script>