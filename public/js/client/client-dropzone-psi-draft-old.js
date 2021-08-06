$(document).ready(function() {
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
                            /* swal({
                                title: "Oops!",
                                text: "Please add an attachment!",
                                type: "warning",
                            }, function() {
                                $('.send-loading ').hide();
                            }); */
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
                    formData.append("client", $('#client').val());
                    formData.append("inspector", 0);
                    formData.append("factory", $('#factory').val());
                    formData.append("factory_contact_person", $('#factory_contact_person').val());
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



                    $('.product_name').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('product_id[]', val);
                    });

                    $('.product_name').each(function(i, obj) {
                        //var val = $(this).val();
                        //var val = $(".product_name option:selected").text(); 
                        var val = $(this).find('option:selected').text();
                        formData.append('product_name[]', val);
                    });

                    $('.product_category').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('product_category[]', val);
                    });

                    $('.product_sub_category').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('product_sub_category[]', val);
                    });

                    $('.brand').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('brand[]', val);
                    });

                    $('.po_number').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('po_number[]', val);
                    });

                    $('.model_no').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('model_no[]', val);
                    });

                    $('.p_unit').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('p_unit[]', val);
                    });
                    $('.prod_number').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('prod_number[]', val);
                    });

                    $('.aql_qty').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_qty[]', val);
                    });

                    $('.aql_qty_unit').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_qty_unit[]', val);
                    });

                    $('.aql_normal_level').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_normal_level[]', val);
                    });

                    $('.aql_normal_level').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_normal_level[]', val);
                    });

                    $('.aql_special_level').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_special_level[]', val);
                    });

                    $('.aql_major').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_major[]', val);
                    });

                    $('.max_major').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('max_major[]', val);
                    });

                    $('.aql_minor').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_minor[]', val);
                    });

                    $('.max_minor').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('max_minor[]', val);
                    });

                    $('.aql_normal_letter').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_normal_letter[]', val);
                    });

                    $('.aql_normal_sampsize').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_normal_sampsize[]', val);
                    });

                    $('.aql_special_letter').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_special_letter[]', val);
                    });

                    $('.aql_special_sampsize').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_special_sampsize[]', val);
                    });

                });
                this.on("successmultiple", function(files, response) {
                    console.log(response);
                    swal({
                        title: "Success!",
                        text: "Inspection project has been created we will be reviewing this and get back to you as soon as possible. Thank you!",
                        type: "success",
                    }, function() {
                        window.location.href = '/panel-client/' + auth_id;
                    });
                });
                this.on("errormultiple", function(files, response) {
                    console.log(response);
                    myDZ.removeAllFiles();
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
                        type: "error",
                    });
                });


            } //init

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
            response.attachment.forEach(element => {
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
                // count_ef += 1;
                existing_files.push({ name: element.file_name, size: element.file_size });
                for (i = 0; i < existing_files.length; i++) {
                    myDZ.emit("addedfile", existing_files[i], "images/project2/" + i_id + "/");
                    myDZ.emit("complete", existing_files[i], "images/project2/" + i_id + "/");
                    myDZ.emit("thumbnail", existing_files[i], thumb_src);
                    myDZ.files.push(existing_files[i], "images/project2/" + i_id + "/");
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
    formData.append("service", $("#service").val());
    formData.append("reference_number", $("#reference_number").val());
    formData.append("inspection_date", $("#inspection_date").val());
    formData.append("inspection_date_to", $("#inspection_date").val());
    formData.append("psi_shipment_date", $("#psi_shipment_date").val());
    formData.append("client", $('#client').val());
    formData.append("inspector", 0);
    formData.append("factory", $('#factory').val());
    formData.append("factory_contact_person", $('#factory_contact_person').val());
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
    $('.product_name').each(function(i, obj) {
        var val = $(this).val();
        formData.append('product_id[]', val);
    });
    $('.product_name').each(function(i, obj) {
        //var val = $(this).val();
        //var val = $(".product_name option:selected").text(); 
        var val = $(this).find('option:selected').text();
        formData.append('product_name[]', val);
    });
    $('.product_category').each(function(i, obj) {
        var val = $(this).val();
        formData.append('product_category[]', val);
    });
    $('.product_sub_category').each(function(i, obj) {
        var val = $(this).val();
        formData.append('product_sub_category[]', val);
    });
    $('.brand').each(function(i, obj) {
        var val = $(this).val();
        formData.append('brand[]', val);
    });
    $('.po_number').each(function(i, obj) {
        var val = $(this).val();
        formData.append('po_number[]', val);
    });
    $('.model_no').each(function(i, obj) {
        var val = $(this).val();
        formData.append('model_no[]', val);
    });
    $('.p_unit').each(function(i, obj) {
        var val = $(this).val();
        formData.append('p_unit[]', val);
    });
    $('.prod_number').each(function(i, obj) {
        var val = $(this).val();
        formData.append('prod_number[]', val);
    });
    $('.aql_qty').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_qty[]', val);
    });
    $('.aql_qty_unit').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_qty_unit[]', val);
    });
    $('.aql_normal_level').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_level[]', val);
    });
    $('.aql_normal_level').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_level[]', val);
    });
    $('.aql_special_level').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_special_level[]', val);
    });
    $('.aql_major').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_major[]', val);
    });
    $('.max_major').each(function(i, obj) {
        var val = $(this).val();
        formData.append('max_major[]', val);
    });
    $('.aql_minor').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_minor[]', val);
    });
    $('.max_minor').each(function(i, obj) {
        var val = $(this).val();
        formData.append('max_minor[]', val);
    });
    $('.aql_normal_letter').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_letter[]', val);
    });
    $('.aql_normal_sampsize').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_sampsize[]', val);
    });
    $('.aql_special_letter').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_special_letter[]', val);
    });
    $('.aql_special_sampsize').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_special_sampsize[]', val);
    });
    formData.append("has_file", 'false');
    formData.append('_token', token);

    $.ajax({
        url: '/client-saveinspection',
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
                window.location.href = '/panel-client/' + auth_id;
            });

        },
        error: function(error) {
            console.log(error);
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}