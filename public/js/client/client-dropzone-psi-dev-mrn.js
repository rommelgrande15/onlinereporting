var current_url = '/panel-client/';
$(document).ready(function() {

    if (window.location.href.indexOf("tic-sera") > -1) {
        current_url = '/panel-client-tic-sera/';
    }
    console.log(current_url);
    //Dropzone.autoDiscover = false;
    var myDZ = new Dropzone("div.file_upload_psi", {
        url: savePSI,
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
                $("#btn-psi-submit").click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var empty = $('.psi_required').filter(function() { return $(this).val() == ""; });
                    var psi_req = $('.psi_required');
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
                        if (myDZ.getQueuedFiles().length > 0) {
                            myDZ.processQueue();
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
                    formData.append("service", $("#service").val());
                    formData.append("reference_number", $("#reference_number").val());
                    formData.append("inspection_date", $("#inspection_date").val());
                    formData.append("inspection_date_to", $("#inspection_date").val());
                    formData.append("psi_shipment_date", $("#psi_shipment_date").val());
                    formData.append("fac_change_date", $("#fac_change_date").val());
                    formData.append("client", $('#client').val());
                    formData.append("inspector", 0);
                    formData.append("factory", $('#factory').val());
                    formData.append("factory_contact_person", $('#factory_contact_person').val());
                    formData.append("supplier", $('#supplier').val());
                    formData.append("supplier_contact_person", $('#supplier_contact_person').val());
                    formData.append("requirement", $('#requirement').val());
                    formData.append("memo", $('#memo_psi').val());
                    formData.append("invisible", $('#invisible').val());
                    formData.append("template", 0);
                    formData.append("report_template", 0);
                    formData.append("client_project_number", $('#client_project_number').val());
                    console.log($('#FRI').val() + " " + $('#FRI').val());

                    if ($("#service").val() == "SPK") {
                        formData.append("percentageSpkFri", $('#SPK').val());
                    } else if ($("#service").val() == "FRI") {
                        formData.append("percentageSpkFri", $('#FRI').val());
                    }


                    var second_inspector = null;
                    var added_inspector = jQuery('.sel-added-inspector');
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
                    formData.append('manday', 1);

                    formData.append("blank_report_type", null);

                    formData.append("has_file", 'true');

                    formData.append("type_of_project", null);

                    var new_contact_person = null;
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
                        new_contact_person = $('#contact_person').val();
                    } else {
                        new_contact_person = new_contact_person + ',' + $('#contact_person').val();
                    }

                    formData.append('contact_person', new_contact_person);

                    var new_fcontact_person = null;
                    var added_fcontact_person = jQuery('.factory_contact_added');
                    if (added_fcontact_person.length > 0 && $(".clone_fcp").is(":visible")) {
                        for (var i = 0; i < added_fcontact_person.length; i++) {
                            var data = $(added_fcontact_person[i]).val();
                            if (i == 0) {
                                new_fcontact_person = data;
                            } else {
                                new_fcontact_person = new_fcontact_person + ',' + data;
                            }
                        }
                        formData.append("factory_contact_person2_psi", new_fcontact_person);
                    } else {
                        formData.append("factory_contact_person2_psi", 'N/A');
                    }


                    var new_set_data = [];
                    $('.report_number').each(function(i, obj) {
                        var report_number = $(this).val();
                        var get_product_name = $(this).closest('.product-with-report').find('.product_name');
                        var products = [];
                        $(get_product_name).each(function(i_pn, obj_pn) {
                            var pid = $(this).val();
                            var pname = $(this).find('option:selected').text();
                            products[i_pn] = {
                                'product_id': pid,
                                'product_name': pname,
                                'product_category': $(this).closest('.clone-inputs').find('.order_product_category').val(),
                                'product_sub_category': $(this).closest('.clone-inputs').find('.order_product_sub_category').val(),
                                'brand': $(this).closest('.clone-inputs').find('.brand').val(),
                                'po_number': $(this).closest('.clone-inputs').find('.po_number').val(),
                                'model_no': $(this).closest('.clone-inputs').find('.model_no').val(),
                                'addtnl_pinfo': $(this).closest('.clone-inputs').find('.addtnl_pinfo').val(),
                                'aql_qty': $(this).closest('.clone-inputs').find('.aql_qty').val(),
                                'aql_qty_unit': $(this).closest('.clone-inputs').find('.aql_qty_unit').val(),
                                'aql_normal_level': $(this).closest('.clone-inputs').find('.aql_normal_level').val(),
                                'aql_special_level': $(this).closest('.clone-inputs').find('.aql_special_level').val(),
                                'aql_major': $(this).closest('.clone-inputs').find('.aql_major').val(),
                                'max_major': $(this).closest('.clone-inputs').find('.max_major').val(),
                                'aql_minor': $(this).closest('.clone-inputs').find('.aql_minor').val(),
                                'max_minor': $(this).closest('.clone-inputs').find('.max_minor').val(),
                                'aql_normal_letter': $(this).closest('.clone-inputs').find('.aql_normal_letter').val(),
                                'aql_normal_sampsize': $(this).closest('.clone-inputs').find('.aql_normal_sampsize').val(),
                                'aql_special_letter': $(this).closest('.clone-inputs').find('.aql_special_letter').val(),
                                'aql_special_sampsize': $(this).closest('.clone-inputs').find('.aql_special_sampsize').val(),
                            };
                        });
                        new_set_data[i] = {
                            'parent_report_number': report_number,
                            'products': products,
                        };
                    });
                    formData.append("new_set_data", JSON.stringify(new_set_data));

                });
                this.on("successmultiple", function(files, response) {
                    console.log(response);
                    if ($("#service").val() == 'st') {
                        swal({
                            title: "Success!",
                            text: "Inspection project has been created.",
                            type: "success",
                        }, function() {
                            window.location.href = current_url + auth_id;

                        });
                    } else {
                        swal({
                            title: "Success!",
                            text: "Inspection project has been created we will be reviewing this and get back to you as soon as possible. Thank you!",
                            type: "success",
                        }, function() {
                            window.location.href = current_url + auth_id;

                        });
                    }
                });
                this.on("errormultiple", function(files, response) {
                    $('.send-loading ').hide();
                    console.log(response);
                    //myDZ.removeAllFiles();
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


            } //init

    });

    $('#loading_service_inspection').on('change', function() {
        console.log($(this).val());
    })

})

