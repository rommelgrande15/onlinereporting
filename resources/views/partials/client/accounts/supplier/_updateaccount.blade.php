<div id="updateAccountModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Account Details</h4>
                </div>
                <div class="modal-body">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="update_username" name="update_username" disabled>
                                <input type="hidden" class="form-control" id="update_id" name="update_id">

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email address:</label>
                                <input type="email" class="form-control" name="update_email" id="update_email" readonly>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="contact_number">Contact Number:</label>
                                <input type="text" minlength="11" maxlength="15" class="form-control numeric" name="update_contact_number" id="update_contact_number" required>
                                <div id="acc0" style="display:none">
                                    <p style="color:red;">This field is required! </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Account Name:</label>
                                <input type="text" class="form-control" name="update_inspector_name" id="update_inspector_name" required>
                                <div id="acc1" style="display:none">
                                    <p style="color:red;">This field is required! </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="loading_contact_supplier">Supplier Contact Person</label>
								<select class="form-control" name="loading_contact_supplier" id="loading_contact_supplier">
                                    <option value="" selected>Select Client Contact Person</option>
								</select>
							</div>
						</div>
					</div>

                    <div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="loading_contact_client">Client Contact Person</label>
								<select class="form-control" name="loading_contact_client" id="loading_contact_client">
									<option value="" selected>Select Client Contact Person</option>
									@foreach ($clientsData as $client_contact)
									<option value="{{$client_contact->id}}" >{{$client_contact->contact_person}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

                    <!-- <div class="row">
              <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">Designation:</label>
                    <select name="designation" id="update_designation" name="update_designation" class="form-control" required>
                        <option selected disabled>Select Designation</option>
                        <option value="administrator">System Administrator</option>
                        <option value="super_admin">Super Admin</option>
                        <option value="sales">Sales</option>
                        <option value="reports_review">Reports Review</option>
                        <option value="booking">Booking</option>
                        <option value="client">Client</option>
                        <option value="intern">Intern</option>
                    </select>
                    <div id="acc2" style="display:none" ><p style="color:red;">This field is required! </p></div>
                  </div>
              </div>
          </div>-->


                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                    <button type="button" onclick="updatesAcc()" class="btn btn-success">Save Details</button>
                </div>
            </div>
            <!-- Modal content end-->
        </form>
    </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#loading_contact_supplier').on('change', function() {
        $('#new_clientcontact_id').val($(this).val());
            $.ajax({
                    url: '/getonesuppliercontactclientupdate/' + $(this).val(),
                    type: 'GET',
                    success: function(response) {
                    $('#update_email').val(response.contacts.supplier_email);
                    document.getElementById("loading_contact_supplier").style.border="1px solid gray";
				    document.getElementById("update_email").style.border="1px solid gray";
                    },
                    error: function(xhr) {
                    var err = JSON.parse(xhr.responseText);
                    //alert(err.message);
                    swal({
                        title: "Error!",
                        text: "Error: " + err.message,
                        type: "error",
                    });
                    document.getElementById("loading_contact_supplier").style.border="1px solid red";
                    document.getElementById("update_email").style.border="1px solid red";
                    $('#update_email').val('');
                }
            });
        });
        
    });
    var idds = [
        'update_contact_number',
        'update_inspector_name',
    ];


    function checkeds() {

        for (var x = 0; x <= 2; x++) {
            jQuery('#' + idds[x] + '').removeAttr("style");
        }

        for (var x = 0; x <= 2; x++) {
            jQuery('#acc' + x + '').css("display", "none");
        }
    }

    function updatesAcc() {
        var site_url = "{{$site_url}}";
        // alert("sds");
        checkeds();
        for (var x = 0; x <= 2; x++) {
            if (jQuery('#' + idds[x] + '').val() == "") {
                jQuery('#acc' + x + '').css("display", "block");
                jQuery('#' + idds[x] + '').css('border-color', 'red');
                x = 4;
            } else if (x == 2) {
                $('.send-loading ').show();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var account_id = jQuery('#update_id').val();
                var update_username = jQuery('#update_username').val();
                var contact_number = jQuery('#update_contact_number').val();
                var inspector_name = jQuery('#update_inspector_name').val();
                var supplier_contact_id = jQuery('#loading_contact_supplier').val();
                var supplier_client_contact_id = jQuery('#loading_contact_client').val();
                var email = jQuery('#update_email').val();
                $.ajax({
                    type: 'POST',
                    url: '/client-updateaccount',
                    data: {
                        account_id: account_id,
                        update_username: update_username,
                        inspector_name: inspector_name,
                        email: email,
                        contact_number: contact_number,
                        supplier_contact_id:supplier_contact_id,
                        supplier_client_contact_id: supplier_client_contact_id,
                        site_url:site_url
                    },
                    success: function(data) {
                        $('.send-loading ').hide();
                        swal({
                            title: "Success!",
                            text: "Account successfully updated.",
                            type: "success",
                        }, function() {
                            location.reload();     
                        });  
                    },
                    error: function(xhr) {
                        $('.send-loading ').hide();
                        var err = JSON.parse(xhr.responseText);
                        //alert(err.message);
                        swal({
                            title: "Error!",
                            text: "Error: " + err.message,
                            type: "error",
                        });
                        document.getElementById("loading_contact_supplier").style.border="1px solid red";
                        document.getElementById("update_email").style.border="1px solid red";
                    }
                });
                $('#clr').click();
            }
        }
    }

</script>
