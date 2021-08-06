$(document).ready(function() {
    Dropzone.autoDiscover = false;
    var change_dropzone_url = "";
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
        acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsb, .xlsx, .xlsm, .ppt, .pptx, .DOC, .DOCX, .PUB, .JPEG, .JPG, .PNG, .GIF, .XLS, .XLSB, .XLSX, .XLSM, .PPT, .PPTX, .tif, .TIF',
        maxFilesize: 500000000,
        paramName: "file",
        init: function() {
                $("#btn-psi-submit").click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    change_dropzone_url = savePSI;
                    var empty = $('.psi_required').filter(function() { return $(this).val() == ""; });
                    var pt = $("input[name='project_type']:checked").val();
                    console.log(empty.length);
                    if (empty.length == 0 && pt != null) {
                        if (myDZ.getQueuedFiles().length > 0) {
                            myDZ.processQueue();
                            $('.send-loading ').show();
                        } else {
                            swal({
                                title: "Oops!",
                                text: "Please add an attachment!",
                                type: "error",
                            }, function() {
                                $('.send-loading ').hide();
                            });
                        }
                    } else {
                        //   swal('Ooops!', 'Please fill up all fields', 'info');
                    }
                })

                $("#btn-psi-submit-draft").click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    change_dropzone_url = "savedraftinspection-dev-mr";
                    var psi_draft_req = $('.psi_draft_required');
                    var psi_req = $('.psi_required');
                    var count_draft_null = 0;
                    for (var i = 0; i < psi_req.length; i++) {
                        $(psi_req[i]).removeAttr("style");
                    }
                    for (var i = 0; i < psi_draft_req.length; i++) {
                        var data = $(psi_draft_req[i]).val();
                        if (data == "") {
                            $(psi_draft_req[i]).css("border", "1px solid red");
                            count_draft_null += 1;
                        } else {
                            $(psi_draft_req[i]).removeAttr("style");
                        }
                    }
                    if (count_draft_null == 0) {
                        if (myDZ.getQueuedFiles().length > 0) {
                            //alert("Good to go");
                            $('.send-loading ').show();
                            myDZ.processQueue();
                        } else {
                            //alert("draft");
                            savePsiAsDraft();
                        }
                    } else {
                        //alert("Please fill up the required fields");
                        swal({
                            title: "Oops!",
                            text: "Please fill up the required fields",
                            type: "warning",
                        });
                    }
                })

                this.on("processing", function(file) {
                    this.options.url = change_dropzone_url;
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
                    formData.append("inspection_date_to", $("#inspection_date_to").val());
                    formData.append("client", $('#client').val());
                    //formData.append("contact_person", $('#contact_person').val());
                    formData.append("inspector", $('#inspector').val());
                    formData.append("fm_username", $('#fm_username').val());
                    formData.append("fm_password", $('#fm_password').val());
                    formData.append("factory", $('#factory').val());
                    formData.append("factory_contact_person", $('#factory_contact_person').val());
                    formData.append("requirement", $('#requirement').val());
                    formData.append("memo", $('#memo_psi').val());
                    formData.append("invisible", $('#invisible').val());
                    formData.append("template", $('#template').val());
                    formData.append("template_word", $('#template_word').val());
                    formData.append("report_template", $('#report_template').val());
                    formData.append("client_project_number", $('#client_project_number').val());
                    formData.append("complex_report", $('#complex_report').val());
                    console.log($('#FRI').val() + " " + $('#FRI').val());

                    if ($("#service").val() == "SPK") {
                        formData.append("percentageSpkFri", $('#SPK').val());
                    } else if ($("#service").val() == "FRI") {
                        formData.append("percentageSpkFri", $('#FRI').val());
                    }


                    formData.append("cli_currency", $('#cli_currency').val());
                    formData.append("cli_md_charge", $('#cli_md_charge').val());
                    formData.append("cli_travel_cost", $('#cli_travel_cost').val());
                    formData.append("cli_hotel_cost", $('#cli_hotel_cost').val());
                    formData.append("cli_ot_cost", $('#cli_ot_cost').val());
                    if ($('.cli_other_cost_text').length > 0) {
                        $('.cli_other_cost_text').each(function(i, obj) {
                            var val = $(this).val();
                            formData.append('cli_other_cost_text[]', val);
                        });
                    } else {
                        formData.append('cli_other_cost_text', 'null');
                    }
                    if ($('.cli_other_cost_value').length > 0) {
                        $('.cli_other_cost_value').each(function(i, obj) {
                            var val = $(this).val();
                            formData.append('cli_other_cost_value[]', val);
                        });
                    } else {
                        formData.append('cli_other_cost_value', 'null');
                    }

                    formData.append("ins_currency", $('#ins_currency').val());
                    formData.append("ins_md_charge", $('#ins_md_charge').val());
                    formData.append("ins_travel_cost", $('#ins_travel_cost').val());
                    formData.append("ins_hotel_cost", $('#ins_hotel_cost').val());
                    formData.append("ins_ot_cost", $('#ins_ot_cost').val());
                    if ($('.ins_other_cost_text').length > 0) {
                        $('.ins_other_cost_text').each(function(i, obj) {
                            var val = $(this).val();
                            formData.append('ins_other_cost_text[]', val);
                        });
                    } else {
                        formData.append('ins_other_cost_text', 'null');
                    }
                    if ($('.ins_other_cost_value').length > 0) {
                        $('.ins_other_cost_value').each(function(i, obj) {
                            var val = $(this).val();
                            formData.append('ins_other_cost_value[]', val);
                        });
                    } else {
                        formData.append('ins_other_cost_value', 'null');
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
                    formData.append('manday', $('#manday').val());

                    formData.append("blank_report_type", $('input[name=blank_report_type]:checked').val());

                    formData.append("has_file", 'true');

                    var type_of_project = $('input[name=project_type]:checked').val();
                    //04-28-2021
                    // var template_word = $('#template_word').val();
                    // if (template_word != ""){ type_of_project = "app_project";}
                    formData.append("type_of_project", type_of_project);

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

                    ////04-20-2021
                    var new_set_data = [];
                    $('.report_number').each(function(i, obj) {
                        var report_number = $(this).val();
                        var get_product_name = $(this).closest('.product-with-report').find('.product_name');
                        var products = [];
                        $(get_product_name).each(function(i_pn, obj_pn) {
                            products[i_pn] = {
                                'product_name': $(this).closest('.clone-inputs').find('.product_name').val(),
                                'product_category': $(this).closest('.clone-inputs').find('.order_product_category').val(),
                                'product_sub_category': $(this).closest('.clone-inputs').find('.order_product_sub_category').val(),
                                'brand': $(this).closest('.clone-inputs').find('.brand').val(),
                                'po_number': $(this).closest('.clone-inputs').find('.po_number').val(),
                                'model_no': $(this).closest('.clone-inputs').find('.model_no').val(),
                                'p_unit': $(this).closest('.clone-inputs').find('.p_unit').val(),
                                'prod_addtl_info': $(this).closest('.clone-inputs').find('.prod_addtl_info').val(),
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
                    swal({
                        title: "Success!",
                        text: "Inspection project has been published",
                        type: "success",
                    }, function() {
                        window.location.href = '/panel/' + auth_id;
                    });
                });
                this.on("errormultiple", function(files, response) {
                    console.log(response);
                    $('.send-loading').hide();
                    //myDZ.removeAllFiles();
                    //alert("Error: Server encountered an error. Please try again or contact your system administrator.");
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                        type: "error",
                    });
                });


            } //init

    });

    $('#loading_service_inspection').on('change', function() {
        console.log($(this).val());
    })

    /*  var existingFiles = [
         { name: "item list EB-1800144.xlsx", size: 9840 },
         { name: "Online booking USERNAME & PASSWORD.docx", size: 564808 }
     ];

     for (i = 0; i < existingFiles.length; i++) {
         myDZ.emit("addedfile", existingFiles[i], "images/project2/1/");
         // myDZ.emit("thumbnail", existingFiles[i], "images/project2/1/");
         myDZ.emit("complete", existingFiles[i], "images/project2/1/");
     } */


})

