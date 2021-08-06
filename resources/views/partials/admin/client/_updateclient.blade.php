<div id="updateClient" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ui-front">

        <!-- Modal content-->
        <!-- ['data-parsley-validate'=>'', 'route'=>'updateclient'] -->
        <div class="modal-content">
            {!!Form::open()!!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Client Details</h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    {{-- <div class="col-md-4">
                  <div class="form-group">
                      {{Form::label('update_client_name','Client Name',['class'=>''])}}
                    {{Form::text('update_client_name',null,['class'=>'form-control update_client_name'])}}
                    <div id="update_require1" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>

                    {{Form::hidden('client_id',null,['class'=>'form-control','id'=>'update_client_id'])}}
                </div>

            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {{Form::label('update_client_code','Client Code',['class'=>''])}}
                    {{Form::text('update_client_code',null,['class'=>'form-control update_client_code'])}}
                    <div id="update_require2" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="form-group">
                    {{Form::label('update_client_user_name','Client Username',['class'=>''])}}
                    {{Form::text('update_client_user_name',null,['class'=>'form-control update_client_user_name'])}}
                    <div id="update_require3" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="form-group">
                    {{Form::label('update_client_password','Client Password',['class'=>''])}}
                    {{Form::password('update_client_password',['class'=>'form-control update_client_password'])}}
                    <div id="update_require4" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>
                </div>

            </div>


            <div class="col-md-4">

                <div class="form-group">

                    {{Form::label('update_confirm_password','Confirm Password',['class'=>''])}}
                    {{Form::password('update_confirm_password',['class'=>'form-control update_confirm_password'])}}
                    <div id="require9" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>
                    <div id="update_matchPassword" style="display:none">
                        <p style="color:red;">Password Not Match! </p>
                    </div>

                </div>
            </div>

            <div class="col-md-4">

                <div class="form-group">
                    {{Form::label('update_client_email_add','Client Email',['class'=>''])}}
                    {{Form::email('client_email_add',null,['class'=>'form-control update_client_email_add'])}}
                    <div id="update_require5" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>
                </div>
            </div> --}}


            {{-- <div class="col-md-12">
                      <div class="form-group">
                          <hr/>
                </div>
                  </div> --}}

            <div class="col-md-12">
                <div class="form-group">
                    <h3> Client Name </h3>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" id="update_client_name" name="update_client_name" class="form-control update_client_name" onchange="inputTextValidator(this.id)">
                    <div id="update_require1" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <h3> Company Details </h3>
                </div>
            </div>

            <div class="col-md-4">

                <div class="form-group">
                    {!!Form::label('update_Company_Name','Company Name',['class'=>''])!!}
                    {{-- {{Form::text('update_Company_Name',null,['class'=>'form-control update_Company_Name'])}} --}}
                    <input type="text" id="update_Company_Name" name="update_Company_Name" class="form-control update_Company_Name" onchange="inputTextValidator(this.id)">
                    {!!Form::hidden('client_id',null,['class'=>'form-control','id'=>'update_client_id'])!!}
                    <div id="update_require10" style="display:none">
                        <p style="color:red;">This field is required! </p>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-4">
                      <div class="form-group">
                          {{Form::label('update_Company_Website','Company Website',['class'=>''])}}
            {{Form::email('update_Company_Website',null,['class'=>'form-control update_Company_Website'])}}
            <div id="update_require11" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div> --}}

    <div class="col-md-4">
        <div class="form-group">
            {!!Form::label('update_Company_Email','Company Email',['class'=>''])!!}
            {{-- {{Form::email('update_Company_Email',null,['class'=>'form-control update_Company_Email'])}} --}}
            <input type="email" id="update_Company_Email" name="update_Company_Email" class="form-control update_Company_Email" onchange="inputTextValidator(this.id)">
            <div id="update_require12" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>



    <div class="col-md-4">
        <div class="form-group">
            {!!Form::label('update_Phone_number','Phone number',['class'=>''])!!}
            {{-- {{Form::text('update_Phone_number',null,['class'=>'form-control update_Phone_number'])}} --}}
            <input type="text" id="update_Phone_number" name="update_Phone_number" class="form-control update_Phone_number" onchange="inputTextValidator(this.id)">
            <div id="update_require15" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="update_company_country">Country</label><span class="error_messages update_company_country"></span>
            <select class="form-control" required data-parsley-required-message="Please select a country!" data-parsley-errors-container=".update_company_country" name="update_company_country" id="update_company_country" onchange="showStateByCountryChange(this.id,'update_company_state','update_company_city','comp')">
                <option value="">Select Country</option>
            </select>
            <div id="#" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="update_company_state">State</label><span class="error_messages update_company_state"></span>
            {{-- <select class="form-control"  name="update_company_state" id="update_company_state" onchange="showCityByCountryAndStateChange('update_company_country',this.id,'update_company_city','comp')">
                      <option value="">Select State</option>
                    </select> --}}
            <input type="text" class="form-control" required name="update_company_state" id="update_company_state">
            <input type="hidden" class="form-control" name="update_company_state_id" id="update_company_state_id">

            <div id="#" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="update_company_city">City</label><span class="error_messages update_company_city"></span>
            {{-- <select class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".update_company_city" name="update_company_city" id="update_company_city" onchange="inputTextValidator(this.id)">
                      <option value="">--Select City--</option>
                    </select> --}}
            <input type="text" class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".update_company_city" name="update_company_city" id="update_company_city" onchange="inputTextValidator(this.id)">

            <div id="#" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>


    <div class="col-md-4">
        <div class="form-group">
            {!!Form::label('update_street_number','Street number / name',['class'=>''])!!}
            {{-- {{Form::text('update_street_number',null,['class'=>'form-control update_street_number'])}} --}}
            <input type="text" id="update_street_number" name="update_street_number" class="form-control update_street_number" onchange="inputTextValidator(this.id)">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!!Form::label('update_house_number','House number',['class'=>''])!!}
            {{-- {{Form::text('update_house_number',null,['class'=>'form-control update_house_number'])}} --}}
            <input type="text" id="update_house_number" name="update_house_number" class="form-control update_house_number" onchange="inputTextValidator(this.id)">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!!Form::label('update_bldg_number','Building number',['class'=>''])!!}
            {{-- {{Form::text('house_number',null,['class'=>'form-control house_number'])}} --}}
            <input type="text" id="update_bldg_number" name="update_bldg_number" class="form-control update_bldg_number" onkeyup="inputTextValidator(this.id)">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!!Form::label('update_zip_code','Zip/Postal Code',['class'=>''])!!}
            {{-- {{Form::text('update_zip_code',null,['class'=>'form-control update_zip_code'])}} --}}
            <input type="text" id="update_zip_code" name="update_zip_code" class="form-control update_zip_code" onchange="inputTextValidator(this.id)">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!!Form::label('update_client_code','Client Code',['class'=>''])!!}
            {!!Form::text('update_client_code',null,['class'=>'form-control update_client_code','maxlength' => 3,'readOnly'])!!}
            <div id="update_require2" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {!!Form::label('online_client','Online Client',['class'=>''])!!}
            <select class="form-control" name="online_client" id="online_client">
                <option value="" disabled selected>Select</option>
                <option value="1" class="text-success">Yes</option>
                <option value="0" class="text-danger">No</option>
            </select>
            <div id="online_client_err" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="checkbox">
            <label><input type="checkbox" value="" id="update_check_invoice"><span id="label_check_invoice">Invoice address same as address. Uncheck if you want to change your invoice address.</span></label>
        </div>
    </div>

    <div class="col-md-4 update_invoice_class">
        <div class="form-group">
            <label for="u_company_invoice_country">Invoice Address Country</label><span class="error_messages u_company_invoice_country"></span>
            <select class="form-control" required data-parsley-required-message="Please select a country!" data-parsley-errors-container=".u_company_invoice_country" name="u_company_invoice_country" id="u_company_invoice_country" onchange="showStateByCountryChange(this.id,'u_company_invoice_state','u_company_invoice_city','inv')">
                <option value="">Select Country</option>
            </select>
            <div id="#" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>

    <div class="col-md-4 update_invoice_class">
        <div class="form-group">
            <label for="u_company_invoice_state">Invoice Address State</label><span class="error_messages u_company_invoice_state"></span>
            {{-- <select class="form-control" required name="u_company_invoice_state" id="u_company_invoice_state" onchange="showCityByCountryAndStateChange('u_company_invoice_country',this.id,'u_company_invoice_city','inv')">
                      <option value="">Select State</option>
                    </select> --}}
            <input type="text" class="form-control" required name="u_company_invoice_state" id="u_company_invoice_state">
            <input type="hidden" class="form-control" required name="u_company_invoice_state_id" id="u_company_invoice_state_id">

            <div id="#" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>

    <div class="col-md-4 update_invoice_class">
        <div class="form-group">
            <label for="u_company_invoice_city">Invoice Address City</label><span class="error_messages u_company_invoice_city"></span>
            {{-- <select class="form-control" required data-parsley-required-message="Please select a city!" data-parsley-errors-container=".u_company_invoice_city" name="u_company_invoice_city" id="u_company_invoice_city" onchange="inputTextValidator(this.id)">
                      <option value="">--Select City--</option>
                    </select> --}}
            <input type="text" class="form-control" required name="u_company_invoice_city" id="u_company_invoice_city">

            <div id="#" style="display:none">
                <p style="color:red;">This field is required! </p>
            </div>
        </div>
    </div>

    <div class="col-md-4 update_invoice_class">
        <div class="form-group">
            {!!Form::label('update_inv_bldg_number','Invoice Building number',['class'=>''])!!}
            {{-- {{Form::text('house_number',null,['class'=>'form-control house_number'])}} --}}
            <input type="text" id="update_inv_bldg_number" name="update_inv_bldg_number" class="form-control update_inv_bldg_number" onkeyup="textValidator(this.id)">
        </div>
    </div>

    <div class="col-md-4 update_invoice_class">
        <div class="form-group">
            {!!Form::label('update_inv_house_number','Invoice House number',['class'=>''])!!}
            {{-- {{Form::text('house_number',null,['class'=>'form-control house_number'])}} --}}
            <input type="text" id="update_inv_house_number" name="update_inv_house_number" class="form-control update_inv_house_number" onkeyup="textValidator(this.id)">
        </div>
    </div>


    <div class="col-md-4 update_invoice_class">
        <div class="form-group">
            {!!Form::label('update_inv_street_number','Invoice Street number / name',['class'=>''])!!}
            {{-- {{Form::text('street_number',null,['class'=>'form-control street_number'])}} --}}
            <input type="text" id="update_inv_street_number" name="update_inv_street_number" class="form-control update_inv_street_number" onkeyup="textValidator(this.id)">
        </div>
    </div>


    <div class="col-md-4 update_invoice_class">
        <div class="form-group">
            {!!Form::label('update_inv_zip_code','Invoice Zip/Postal Code',['class'=>''])!!}
            {{-- {{Form::text('zip_code',null,['class'=>'form-control zip_code'])}} --}}
            <input type="text" id="update_inv_zip_code" name="update_inv_zip_code" class="form-control update_inv_zip_code" onkeyup="textValidator(this.id)">
        </div>
    </div>

    {{-- <div class="col-md-4">
                  <div class="form-group">
                      {{Form::label('update_Invoice_Address','Invoice Address',['class'=>''])}}
    {{Form::text('update_Invoice_Address',null,['class'=>'form-control update_Invoice_Address'])}}
    <div id="update_require14" style="display:none">
        <p style="color:red;">This field is required! </p>
    </div>
</div>
</div> --}}




