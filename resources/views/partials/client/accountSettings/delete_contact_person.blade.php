<div id="modalDeleteContactPerson" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">

        <!-- Modal content-->
        <div class="modal-content">
            <form data-parsley-validate="">
                {!!csrf_field()!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete <span id="delete_contact_name"></span> ?</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="delete_contact_id" class="form-control" id="delete_contact_id">
                            <label>Are you sure you want to delete this Contact</label>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::button('<i class="fa fa-ban"></i> Cancel', ['class' => 'btn btn-warning btn-block','data-dismiss' => "modal"]) !!}
                        </div>
                        <div class="col-md-6">
                            {!! Form::button('<i class="fa fa-trash"></i> Delete', ['class' => 'btn btn-danger btn-block','id'=>'btn_delete_contact']) !!}
                        </div>
                    </div>
                    <input type="hidden" id="hidden_cid">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
    jQuery(document).ready(function() {
        $('#close-err-e-prod').click(function() {
            $('#edit-show-error').hide();
        });
        $('#btn_delete_contact').click(function() {
            console.log('Delete Contact Person Details');
            $('#edit-show-error').hide();
            $('.send-loading ').show();
            $.ajax({
                url: '/delete_ContactPerson',
                type: 'POST',
                data: {
                    _token: token,
                    'delete_contact_id': $('#delete_contact_id').val()
                },
                beforeSend: function() {
                    $('.send-loading ').show();
                },
                success: function(response) {
                    console.log(response);
                    $('.send-loading ').hide();
                    swal({
                        title: "Success!",
                        text: "Contact Person Details successfully Deleted!",
                        type: "success",
                    }, function() {
                        $('#modalDeleteContactPerson').modal('hide');
                        location.reload();
                    });
                },
                error: function() {
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                        type: "error",
                    });
                }
            });
        });

    });

</script>