function saveNoAttachment() {
    var formData = new FormData();
    formData.append("service", $("#service").val());
    formData.append("reference_number", $("#reference_number").val());
    formData.append("inspection_date", $("#inspection_date").val());
    formData.append("inspection_date_to", $("#inspection_date").val());
    formData.append("psi_shipment_date", $("#psi_shipment_date").val());
    formData.append("fac_change_date", $("#fac_change_date").val());
    formData.append("client", $('#client').val());
    formData.append("inspector", 0);
    formData.append("factory", $('#factory').val());
    formData.append("factory_contact_person", $('#factory_contact_person').val());
    formData.append("supplier", $('#supplier').val());
    formData.append("supplier_contact_person", $('#supplier_contact_person').val());
    formData.append("requirement", $('#requirement').val());
    formData.append("memo", $('#memo_psi').val());
    formData.append("invisible", $('#invisible').val());
    formData.append("template", 0);
    formData.append("report_template", 0);
    formData.append("client_project_number", $('#client_project_number').val());
    console.log($('#FRI').val() + " " + $('#FRI').val());
    if ($("#service").val() == "SPK") {
        formData.append("percentageSpkFri", $('#SPK').val());
    } else if ($("#service").val() == "FRI") {
        formData.append("percentageSpkFri", $('#FRI').val());
    }
    var second_inspector = null;
    var added_inspector = jQuery('.sel-added-inspector');
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
    formData.append('manday', 1);
    formData.append("blank_report_type", null);
    formData.append("has_file", 'true');
    formData.append("type_of_project", null);
    var new_contact_person = null;
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
        new_contact_person = $('#contact_person').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#contact_person').val();
    }
    formData.append('contact_person', new_contact_person);
    var new_fcontact_person = null;
    var added_fcontact_person = jQuery('.factory_contact_added');
    if (added_fcontact_person.length > 0 && $(".clone_fcp").is(":visible")) {
        for (var i = 0; i < added_fcontact_person.length; i++) {
            var data = $(added_fcontact_person[i]).val();
            if (i == 0) {
                new_fcontact_person = data;
            } else {
                new_fcontact_person = new_fcontact_person + ',' + data;
            }
        }
        formData.append("factory_contact_person2_psi", new_fcontact_person);
    } else {
        formData.append("factory_contact_person2_psi", 'N/A');
    }
    //this is for multiple report number
    var new_set_data = [];
    $('.report_number').each(function(i, obj) {
        var report_number = $(this).val();
        var get_product_name = $(this).closest('.product-with-report').find('.product_name');
        var products = [];
        $(get_product_name).each(function(i_pn, obj_pn) {
            var pid = $(this).val();
            var pname = $(this).find('option:selected').text();
            products[i_pn] = {
                'product_id': pid,
                'product_name': pname,
                'product_category': $(this).closest('.clone-inputs').find('.order_product_category').val(),
                'product_sub_category': $(this).closest('.clone-inputs').find('.order_product_sub_category').val(),
                'brand': $(this).closest('.clone-inputs').find('.brand').val(),
                'po_number': $(this).closest('.clone-inputs').find('.po_number').val(),
                'model_no': $(this).closest('.clone-inputs').find('.model_no').val(),
                'addtnl_pinfo': $(this).closest('.clone-inputs').find('.addtnl_pinfo').val(),
                'aql_qty': $(this).closest('.clone-inputs').find('.aql_qty').val(),
                'aql_qty_unit': $(this).closest('.clone-inputs').find('.aql_qty_unit').val(),
                'aql_normal_level': $(this).closest('.clone-inputs').find('.aql_normal_level').val(),
                'aql_special_level': $(this).closest('.clone-inputs').find('.aql_special_level').val(),
                'aql_major': $(this).closest('.clone-inputs').find('.aql_major').val(),
                'max_major': $(this).closest('.clone-inputs').find('.max_major').val(),
                'aql_minor': $(this).closest('.clone-inputs').find('.aql_minor').val(),
                'max_minor': $(this).closest('.clone-inputs').find('.max_minor').val(),
                'aql_normal_letter': $(this).closest('.clone-inputs').find('.aql_normal_letter').val(),
                'aql_normal_sampsize': $(this).closest('.clone-inputs').find('.aql_normal_sampsize').val(),
                'aql_special_letter': $(this).closest('.clone-inputs').find('.aql_special_letter').val(),
                'aql_special_sampsize': $(this).closest('.clone-inputs').find('.aql_special_sampsize').val(),
            };
        });
        new_set_data[i] = {
            'parent_report_number': report_number,
            'products': products,
        };
    });
    console.log(new_set_data);

    formData.append("new_set_data", JSON.stringify(new_set_data));
    formData.append("has_file", 'false');
    formData.append('_token', token);

    $.ajax({
        url: '/client-saveinspection-dev-mrn',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('.send-loading ').show();
        },
        success: function(response) {
            $('.send-loading ').hide();
            if ($("#service").val() == 'st') {
                swal({
                    title: "Success!",
                    text: "Inspection project has been created.",
                    type: "success",
                }, function() {
                    window.location.href = current_url + auth_id;

                });
            } else {
                swal({
                    title: "Success!",
                    text: "Inspection project has been created we will be reviewing this and get back to you as soon as possible. Thank you!",
                    type: "success",
                }, function() {
                    window.location.href = current_url + auth_id;
                });
            }

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