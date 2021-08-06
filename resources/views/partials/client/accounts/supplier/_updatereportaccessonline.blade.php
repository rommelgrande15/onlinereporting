<div id="updateReportAccess" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form method="POST" action="">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Report Access For Supplier Account</h4>
                </div>
                <div class="modal-body">
                    {!!csrf_field()!!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="update_username_access" name="update_username_access" disabled>
                                <input type="hidden" class="form-control" id="update_id_access" name="update_id_access">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="supplier_name">Supplier Name</label>
                                <input type="text" class="form-control" id="update_supplierName_access" name="update_supplierName_access" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="username">Online Access Of Account</label>
                                <input class="form-control" id="update_access_value" name="update_access_value" disabled>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><strong>Report Access Online Of Supplier Account:</strong> </p>
                                        <p>Please select:</p>
                                        <input type="radio" id="update_report_access1" name="update_report_access" value="1">
                                        <label for="Enable">Enable</label><br>
                                        <input type="radio" id="update_report_access2" name="update_report_access" value="0">
                                        <label for="Disable">Disable</label><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-ban"></i> Close</button>
                    <button type="button" onclick="updateAccess()" class="btn btn-success">Save Details</button>
                </div>
            </div>
            <!-- Modal content end-->
        </form>
    </div>
</div>


<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>

<script>
    function updateAccess() {
                if (document.getElementById('update_report_access1').checked) {
                        update_report_access = document.getElementById('update_report_access1').value;
                    }
                    else if(document.getElementById('update_report_access2').checked){
                        update_report_access = document.getElementById('update_report_access2').value;
                    }
                    else{
                    swal({
                        title: "Error!",
                        text: "Please select what you want to update.",
                        type: "error",
                    }); 
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var id_access = jQuery('#update_id_access').val();
                $.ajax({
                    type: 'POST',
                    url: '/supplier-updateaccount-access',
                    data: {
                        id_access: id_access,
                        report_access_update: update_report_access,
                    },
                    success: function(data) {
                        $('.send-loading ').hide();
                        swal({
                            title: "Success!",
                            text: "Suplier Access Succesfully Updated",
                            type: "success",
                        }, function() {
                            $('#updateReportAccess').modal('hide');
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
