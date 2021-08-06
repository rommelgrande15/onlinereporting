<div id="modalSendReport" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="" enctype="multipart/form-data" id="upload_form">
                {!!csrf_field()!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Upload Reports</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="inspection_id" name="inspection_id" required>
                    <div class="form-group">
                        <label for="">Reference Number:</label>
                        <input type="text" class="form-control add_report" id="ref_no" name="ref_no" readonly required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Client Name:</label>
                                <input type="text" class="form-control add_report" id="client_name" name="client_name" placeholder="Client Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Client Email:</label>
                                <input type="text" class="form-control add_report" placeholder="Client Email" id="company_email" name="company_email" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" data-toggle="tooltip" title="Separate Email with semicolon ;">
                        <label>Recipient CC:</label>
                        <textarea class="form-control" id="cc_email" name="cc_email" rows="3" placeholder="Recipient CC (Separate Email with semicolon; )"></textarea>
                    </div>
                    <div id="drop_group">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Report :</label>
                                    <input type="file" name="reports[]" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Reference #:</label>
                                    <input type="text" class="form-control" name="ref_numbers[]">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Status:</label>
                                    <select class="form-control" name="status[]" required>
                                        <option value="" selected="">Select Status</option>
                                        <option value="Passed">Pass</option>
                                        <option value="Failed">Failed</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button type="button" class="btn-add btn btn-primary"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            {!! Form::button('Close', ['class' => 'btn btn-default btn-block', 'data-dismiss' => "modal"]) !!}
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            {!! Form::button('<i class="fa fa-upload"></i> Upload', ['class' => 'btn btn-block btn-primary', 'type'=>'submit','id'=>'btn_upload']) !!}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.btn-add'); //Add button selector
        var wrapper = $('#drop_group'); //Input field wrapper
        var fieldHTML = '<div class="row"><hr>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Report :</label>' +
            '<input type="file" name="reports[]" required>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label for="">Reference #:</label>' +
            '<input type="text" class="form-control" name="ref_numbers[]">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-3">' +
            '<div class="form-group">' +
            '<label for="">Status:</label>' +
            '<select class="form-control" name="status[]" required>' +
            '<option value="" selected="">Select Status</option>' +
            '<option value="Passed">Pass</option>' +
            '<option value="Failed">Failed</option>' +
            '<option value="Pending">Pending</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<label for=""></label><br><button type="button" class="btn-remove btn btn-danger"><i class="fa fa-remove"></i></button>' +
            '</div>'; //New input field html 
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.btn-remove', function(e) {
            e.preventDefault();
            $(this).parent('.row').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });

</script>
<script>
    $(document).ready(function(e) {
        var url = '/upload-report-nomail';
        $("#upload_form").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    //$("#preview").fadeOut();
                    $("#err").fadeOut();
                },
                success: function(data) {
                    console.log(data.message);
                    if (data.message == "Report Saved") {
                        $('#modalSendReport').modal('hide');
                        swal({
                            title: "Succes",
                            text: "Report successfully sent!",
                            type: "success",
                        }, function() {
                            //location.reload();
                        });
                    } else if (data.message == "Save Error") {
                        swal({
                            title: "Failed",
                            text: "Report Not Save",
                            type: "error",
                        }, function() {
                            //location.reload();
                        });
                    } else if (data.message == "Email Error") {
                        swal({
                            title: "Failed",
                            text: "Email Not Send",
                            type: "error",
                        }, function() {
                            //location.reload();
                        });
                    } else {
                        swal({
                            title: "Failed",
                            text: data.message,
                            type: "error",
                        });
                    }
                },
                error: function(e) {
                    console.log('Error: ' + e);
                    $('#btn_upload').attr('disabled', false);
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                        type: "error",
                    });
                }
            });
        }));
    });

</script>
