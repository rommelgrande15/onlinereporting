var current_url = '/panel-client/';
$(document).ready(function() {
    if (window.location.href.indexOf("tic-sera") > -1) {
        current_url = '/panel-client-tic-sera/';
    }
    //Dropzone.autoDiscover = false;
    var myDZLoading = new Dropzone("div.file_upload", {
        url: saveCBPI,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoProcessQueue: false,
        addRemoveLinks: true,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .zip, .ZIP, .rar, .RAR, .DOC, .DOCX, .PUB, .JPEG, .JPG, .PNG, .GIF, .XLS, .XLSX, .PPT, .PPTX',
        maxFilesize: 500000000,
        paramName: "file",
        init: function() {
                $("#CBPI_submit").click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var empty = $('.cli_required').filter(function() { return $(this).val() == ""; });
                    var psi_req = $('.cli_required');
                    var count_null = 0;
                    for (var i = 0; i < psi_req.length; i++) {
                        var data = $(psi_req[i]).val();
                        if (data == "") {
                            $(psi_req[i]).css("border", "1px solid red");
                            count_null += 1;
                        } else {
                            $(psi_req[i]).removeAttr("style");
                        }
                    }

                    console.log(empty.length);
                    if (empty.length == 0 && count_null == 0) {
                        if (myDZLoading.getQueuedFiles().length > 0) {
                            myDZLoading.processQueue();
                            $('.send-loading ').show();
                        } else {
                            //send empty 
                            saveNoAttachment();
                            //myDZLoading.uploadFiles([]); 
                        }
                    } else {
                        swal({
                            title: "Oops!",
                            text: "Please fill up required fields!",
                            type: "warning",
                        });
                    }
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
                    formData.append("service", $("#loading_service").val());
                    formData.append("reference_number", $("#loading_reference_number").val());
                    formData.append("inspection_date", $("#loading_inspection_date").val());
                    formData.append("inspection_date_to", $("#loading_inspection_date").val());
                    formData.append("shipment_date", $("#cbpi_shipment_date").val());
                    formData.append("client", $('#loading_client').val());
                    formData.append("factory", $('#loading_factory').val());
                    formData.append("factory_contact_person", $('#loading_factory_contact_person').val());
                    formData.append("supplier", $('#loading_supplier').val());
                    formData.append("supplier_contact_person", $('#loading_supplier_contact_person').val());
                    formData.append("loading_supplier_name", $('#loading_supplier option:selected').text());
                    formData.append("requirement", $('#loading_requirements').val());
                    formData.append("memo", $('#memo_cbpi').val());
                    formData.append("client_project_number", $('#client_project_number_cbpi').val());
                    formData.append("has_file", 'true');

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
                    //myDZLoading.removeAllFiles();
                    if(response.responseJSON.message=="Empty fields"){
                        swal({
                            title: "Warning!",
                            text: "Please fill up required fields",
                            type: "warning",
                        });
                    }else{
                        swal({
                            title: "Error!",
                            text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
                            type: "error",
                        });
                    }
                });


            } //init

    });

    $('#loading_service_inspection').on('change', function() {
        console.log($(this).val());
    })

})

function saveNoAttachment() {
    var formData = new FormData();
    formData.append("service", $("#loading_service").val());
    formData.append("reference_number", $("#loading_reference_number").val());
    formData.append("inspection_date", $("#loading_inspection_date").val());
    formData.append("inspection_date_to", $("#loading_inspection_date").val());
    formData.append("shipment_date", $("#cbpi_shipment_date").val());
    formData.append("client", $('#loading_client').val());
    formData.append("factory", $('#loading_factory').val());
    formData.append("factory_contact_person", $('#loading_factory_contact_person').val());
    formData.append("supplier", $('#loading_supplier').val());
    formData.append("supplier_contact_person", $('#loading_supplier_contact_person').val());
    formData.append("loading_supplier_name", $('#loading_supplier option:selected').text());
    formData.append("requirement", $('#loading_requirements').val());
    formData.append("memo", $('#memo_cbpi').val());
    formData.append("client_project_number", $('#client_project_number_cbpi').val());

    formData.append("has_file", 'false');
    formData.append('_token', token);

    $.ajax({
        url: '/client-savecbpiinspection',
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
                text: "Inspection project has been created we will be reviewing this and get back to you as soon as possible. Thank you!",
                type: "success",
            }, function() {
                window.location.href = current_url + auth_id;
            });

        },
        error: function(error) {
            $('.send-loading ').hide();
            console.log(error);
            if(error.responseJSON.message=="Empty fields"){
                swal({
                    title: "Warning!",
                    text: "Please fill up required fields",
                    type: "warning",
                });
            }else{
                swal({
                    title: "Error!",
                    text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
                    type: "error",
                });
            }
        }
    });
}