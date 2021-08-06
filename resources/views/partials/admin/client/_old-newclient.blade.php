<div id="newClient" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg ui-front">

    <!-- Modal content-->
    <div class="modal-content">
      {!!Form::open(['data-parsley-validate'=>'', 'route'=>'addclient'])!!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Client</h4>
      </div>
      <div class="modal-body">
          <div class="row">


                  <div class="col-md-12">
                      <label class="pull-right"><span class="text-danger">*</span> <i>Indicate required fields</i></label><br/>
                      <div class="form-group">
             
                          <h4 class="modal-title">Company Details</h4>
                </div>
                  </div>

                  <div class="col-md-12">
                      
                      <div class="form-group">
                        {{-- {{Form::label('Company_Name','<span class="text-danger">*</span> Company Name',['class'=>''],false)}} --}}
                        {{-- {{Form::text('Company_Name',null,['class'=>'form-control Company_Name'])}} --}}
                        <label><span class="text-danger">*</span> Company Name</label>
                        <input type="text" id="Company_Name" name="Company_Name" class="form-control Company_Name" onkeyup="textValidator(this.id)">
                    </div>  
    
                    </div>
    

                  <div class="col-md-4">
                    <div class="form-group">
                      {{-- {{Form::label('client_code','<span class="text-danger">*</span> Client Code',['class'=>''],false)}} --}}
                      {{-- {{Form::text('client_code',null,['class'=>'form-control client_code','maxlength' => 3])}} --}}
                      <label><span class="text-danger">*</span> Client Code</label>
                      <input type="text" id="client_code" name="client_code" class="form-control client_code" maxlength="3" onkeyup="textValidator(this.id)" autocapitalize>
                  </div>  
                     
                  </div>


                  <div class="col-md-4">
                      <div class="form-group">
                          {{-- {{Form::label('Company_Email','<span class="text-danger">*</span> Company Email',['class'=>''],false)}} --}}
                          {{-- {{Form::email('Company_Email',null,['class'=>'form-control Company_Email'])}} --}}
                          <label><span class="text-danger">*</span> Company Email</label>
                          <input type="email" id="Company_Email" name="Company_Email" class="form-control Company_Email" onkeyup="textValidator(this.id)">
                      </div>  
                  </div>

                

                  

                  <div class="col-md-4">
                      <div class="form-group">
                          {{-- {{Form::label('Phone_number','<span class="text-danger">*</span> Phone number',['class'=>''],false)}} --}}
                         {{--  {{Form::text('Phone_number',null,['class'=>'form-control Phone_number'])}} --}}
                         <label><span class="text-danger">*</span> Phone number</label>
                          <input type="text" id="Phone_number" name="Phone_number" class="form-control Phone_number" onkeyup="textValidator(this.id)">
                      </div>  
                  </div>

                

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="company_country"><span class="text-danger">*</span> Country</label><span class="error_messages company_country"></span>
                      <select class="form-control"  name="company_country" id="company_country">
                        <option value="">Select Country</option>
                      </select>
                      <div id="#" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </div>
                  </div>
                  
                  <div class="col-md-4">
                    <div class="form-group">
                      {{-- <label for="company_state"><span class="text-danger">*</span> State</label><span class="error_messages company_state"></span> --}}
                      {{-- <select class="form-control" required data-parsley-required-message="Please select a state!"  data-parsley-errors-container=".company_state" name="company_state" id="company_state">
                        <option value="">--Select State--</option>
                      </select> --}}
                      <label><span class="text-danger">*</span> Enter State</label>
                     
                      {{-- <select class="form-control"  name="company_state" id="company_state">
                        <option value="">Select State</option>
                      </select> --}}
                      <input type="text" class="form-control" required name="company_state" id="company_state">
                      <input type="hidden" class="form-control" required name="hidden_company_state_id" id="hidden_company_state_id">
                      <div id="#" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </div>
                  </div>
                  
                   <div class="col-md-4">
                    <div class="form-group">
                      <label for="company_city"><span class="text-danger">*</span> Enter City</label><span class="error_messages company_city"></span>
                      {{-- <select class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".company_city" name="company_city" id="company_city" onchange="cmbValidator(this.id)">
                        <option value="">--Select City--</option>
                      </select> --}}
                      <input type="text" class="form-control" required  name="company_city" id="company_city">

                      <div id="#" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </div>
                  </div>

                
                  <div class="col-md-4">
                      <div class="form-group">
                          {{-- {{Form::label('street_number','<span class="text-danger">*</span> Street number /  name',['class'=>''],false)}} --}}
                         {{--  {{Form::text('street_number',null,['class'=>'form-control street_number'])}} --}}
                         <label><span class="text-danger">*</span> Street number /  name</label>
                          <input type="text" id="street_number" name="street_number" class="form-control street_number" onkeyup="textValidator(this.id)">
                      </div>  
                    </div>
                  
                  <div class="col-md-4">
                    <div class="form-group">
                        {{-- {{Form::label('house_number','<span class="text-danger">*</span> House number',['class'=>''],false)}} --}}
                       {{--  {{Form::text('house_number',null,['class'=>'form-control house_number'])}} --}}
                       <label><span class="text-danger">*</span> House number</label>
                        <input type="text" id="house_number" name="house_number" class="form-control house_number" onkeyup="textValidator(this.id)">
                    </div>  
                  </div>

               

                  <div class="col-md-4">
                      <div class="form-group">
                          {{-- {{Form::label('bldg_number','<span class="text-danger">*</span> Building number',['class'=>''],false)}} --}}
                         {{--  {{Form::text('house_number',null,['class'=>'form-control house_number'])}} --}}
                         <label><span class="text-danger">*</span> Building number</label>
                          <input type="text" id="bldg_number" name="bldg_number" class="form-control bldg_number" onkeyup="textValidator(this.id)">
                      </div>  
                    </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        {{-- {{Form::label('zip_code','<span class="text-danger">*</span> Zip/Postal Code',['class'=>''], false)}} --}}
                       {{--  {{Form::text('zip_code',null,['class'=>'form-control zip_code'])}} --}}
                       <label><span class="text-danger">*</span> Zip/Postal Code</label>
                        <input type="text" id="zip_code" name="zip_code" class="form-control zip_code" onkeyup="textValidator(this.id)">
                    </div>  
                  </div>
                  <div class="col-md-12">
                      <div class="checkbox">
                          <label><input type="checkbox" value="" id="check_invoice">Invoice Address. Check if same as address.</label>
                        </div>
                  </div>
                  <div class="col-md-4 invoice_class">
                    <div class="form-group">
                      <label for="company_invoice_country"><span class="text-danger">*</span> Invoice Address Country</label><span class="error_messages company_invoice_country"></span>
                      <select class="form-control" required data-parsley-required-message="Please select a country!"  data-parsley-errors-container=".company_invoice_country" name="company_invoice_country" id="company_invoice_country">
                        <option value="">--Select Country--</option>
                      </select>
                      <div id="#" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </div>
                  </div>
                  
                  <div class="col-md-4 invoice_class">
                    <div class="form-group">
                      <label for="company_invoice_state"><span class="text-danger">*</span> Invoice Address State</label><span class="error_messages company_invoice_state"></span>
                      {{-- <select class="form-control" name="company_invoice_state" id="company_invoice_state">
                        <option value="">--Select State--</option>
                      </select> --}}
                      <input type="text" class="form-control" required name="company_invoice_state" id="company_invoice_state">
                      <input type="hidden" class="form-control" name="hidden_company_invoice_state_id" id="hidden_company_invoice_state_id">
                      <div id="#" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </div>
                  </div>
                  
                   <div class="col-md-4 invoice_class">
                    <div class="form-group">
                      <label for="company_invoice_city"><span class="text-danger">*</span> Invoice Address City</label><span class="error_messages company_invoice_city"></span>
                      {{-- <select class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".company_invoice_city" name="company_invoice_city" id="company_invoice_city" onchange="cmbValidator(this.id)">
                        <option value="">--Select City--</option>
                      </select> --}}
                      <input type="text" class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".company_invoice_city" name="company_invoice_city" id="company_invoice_city" onchange="cmbValidator(this.id)">

                      <div id="#" style="display:none" ><p style="color:red;">This field is required! </p></div>
                    </div>
                  </div>

                  <div class="col-md-4 invoice_class">
                    <div class="form-group">
                        {{-- {{Form::label('inv_bldg_number','<span class="text-danger">*</span> Invoice Building number',['class'=>''],false)}} --}}
                       {{--  {{Form::text('house_number',null,['class'=>'form-control house_number'])}} --}}
                       <label><span class="text-danger">*</span> Invoice Building number</label>
                        <input type="text" id="inv_bldg_number" name="inv_bldg_number" class="form-control inv_bldg_number" onkeyup="textValidator(this.id)">
                    </div>  
                  </div>

                  <div class="col-md-4 invoice_class">
                    <div class="form-group">
                        {{-- {{Form::label('inv_house_number','<span class="text-danger">*</span> Invoice House number',['class'=>''],false)}} --}}
                       {{--  {{Form::text('house_number',null,['class'=>'form-control house_number'])}} --}}
                       <label><span class="text-danger">*</span> Invoice House number</label>
                        <input type="text" id="inv_house_number" name="inv_house_number" class="form-control inv_house_number" onkeyup="textValidator(this.id)">
                    </div>  
                  </div>

                  <div class="col-md-4 invoice_class">
                      <div class="form-group">
                          {{-- {{Form::label('inv_street_number','<span class="text-danger">*</span> Invoice Street number / Name',['class'=>''],false)}} --}}
                         {{--  {{Form::text('street_number',null,['class'=>'form-control street_number'])}} --}}
                         <label><span class="text-danger">*</span> Invoice Street number / Name</label>
                          <input type="text" id="inv_street_number" name="inv_street_number" class="form-control inv_street_number" onkeyup="textValidator(this.id)">
                      </div>  
                    </div>
  
                    
  
                    <div class="col-md-4 invoice_class">
                      <div class="form-group">
                          {{-- {{Form::label('inv_zip_code','<span class="text-danger">*</span> Invoice Zip/Postal Code',['class'=>''],false)}} --}}
                         {{--  {{Form::text('zip_code',null,['class'=>'form-control zip_code'])}} --}}
                         <label><span class="text-danger">*</span> Invoice Zip/Postal Code</label>
                          <input type="text" id="inv_zip_code" name="inv_zip_code" class="form-control inv_zip_code" onkeyup="textValidator(this.id)">
                      </div>  
                    </div>

                
                  <div class="col-md-12">
                      <div class="form-group">
                          <hr/>
                </div>
                  </div>
                  <div class="col-md-12">
                      <div class="form-group">
                 
                          
                             <h4 class="modal-title">Contact Person</h4>
                </div>
                  </div>

                  <div class="client-clone">
                    <div class="clone-inputs">
                        <div class="col-md-12">
                            <hr>
                        </div>
                  <div class="col-md-4">

                      <div class="form-group">

                          {{-- {{Form::label('contact_person','<span class="text-danger">*</span> Contact Person',['class'=>''],false)}} --}}
                          {{-- {{Form::text('contact_person',null,['class'=>'form-control contact_person'])}} --}}
                          <label><span class="text-danger">*</span> Contact Person</label>
                          <input type="text" id="contact_person" name="contact_person" class="form-control contact_person" onkeyup="contacPersonValidator('contact_person')">
                          

                      </div>
                  </div>

                <div class="col-md-4">
                  <div class="form-group">

                      {{-- {{Form::label('contact_person_email','<span class="text-danger">*</span> Email Address',['class'=>''],false)}} --}}
                      {{-- {{Form::email('contact_person_email',null,['class'=>'form-control contact_person_email'])}} --}}
                      <label><span class="text-danger">*</span> Email Address</label>
                     <input type="email" id="contact_person_email" name="contact_person_email" class="form-control contact_person_email" onkeyup="contacPersonValidator('contact_person_email')">

                  </div>
                  </div>

                  

                  <div class="col-md-4">
                    <div class="form-group">
                        {{-- {{Form::label('contact_person_phone_number','<span class="text-danger">*</span> Telephone Number',['class'=>''],false)}} --}}
                        {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
                        <label><span class="text-danger">*</span> Telephone Number</label>
                        <input type="text" id="contact_person_phone_number" name="contact_person_phone_number" class="form-control contact_person_phone_number" onkeyup="contacPersonValidator('contact_person_phone_number')">
                    </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                          {{-- {{Form::label('contact_person_number','<span class="text-danger">*</span> Mobile Number',['class'=>''],false)}} --}}
                          {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
                          <label><span class="text-danger">*</span> Mobile Number</label>
                          <input type="text" id="contact_person_number" name="contact_person_number" class="form-control contact_person_number" onkeyup="contacPersonValidator('contact_person_number')">
                      </div>
                      </div>

                  <div class="col-md-4">
                      <div class="form-group">
                          {{-- {{Form::label('client_skype','Skype',['class'=>''])}} --}}
                          {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
                          <label>Skype</label>
                          <input type="text" id="client_skype" name="client_skype" class="form-control client_skype" onkeyup="contacPersonValidator('client_skype')">
                      </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {{-- {{Form::label('client_wechat','We Chat',['class'=>''])}} --}}
                            {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
                            <label>We Chat</label>
                            <input type="text" id="client_wechat" name="client_wechat" class="form-control client_wechat" onkeyup="contacPersonValidator('client_wechat')">
                        </div>
                      </div>

                      <div class="col-md-4">
                          <div class="form-group">
                              {{-- {{Form::label('client_whatsapp','WhatsApp',['class'=>''])}} --}}
                              {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
                              <label>WhatsApp</label>
                              <input type="text" id="client_whatsapp" name="client_whatsapp" class="form-control client_whatsapp" onkeyup="contacPersonValidator('client_whatsapp')">
                          </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                {{-- {{Form::label('client_qqmail','QQ Mail',['class'=>''])}} --}}
                                {{-- {{Form::text('contact_person_number',null,['class'=>'form-control contact_person_number'])}} --}}
                                <label>QQ Mail</label>
                                <input type="text" id="client_qqmail" name="client_qqmail" class="form-control client_qqmail" onkeyup="contacPersonValidator('client_qqmail')">
                            </div>
                          </div>

                </div>
              </div>

                  <div class="col-md-12">
                    <div class="form-group">
                           <button class="btn btn-success" type="button" id="btn_add_more_fields_client"><i class="fa fa-plus"></i> Add more contact person</button>
                    </div>
                  </div>
              
               <div class="col-md-12">
                      <div class="form-group">
                          <hr/>
                </div>
                  </div>
               <div class="col-md-12">
                      <div class="form-group">
                 
                          
                             <h4 class="modal-title">Others</h4>
                </div>
                  </div>
              
               <div class="col-md-6">
                   
                   
              <div class="form-group">
              <label for="payment_terms"><span class="text-danger">*</span> Payment Terms</label><span class="error_messages"></span>
              <select class="form-control payment_terms"  required data-parsley-required-message="Please select a payment!" data-parsley-errors-container=".payment_terms" name="payment_terms" id="payment_terms" onchange="cmbValidator(this.id)">
                  <option value="">--Select Payment Terms--</option>
                  <option value="Collect invoice end of the month payable with 10 days">Collect invoice end of the month payable with 10 days</option>
                  <option value="Collect invoice end of the month payable with 30 days">Collect invoice end of the month payable with 30 days</option>
                  <option value="2 month Collect invoice payable with 10 days">2 month Collect invoice payable with 10 days</option>
                  <option value="2 month Collect invoice payable with 30 days">2 month Collect invoice payable with 30 days</option>
                  <option value="Invoice after inspection within 10 days payable">Invoice after inspection within 10 days payable</option>
                  <option value="Invoice to be paid before inspection">Invoice to be paid before inspection</option>
                  <option value="Invoice to be paid by factory before inspection">Invoice to be paid by factory before inspection</option>
                  <option value="special_terms">Special Terms</option>
              </select>
              <div id="payment_terms3" style="display:none" ><p style="color:red;">This field is required! </p></div>
            </div>

           
              
              </div>
              
              <div class="col-md-6" style="display:none;" id="div_special_terms">
                  <div class="form-group">
                      {{Form::label('special_terms','<span class="text-danger">*</span> Special Terms',['class'=>''],false)}}
                      {{Form::text('special_terms',null,['class'=>'form-control special_terms','placeholder'=>'Input special terms here'])}}
                  </div>
                </div>

          </div>
         
      </div>
      <div class="modal-footer">
       {{--  {{ Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger clr','data-dismiss' => "modal"]) }}
        {{ Form::button('<i class="fa fa-floppy-o"></i> Save Client Details', ['class' => 'btn btn-success', 'id'=>'save']) }} --}}
        <button class="btn btn-danger clr" data-dismiss="modal"><i class="fa fa-ban"></i> Cancel</button>
        <button class="btn btn-success" id="save"><i class="fa fa-floppy-o"></i> Save Client Details</button>
    {{--     {{ Form::button('<i class="fa fa-floppy-o"></i> Test Button Client Details', ['class' => 'btn btn-success', 'id'=>'Test']) }} --}}
     
      </div>

    </div>

  </div>
</div>

<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
      </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  
<script>


      jQuery(document).ready(function(){
 /* 
if(localStorage.getItem('ClientContact')==null){

  $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });


            $.ajax({
               type:'POST',
               url:'/getAllData',
               success:function(data){
              //  var myJSON = JSON.stringify(data);

              // Put the object into storage
              localStorage.setItem('ClientContact', JSON.stringify(data));

              // Retrieve the object from storage
            //  var retrievedObject = localStorage.getItem('testObject');

              //console.log('retrievedObject: ', JSON.parse(retrievedObject));
            console.log(data.clientContact);
              }
            });  
} */
           
        showAllCountryInCompany();
 /* 
   jQuery('#Test').click(function(e){  
    var c_person = jQuery('.contact_person');
      for(var i = 0; i < c_person.length; i++){
            var g_data=$(c_person[i]).val();
            console.log(g_data);
            contact_person.push(g_data);
            if(g_data==""){
              count_null+=1;
              returnData+=1;
              $(c_person[i]).css("border","1px solid red");
              
             
            }else{
             $(c_person[i]).removeAttr("style");
            
             
            }
          }

           if(c_person.length>1){
            for (let index = 0; index < contact_person.length; index++) {
            const element = contact_person[index];

    

          }
          }
   });
 */ 
        jQuery('#save').click(function(e){     

       /*       $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });


            $.ajax({
               type:'POST',
               url:'/getAllData',
               success:function(data){
              //  var myJSON = JSON.stringify(data);

              // Put the object into storage
              localStorage.setItem('ClientContact', JSON.stringify(data));

              // Retrieve the object from storage
            //  var retrievedObject = localStorage.getItem('testObject');

              //console.log('retrievedObject: ', JSON.parse(retrievedObject));
            //console.log(data.clientContact);
              }
            });    */
            

          var emailValidator=/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

          var client_code = jQuery('#client_code').val().toLowerCase();
          var Company_Name = jQuery('#Company_Name').val();
          var Company_Email = jQuery('#Company_Email').val();
          var Phone_number = jQuery('#Phone_number').val();
          var payment_terms = jQuery('#payment_terms').val(); 
          var special_terms = jQuery('#special_terms').val();      

          var company_country_name = jQuery('#company_country option:selected').text();
         /*  var company_state_name = jQuery('#company_state option:selected').text();
          var company_city_name = jQuery('#company_city option:selected').text(); */
          //var company_state_name = jQuery('#company_state').val();

          var company_state_name = jQuery('#company_state').val();
          var company_city_name = jQuery('#company_city').val(); 

          var company_country_id = jQuery('#company_country').val();
          var company_state_id = jQuery('#hidden_company_state_id').val();
          var company_city_id = jQuery('#company_city').val(); 

          var company_bldg_num  = jQuery('#bldg_number').val();
          var street_number = jQuery('#street_number').val();
          var house_number = jQuery('#house_number').val(); 
          var zip_code = jQuery('#zip_code').val(); 

            var company_invoice_country_name;
            var company_invoice_state_name;
            var company_invoice_city_name;
            var company_invoice_country_id;
            var company_invoice_state_id;
            var company_invoice_city_id;

            var company_inv_bldg_num;
            var inv_street_number;
            var inv_house_number; 
            var inv_zip_code; 
            var message_array;
            var count_null=0; //variable for counting the null values

          var array_id_name=[];
          if ($('#check_invoice').prop('checked')==true) { 
            company_invoice_country_name = company_country_name;
            company_invoice_state_name = company_state_name;
            company_invoice_city_name = company_city_name;
            company_invoice_country_id = company_country_id;
            company_invoice_state_id = company_state_id;
            company_invoice_city_id = company_city_id; 
            inv_street_number=street_number;
            inv_house_number=house_number; 
            inv_zip_code=zip_code; 
            company_inv_bldg_num=company_bldg_num;
            array_id_name = ['Company_Name','client_code','Company_Email','Phone_number','company_country','company_state','company_city','bldg_number','house_number','street_number','zip_code','company_country','company_state','company_city','bldg_number','street_number','house_number','zip_code','contact_person','contact_person_email','contact_person_phone_number','contact_person_number','payment_terms'];
            message_array =['Company Name','client code','Company Email','Phone number','company country','company state','company city','bldg number','house number','street number','zip code','company country','company state','company city','bldg number','house number','street number','Invoice Zip/Postal Code','contact person','contact person email','contact person phone number','contact person_number','payment terms'];  
          }else{
            company_invoice_country_name = jQuery('#company_invoice_country option:selected').text();
            //company_invoice_state_name = jQuery('#company_invoice_state').val();
            company_invoice_state_name = jQuery('#company_invoice_state').val();
            company_invoice_city_name = jQuery('#company_invoice_city').val();
            company_invoice_country_id = jQuery('#company_invoice_country').val();
            company_invoice_state_id = jQuery('#hidden_company_invoice_state_id').val();
            company_invoice_city_id = jQuery('#company_invoice_city').val(); 
            inv_street_number=jQuery('#inv_street_number').val(); 
            inv_house_number=jQuery('#inv_house_number').val(); 
            inv_zip_code=jQuery('#inv_zip_code').val();  
            company_inv_bldg_num=jQuery('#inv_bldg_number').val(); 
            array_id_name = ['Company_Name','client_code','Company_Email','Phone_number','company_country','company_state','company_city','bldg_number','house_number','street_number','zip_code','company_country','company_state','company_city','bldg_number','house_number','street_number','zip_code','company_invoice_country','company_invoice_state','company_invoice_city','inv_bldg_number','inv_house_number','inv_street_number','inv_zip_code','contact_person','contact_person_email','contact_person_phone_number','contact_person_number','payment_terms'];

              message_array =['Company Name','client code','Company Email','Phone number','company country','company state','company city','bldg number','house number','street number','zip code','company country','company state','company city','bldg number','house number','street number','Invoice Zip/Postal Code','company invoice country','company invoice state','company invoice city','inv bldg number','inv house number','inv street number','inv zip code','contact person','contact person email','contact person phone number','contact person_number','payment terms']; 
          }

       /*    if($('#payment_terms').val()=="special_terms"){
            array_id_name.push('special_terms');
          }else{
            //array_id_name.remove('special_terms');
            //array_id_name.splice($.inArray('special_terms', array_id_name), 1);
          } */

          if($('#payment_terms').val()== "special_terms"){
            array_id_name.push("special_terms");
            message_array.push("Special Terms")
          }
          

         // console.log(array_id_name);

          var c_person = jQuery('.contact_person');
          var c_person_email = jQuery('.contact_person_email');
          var c_person_number = jQuery('.contact_person_number');

          var c_person_tel_number = jQuery('.contact_person_phone_number');

          var c_client_skype = jQuery('.client_skype');  
          var c_client_wechat = jQuery('.client_wechat');       
          var c_client_whatsapp = jQuery('.client_whatsapp');  
          var c_client_qqmail = jQuery('.client_qqmail');  

          var contact_person = [];
          var contact_person_email = [];
          var contact_person_number = []; 
          var contact_person_tel_number = []; 

          var client_skype = [];  
          var client_wechat = [];        
          var client_whatsapp = [];  
          var client_qqmail = [];  

var contacts_id = [
'contact_person',
'contact_person_email',
'contact_person_number',
'contact_person_phone_number',
'client_skype',
'client_wechat',
'client_whatsapp',
'client_qqmail'
]
          
/* var checked;
for (var index = 0; index < contacts_id.length; index++) {
  var element = jQuery('.'+contacts_id[index]+'');
    for(var i = 0; i < element.length; i++){
            var g_data=$(element[index]).val();
            console.log(contacts_id[index]);
            if(contacts_id[index]=="contact_person_email"){
                      
              if(emailValidator.test(g_data)){
                  
                  contact_person_email.push(g_data);
                    checked="ok";
                  }else{
                 
                  checked="Not Ok"
                  }
              $(element[index]).css("border","1px solid red");
              break;
            }else{
              $(element[index]).removeAttr("style");
            }

          
          }
  
} */



           for(var i = 0; i < c_client_skype.length; i++){
            var g_data=$(c_client_skype[i]).val();
            client_skype.push(g_data);
            /* if(g_data==""){
              count_null+=1;
              $(c_client_skype[i]).css("border","1px solid red");
            }else{
              $(c_client_skype[i]).removeAttr("style");
            } */
          }

           for(var i = 0; i < c_client_wechat.length; i++){
            var g_data=$(c_client_wechat[i]).val();
            client_wechat.push(g_data);
       /*      if(g_data==""){
              count_null+=1;
              $(c_client_wechat[i]).css("border","1px solid red");
            }else{
              $(c_client_wechat[i]).removeAttr("style");
            } */
          }

          for(var i = 0; i < c_client_whatsapp.length; i++){
            var g_data=$(c_client_whatsapp[i]).val();
            client_whatsapp.push(g_data);
   /*          if(g_data==""){
              count_null+=1;
              $(c_client_whatsapp[i]).css("border","1px solid red");
            }else{
              $(c_client_whatsapp[i]).removeAttr("style");
            } */
          }

           for(var i = 0; i < c_client_qqmail.length; i++){
            var g_data=$(c_client_qqmail[i]).val();
            client_qqmail.push(g_data);
           /*  if(g_data==""){
              count_null+=1;
              $(c_client_qqmail[i]).css("border","1px solid red");
            }else{
              $(c_client_qqmail[i]).removeAttr("style");
            } */
          }
          
          
 


var duplicateChecker = 0;
var message;

          for (var index = 0; index < array_id_name.length; index++) {
            
            if(array_id_name[index]=='contact_person' || array_id_name[index]=='contact_person_email'||array_id_name[index]=='contact_person_phone_number'||array_id_name[index]=='contact_person_number'){
              $('#payment_terms').removeAttr("style");
             var a =ContactPerson(array_id_name[index]);
           //  console.log(a);
             if(a==true){
             }else{ 
              message=message_array[index];
              break;
             }
             
             
            }else{
              if(array_id_name[index]=="Company_Email"){
               
                if(emailValidator.test( $('#'+array_id_name[index]+'').val())){
        
        
          checked="ok";
        }else{
          
        checked="Not Ok"
  }
              }
              
            var element = $('#'+array_id_name[index]+'').val();
        //console.log(array_id_name[index]);
            if(element==""){

            count_null+=1;
              $('#'+array_id_name[index]+'').css("border","1px solid red");
            message=message_array[index];
             // console.log(index);
              break;
            }else{
              $('#'+array_id_name[index]+'').removeAttr("style");
              
            } 
            }
          }


  function ContactPerson(state){
    var returnData=0;
//onsole.log(state);
            if(state=="contact_person"){
              for(var i = 0; i < c_person.length; i++){
            var g_data=$(c_person[i]).val();
            contact_person.push(g_data);
            if(g_data==""){
              count_null+=1;
              returnData+=1;
              $(c_person[i]).css("border","1px solid red");
              
             
            }else{
             $(c_person[i]).removeAttr("style");
            
             
            }
          }

            }else if(state=="contact_person_email"){
              for(var i = 0; i < c_person_email.length; i++){
            var g_data=$(c_person_email[i]).val();
            contact_person_email.push(g_data);
            if(g_data==""){
              count_null+=1;
              returnData+=1;
              $(c_person_email[i]).css("border","1px solid red");
                // joe regex
           
            
              
            }else{
              $(c_person_email[i]).removeAttr("style");

               if(emailValidator.test(g_data) ){
        
                if(checked=="Not Ok"){

}else{
checked="ok";
}
        }else{
          
        checked="Not Ok"
  }

             
             
            }

       
           
          }
              
            }else if(state=="contact_person_number"){

            for(var i = 0; i < c_person_number.length; i++){
            var g_data=$(c_person_number[i]).val();
            contact_person_number.push(g_data);
            if(g_data==""){
              count_null+=1;
              returnData+=1;
              $(c_person_number[i]).css("border","1px solid red");
             
              
            }else{
              $(c_person_number[i]).removeAttr("style");
             
             
            }
          }
            }else if(state=="contact_person_phone_number"){

            for(var i = 0; i < c_person_tel_number.length; i++){
            var g_data=$(c_person_tel_number[i]).val();
            contact_person_tel_number.push(g_data);
            if(g_data==""){
              count_null+=1;
              returnData+=1;
              $(c_person_tel_number[i]).css("border","1px solid red");
            
             
            }else{
              $(c_person_tel_number[i]).removeAttr("style");
             
            
            }
          }
            }
           
        
         
if(returnData>=1){
  return false;

}else{
 return true;

}           

  }        
 //console.log(array_id_name);

          if(count_null==0){
           // console.log(checked);
            if(checked=="Not Ok"){


 for(var i = 0; i < c_person_email.length; i++){
            var g_data=$(c_person_email[i]).val();
            contact_person_email.push(g_data);
       
              $(c_person_email[i]).removeAttr("style");
              
               if(emailValidator.test(g_data)){
        
  
        }else{
          $(c_person_email[i]).css("border","1px solid red");
  
  }       
          }

            if(emailValidator.test($('#Company_Email').val())){
        
  
      }else{
        $('#Company_Email').css("border","1px solid red");

}

alert("Please Input Corect Email");
}else{

     if($('#payment_terms').val()== "special_terms"){
      special_terms=$('#special_terms').val();
          }




         
        
         $('.send-loading ').show();
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            e.preventDefault();

            $.ajax({
              type:'POST',
              url:'/addclient',
              data:
              {
                client_name:Company_Name, 
                client_code:client_code, 
                Company_Name:Company_Name,
                Company_Email:Company_Email,
                company_country_name:company_country_name,
                company_state_name:company_state_name,
                company_city_name:company_city_name,
                company_country_id:company_country_id,
                company_state_id:company_state_id,
                company_city_id:company_city_id,
                company_invoice_country_name:company_invoice_country_name,
                company_invoice_state_name:company_invoice_state_name,
                company_invoice_city_name:company_invoice_city_name,
                company_invoice_country_id:company_invoice_country_id,
                company_invoice_state_id:company_invoice_state_id,
                company_invoice_city_id:company_invoice_city_id,
                street_number:street_number,
                house_number:house_number,
                zip_code:zip_code,
                Phone_number:Phone_number,
                payment_terms:payment_terms,
                special_terms:special_terms,
                inv_street_number:inv_street_number,
                inv_house_number:inv_house_number,
                inv_zip_code:inv_zip_code,
                company_bldg_num :company_bldg_num ,
                company_inv_bldg_num :company_inv_bldg_num 
              },
              success:function(data){ 

              }                           
            });
 
            $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });


            $.ajax({
               type:'POST',
               url:'/addclientcontact',
               data:
               {
                  client_code:client_code,
                  contact_person:contact_person,
                  contact_person_email:contact_person_email,
                  contact_person_number:contact_person_number,
                  contact_person_tel_number:contact_person_tel_number,
                  
                  client_skype:client_skype,
                  client_wechat:client_wechat,
                  client_whatsapp:client_whatsapp,
                  client_qqmail:client_qqmail
                
                },
              success:function(data){
                alert("Client successfully added.");
                $('.send-loading ').hide();
                location.reload();
              },
              error: function(){
                alert("Error: Server encountered an error. Please try again or contact your system administrator.");
              }
            });   

            }   
          }else{
            alert(message+" are Required");
          }
                                     
        });





      });

     jQuery('.clr').click(function(e){
      jQuery('.client_name').val()==""
      jQuery('.client_name').removeAttr("style");
      jQuery('#require1').css("display","none");

       jQuery('.client_code').val()==""
      jQuery('.client_code').removeAttr("style");
      jQuery('#require2').css("display","none");

      jQuery('.client_user_name').val()==""
      jQuery('.client_user_name').removeAttr("style");
      jQuery('#require3').css("display","none");

       jQuery('.client_password').val()==""
      jQuery('.client_password').removeAttr("style");
      jQuery('#require4').css("display","none");

       jQuery('.client_email_add').val()==""
      jQuery('.client_email_add').removeAttr("style");
      jQuery('#require5').css("display","none");

     }); 


     function textValidator(input_id){
       if(jQuery('#'+input_id).val()!=""){
            jQuery('#'+input_id).removeAttr("style");
        }
     }

     function cmbValidator(id){
       if($('#'+id).val()!=""){
            $('#'+id).removeAttr("style");
        }
        if(id=='payment_terms'){
          if($('#payment_terms').val()=="special_terms"){
            $('#div_special_terms').show();
          }else{
            $('#div_special_terms').hide();
          }
        }
     }

     function contacPersonValidator(class_name){
       if(jQuery('.'+class_name).val()!=""){
            jQuery('.'+class_name).removeAttr("style");
        }
     }

     function showAllCountryInCompany(){
        $('#company_country').empty();
		$('#company_country').append('<option value="">Please Wait...</option>');
		$.ajax({         
        	url: 'http://world.t-i-c.asia/webapi_world_controller.php'            
          , type: 'POST'
        	, datatype: 'json'
        	, data: {
        	    show_all_country: 1
        	}
        	, success: function (result) {
                //localStorage.setItem("result",result);
              
                $('#company_country').empty();
				        $('#company_country').append('<option value="">Select Country</option>');
              //var data_country=  JSON.parse(result);
              data_country=result;
              data_country.forEach(element => {
                    if(element.name=="" || element.name==null){

                    }else{
                        $('#company_country').append('<option value="'+element.id+'">'+element.name+'</option>');
                        $('#company_invoice_country').append('<option value="'+element.id+'">'+element.name+'</option>');
                        
                    }
                   
                });
               
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#company_country').empty();
        $('#company_country').append('<option value="">Something went wrong. Please try again.</option>');

				$('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
        });
    }
    $('#company_country').on('change', function() {
      showStateByCountryInCompany(this.id,'company_state','comp');
      cmbValidator(this.id);
    });

     $('#company_state').on('change', function() {
      showCityByCountryAndStateInCompany('company_country','hidden_company_state_id','company_city','company');
      cmbValidator(this.id);
    });
    $('#company_city').on('change', function() {
      //showCityByCountryAndStateInCompany('company_country','company_state','company_city');
      cmbValidator(this.id);
    });

    $('#company_invoice_country').on('change', function() {
      showStateByCountryInCompany(this.id,'company_invoice_state','inv');
      cmbValidator(this.id);
    });

     $('#company_invoice_state').on('change', function() {
      showCityByCountryAndStateInCompany('company_invoice_country','hidden_company_invoice_state_id','company_invoice_city','invoice');
      cmbValidator(this.id);
    });
    
    var source_comp_state=[];
    var source_inv_state=[];

$('#company_state').autocomplete({
  maxResults: 10,
  source: function(request, response) {
    var results = $.ui.autocomplete.filter(source_comp_state, request.term);
    
    response(results.slice(0, this.options.maxResults));
  },
  select: function (event, ui) {
      $("#company_state").val(ui.item.label); // display the selected text
      $("#hidden_company_state_id").val(ui.item.value); // save selected id to hidden input
      //showCityByCountryAndStateInCompany('inspector_country','hidden_inspector_state','');
      return false;
  }
});

$('#company_invoice_state').autocomplete({
  maxResults: 10,
  source: function(request, response) {
    var results = $.ui.autocomplete.filter(source_inv_state, request.term);
    
    response(results.slice(0, this.options.maxResults));
  },
  select: function (event, ui) {
      $("#company_invoice_state").val(ui.item.label); // display the selected text
      $("#hidden_company_invoice_state_id").val(ui.item.value); // save selected id to hidden input
      //showCityByCountryAndStateInCompany('inspector_country','hidden_inspector_state','');
      return false;
  }
});

function showStateByCountryInCompany(country_id,select_id,src){
    var id = $('#'+country_id).val();
		//$('#'+select_id).empty();
    //$('#'+select_id).append('<option value="">Please Wait...</option>');
    $('#'+select_id).val('Please Wait...');
		$.ajax({         
        	url: 'http://world.t-i-c.asia/webapi_state_controller.php?id='+id            
        	, type: 'GET'
        	, datatype: 'json'
        	, data: {
        	    show_all_country: 1
        	}
        	, success: function (result) {
              $('#'+select_id).val('');
               if(src=='comp'){
                source_comp_state.length = 0;
               }else{
                source_inv_state.length = 0;
               }
                var data_country= result;
                data_country.forEach(element => {
                    if(element.name=="" || element.name==null){

                    }else{
                       // $('#'+select_id).append('<option value="'+element.id+'">'+element.name+'</option>');
                       if(src=='comp'){
                        source_comp_state.push({value:element.id,label:element.name});
                        }else{
                          source_inv_state.push({value:element.id,label:element.name});
                        }
                    }                  
                });
               
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#'+select_id).empty();
				$('#'+select_id).append('<option value="">Something went wrong. Please try again.</option>');
				$('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
        });
    }

     var source_comp_city=[];
     var source_inv_city=[];

  $('#company_city').autocomplete({
    maxResults: 10,
    source: function(request, response) {
        var results = $.ui.autocomplete.filter(source_comp_city, request.term);

        response(results.slice(0, this.options.maxResults));
      }
  });

    $( "#company_city" ).autocomplete( "option", "appendTo", ".eventInsForm" );

    $('#company_invoice_city').autocomplete({
    maxResults: 10,
    source: function(request, response) {
        var results = $.ui.autocomplete.filter(source_inv_city, request.term);

        response(results.slice(0, this.options.maxResults));
      }
  });

    $( "#company_invoice_city" ).autocomplete( "option", "appendTo", ".eventInsForm" );

    function showCityByCountryAndStateInCompany(country_id,state_id,city_id,source){
        var cid = $('#'+country_id).val();
        var sid = $('#'+state_id).val();
        $('#'+city_id).val('Please wait...');
		    $.ajax({         
        	url: 'http://world.t-i-c.asia/webapi_city_controller.php?state_id='+sid
        	, type: 'GET'
        	, datatype: 'json'
        	, data: {
        	    show_all_country: 1
        	}
        	, success: function (result) {
                console.log(result);
        var data_city=  result;
        if(source=='company'){
          source_comp_city.length = 0;
        }else{
          source_inv_city.length = 0;
        }
          data_city.forEach(element => {
                  if(element.name=="" || element.name==null){

                  }else{
                      if(source=='company'){
                          source_comp_city.push(element.name);
                      }else{
                        source_inv_city.push(element.name);
                      }
                      $('#'+city_id).val('');
                  }                  
				  });
				  
        	},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#'+city_id).empty();
				$('#'+city_id).append('<option value="">Something went wrong. Please try again.</option>');
				$('#result').html('<p>status code: '+jqXHR.status+'</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>'+jqXHR.responseText + '</div>');
				console.log('jqXHR:');
				console.log(jqXHR);
				console.log('textStatus:');
				console.log(textStatus);
				console.log('errorThrown:');
				console.log(errorThrown);
			}
        });
	}


    $('#btn_add_more_fields_client').click(function() {
        $('.clone-inputs:first').clone().appendTo('.client-clone').find("input").val("");
        $('.clone-inputs:last').append('<div class="col-md-1">' +
            '<div class="form-group"><br>' +
            '<button type="button" class="btn btn-danger btn-rm"><i class="fa fa-times"></i></button>' +
            '</div>' +
            '</div>');
           
    });
    $('body').on('click', '.btn-rm', function() {
      $(this).closest('.clone-inputs').remove();
    });
    
    $('#check_invoice').click(function(){
    if (this.checked) {
     
      $('.invoice_class').hide();

    

    }else{
      $('.invoice_class').show();
        }
  }) 

      </script>

{!!Form::close()!!}