{{-- <div class="col-md-4">
                      <div class="form-group">
                          {{Form::label('update_Company_Address','Company Address',['class'=>''])}}
{{Form::text('update_Company_Address',null,['class'=>'form-control update_Company_Address'])}}
<div id="update_require13" style="display:none">
    <p style="color:red;">This field is required! </p>
</div>
</div>
</div> --}}

{{-- <div class="col-md-8">
                    <div class="form-group">
                        {{Form::label('update_Company_Address','Company Address',['class'=>''])}}



{!! Form::textarea('update_Company_Address',null, array('class'=>'form-control update_Company_Address',
'rows' => 5, 'cols' => 500)) !!}




<div id="update_require13" style="display:none">
    <p style="color:red;">This field is required! </p>
</div>
</div>
</div>
--}}






<div class="col-md-12">
    <div class="form-group">
        <hr />
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">
        <h3> Contact Person </h3>
    </div>
</div>

<div id="div_edit_more_fields_client">

</div>

<div class="col-md-12">
    <div class="form-group">
        {!! Form::button('<i class="fa fa-plus"></i> Add more contact person', ['class' => 'btn btn-primary btn-add-new','id'=>'new-add-btn-cperson', 'data-id'=>'0']) !!}
    </div>
</div>


<div class="col-md-12">
    <div class="form-group">
        <hr />
    </div>
