<div id="updateEmailNotifications" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Email Notifications For Supplier Account</h4>
                </div>
                <div class="modal-body">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="update_username_email" name="update_username_email" disabled>
                                <input type="hidden" class="form-control" id="update_id_email" name="update_id_email" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" class="form-control" id="update_supplierName_email" name="update_supplierName_email" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="supplier_name">Email</label>
                                <input type="text" class="form-control" id="update_usernameSupplier_email" name="update_usernameSupplier_email" disabled>
                                <input hidden id="update_email_reciever_value">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="username">Recieving Email Simultaneously</label>
                                <input class="form-control" id="update_email_value" name="update_email_value" disabled>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        {{-- <label class="checkbox-inline checkbox-bootstrap checkbox-lg">
                                            <input type="checkbox" id="update_email_reciever" class="update_email_reciever" value="" >
                                            <span class="checkbox-placeholder"></span>
                                            Checked if you want to send email from this supplier to factory after the inspection. Uncheck it if you want to stop sending email to factory after the inspection.
                                      </label> --}}
                                        <p><strong>Sending Email To Supplier:</strong> </p>
                                        <p>Please select:</p>
                                        <input type="radio" id="update_email_reciever1" name="update_email" value="1">
                                        <label for="Enable">Enable</label><br>
                                        <input type="radio" id="update_email_reciever2" name="update_email" value="0">
                                        <label for="Disable">Disable</label><br>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                    <button type="button" onclick="updateEmail()" class="btn btn-success">Save Details</button>
                </div>
            </div>
            <!-- Modal content end-->
        </form>
    </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script>
        function updateEmail() {
            if (document.getElementById('update_email_reciever1').checked) {
                update_email_reciever = document.getElementById('update_email_reciever1').value;
                no_email = 0;
            }
            else if(document.getElementById('update_email_reciever2').checked){
                update_email_reciever = document.getElementById('update_email_reciever2').value;
                no_email = 1;
            }
            else{
                $('.send-loading ').hide();
                swal({
                        title: "Error!",
                        text: "Please select what you want to update.",
                        type: "error",
                    }); 
            }
            
            var id_email = jQuery('#update_id_email').val();
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                type: 'POST',
                url: '/supplier-updateaccount-email',
                data: {
                    id_email: id_email,
                    // user_id: user_id,
                    // supplier_id: supplier_id,
                    email_reciever: update_email_reciever,
                    no_email: no_email,
                    // report_access: report_access,
                    // no_email: no_email,
                },
                success: function(data) {
                    $('.send-loading ').hide();
                    swal({
                        title: "Success!",
                        text: "Email Notification Successfully Updated.",
                        type: "success",
                    }, function() {
                        $('#updateEmailNotifications').modal('hide');
                    });  
                },
                error: function() {
                    console.log(error);
                    $('.send-loading ').hide();
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                        type: "error",
                    });
                }

            });
        }

</script>
