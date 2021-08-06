<div id="newProduct" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form data-parsley-validate=''>
        {!!csrf_field()!!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add new Product</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <input type="hidden" name="new_client_code_product" id="new_client_code_product" value="{{$client_code}}">
            <div class="form-group">
              <label for="factory_name">Product Name</label><span class="error_messages product_error"></span>
              <input type="text" name="new_product_name" class="form-control product_input" id="new_product_name" required data-parsley-required-message="Please enter a Product name!" data-parsley-errors-container=".product_error">
              <div id="productRequired2" style="display:none" ><p style="color:red;">This field is required!</p></div>
            </div>

            <div class="form-group">
              <label for="factory_address">Product Category</label><span class="error_messages category_error"></span>
              <select class="form-control product_category" id="new_product_category" name="new_product_category" required data-parsley-required-message="Please select a product category!" data-parsley-errors-container=".category_error">
                <option selected="selected" value="">Select a Category</option>
              </select>
              <div id="productRequired3" style="display:none" ><p style="color:red;">This field is required!</p></div>
            </div>

            <div class="form-group">
              <label for="factory_address">Product Sub-category</label><span class="error_messages category_error"></span>
              <select class="form-control product_sub_category " id="new_product_sub_category" name="new_product_sub_category" required data-parsley-required-message="Please select a product category!" data-parsley-errors-container=".category_error">
                <option selected="selected" value="">Select a Category</option>
              </select>
              <div id="productRequired3" style="display:none" ><p style="color:red;">This field is required!</p></div>
            </div>

           

            <div class="row">
              <div class="col-md-6">
                 <div class="form-group">
                    <label for="factory_country">Unit</label><span class="error_messages unit_error"></span>
                    <select class="form-control unit" id="unit" name="unit" required data-parsley-required-message="Please select a unit!" data-parsley-errors-container=".unit_error">
                        <option selected="selected" value="">Select a unit</option>
                        <option value="piece">Piece/s</option>
                        <option value="roll">Roll/s</option>
                        <option value="set">Set/s</option>
                        <option value="pair">Pair/s</option>
                        <option value="piece">Box/es</option>
                    </select>
                    <div id="productRequired4" style="display:none" ><p style="color:red;">This field is required!</p></div>
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="contact_person">PO Number</label><span class="error_messages po_error"></span>
                  <div id="po_num_container">
                  </div>
                  <div class="input-group">
                    <input type="text" name="new_po_number" class="form-control product_input new_po_number" id="new_po_number" required data-parsley-required-message="Please enter the PO number!" data-parsley-errors-container=".po_error">
                    <div class="input-group-btn">
                      <button class="btn btn-success" type="button" id="add_more_po_num">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>
                  
                  <div id="productRequired5" style="display:none" ><p style="color:red;">This field is required!</p></div>
                </div>
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="new_model_number">Model Number</label><span class="error_messages model_error"></span>
                  <div id="model_num_container">
                  </div>
                  <div class="input-group">
                    <input type="text" name="new_model_number" class="form-control product_input new_model_number" id="new_model_number" required data-parsley-required-message="Please enter the Model Number!" data-parsley-errors-container=".model_error">
                    <div class="input-group-btn">
                      <button class="btn btn-success" type="button" id="add_more_model_num">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>

                  <div id="productRequired6" style="display:none" ><p style="color:red;">This field is required!</p></div>
                </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="email">Brand</label><span class="error_messages brand_error"></span>
                    <div id="brand_container">
                    </div>
                    <div class="input-group">
                    <input type="text" name="new_brand" class="form-control product_input new_brand" id="new_brand" required data-parsley-required-message="Please enter the Product Brand!" data-parsley-errors-container=".brand_error">
                    <div class="input-group-btn">
                      <button class="btn btn-success" type="button" id="add_more_brand">
                        <i class="fa fa-plus"></i>
                      </button>
                    </div>
                  </div>

                    <div id="productRequired7" style="display:none" ><p style="color:red;">This field is required!</p></div>
                  </div>
              </div>
            </div>

            <div class="row">

              <div class="col-md-12">
                  <div class="form-group">
                    <label for="new_cmf">Additional Information</label><span class="error_messages specs_error"></span>
                    <div id="addtl_container">
                    </div>
                    <div class="input-group">
                      <input type="text" name="new_additional_product_info" class="form-control product_input new_additional_product_info" id="new_additional_product_info" required data-parsley-required-message="Please enter dditional information or put N/A if not applicable" data-parsley-errors-container=".brand_error">
                      <div class="input-group-btn">
                        <button class="btn btn-success" type="button" id="add_more_addtl">
                          <i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                    <div id="productRequired11" style="display:none" ><p style="color:red;">This field is required!</p></div>
                  </div>
              </div>
            </div>
        </div>       
      </div>
      <div class="modal-footer">
        {!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger','data-dismiss' => "modal"]) !!}
        {!! Form::button('<i class="fa fa-floppy-o"></i> Save Product Details', ['class' => 'btn btn-success','id'=>'save_product']) !!}
      </div>
       </form>
    </div>

  </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
jQuery(document).ready(function(){ 

var id =[
'new_client_code_product',
'new_product_name',
'new_product_category',
'unit'
];


function checked()
        {
          for(var x=0;x<=3;x++){
          jQuery('#'+id[x]+'').removeAttr("style");
          }

          for(var x=1;x<=3;x++){
            jQuery('#productRequired'+x+'').css("display","none");
          }
        }

jQuery('#new_client_code_product').on('change',function(e){
          if(jQuery('#new_client_code_product').val()!=""  ){
            checked();
          }else{

          }
        });

        jQuery('#new_product_name').on('change',function(e){
          if(jQuery('#new_product_name').val()!=""  ){
            checked();
          }else{

          }
        });

        jQuery('#unit').on('change',function(e){
          if(jQuery('#unit').val()!=""  ){
            checked();
          }else{

          }
        });

        /* jQuery('#new_po_number').on('change',function(e){
          if(jQuery('#new_po_number').val()!=""  ){
            checked();
          }else{

          }
        });

        jQuery('#new_model_number').on('change',function(e){
          if(jQuery('#new_model_number').val()!=""  ){
            checked();
          }else{

          }
        });

        jQuery('#new_model_number').on('change',function(e){
          if(jQuery('#new_model_number').val()!=""  ){
            checked();
          }else{

          }
        });

        jQuery('#new_brand').on('change',function(e){
          if(jQuery('#new_brand').val()!=""  ){
            checked();
          }else{

          }
        });

         jQuery('#new_cmf').on('change',function(e){
          if(jQuery('#new_cmf').val()!=""  ){
            checked();
          }else{

          }
        });
        jQuery('#new_tech_specs').on('change',function(e){
          if(jQuery('#new_tech_specs').val()!=""  ){
            checked();
          }else{

          }
        });
        jQuery('#new_shipping_mark').on('change',function(e){
          if(jQuery('#new_shipping_mark').val()!=""  ){
            checked();
          }else{

          }
        });
        jQuery('#new_additional_product_info').on('change',function(e){
          if(jQuery('#new_additional_product_info').val()!=""  ){
            checked();
          }else{

          } 
        });
        */


  jQuery('#save_product').click(function(e){
    checked();
      
          for(var x=0;x<=3;x++)  
              {
              if(jQuery('#'+id[x]+'').val()==""){
                  jQuery('#'+id[x]+'').css('border-color', 'red');
                  var y=x;
                  y=y+1;
                  jQuery('#productRequired'+y+'').css("display","block");
                  x=5;
                }
                else if(x==3){
                  x=5;
                  //alert("successfully added");
                     
                }
              }
        });

    /* $('#cb_new_po_number ').click(function(){
      if (this.checked) {    
        $('#new_po_number').attr('disabled','disabled');
        $('#new_po_number').val('N/A'); 
        $('.added_more_fields_po').remove();   
        $('#add_more_po_num').attr('disabled','disabled');
      }else{
        $('#new_po_number').removeAttr("disabled");  
        $('#add_more_po_num').removeAttr("disabled"); 
        $('#new_po_number').val('');
      }
    }) ; */

    

   

});

 function setEnEy(cb_id,text_id,group_class,btn_id){
      if ($('#'+cb_id).prop('checked')==true) {    
        $('#'+text_id).attr('disabled','disabled');
        $('#'+text_id).val('N/A'); 
        $('.'+group_class).remove();   
        $('#'+btn_id).attr('disabled','disabled');
      }else{
        $('#'+text_id).removeAttr("disabled");      
        $('#'+text_id).val('');
        $('#'+btn_id).removeAttr("disabled"); 
      }

    }

</script>