<div id="updateClient" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg ui-front">
        <!-- Modal content-->
        <!-- ['data-parsley-validate'=>'', 'route'=>'updateclient'] -->
        <div class="modal-content">
            {!!Form::open()!!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Approve / Reject Client Registration</h4>
            </div>
            <div class="modal-body">
                <div class="row">




                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('update_client_name','Full Name',['class'=>''])!!}
                            <input type="text" id="update_client_name" name="update_client_name" class="form-control update_client_name" onchange="inputTextValidator(this.id)" readonly>
                            {!!Form::hidden('client_id',null,['class'=>'form-control','id'=>'update_client_id'])!!}
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('update_Company_Name','Company Name',['class'=>''])!!}
                            <input type="text" id="update_Company_Name" name="update_Company_Name" class="form-control update_Company_Name" onchange="inputTextValidator(this.id)" readonly>

                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('update_company_country2','Country',['class'=>''])!!}
                            <input type="text" id="update_company_country2" name="update_company_country2" class="form-control update_company_country" onchange="inputTextValidator(this.id)" readonly>

                        </div>
                    </div>



                    <div class="col-md-3">
                        <div class="form-group">
                            {!!Form::label('update_Phone_number','Telephone Number',['class'=>''])!!}
                            <input type="text" id="update_Phone_number" name="update_Phone_number" class="form-control update_Phone_number" onchange="inputTextValidator(this.id)" readonly>

                        </div>
                    </div>



                    <div class="col-md-3">
                        <div class="form-group">
                            {!!Form::label('update_Company_Email','Email Address',['class'=>''])!!}
                            <input type="text" id="update_Company_Email" name="update_Company_Email" class="form-control update_Company_Email" onchange="inputTextValidator(this.id)" readonly>

                        </div>
                    </div>










                    <!--  <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('update_Company_Name','Company Name',['class'=>''])!!}
              <input type="text" id="update_Company_Name" name="update_Company_Name" class="form-control update_Company_Name" onchange="inputTextValidator(this.id)" readonly>
             
            </div>  
          </div>



          <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('update_Company_Email','Company Email',['class'=>''])!!}
              <input type="email" id="update_Company_Email" name="update_Company_Email" class="form-control update_Company_Email" onchange="inputTextValidator(this.id)" readonly>
            </div>  
          </div>-->



                    <!-- <div class="col-md-4">
            <div class="form-group">
              {!!Form::label('update_client_code','Client Code',['class'=>''])!!}
              {!!Form::text('update_client_code',null,['class'=>'form-control update_client_code new_reg_client','maxlength' => 3, 'style'=>'text-transform:uppercase'])!!}
            </div>   
          </div>-->



                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="new_reg_payment_terms"><span class="text-danger"></span> Payment Terms</label><span class="error_messages"></span>
                            <select class="form-control new_reg_client" required name="new_reg_payment_terms" id="new_reg_payment_terms" onchange="payment_change(this.id)">
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
                    <div class="col-md-3">
                        <div class="form-group">
                            {!!Form::label('online_client','Online Client',['class'=>''])!!}
                            <select class="form-control" name="online_client" id="online_client" required>
                                <option value="" disabled selected>Select</option>
                                <option value="1" class="text-success">Yes</option>
                                <option value="0" class="text-danger">No</option>
                            </select>
                            <div id="online_client_err" style="display:none">
                                <p style="color:red;">This field is required! </p>
                            </div>
                        </div>
                    </div>

                     {{-- 07-08-2021 --}}
                     <div class="col-md-3">
                        <div class="form-group">
                            <label>Sales Manager</label>
                            <select class="form-control" required data-parsley-required-message="Select sales manager" data-parsley-errors-container=".sales_manager" name="sales_manager" id="sales_manager">
                                <option value="">--Select Sales Manager--</option>
                                @foreach ($sales as $sale)
                                <option value="{{$sale->user_id}}">{{$sale->name}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- 07-15-2021 --}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>* Clients Related By:</label>
                            <select class="form-control" name="related_by" id="related_by">
                                <option value="">--Select Here--</option>
                                <option value="Website">Website</option>
                                <option value="Google Ads">Google Ads</option>
                                <option value="Recommendation">Recommendation</option>
                                <option value="Friends">Friends</option>
                                <option value="others">Others</option>    
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" style="display:none;" id="div_related_others">
                        <div class="form-group">
                            {!!Form::label('others','<span class="text-danger">*</span> Others',['class'=>''],false)!!}
                            {!!Form::text('others',null,['class'=>'form-control others','placeholder'=>'Input others here'])!!}
                        </div>
                    </div>



                    <div class="col-md-12" style="display:none;" id="new_div_special_terms">
                        <div class="form-group">
                            {!!Form::label('new_special_terms','<span class="text-danger">*</span> Special Terms',['class'=>''],false)!!}
                            {!!Form::text('new_special_terms',null,['class'=>'form-control new_special_terms','placeholder'=>'Input special terms here'])!!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::button('<i class="fa fa-reply"></i> Back', ['class' => 'btn btn-info clr','data-dismiss' => "modal"]) !!}

                    {!! Form::button('<i class="fa fa-ban"></i> Reject', ['class' => 'btn btn-danger clr','id'=>'reject_client']) !!}


                    {!! Form::button('<i class="fa fa-floppy-o"></i> Accept', ['class' => 'btn btn-success', 'id'=>'update_save']) !!}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            $('#update_save').click(function(e) {
                var count_null = 0; //variable for counting the null values
                var client_code = jQuery('.update_client_code').val();
                var online_client = jQuery('#online_client').val();
                var client_id = jQuery('#update_client_id').val();
                var payment_term = jQuery('#new_reg_payment_terms').val();
                var special_terms = jQuery('#new_special_terms').val();
                var sales_manager = jQuery('#sales_manager').val();
                var related_by = jQuery('#related_by').val();
                var others = jQuery('#others').val();

                var new_reg_client = jQuery('.new_reg_client');


                for (var i = 0; i < new_reg_client.length; i++) {
                    var data = $(new_reg_client[i]).val();
                    if (data == "" || data == "000") {
                        count_null += 1;
                        $(new_reg_client[i]).css("border", "1px solid red");
                    } else {
                        $(new_reg_client[i]).removeAttr("style");
                    }
                }

                if (count_null == 0) {
                    $('.send-loading ').show();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    e.preventDefault();
                    //console.log(checked);
                    $.ajax({
                        type: 'POST',
                        url: '/updatenewclient',
                        data: {
                            client_id: client_id,
                            client_code: client_code,
                            payment_term: payment_term,
                            online_client: online_client,
                            special_terms: special_terms,
                            sales_manager: sales_manager,
                            related_by: related_by,
                            others: others
                        },
                        success: function(data) {
                            if (data.message == "dupticateCode") {
                                $('.send-loading ').hide();
                                swal({
                                    title: "Oops!",
                                    text: "Client Code is not Available",
                                    type: "warning",
                                });
                            } else {
                                swal({
                                    title: "Succes",
                                    text: "Client successfully accepted.",
                                    type: "success",
                                }, function() {
                                    location.reload();
                                });
                            }
                        },
                        error: function(data) {
                            $('.send-loading ').hide();
                            swal({
                                title: "Error!",
                                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                                type: "error",
                            });
                        }
                    });
                } else {
                    swal({
                        title: "Oops!",
                        text: "Please fill up required fields",
                        type: "warning",
                    });
                }
            });

            $('#reject_client').click(function(e) {
                var client_id = jQuery('#update_client_id').val();
                var client_email = jQuery('#update_Company_Email').val();
                $('.send-loading ').show();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                e.preventDefault();
                //console.log(checked);
                $.ajax({
                    type: 'POST',
                    url: '/rejectclient',
                    data: {
                        client_id: client_id,
                        client_email: client_email
                    },
                    success: function(data) {
                        console.log(data);
                        $('.send-loading ').hide();
                        swal({
                            title: "Success",
                            text: "Client successfully rejected",
                            type: "success",
                        }, function() {
                            location.reload();
                        });
                    },
                    error: function(data) {
                        console.log(data);
                        $('.send-loading ').hide();
                        swal({
                            title: "Error!",
                            text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                            type: "error",
                        });
                    }
                });

            });
        });

        function payment_change(id) {
            if ($('#' + id).val() != "") {
                $('#' + id).removeAttr("style");
            }
            if (id == 'new_reg_payment_terms') {
                if ($('#new_reg_payment_terms').val() == "special_terms") {
                    $('#new_div_special_terms').show();
                    $('#new_special_terms').addClass('new_reg_client');
                } else {
                    $('#new_div_special_terms').hide();
                    $('#new_special_terms').removeClass('new_reg_client');
                }
            }
        }
        //07-15-2021
    $('#related_by').on('change', function() {
        if ( this.value == 'others')
        {
            $('#div_related_others').show();
        }
        else
        {
            $('#div_related_others').hide();
        }
    });

    </script>
    {!!Form::close()!!}