</div>
<div class="col-md-12">
    <div class="form-group">


        <h4 class="modal-title">Others</h4>
    </div>
</div>

<div class="col-md-6">
    <div class="form-group">
        <label for="update_payment_terms">Payment Terms</label><span class="error_messages "></span>
        <select class="form-control update_payment_terms" required data-parsley-required-message="Please select a payment!" data-parsley-errors-container=".payment_terms" name="payment_terms" id="update_payment_terms" onchange="inputTextValidator(this.id)">
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
    </div>
</div>


<div class="col-md-6" style="display:none;" id="update_div_special_terms">
    <div class="form-group">
        {!!Form::label('update_special_terms','Special Terms',['class'=>''])!!}
        {!!Form::text('update_special_terms',null,['class'=>'form-control special_terms','placeholder'=>'Input special terms here'])!!}
    </div>
</div>
{{-- 06-11-2021 --}}
<div class="col-md-6">
    <div class="form-group">
        <label>Sales Manager</label>
        {{-- <input type="text" id="sales_id"> --}}
        <select class="form-control update_sales_manager" name="update_sales_manager" id="update_sales_manager" onchange="inputTextValidator(this.id)">
        </select>
    </div>
</div>

 {{-- 06-28-2021 --}}
 <div class="col-md-6">
    <div class="form-group">
        <label for="update_related_by">* Clients Related By:</label>
        <select class="form-control update_related_by" name="update_related_by" id="update_related_by">
            <option value="">--Select Here--</option>
            <option value="Website">Website</option>
            <option value="Google Ads">Google Ads</option>
            <option value="Recommendation">Recommendation</option>
            <option value="Friends">Friends</option>
            <option value="others">Others</option>    
        </select>
    </div>
</div>
<div class="col-md-6" style="display:none;" id="update_div_related_others">
    <div class="form-group">
        {!!Form::label('update_others','Others',['class'=>''])!!}
        {!!Form::text('update_others',null,['class'=>'form-control update_others','placeholder'=>'Input others here'])!!}
    </div>
</div>

</div>

