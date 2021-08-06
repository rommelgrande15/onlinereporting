<div id="modalSendReport" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="" enctype="multipart/form-data" id="my-dropzone">
                {!!csrf_field()!!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Upload Report</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="inspection_id" name="inspection_id" required>
                    <div class="form-group">
                        <label>Report :</label>
                        <div class="col-md-12 dropzone-container dz-clickable" id="form_report_files">
                            <div class="dz-message default-dropzone-text" data-dz-message=""><span class="text-default">Drag files or click here to Upload</span></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Reference #:</label>
                        <input type="text" class="form-control" id="ref_no" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Client Email:</label>
                        <input type="text" class="form-control add_report" placeholder="Client Email" id="company_email" name="company_email" autocomplete="off" required>
                    </div>
                    <div class="form-group" data-toggle="tooltip" title="Separate Email with semicolon ;">
                        <label>Recipient CC:</label>
                        <textarea class="form-control" id="cc_email"  rows="3" placeholder="Recipient CC (Separate Email with semicolon; )"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="">Report Status:</label>
                        <select class="form-control add_report" id="report_status">
                            <option value="" selected>Select Status</option>
                            <option value="Pass">Pass</option>
                            <option value="Failed">Failed</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    {{--<div class="form-group" data-toggle="tooltip" title="Separate Email with semicolon ;">
						<label>Add Recipient:</label>
						<input type="text" class="form-control add_report" placeholder="Recipient (Separate Email with semicolon; )" id="recipient_email" autocomplete="off" autofocus required>
					</div>--}}
                    
                    <div class="form-group">
                        <span style="color:#e74c3c; font-size:12px;">Notes: Remove other from email like example: <span style="background-color:yellow; color:#c0392b;">IT Support &lt;it-support@t-i-c.asia&gt;</span>
                            this is not accepted, remove the alias to become like this <span style="background-color:yellow; color:#c0392b;">it-support@t-i-c.asia</span></span>
                    </div>
                    <div id="add-show-error-send" style="display:none;">
                        <div class="alert alert-danger alert-dismissable" role="alert">
                            <a href="#" class="close" id="close-err-a-send">&times;</a>
                            <strong>Error</strong> Please fill up the required fields.
                        </div>
                    </div>
                    <div id="add-show-error-send-file" style="display:none;">
                        <div class="alert alert-sm alert-danger alert-dismissable" role="alert">
                            <a href="#" class="close" id="close-err-a-send-file">&times;</a>
                            <strong>Error</strong> Please add the file.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            {!! Form::button('Close', ['class' => 'btn btn-default btn-block', 'data-dismiss' => "modal"]) !!}
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-6">
                            {!! Form::button('<i class="fa fa-upload"></i> Upload', ['class' => 'btn btn-block btn-primary', 'type'=>'button','id'=>'btn_upload']) !!}
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('cloudfare/jquery-ui.min.js')}}"></script>
<script src="{{asset('js/dropzone.js')}}"></script>
<script>
    Dropzone.autoDiscover = false;
    var auth_id = "{{Auth::id()}}";
    var token = "{{csrf_token()}}";
    var pdf_icon = "{{asset('images/icons/pdf.png')}}";
    var doc_icon = "{{asset('images/icons/doc.png')}}";
    var xls_icon = "{{asset('images/icons/xls.png')}}";
    var ppt_icon = "{{asset('images/icons/ppt.png')}}";
    var pub_icon = "{{asset('images/icons/pub.png')}}";
    var rar_icon = "{{asset('images/icons/rar.png')}}";
    jQuery(document).ready(function() {
        var d1 = "nd";
        var count;
        var subcount = 0;

        var myDropzone1 = new Dropzone(

            //id of drop zone element 1
            '#form_report_files', {
                //url: "http://ticapp.tk/js/dropzone/report_reviewer/upload.php",
                url: "/upload-report",
                addRemoveLinks: true,
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,

                removedfile: function(file) {
                    var name = file.name;
                    $.ajax({
                        type: 'POST',
                        url: '/upload-report',
                        data: {
                            _token: token,
                            id: file.name,
                            request: 2
                        },
                        sucess: function(data) {
                            $('#btn_upload').attr('disabled', false);
                            console.log('success: ' + data);
                        },
                        error: function() {
                            console.log('Error: ' + data);
                            $('#btn_upload').attr('disabled', false);
                            swal({
                                title: "Error!",
                                text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                                type: "error",
                            });

                        }
                    });
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },
                acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .rar, .zip',
                maxFilesize: 100,
                paramName: "file",
                init: function() {
                    this.on('addedfile', function(file) {
                        var ext = file.name.split('.').pop();
                        if (ext == "pdf") {
                            $(file.previewElement).find(".dz-image img").attr("src", pdf_icon);
                        } else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
                            $(file.previewElement).find(".dz-image img").attr("src", doc_icon);
                        } else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
                            $(file.previewElement).find(".dz-image img").attr("src", xls_icon);
                        } else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
                            $(file.previewElement).find(".dz-image img").attr("src", ppt_icon);
                        } else if (ext.indexOf("pub") != -1) {
                            $(file.previewElement).find(".dz-image img").attr("src", pub_icon);
                        } else if (ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1) {
                            $(file.previewElement).find(".dz-image img").attr("src", rar_icon);
                        }
                    })



                    this.on("sending", function(file, xhr, formData) {
                        // Append all the additional input data of your form here!
                        var inspection_id = $('#inspection_id').val();
                        var company_email = $('#company_email').val();
                        var report_status = $('#report_status').val();
                        //var recipient_email = $('#recipient_email').val();
                        var cc_email = $('#cc_email').val();
                        formData.append("_token", token);
                        formData.append("inspection_id", inspection_id);
                        formData.append("company_email", company_email);
                        formData.append("report_status", report_status);
                        //formData.append("recipient_email", recipient_email);
                        formData.append("cc_email", cc_email);
                    });

                    this.on("success", function(file, responseText) {
                        if (responseText.message == "Report Saved") {
                            $('#modalViewReport').modal('hide');
                            swal({
                                title: "Succes",
                                text: "Report successfully sent!",
                                type: "success",
                            }, function() {
                                location.reload();
                            });
                        } else if (responseText.message == "Save Error") {
                            swal({
                                title: "Failed",
                                text: "Report Not Save",
                                type: "error",
                            }, function() {
                                location.reload();
                            });
                        } else if (responseText.message == "Email Error") {
                            swal({
                                title: "Failed",
                                text: "Email Not Send",
                                type: "error",
                            }, function() {
                                location.reload();
                            });
                        } else {
                            swal({
                                title: "Failed",
                                text: responseText.message,
                                type: "error",
                            });
                        }
                    });
                }
            }
        );


        $('#close-err-a-send').click(function() {
            $('#add-show-error-send').hide();
        });
        $('#close-err-a-send-file').click(function() {
            $('#add-show-error-send-file').hide();
        });
        $('#btn_upload').click(function() {
            var dis = $(this);
            var add = $('.add_report');
            /*$('#my-dropzone')[0].reset();*/


            var file_report = $(this).data('dz-name');
            count_file = myDropzone1.files.length;
            var add_count_null = 0;

            for (var i = 0; i < add.length; i++) {
                var data = $(add[i]).val();
                if (data == "") {
                    $(add[i]).css("border", "1px solid red");
                    add_count_null += 1;
                } else {
                    $(add[i]).removeAttr("style");
                }
            }
            $('.dropzone-container').removeAttr("css");
            if (add_count_null == 0) {
                if (count_file != "") {
                    $(this).text("Saving...");
                    $('#btn_upload').attr('disabled', true);
                    $('add-show-error-send').hide();
                    $('add-show-error-send-file').hide();
                    count = myDropzone1.files.length;
                    //console.log(count);
                    //console.log(subcount);
                    myDropzone1.processQueue();
                    //savealldata();
                    //dropzoneupload();
                } else {
                    $('add-show-error-send').hide();
                    $('#add-show-error-send-file').show();
                    $('#btn_upload').attr('disabled', false);
                }
            } else {
                $('#add-show-error-send').show();
                $('#add-show-error-send-file').hide();
                $('#btn_upload').attr('disabled', false);
            }
        });
    });

</script>
