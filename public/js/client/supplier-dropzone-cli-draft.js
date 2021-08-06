var current_url = '/panel-supplier/';
$(document).ready(function() {
    if (window.location.href.indexOf("tic-sera") > -1) {
        current_url = '/panel-supplier-tic-sera/';
    }
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div.file_upload", {
        url: saveCBPI,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoProcessQueue: false,
        addRemoveLinks: true,
        dictRemoveFileConfirmation: "Are you sure you want to remove this file? Once removed, you will not be able to recover this file on our database.",
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
        maxFilesize: 700000000,
        paramName: "file",
        init: function() {
            $("#CBPI_submit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var empty = $('.cli_required').filter(function() { return $(this).val() == ""; });
                console.log(empty.length);
                var cbpi_req = $('.cli_required');
                var count_null = 0;
                for (var i = 0; i < cbpi_req.length; i++) {
                    var data = $(cbpi_req[i]).val();
                    if (data == "") {
                        $(cbpi_req[i]).css("border", "1px solid red");
                        count_null += 1;
                    } else {
                        $(cbpi_req[i]).removeAttr("style");
                    }
                }
                if (empty.length == 0 && count_null == 0) {
                    if (myDropzone.getQueuedFiles().length > 0) {
                        //process dropzone if there is/are attached file
                        myDropzone.processQueue();
                        $('.send-loading ').show();
                    } else {
                        saveNoAttachment();
                    }
                } else {
                    swal({
                        title: "Oops!",
                        text: "Please fill up required fields!",
                        type: "warning",
                    });
                }


            })
            //06-02-2021
            this.on('removedfile', function(file) {
                var i_id = $('#edit_inspection_id').val();
                var name = file.name;
                var pass_file = file;
                var _ref;

                $.ajax({
                    url: '/delete-supplier-attachments',
                    type: 'POST',
                    data: {
                        _token: token,
                        inspection_id: i_id,
                        file_name: name
                    },
                    success: function() {
                        swal("Success", "File has been removed!", "success");
                        
                        count_ef -= 1;
                        
                        return (_ref = pass_file.previewElement) != null ? _ref.parentNode.removeChild(pass_file.previewElement) : void 0;
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            })

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
                }
            })
            this.on("sendingmultiple", function(data, xhr, formData) {
                var chosen_service = $("#loading_service").val();
                formData.append("edit_inspection_id", $('#edit_inspection_id').val());
                formData.append("loading_service", chosen_service);
                formData.append("loading_reference_number", $("#loading_reference_number").val());
                formData.append("loading_inspection_date", $("#loading_inspection_date").val());
                formData.append("loading_inspection_date_to", $("#loading_inspection_date").val());
                formData.append("shipment_date", $("#cbpi_shipment_date").val());
                formData.append("loading_fac_change_date", $("#loading_fac_change_date").val());
                formData.append("loading_client", $('#loading_client').val());
                formData.append("loading_inspector", 0);
                formData.append("loading_factory", $('#loading_factory').val());
                formData.append("loading_factory_contact_person", $('#loading_factory_contact_person').val());
                formData.append("loading_supplier", $('#loading-supplier').val());
                formData.append("loading_supplier_contact_person", $('#loading_supplier_cp').val());
                formData.append("loading_client_name", $('#loading_client_name').val());
                formData.append("loading_supplier_name", $('#loading-supplier-name').val());
                formData.append("loading_requirements", $('#loading_requirements').val());
                formData.append("memo", $('#memo_cbpi').val());
                formData.append("loading_invisible", $('#loading_invisible').val());
                formData.append("client_project_number_cbpi", $('#client_project_number_cbpi').val());

                formData.append("loading_template", 0);
                formData.append("loading_report_template", 0);


                var second_inspector = null;
                var added_inspector = jQuery('.cbpi-sel-added-inspector');
                if (added_inspector.length > 0) {
                    for (var i = 0; i < added_inspector.length; i++) {
                        var data = $(added_inspector[i]).val();
                        if (i == 0) {
                            second_inspector = data;
                        } else {
                            second_inspector = second_inspector + ',' + data;
                        }
                    }
                }
                formData.append('second_inspector', second_inspector);

                formData.append('manday', $('#cbpi_manday').val());

                formData.append("has_file", 'true');

                formData.append("project_type_cbpi", null);


                var new_contact_person;
                var added_contact_person = jQuery('.added_contact_persons');
                if (added_contact_person.length > 0) {
                    for (var i = 0; i < added_contact_person.length; i++) {
                        var data = $(added_contact_person[i]).val();
                        if (i == 0) {
                            new_contact_person = data;
                        } else {
                            new_contact_person = new_contact_person + ',' + data;
                        }
                    }
                }
                if (new_contact_person == "" || new_contact_person == null) {
                    new_contact_person = $('#loading_client_cp').val();
                } else {
                    new_contact_person = new_contact_person + ',' + $('#loading_client_cp').val();
                }
                formData.append('loading_contact_person', new_contact_person);

                var new_fcontact_person = null;
                var added_fcontact_person = jQuery('.factory_contact_added_cbpi');
                if (added_fcontact_person.length > 0 && $(".clone_fcp_cbpi").is(":visible")) {
                    for (var i = 0; i < added_fcontact_person.length; i++) {
                        var data = $(added_fcontact_person[i]).val();
                        if (i == 0) {
                            new_fcontact_person = data;
                        } else {
                            new_fcontact_person = new_fcontact_person + ',' + data;
                        }
                    }
                    formData.append("factory_contact_person2_cbpi", new_fcontact_person);
                } else {
                    formData.append("factory_contact_person2_cbpi", 'N/A');
                }

            });
            this.on("successmultiple", function(files, response) {
                console.log(response);
                swal({
                    title: "Success!",
                    text: "Inspection project has been created we will be reviewing this and get back to you as soon as possible. Thank you!",
                    type: "success",
                }, function() {
                    window.location.href = current_url + auth_id;
                });
            });
            this.on("errormultiple", function(files, response) {
                $('.send-loading ').hide();
                console.log(response);
                //myDropzone.removeAllFiles();
                if (response.responseJSON.message == "Empty fields") {
                    swal({
                        title: "Warning!",
                        text: "Please fill up required fields",
                        type: "warning",
                    });
                } else {
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
                        type: "error",
                    });
                }
            });
        }
    });

    $('#loading_service_inspection').on('change', function() {
        console.log($(this).val());
    })


    var i_id = $('#edit_inspection_id').val();
    console.log(i_id);
    var existing_files = [];

    $.ajax({
        url: '/findattachments/' + i_id,
        type: 'GET',
        success: function(response) {
            console.log(response.attachment);
            $.each(response.attachment, function(i, element) {
                var thumb_src = "";
                var ext = element.file_name.split('.').pop();
                if (ext == "pdf") {
                    thumb_src = pdf_icon;
                } else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {
                    thumb_src = doc_icon;
                } else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {
                    thumb_src = xls_icon;
                } else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {
                    thumb_src = ppt_ico;
                } else if (ext.indexOf("pub") != -1) {
                    thumb_src = pub_icon;
                }
                //count_ef += 1;
                existing_files.push({ name: element.file_name, size: element.file_size });
                for (i = 0; i < existing_files.length; i++) {
                    var new_src = "http://ticapp.tk/images/project2/" + i_id + "/" + element.file_name;
                    myDropzone.emit("addedfile", existing_files[i], "images/project2/" + i_id + "/");
                    myDropzone.emit("complete", existing_files[i], "images/project2/" + i_id + "/");
                    if (ext == "pdf" || ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1 || ext.indexOf("pub") != -1 || ext.indexOf("zip") != -1) {
                        myDropzone.emit('thumbnail', existing_files[i], thumb_src)
                    } else {
                        existing_files[i].previewElement.querySelector("img").src = new_src;
                    }
                    myDropzone.files.push(existing_files[i], "images/project2/" + i_id + "/");
                }
                existing_files = [];
            });
        },
        error: function(error) {
            console.log(error);
        }
    });

})