</div>
<div class="modal-footer">
    {!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-danger clr','data-dismiss' => "modal"]) !!}
    {!! Form::button('<i class="fa fa-floppy-o"></i> Save Client Details', ['class' => 'btn btn-success', 'id'=>'update_save']) !!}

</div>

</div>

</div>
</div>

<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>

<script>
    var emailValidator = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    function update_Client_data(id) {
        var sure_delete = confirm("Are you sure you want to delete this?");
        var dis_btn = this;
        if (sure_delete) {
            //alert(id);
            $('.send-loading ').show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '/deleteContact',
                data: {
                    contact_id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#' + data).remove();
                    alert("successfully deleted");
                    $('.send-loading ').hide();
                },
                error: function() {
                    alert("Error: Server encountered an error. Please try again or contact your system administrator.");
                }
            });
        }
    }

    jQuery(document).ready(function() {




        $('#update_check_invoice').click(function() {
            if (this.checked) {
                $('.update_invoice_class').hide();
            } else {
                $('.update_invoice_class').show();
            }

        });
        /* if ($('#update_check_invoice').prop('checked')==true) {
              alert("checked");
            }else{
              alert("unchecked");
            } */

        // jQuery('.save').prop('disabled', true);




        /* jQuery('.update_client_name').keyup(function(e){
          if(jQuery('.update_client_name').val()!=""){
            jQuery('.update_client_name').removeAttr("style");
            jQuery('#update_require1').css("display","none");
          }
        });

jQuery('.update_client_code').keyup(function(e){
          if(jQuery('.update_client_code').val()!=""){
            jQuery('.update_client_code').removeAttr("style");
            jQuery('#update_require2').css("display","none");
          }
        });

        jQuery('.update_client_user_name').keyup(function(e){
          if(jQuery('.update_client_user_name').val()!=""){
            jQuery('.update_client_user_name').removeAttr("style");
            jQuery('#update_require3').css("display","none");
          }
        });

        jQuery('.update_client_password').keyup(function(e){
          if(jQuery('.update_client_password').val()!=""){
            jQuery('.update_client_password').removeAttr("style");
            jQuery('#update_require4').css("display","none");
          }
        });

        jQuery('.update_client_email_add').keyup(function(e){
          if(jQuery('.update_client_email_add').val()!=""){
            jQuery('.update_client_email_add').removeAttr("style");
            jQuery('#update_require5').css("display","none");
          }
        });

         jQuery('.update_contact_person').keyup(function(e){
          if(jQuery('.update_contact_person').val()!=""){
            jQuery('.update_contact_person').removeAttr("style");
            jQuery('#update_require6').css("display","none");
          }
        });

           jQuery('.update_contact_person_email').keyup(function(e){
          if(jQuery('.update_contact_person_email').val()!=""){
            jQuery('.update_contact_person_email').removeAttr("style");
            jQuery('#update_require7').css("display","none");
          }
        });

           jQuery('.update_contact_person_number').keyup(function(e){
          if(jQuery('.update_contact_person_number').val()!=""){
            jQuery('.update_contact_person_number').removeAttr("style");
            jQuery('#update_require8').css("display","none");
          }
        }); */


        jQuery('#update_save').click(function(e) {
            var checked = "ok";
            /* var client_name = jQuery('.update_client_name').val();
            var client_name = jQuery('.update_client_name').val();
            var client_code = jQuery('.update_client_code').val();
            var client_un = jQuery('.update_client_user_name').val();
            var client_pass = jQuery('.update_client_password').val();
            var client_email = jQuery('.update_client_email_add').val(); */

            var count_null = 0; //variable for counting the null values
            var client_name = jQuery('.update_client_name').val();
            var client_code = jQuery('.update_client_code').val();
            var Company_Name = jQuery('.update_Company_Name').val();
            var Company_Website = "";
            var Company_Email = jQuery('.update_Company_Email').val();
            var Company_Address = jQuery('.update_Company_Address').val();
            var Invoice_Address = jQuery('.update_Invoice_Address').val();
            var Phone_number = jQuery('.update_Phone_number').val();
            var client_id = jQuery('#update_client_id').val();

            var sales_manager = jQuery('#update_sales_manager option:selected').val();

            var update_related_by = jQuery('#update_related_by').val(); //06-28-2021

            var others = jQuery('#update_others').val();

            var update_company_country_id = jQuery('#update_company_country').val();
            var update_company_state_id = jQuery('#update_company_state_id').val();
            var update_company_city_id = jQuery('#update_company_city').val();

            var update_company_country_name = jQuery('#update_company_country option:selected').text();
            var online_client = jQuery('#online_client option:selected').val(); // Online CLient
            /*   var update_company_state_name = jQuery('#update_company_state option:selected').text();
              var update_company_city_name = jQuery('#update_company_city option:selected').text(); */

            var update_company_state_name = jQuery('#update_company_state').val();
            var update_company_city_name = jQuery('#update_company_city').val();


            var update_bldg_number = jQuery('#update_bldg_number').val();

            var update_street_number = jQuery('#update_street_number').val();
            var update_house_number = jQuery('#update_house_number').val();
            var update_zip_code = jQuery('#update_zip_code').val();

            var company_invoice_country_id;
            var company_invoice_state_id;
            var company_invoice_city_id;

            var company_invoice_country_name;
            var company_invoice_state_name;
            var company_invoice_city_name;

            var update_inv_bldg_number;
            var update_inv_street_number;
            var update_inv_house_number;
            var update_inv_zip_code;

            if ($('#update_check_invoice').prop('checked') == true) {
                company_invoice_country_id = update_company_country_id;
                company_invoice_state_id = update_company_state_id;
                company_invoice_city_id = update_company_city_id;
                company_invoice_country_name = update_company_country_name;
                company_invoice_state_name = update_company_state_name;
                company_invoice_city_name = update_company_city_name;

                update_inv_bldg_number = update_bldg_number;
                update_inv_street_number = update_street_number;
                update_inv_house_number = update_house_number;
                update_inv_zip_code = update_zip_code;
            } else {
                company_invoice_country_id = jQuery('#u_company_invoice_country').val();
                company_invoice_state_id = jQuery('#u_company_invoice_state_id').val();
                company_invoice_city_id = jQuery('#u_company_invoice_city').val();
                company_invoice_country_name = jQuery('#u_company_invoice_country option:selected').text();
                /*  company_invoice_state_name = jQuery('#u_company_invoice_state option:selected').text();
                 company_invoice_city_name = jQuery('#u_company_invoice_city option:selected').text(); */
                company_invoice_state_name = jQuery('#u_company_invoice_state').val();
                company_invoice_city_name = jQuery('#u_company_invoice_city').val();

                update_inv_bldg_number = jQuery('#update_inv_bldg_number').val();
                update_inv_street_number = jQuery('#update_inv_street_number').val();
                update_inv_house_number = jQuery('#update_inv_house_number').val();
                update_inv_zip_code = jQuery('#update_inv_zip_code').val();
            }

            var payment_term = jQuery('#update_payment_terms').val();
            // var sales_manager = jQuery('.update_sales_manager').val(); //06-11-2021
            
           

            var cperson = jQuery('.update_contact_person');
            var cperson_email = jQuery('.update_contact_person_email');
            var cperson_number = jQuery('.update_contact_person_number');
            var cperson_tel_number = jQuery('.update_contact_tel_number');



            var cperson_id = jQuery('.update_contact_id');



            var contact_person = [];
            var contact_person_email = [];
            var contact_person_number = [];
            var contact_person_tel_number = [];

            var d_client_skype = [];
            var d_client_wechat = [];
            var d_client_whatsapp = [];
            var d_client_qqmail = [];

            var c_client_skype = jQuery('.update_client_skype');
            var c_client_wechat = jQuery('.update_client_wechat');
            var c_client_whatsapp = jQuery('.update_client_whatsapp');
            var c_client_qqmail = jQuery('.update_client_qqmail');
            var contact_id = [];

            for (var i = 0; i < c_client_skype.length; i++) {
                var g_data = $(c_client_skype[i]).val();
                d_client_skype.push(g_data);
                if (g_data == "") {
                    count_null += 1;
                    $(c_client_skype[i]).css("border", "1px solid red");
                } else {
                    $(c_client_skype[i]).removeAttr("style");
                }
            }

            for (var i = 0; i < c_client_wechat.length; i++) {
                var g_data = $(c_client_wechat[i]).val();
                d_client_wechat.push(g_data);
                if (g_data == "") {
                    count_null += 1;
                    $(c_client_wechat[i]).css("border", "1px solid red");
                } else {
                    $(c_client_wechat[i]).removeAttr("style");
                }
            }

            for (var i = 0; i < c_client_whatsapp.length; i++) {
                var g_data = $(c_client_whatsapp[i]).val();
                d_client_whatsapp.push(g_data);
                if (g_data == "") {
                    count_null += 1;
                    $(c_client_whatsapp[i]).css("border", "1px solid red");
                } else {
                    $(c_client_whatsapp[i]).removeAttr("style");
                }
            }

            for (var i = 0; i < c_client_qqmail.length; i++) {
                var g_data = $(c_client_qqmail[i]).val();
                d_client_qqmail.push(g_data);
                if (g_data == "") {
                    count_null += 1;
                    $(c_client_qqmail[i]).css("border", "1px solid red");
                } else {
                    $(c_client_qqmail[i]).removeAttr("style");
                }
            }

            for (var i = 0; i < cperson.length; i++) {
                var g_data = $(cperson[i]).val();
                contact_person.push(g_data);
                if (g_data == "") {
                    count_null += 1;
                    $(cperson[i]).css("border", "1px solid red");
                } else {
                    $(cperson[i]).removeAttr("style");
                }
            }
            for (var i = 0; i < cperson_email.length; i++) {
                var g_data = $(cperson_email[i]).val();
                contact_person_email.push(g_data);
                if (g_data == "") {
                    count_null += 1;
                    $(cperson_email[i]).css("border", "1px solid red");
                } else {
                    $(cperson_email[i]).removeAttr("style");

                    if (emailValidator.test(g_data)) {

                        if (checked == "Not Ok") {

                        } else {
                            checked = "ok";
                        }
                    } else {

                        checked = "Not Ok"
                    }
                }
            }
            for (var i = 0; i < cperson_number.length; i++) {
                var g_data = $(cperson_number[i]).val();
                contact_person_number.push(g_data);
                if (g_data == "") {
                    count_null += 1;
                    $(cperson_number[i]).css("border", "1px solid red");
                } else {
                    $(cperson_number[i]).removeAttr("style");
                }
            }

            for (var i = 0; i < cperson_tel_number.length; i++) {
                var g_data = $(cperson_tel_number[i]).val();
                contact_person_tel_number.push(g_data);
                if (g_data == "") {
                    count_null += 1;
                    $(cperson_tel_number[i]).css("border", "1px solid red");
                } else {
                    $(cperson_tel_number[i]).removeAttr("style");
                }
            }


            for (var i = 0; i < cperson_id.length; i++) {
                var g_data = $(cperson_id[i]).val();
                contact_id.push(g_data);
                /* if(g_data==""){
                  count_null+=1;
                $(cperson_id[i]).css("border","1px solid red");
                }else{
                  $(cperson_id[i]).removeAttr("style");
                } */
            }

            var up_client_id_name = ['update_client_name','update_Company_Name', 'online_client','update_client_code', 'update_Phone_number', 'update_company_country', 'update_company_state', 'update_company_city', 'update_street_number', 'update_house_number', 'update_zip_code', 'u_company_invoice_country', 'u_company_invoice_state', 'u_company_invoice_city', 'update_payment_terms'];


            up_client_id_name.forEach(element => {
                var val = $('#' + element).val();
                if (val == "") {
                    count_null += 1;
                    $('#' + element).css("border", "1px solid red");
                } else {
                    $('#' + element).removeAttr("style");
                }
            });

            if (count_null == 0) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                console.log(checked);
                if (emailValidator.test($('#update_Company_Email').val())) {
                    if (checked == "Not Ok") {
                        for (var i = 0; i < cperson_email.length; i++) {
                            var g_data = $(cperson_email[i]).val();
                            contact_person_email.push(g_data);

                            $(cperson_email[i]).removeAttr("style");

                            if (emailValidator.test(g_data)) {

                                if (checked == "Not Ok") {

                                } else {
                                    $(cperson_email[i]).removeAttr("style");
                                }
                            } else {

                                $(cperson_email[i]).css("border", "1px solid red");
                                alert("email not Valid");
                            }

                        }

                    } else {
                        $('.send-loading ').show();
                        $.ajax({
                            type: 'POST',
                            url: '/updateclient',
                            data: {
                                client_id: client_id,
                                online_client: online_client,
                                client_code: client_code,
                                client_name: client_name,
                                Company_Name: Company_Name,
                                Company_Website: Company_Website,
                                Company_Email: Company_Email,
                                Phone_number: Phone_number,
                                payment_term: payment_term,
                                sales_manager: sales_manager, //06-11-2021
                                related_by: update_related_by, //06-28-2021
                                others: others,

                                company_country_name: update_company_country_name,
                                company_state_name: update_company_state_name,
                                company_city_name: update_company_city_name,
                                company_country_id: update_company_country_id,
                                company_state_id: update_company_state_id,
                                company_city_id: update_company_city_id,

                                update_bldg_number: update_bldg_number,
                                update_inv_bldg_number: update_inv_bldg_number,


                                street_number: update_street_number,
                                house_number: update_house_number,
                                zip_code: update_zip_code,

                                update_inv_street_number: update_inv_street_number,
                                update_inv_house_number: update_inv_house_number,
                                update_inv_zip_code: update_inv_zip_code,

                                company_invoice_country_id: company_invoice_country_id,
                                company_invoice_state_id: company_invoice_state_id,
                                company_invoice_city_id: company_invoice_city_id,
                                company_invoice_country_name: company_invoice_country_name,
                                company_invoice_state_name: company_invoice_state_name,
                                company_invoice_city_name: company_invoice_city_name
                            },
                            success: function(data) {


                            }

                        });




                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        /* var contact_person = jQuery('.update_contact_person').val();
                        var contact_person_email = jQuery('.update_contact_person_email').val();
                        var contact_person_number = jQuery('.update_contact_person_number').val(); */


                        console.log(contact_id);

                        $.ajax({
                            type: 'POST',
                            url: '/updatecontact',
                            data: {
                                client_code: client_code,
                                contact_id: contact_id,
                                contact_person: contact_person,
                                contact_person_email: contact_person_email,
                                contact_person_number: contact_person_number,
                                contact_person_tel_number: contact_person_tel_number,

                                client_skype: d_client_skype,
                                client_wechat: d_client_wechat,
                                client_whatsapp: d_client_whatsapp,
                                client_qqmail: d_client_qqmail


                            },
                            success: function(data) {
                                swal({
                                    title: "Success",
                                    text: "Client Successfully Updated.",
                                    icon: "success",
                                    button: "Ok",
                                    });
                                $('.send-loading ').hide();

                                location.reload();
                            }

                        });
                    }

                } else {
                    alert("Email is not Valid");
                    $('#update_Company_Email').css("border", "1px solid red");

                }

            } else {
                swal("Error", "Please fill-up all the fields! Put N/A if unavailable.", "error");
            }
        });

        jQuery('#update_save_old').click(function(e) {


            for (var x = 0; x <= 7; x++) {
                if (jQuery('.update_client_name').val() == "") {
                    jQuery('.update_client_name').css('border-color', 'red');
                    jQuery('#update_require1').css("display", "block");
                    x = 8;

                } else if (jQuery('.update_client_code').val() == "") {
                    jQuery('.update_client_code').css('border-color', 'red');
                    jQuery('#update_require2').css("display", "block");
                    x = 8;
                } else if (jQuery('.update_client_user_name').val() == "") {
                    jQuery('.update_client_user_name').css('border-color', 'red');
                    jQuery('#update_require3').css("display", "block");
                    x = 8;
                } else if (jQuery('.update_client_password').val() == "") {
                    jQuery('.update_client_password').css('border-color', 'red');
                    jQuery('#update_require4').css("display", "block");
                    x = 8;
                } else if (jQuery('.update_client_email_add').val() == "") {
                    jQuery('.update_client_email_add').css('border-color', 'red');
                    jQuery('#update_require5').css("display", "block");
                    x = 8;
                } else if (jQuery('.update_contact_person').val() == "") {
                    jQuery('.update_contact_person').css('border-color', 'red');
                    jQuery('#update_require6').css("display", "block");
                    x = 8;
                } else if (jQuery('.update_contact_person_email').val() == "") {
                    jQuery('.update_contact_person_email').css('border-color', 'red');
                    jQuery('#update_require7').css("display", "block");
                    x = 8;
                } else if (jQuery('.update_contact_person_number').val() == "") {
                    jQuery('.update_contact_person_number').css('border-color', 'red');
                    jQuery('#update_require8').css("display", "block");
                    x = 8;
                } else if (jQuery('.update_payment_terms').val() == "") {
                    jQuery('.update_payment_terms').css('border-color', 'red');
                    jQuery('#update_payment_terms3').css("display", "block");
                    x = 8;
                } else {
                    if (jQuery('.update_client_password').val() != jQuery('.update_confirm_password').val()) {
                        /* jQuery('.contact_person_number').css('border-color', 'red'); */
                        jQuery('#update_matchPassword').css("display", "block");

                    } else {
                        var client_name = jQuery('.update_client_name').val();
                        var client_code = jQuery('.update_client_code').val();
                        var client_un = jQuery('.update_client_user_name').val();
                        var client_pass = jQuery('.update_client_password').val();
                        var client_email = jQuery('.update_client_email_add').val();

                        var Company_Name = jQuery('.update_Company_Name').val();
                        /* var Company_Website = jQuery('.update_Company_Website').val(); */
                        var Company_Website = "";
                        var Company_Email = jQuery('.update_Company_Email').val();
                        var Company_Address = jQuery('.update_Company_Address').val();
                        var Invoice_Address = jQuery('.update_Invoice_Address').val();
                        var Phone_number = jQuery('.update_Phone_number').val();
                        var client_id = jQuery('#update_client_id').val();


                        var payment_term = jQuery('#update_payment_terms').val();


                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        e.preventDefault();

                        $.ajax({
                            type: 'POST',
                            url: '/updateclient',
                            data: {
                                client_id: client_id,
                                client_name: client_name,
                                client_code: client_code,
                                client_un: client_un,
                                client_pass: client_pass,
                                client_email: client_email,
                                Company_Name: Company_Name,
                                Company_Website: Company_Website,
                                Company_Email: Company_Email,
                                Company_Address: Company_Address,
                                Invoice_Address: Invoice_Address,
                                Phone_number: Phone_number,
                                payment_term: payment_term,
                            },
                            success: function(data) {


                            }

                        });


                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        /*   var client_code = jQuery('#new_client_code').val();
                                  var client_name = jQuery('#new_client_name').val(); */
                        var contact_person = jQuery('.update_contact_person').val();
                        var contact_person_email = jQuery('.update_contact_person_email').val();
                        var contact_person_number = jQuery('.update_contact_person_number').val();
                        var contact_id = jQuery('#update_contact_client_id').val();
                        $.ajax({
                            type: 'POST',
                            url: '/updatecontact',
                            data: {
                                contact_id: contact_id,
                                client_code: client_code,
                                client_name: client_name,
                                contact_person: contact_person,
                                contact_person_email: contact_person_email,
                                contact_person_number: contact_person_number
                            },
                            success: function(data) {
                                alert("Success");
                                $('.clr').click();
                                location.reload();
                            }

                        });

                        /* alert("Success"); */
                        /*  $('.clr').click(); */
                        /*  location.reload(); */
                        x = 8;
                    }
                }
            }
        });


    });

    jQuery('.clr').click(function(e) {
        jQuery('.client_name').val() == ""
        jQuery('.client_name').removeAttr("style");
        jQuery('#require1').css("display", "none");

        jQuery('.client_code').val() == ""
        jQuery('.client_code').removeAttr("style");
        jQuery('#require2').css("display", "none");

        jQuery('.client_user_name').val() == ""
        jQuery('.client_user_name').removeAttr("style");
        jQuery('#require3').css("display", "none");

        jQuery('.client_password').val() == ""
        jQuery('.client_password').removeAttr("style");
        jQuery('#require4').css("display", "none");

        jQuery('.client_email_add').val() == ""
        jQuery('.client_email_add').removeAttr("style");
        jQuery('#require5').css("display", "none");

    });

    jQuery('#update_payment_terms').change(function(e) {
        if (jQuery('#update_payment_terms').val() == "special_terms") {
            jQuery('#update_div_special_terms').css("display", "block");
        } else {
            jQuery('#update_div_special_terms').css("display", "none");
        }
    });

