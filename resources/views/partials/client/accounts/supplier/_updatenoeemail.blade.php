<div id="updateNoEmail" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update No Email Notifications For Supplier Account</h4>
                </div>
                <div class="modal-body">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="update_username_noemail" name="update_username_noemail" disabled>
                                <input type="hidden" class="form-control" id="update_id_noemail" name="update_id_noemail" >
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" class="form-control" id="update_usernameSupplier_noemail" name="update_usernameSupplier_noemail" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="supplier_name">Email</label>
                                <input type="text" class="form-control" id="update_email_noemail" name="update_email_noemail" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="username">Cannot Recieve Any Email From Reports</label>
                                <input class="form-control" id="update_noemail_value" name="update_noemail_value" disabled>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                            <p><strong>Sending Email To Supplier:</strong> </p>
                                            <p>Please select:</p>
                                            <input type="radio" id="update_no_email1" name="update_no_email" value="1">
                                            <label for="Enable">Enable</label><br>
                                            <input type="radio" id="update_no_email2" name="update_no_email" value="0">
                                            <label for="Disable">Disable</label><br>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                    <button type="button" onclick="updateNoEmail()" class="btn btn-success">Save Details</button>
                </div>
            </div>
            <!-- Modal content end-->
        </form>
    </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script>
        function updateNoEmail() {
            if (document.getElementById('update_no_email1').checked) {
                update_email_noemail = 0;
                update_no_email = document.getElementById('update_no_email1').value;
            }
            else if(document.getElementById('update_no_email2').checked){
                update_email_noemail = 1;
                update_no_email = document.getElementById('update_no_email2').value;
            }
            else{
                swal({
                        title: "Error!",
                        text: "Please select what you want to update.",
                        type: "error",
                    }); 
            }
            
            var id_noemail = jQuery('#update_id_noemail').val();
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            $.ajax({
                type: 'POST',
                url: '/supplier-updateaccount-no-email',
                data: {
                    id_noemail: id_noemail,
                    // user_id: user_id,
                    // supplier_id: supplier_id,
                    email_reciever: update_email_noemail,
                    no_email: update_no_email,
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
                        $('#updateNoEmail').modal('hide');
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