function saveNoAttachment() {
    var formData = new FormData();

    var chosen_service = $("#loading_service").val();
    formData.append("edit_inspection_id", $('#edit_inspection_id').val());
    formData.append("loading_service", chosen_service);
    formData.append("loading_reference_number", $("#loading_reference_number").val());
    formData.append("loading_inspection_date", $("#loading_inspection_date").val());
    formData.append("loading_inspection_date_to", $("#loading_inspection_date").val());
    formData.append("shipment_date", $("#cbpi_shipment_date").val());
    formData.append("loading_fac_change_date", $("#loading_fac_change_date").val());
    formData.append("loading_client", $('#loading_client').val());
    formData.append("loading_inspector", 0);
    formData.append("loading_factory", $('#loading_factory').val());
    formData.append("loading_factory_contact_person", $('#loading_factory_contact_person').val());
    formData.append("loading_supplier", $('#loading-supplier').val());
    formData.append("loading_supplier_contact_person", $('#loading_supplier_cp').val());
    formData.append("loading_client_name", $('#loading_client_name').val());
    formData.append("loading_supplier_name", $('#loading-supplier-name').val());
    formData.append("loading_requirements", $('#loading_requirements').val());
    formData.append("memo", $('#memo_cbpi').val());
    formData.append("loading_invisible", $('#loading_invisible').val());
    formData.append("client_project_number_cbpi", $('#client_project_number_cbpi').val());

    formData.append("loading_template", 0);
    formData.append("loading_report_template", 0);


    var second_inspector = null;
    var added_inspector = jQuery('.cbpi-sel-added-inspector');
    if (added_inspector.length > 0) {
        for (var i = 0; i < added_inspector.length; i++) {
            var data = $(added_inspector[i]).val();
            if (i == 0) {
                second_inspector = data;
            } else {
                second_inspector = second_inspector + ',' + data;
            }
        }
    }
    formData.append('second_inspector', second_inspector);

    formData.append('manday', $('#cbpi_manday').val());

    formData.append("has_file", 'true');

    formData.append("project_type_cbpi", null);


    var new_contact_person;
    var added_contact_person = jQuery('.added_contact_persons');
    if (added_contact_person.length > 0) {
        for (var i = 0; i < added_contact_person.length; i++) {
            var data = $(added_contact_person[i]).val();
            if (i == 0) {
                new_contact_person = data;
            } else {
                new_contact_person = new_contact_person + ',' + data;
            }
        }
    }
    if (new_contact_person == "" || new_contact_person == null) {
        new_contact_person = $('#loading_client_cp').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#loading_client_cp').val();
    }
    formData.append('loading_contact_person', new_contact_person);

    var new_fcontact_person = null;
    var added_fcontact_person = jQuery('.factory_contact_added_cbpi');
    if (added_fcontact_person.length > 0 && $(".clone_fcp_cbpi").is(":visible")) {
        for (var i = 0; i < added_fcontact_person.length; i++) {
            var data = $(added_fcontact_person[i]).val();
            if (i == 0) {
                new_fcontact_person = data;
            } else {
                new_fcontact_person = new_fcontact_person + ',' + data;
            }
        }
        formData.append("factory_contact_person2_cbpi", new_fcontact_person);
    } else {
        formData.append("factory_contact_person2_cbpi", 'N/A');
    }

    formData.append("has_file", 'false');
    formData.append('_token', token);

    $.ajax({
        url: '/supplier-editloadinginspection',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('.send-loading ').show();
        },
        success: function(response) {
            $('.send-loading ').hide();
            swal({
                title: "Success!",
                text: "Inspection project has been successfully updated we will be reviewing this and get back to you as soon as possible. Thank you!",
                type: "success",
            }, function() {
                window.location.href = current_url + auth_id;
            });

        },
        error: function(error) {
            $('.send-loading ').hide();
            console.log(error);
            if (error.responseJSON.message == "Empty fields") {
                swal({
                    title: "Warning!",
                    text: "Please fill up required fields",
                    type: "warning",
                });
            } else {
                swal({
                    title: "Error!",
                    text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
                    type: "error",
                });
            }
        }
    });
}