</script>


<script>
    function contacPersonValidator(class_name) {

        if (jQuery('.' + class_name).val() != "") {
            jQuery('.' + class_name).removeAttr("style");
        }
    }

    $('#update_company_state').autocomplete({
        maxResults: 10,
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(update_comp_source_state, request.term);

            response(results.slice(0, this.options.maxResults));
        },
        select: function(event, ui) {
            $("#update_company_state").val(ui.item.label); // display the selected text
            $("#update_company_state_id").val(ui.item.value); // save selected id to hidden input
            showCityByCountryAndStateChange('update_company_country', 'update_company_state_id', 'update_company_city', 'comp')
            return false;
        }
    });


    $('#u_company_invoice_state').autocomplete({
        maxResults: 10,
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(update_inv_source_state, request.term);

            response(results.slice(0, this.options.maxResults));
        },
        select: function(event, ui) {
            $("#u_company_invoice_state").val(ui.item.label); // display the selected text
            $("#u_company_invoice_state_id").val(ui.item.value); // save selected id to hidden input
            showCityByCountryAndStateChange('u_company_invoice_country', 'u_company_invoice_state_id', 'u_company_invoice_city', 'inv')
            return false;
        }
    });

    function showStateByCountryChange(sel_country_id, sel_state_id, sel_city_id, src) {
        inputTextValidator(sel_country_id);
        var id = $('#' + sel_country_id).val();
        //$('#'+sel_state_id).empty();
        //$('#'+sel_state_id).append('<option value="">Please Wait...</option>');
        //$('#'+sel_city_id).empty();
        //$('#'+sel_city_id).append('<option value="">Select City</option>');
        $('#' + sel_state_id).val('Please wait...');
        $.ajax({
            url: '/get-state/' + id,
            type: 'GET',
            success: function(result) {
                //console.log(result);
                //$('#'+sel_state_id).empty();
                //$('#'+sel_state_id).append('<option value="">Select State</option>');
                /* var data_country=  JSON.parse(result); */
                $('#' + sel_state_id).val('');
                if (src == 'comp') {
                    update_comp_source_state.length = 0;
                } else {
                    update_inv_source_state.length = 0;
                }
                //var data_country = result;
                var data_country = JSON.parse(result);
                data_country.forEach(element => {
                    if (element.name == "" || element.name == null) {

                    } else {
                        //$('#'+sel_state_id).append('<option value="' + element.id + '">' + element.name + '</option>');
                        if (src == 'comp') {
                            update_comp_source_state.push({
                                value: element.id,
                                label: element.name
                            });
                        } else {
                            update_inv_source_state.push({
                                value: element.id,
                                label: element.name
                            });
                        }
                    }
                });


            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#' + sel_state_id).empty();
                $('#' + sel_state_id).append('<option value="">Something went wrong. Please try again.</option>');
                $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });
    }

    $('#update_company_city').autocomplete({
        maxResults: 10,
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(update_comp_source_city, request.term);

            response(results.slice(0, this.options.maxResults));
        }
    });

    $('#u_company_invoice_city').autocomplete({
        maxResults: 10,
        source: function(request, response) {
            var results = $.ui.autocomplete.filter(update_inv_source_city, request.term);

            response(results.slice(0, this.options.maxResults));
        }
    });


    function showCityByCountryAndStateChange(sel_country_id, sel_state_id, sel_city_id, source) {
        var cid = $('#' + sel_country_id).val();
        var sid = $('#' + sel_state_id).val();

        inputTextValidator(sel_state_id);

        //$('#'+sel_city_id).empty();
        //$('#'+sel_city_id).append('<option value="">Please Wait...</option>');
        $('#' + sel_city_id).val('Please wait...');
        $.ajax({
            url: '/get-city/' + sid,
            type: 'GET',
            success: function(result) {
                //console.log(result);
                //$('#'+sel_city_id).empty();
                //$('#'+sel_city_id).append('<option value="">Select City</option>');
                //var data_city=  JSON.parse(result);
                $('#' + sel_city_id).val('');
                //var data_city = result;
                var data_city = JSON.parse(result);
                if (source == 'comp') {
                    update_comp_source_city.length = 0;
                } else {
                    update_inv_source_city.length = 0;
                }
                data_city.forEach(element => {
                    if (element.name == "" || element.name == null) {

                    } else {
                        //$('#'+sel_city_id).append('<option value="' + element.id + '">' + element.name + '</option>');
                        if (source == 'comp') {
                            update_comp_source_city.push(element.name);
                        } else {
                            update_inv_source_city.push(element.name);
                        }
                    }
                });


            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#' + sel_city_id).empty();
                $('#' + sel_city_id).append('<option value="">Something went wrong. Please try again.</option>');
                $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
                console.log('jqXHR:');
                console.log(jqXHR);
                console.log('textStatus:');
                console.log(textStatus);
                console.log('errorThrown:');
                console.log(errorThrown);
            }
        });
    }

    function inputTextValidator(input_id) {
        if (jQuery('#' + input_id).val() != "") {
            jQuery('#' + input_id).removeAttr("style");
        }
    }
    //06-29-2021
     $('#update_related_by').on('change', function() {
            if ( this.value == 'others')
            {
                $('#update_div_related_others').show();
            }
            else
            {
                $('#update_div_related_others').hide();
            }
    });

</script>
{!!Form::close()!!}