function savePsiAsDraft() {
    var form_data = new FormData();
    var service = $("#service").val();
    var reference_number = $("#reference_number").val();
    var inspection_date = $("#inspection_date").val();
    var client = $('#client').val();
    var inspector = $('#inspector').val();
    var factory = $('#factory').val();
    var factory_contact_person = $('#factory_contact_person').val();
    var requirement = $('#requirement').val();
    var memo = $('#memo_psi').val();
    var invisible = $('#invisible').val();
    var template = $('#template').val();
    var template_word = $('#template_word').val();
    if (template == "") { template = 0; }
    //04-28-2021
    if (template_word == "") { template_word = 0; }
    var client_project_number = $('#client_project_number').val();
    //var factory_contact_person2_psi = $('#factory_contact_person2_psi').val();
    var factory_contact_person2_psi = "";
    var sub_service = $('#sub_service').val();
    if (sub_service == "") { sub_service = "N/A"; }

    var type_of_project = $('input[name=project_type]:checked').val();
    // //04-28-2021
    // if (template_word != ""){ type_of_project = "app_project";}

    var blank_report_type = $('input[name=blank_report_type]:checked').val();
    var report_template = $('#report_template').val();
    if (blank_report_type == "") { blank_report_type = "N/A"; }
    if (report_template == "") { report_template = "0"; }
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
        factory_contact_person2_psi = new_fcontact_person;
    } else {
        factory_contact_person2_psi = 'N/A';
    }


    if (new_contact_person == "" || new_contact_person == null) {
        new_contact_person = $('#contact_person').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#contact_person').val();
    }
    var contact_person = new_contact_person;

    form_data.append("cli_currency", $('#cli_currency').val());
    form_data.append("cli_md_charge", $('#cli_md_charge').val());
    form_data.append("cli_travel_cost", $('#cli_travel_cost').val());
    form_data.append("cli_hotel_cost", $('#cli_hotel_cost').val());
    form_data.append("cli_ot_cost", $('#cli_ot_cost').val());
    if ($('.cli_other_cost_text').length > 0) {
        $('.cli_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            form_data.append('cli_other_cost_text[]', val);
        });
    } else {
        form_data.append('cli_other_cost_text', 'null');
    }
    if ($('.cli_other_cost_value').length > 0) {
        $('.cli_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            form_data.append('cli_other_cost_value[]', val);
        });
    } else {
        form_data.append('cli_other_cost_value', 'null');
    }

    form_data.append("ins_currency", $('#ins_currency').val());
    form_data.append("ins_md_charge", $('#ins_md_charge').val());
    form_data.append("ins_travel_cost", $('#ins_travel_cost').val());
    form_data.append("ins_hotel_cost", $('#ins_hotel_cost').val());
    form_data.append("ins_ot_cost", $('#ins_ot_cost').val());
    if ($('.ins_other_cost_text').length > 0) {
        $('.ins_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            form_data.append('ins_other_cost_text[]', val);
        });
    } else {
        form_data.append('ins_other_cost_text', 'null');
    }
    if ($('.ins_other_cost_value').length > 0) {
        $('.ins_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            form_data.append('ins_other_cost_value[]', val);
        });
    } else {
        form_data.append('ins_other_cost_value', 'null');
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

    if ($("#service").val() == "SPK") {
        form_data.append("percentageSpkFri", $('#SPK').val());
    } else if ($("#service").val() == "FRI") {
        form_data.append("percentageSpkFri", $('#FRI').val());
    }

    form_data.append("inspection_date_to", $("#inspection_date_to").val());

    form_data.append('second_inspector', second_inspector);
    form_data.append('manday', $('#manday').val());

    form_data.append('service', service);
    form_data.append('reference_number', reference_number);
    form_data.append('inspection_date', inspection_date);
    form_data.append("inspection_date_to", $("#inspection_date_to").val());
    form_data.append('client', client);
    form_data.append('inspector', inspector);
    form_data.append('factory', factory);
    form_data.append('factory_contact_person', factory_contact_person);
    form_data.append('requirement', requirement);
    form_data.append('memo', memo);
    form_data.append('invisible', invisible);
    form_data.append('template', template);
    form_data.append('template_word', template_word);
    form_data.append('client_project_number', client_project_number);
    form_data.append('factory_contact_person2_psi', factory_contact_person2_psi);
    form_data.append('sub_service', sub_service);
    form_data.append('type_of_project', type_of_project);
    form_data.append('report_template', report_template);
    form_data.append('blank_report_type', blank_report_type);
    form_data.append('contact_person', contact_person);
    form_data.append("complex_report", $('#complex_report').val());

    //////04-20-2021
    var new_set_data = [];
    $('.report_number').each(function(i, obj) {
        var report_number = $(this).val();
        var get_product_name = $(this).closest('.product-with-report').find('.product_name');
        var products = [];
        $(get_product_name).each(function(i_pn, obj_pn) {
            products[i_pn] = {
                'product_name': $(this).closest('.clone-inputs').find('.product_name').val(),
                'product_category': $(this).closest('.clone-inputs').find('.order_product_category').val(),
                'product_sub_category': $(this).closest('.clone-inputs').find('.order_product_sub_category').val(),
                'brand': $(this).closest('.clone-inputs').find('.brand').val(),
                'po_number': $(this).closest('.clone-inputs').find('.po_number').val(),
                'model_no': $(this).closest('.clone-inputs').find('.model_no').val(),
                'p_unit': $(this).closest('.clone-inputs').find('.p_unit').val(),
                'prod_addtl_info': $(this).closest('.clone-inputs').find('.prod_addtl_info').val(),
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
    form_data.append("has_file", 'false');
    form_data.append('_token', token);

    $.ajax({
        url: '/savedraftinspection-dev-mr',
        type: 'POST',
        data: form_data,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $('.send-loading ').show();
        },
        success: function(response) {
            $('.send-loading ').hide();
            //alert("Draft successfully saved");
            //window.location.href="/panel/1";
            // document.location = './panel/' + auth_id;
            swal({
                title: "Success!",
                text: "Inspection project has been save as draft",
                type: "success",
            }, function() {
                window.location.href = '/panel/' + auth_id;
            });

        },
        error: function(error) {
            console.log(error);
            //alert("Error: Server encountered an error. Please try again or contact your system administrator.");
            $('.send-loading').hide();
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}