$(document).ready(function() {
    var count_ef = 0;
    var change_draft_dropzone_url = "";
    var button_click;
    var send_email=true;
    Dropzone.autoDiscover = false;
    var myDZ = new Dropzone("div.file_upload_psi", {
        url: savePSI,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoProcessQueue: false,
        addRemoveLinks: true,
        dictRemoveFileConfirmation: "Are you sure you want to remove this file? Once removed, you will not be able to recover this file on our database.",
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
                change_draft_dropzone_url = savePSI;
                button_click = "submit";
                send_email=true;
                var empty = $('.psi_required').filter(function() { return $(this).val() == ""; });
                var pt = $("input[name='project_type']:checked").val();

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
                console.log(empty.length);
                console.log(count_ef);
                if (empty.length == 0 && pt != null) {
                    if (myDZ.getQueuedFiles().length > 0) {
                        myDZ.processQueue();
                        $('.send-loading ').show();
                    } else if (count_ef > 0) {
                        //manually save here
                        publishDraft(true);
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
                       swal('Ooops!', 'Please fill up all fields', 'info');
                }
            })

            $("#btn-psi-submit-no-email").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                change_draft_dropzone_url = savePSI;
                button_click = "submit";
                send_email=false;
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
                var empty = $('.psi_required').filter(function() { return $(this).val() == ""; });
                var pt = $("input[name='project_type']:checked").val();
                console.log(empty.length);
                console.log(count_ef);
                if (empty.length == 0 && pt != null) {
                    if (myDZ.getQueuedFiles().length > 0) {
                        myDZ.processQueue();
                        $('.send-loading ').show();
                    } else if (count_ef > 0) {
                        //manually save here
                        publishDraft(false);
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
                       swal('Ooops!', 'Please fill up all fields', 'info');
                }
            })

            $("#btn-psi-edit-draft").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                change_draft_dropzone_url = routeupdatePsiDraft;
                button_click = "draft";
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

                        myDZ.processQueue();
                        $('.send-loading ').show();
                    } else if (count_ef > 0) {
                        //manually update here
                        updatePsiDraft();
                    } else {

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
                this.options.url = change_draft_dropzone_url;
            })

            this.on('removedfile', function(file) {
                // var i_id = $('#edit_inspection_id').val();
                var i_id = [];
                $('.mrn_inspection_id').each(function(i, obj) {
                    var val = $(this).val();
                    i_id.push(val);
                });
                var name = file.name;
                var pass_file = file;
                var _ref;

                $.ajax({
                    url: '/deleteattachments-mrn',
                    type: 'POST',
                    data: {
                        _token: token,
                        inspection_id: i_id,
                        file_name: name
                    },
                    success: function() {
                        count_ef -= 1;
                        swal("Success", "File has been removed!", "success");
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
                formData.append("service", $("#service").val());
                // formData.append("reference_number", $("#reference_number").val());
                formData.append("inspection_date", $("#inspection_date").val());
                formData.append("inspection_date_to", $("#inspection_date_to").val());
                formData.append("client", $('#client').val());
                formData.append("edit_inspection_id", $('#edit_inspection_id').val());
                formData.append("inspector", $('#inspector').val());
                formData.append("old_inspector", $('#old_inspector').val());
                formData.append("factory", $('#factory').val());
                formData.append("factory_contact_person", $('#factory_contact_person').val());
                formData.append("requirement", $('#requirement').val());
                formData.append("memo", $('#memo_psi').val());
                formData.append("invisible", $('#invisible').val());
                formData.append("template", $('#template').val());
                formData.append("template_word", $('#template_word').val()); //04-29-2021
                formData.append("client_project_number", $('#client_project_number').val());

                //send email send_email
                formData.append("send_email", send_email);

                var percentageSpkFri = "";
                if ($("#service").val() == "SPK") {
                    percentageSpkFri = $('#SPK').val();
                    formData.append("percentageSpkFri", percentageSpkFri);
                } else if ($("#service").val() == "FRI") {
                    percentageSpkFri = $('#FRI').val();
                    formData.append("percentageSpkFri", percentageSpkFri);
                } else {
                    formData.append("percentageSpkFri", percentageSpkFri);
                }


                formData.append("report_template", $('#report_template').val());
                formData.append("blank_report_type", $('input[name=blank_report_type]:checked').val());
                formData.append("is_new_product_added", $('#is_new_product_added').val());

                var type_of_project = $('input[name=project_type]:checked').val();

                 //04-29-2021
                //  var template_word = $('#template_word').val();
                //  if (template_word != ""){ type_of_project = "app_project";}

                formData.append("type_of_project", type_of_project);

                formData.append("has_file", 'true');

                formData.append('manday', $('#manday').val());

                formData.append("client_cost_id", $('#client_cost_id').val());
                formData.append("inspector_cost_id", $('#inspector_cost_id').val());

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
                if (added_fcontact_person.length > 0) {
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
                    formData.append("factory_contact_person2_psi", "N/A");
                }

                //05-31-2021
                $('.report_id').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('report_id[]', val);
                });
                $('.mrn_inspection_id').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('mrn_inspection_id[]', val);
                });
                $('.reference_number').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('reference_number[]', val);
                });

                $('.hidden_product_id').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('hidden_product_id[]', val);
                });

                $('.product_name').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('product_name[]', val);
                });
                // $('.product_category').each(function(i, obj) {
                //     var val = $(this).val();
                //     formData.append('product_category[]', val);
                // });
                //added 04-16-2021
                $('.product_category').each(function(i, obj) {
                    var val = $(this).find('option:selected').text();
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
                /*  $('.cmf').each(function(i, obj) {
                     var val = $(this).val();
                     formData.append('cmf[]', val);
                 });
                 $('.technical').each(function(i, obj) {
                     var val = $(this).val();
                     formData.append('technical[]', val);
                 });
                 $('.shipping').each(function(i, obj) {
                     var val = $(this).val();
                     formData.append('shipping[]', val);
                 }); */
                $('.prod_addtl_info').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('prod_addtl_info[]', val);
                });

                $('.jesserjOE').each(function(i, obj) {
                    var val = $(this).val();
                    console.log("append " + val);
                    formData.append('aql_qty[]', val);
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

                // new product added
                var new_product_name = [];
                $('.new_product_name').each(function(i, obj) {
                    var val = $(this).val();
                    //formData.append('new_product_name[]', val);
                    console.log("test=" + val);
                    new_product_name.push(val);
                });
                if (new_product_name == "" || new_product_name == null) {
                    formData.append('new_product_name[]', null);
                } else {
                    formData.append('new_product_name[]', new_product_name);
                }

                console.log(new_product_name);


                $('.new_brand').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_brand[]', val);
                });
                //04-27-2021
                $('.new_product_category').each(function(i, obj) {
                    var val = $(this).find('option:selected').text();
                    formData.append('new_product_category[]', val);
                });
                //04-26-2021
                $('.new_product_sub_category').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_product_sub_category[]', val);
                });

                $('.new_po_number').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_po_number[]', val);
                });

                $('.new_model_no').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_model_no[]', val);
                });
                //04-26-2021
                $('.new_product_unit').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_product_unit[]', val);
                });
                //04-27-2021
                $('.new_prod_addtl_info').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_prod_addtl_info[]', val);
                });


                $('.new_aql_qty').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_qty[]', val);
                });

                $('.new_aql_qty_unit').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_qty_unit[]', val);
                });

                $('.new_aql_normal_level').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_normal_level[]', val);
                });

                $('.new_aql_normal_level').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_normal_level[]', val);
                });

                $('.new_aql_special_level').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_special_level[]', val);
                });

                $('.new_aql_major').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_major[]', val);
                });

                $('.new_max_major').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_max_major[]', val);
                });

                $('.new_aql_minor').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_minor[]', val);
                });

                $('.new_max_minor').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_max_minor[]', val);
                });

                $('.new_aql_normal_letter').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_normal_letter[]', val);
                });

                $('.new_aql_normal_sampsize').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_normal_sampsize[]', val);
                });

                $('.new_aql_special_letter').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_special_letter[]', val);
                });

                $('.new_aql_special_sampsize').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_special_sampsize[]', val);
                });

            });
            this.on("successmultiple", function(files, response) {
                console.log(response);
                if (button_click == 'draft') {
                    swal({
                        title: "Success!",
                        text: "Inspection project has been updated",
                        type: "success",
                    }, function() {
                        window.location.href = '/panel/' + auth_id;
                    });
                } else {
                    swal({
                        title: "Success!",
                        text: "Inspection project has been published",
                        type: "success",
                    }, function() {
                        window.location.href = '/panel/' + auth_id;
                    });
                }

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
            response.attachment.forEach(element => {
                count_ef += 1;
                existing_files.push({ name: element.file_name, size: element.file_size });
                for (i = 0; i < existing_files.length; i++) {
                    myDZ.emit("addedfile", existing_files[i], "images/project2/" + i_id + "/");
                    myDZ.emit("complete", existing_files[i], "images/project2/" + i_id + "/");
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

function publishDraft(send_email) {
    var service = $("#service").val();
    // var reference_number = $("#reference_number").val();
    //05-31-2021
    var report_id = [];
    $('.report_id').each(function(i, obj) {
        var val = $(this).val();
        report_id.push(val);
    });
    var mrn_inspection_id = [];
    $('.mrn_inspection_id').each(function(i, obj) {
        var val = $(this).val();
        mrn_inspection_id.push(val);
    });
    var reference_number = [];
    $('.reference_number').each(function(i, obj) {
        var val = $(this).val();
        reference_number.push(val);
    });
    var inspection_date = $("#inspection_date").val();
    var inspection_date_to = $("#inspection_date_to").val();
    var client = $('#client').val();
    var edit_inspection_id = $('#edit_inspection_id').val();
    var inspector = $('#inspector').val();
    var old_inspector = $('#old_inspector').val();
    var factory = $('#factory').val();
    var factory_contact_person = $('#factory_contact_person').val();
    var requirement = $('#requirement').val();
    var memo = $('#memo_psi').val();
    var invisible = $('#invisible').val();
    var template = $('#template').val();
    //04-29-2021
    //if (template == "") { template = 0; }
    //04-29-2021
    var template_word = $('#template_word').val();
    //04-29-2021
    //if (template_word == "") { template_word = 0; }
    var client_project_number = $('#client_project_number').val();
    var word_template = $('#word_template').val();
    var blank_report_type = $('input[name=blank_report_type]:checked').val();
    var is_new_product_added = $('#is_new_product_added').val();

    var type_of_project = $('input[name=project_type]:checked').val();

    // if (template_word != ""){ type_of_project = "app_project";}


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

    var contact_person = new_contact_person;

    var factory_contact_person2_psi = "";
    var new_fcontact_person = null;
    var added_fcontact_person = jQuery('.factory_contact_added');
    if (added_fcontact_person.length > 0) {
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
        factory_contact_person2_psi = "N/A";
    }

    var hidden_product_id = [];

    $('.hidden_product_id').each(function(i, obj) {
        var val = $(this).val();
        hidden_product_id.push(val);
    });

    var product_name = [];
    $('.product_name').each(function(i, obj) {
        var val = $(this).val();
        product_name.push(val);
    });

    var product_category = [];
    $('.product_category').each(function(i, obj) {
        var val = $(this).val();
        product_category.push(val);
    });

    //added 04-16-2021
    var product_sub_category = [];
    $('.product_sub_category').each(function(i, obj) {
        var val = $(this).val();
        product_sub_category.push(val);
    });

    var brand = [];
    $('.brand').each(function(i, obj) {
        var val = $(this).val();
        brand.push(val);
    });

    var po_number = [];
    $('.po_number').each(function(i, obj) {
        var val = $(this).val();
        po_number.push(val);
    });

    var model_no = [];
    $('.model_no').each(function(i, obj) {
        var val = $(this).val();
        model_no.push(val);
    });

    var p_unit = [];
    $('.p_unit').each(function(i, obj) {
        var val = $(this).val();
        p_unit.push(val);
    });
    var prod_addtl_info = [];
    $('.prod_addtl_info').each(function(i, obj) {
        var val = $(this).val();
        prod_addtl_info.push(val);
    });

    var aql_qty = [];
    $('.jesserjOE').each(function(i, obj) {
        var val = $(this).val();
        console.log('aql_qty: ' + val);
        aql_qty.push(val);
    });

    var aql_normal_level = [];
    $('.aql_normal_level').each(function(i, obj) {
        var val = $(this).val();
        aql_normal_level.push(val);
    });

    /*  var aql_normal_level = [];
     $('.aql_normal_level').each(function(i, obj) {
         var val = $(this).val();
         aql_normal_level.push(val);
     }); */

    var aql_special_level = [];
    $('.aql_special_level').each(function(i, obj) {
        var val = $(this).val();
        aql_special_level.push(val);
    });

    var aql_major = [];
    $('.aql_major').each(function(i, obj) {
        var val = $(this).val();
        aql_major.push(val);
    });

    var max_major = [];
    $('.max_major').each(function(i, obj) {
        var val = $(this).val();
        max_major.push(val);
    });

    var aql_minor = [];
    $('.aql_minor').each(function(i, obj) {
        var val = $(this).val();
        aql_minor.push(val);
    });

    var max_minor = [];
    $('.max_minor').each(function(i, obj) {
        var val = $(this).val();
        max_minor.push(val);
    });

    var aql_normal_letter = [];
    $('.aql_normal_letter').each(function(i, obj) {
        var val = $(this).val();
        aql_normal_letter.push(val);
    });

    var aql_normal_sampsize = [];
    $('.aql_normal_sampsize').each(function(i, obj) {
        var val = $(this).val();
        aql_normal_sampsize.push(val);
    });

    var aql_special_letter = [];
    $('.aql_special_letter').each(function(i, obj) {
        var val = $(this).val();
        aql_special_letter.push(val);
    });

    var aql_special_sampsize = [];
    $('.aql_special_sampsize').each(function(i, obj) {
        var val = $(this).val();
        aql_special_sampsize.push(val);
    });

    // new product added
    var new_product_name = [];
    $('.new_product_name').each(function(i, obj) {
        var val = $(this).val();
        new_product_name.push(val);
    });
    if (new_product_name == "" || new_product_name == null) {
        new_product_name = null;
    }

    console.log(new_product_name);


    var new_brand = [];
    $('.new_brand').each(function(i, obj) {
        var val = $(this).val();
        new_brand.push(val);
    });

    var new_product_category = [];
    $('.new_product_category').each(function(i, obj) {
        var val = $(this).val();
        new_product_category.push(val);
    });
    //04-26-2021
    var new_product_sub_category = [];
    $('.new_product_sub_category').each(function(i, obj) {
        var val = $(this).val();
        new_product_sub_category.push(val);
    });

    var new_po_number = [];
    $('.new_po_number').each(function(i, obj) {
        var val = $(this).val();
        new_po_number.push(val);
    });

    var new_model_no = [];
    $('.new_model_no').each(function(i, obj) {
        var val = $(this).val();
        new_model_no.push(val);
    });
    //04-26-2021
    var new_product_unit = [];
    $('.new_product_unit').each(function(i, obj) {
        var val = $(this).val();
        new_product_unit.push(val);
    });
    //04-27-2021
    var new_prod_addtl_info = [];
    $('.new_prod_addtl_info').each(function(i, obj) {
        var val = $(this).val();
        new_prod_addtl_info.push(val);
    });

    var new_aql_qty = [];
    $('.new_aql_qty').each(function(i, obj) {
        var val = $(this).val();
        new_aql_qty.push(val);
    });

    var new_aql_qty_unit = [];
    $('.new_aql_qty_unit').each(function(i, obj) {
        var val = $(this).val();
        new_aql_qty_unit.push(val);
    });

    var new_aql_normal_level = [];
    $('.new_aql_normal_level').each(function(i, obj) {
        var val = $(this).val();
        new_aql_normal_level.push(val);
    });

    var new_aql_special_level = [];
    $('.new_aql_special_level').each(function(i, obj) {
        var val = $(this).val();
        new_aql_special_level.push(val);
    });

    var new_aql_major = [];
    $('.new_aql_major').each(function(i, obj) {
        var val = $(this).val();
        new_aql_major.push(val);
    });

    var new_max_major = [];
    $('.new_max_major').each(function(i, obj) {
        var val = $(this).val();
        new_max_major.push(val);
    });

    var new_aql_minor = [];
    $('.new_aql_minor').each(function(i, obj) {
        var val = $(this).val();
        new_aql_minor.push(val);
    });

    var new_max_minor = [];
    $('.new_max_minor').each(function(i, obj) {
        var val = $(this).val();
        new_max_minor.push(val);
    });

    var new_aql_normal_letter = [];
    $('.new_aql_normal_letter').each(function(i, obj) {
        var val = $(this).val();
        new_aql_normal_letter.push(val);
    });

    var new_aql_normal_sampsize = [];
    $('.new_aql_normal_sampsize').each(function(i, obj) {
        var val = $(this).val();
        new_aql_normal_sampsize.push(val);
    });

    var new_aql_special_letter = [];
    $('.new_aql_special_letter').each(function(i, obj) {
        var val = $(this).val();
        new_aql_special_letter.push(val);
    });

    var new_aql_special_sampsize = [];
    $('.new_aql_special_sampsize').each(function(i, obj) {
        var val = $(this).val();
        new_aql_special_sampsize.push(val);
    });

    var client_cost_id = $('#client_cost_id').val();
    var inspector_cost_id = $('#inspector_cost_id').val();

    var cli_currency = $('#cli_currency').val();
    var cli_md_charge = $('#cli_md_charge').val();
    var cli_travel_cost = $('#cli_travel_cost').val();
    var cli_hotel_cost = $('#cli_hotel_cost').val();
    var cli_ot_cost = $('#cli_ot_cost').val();
    var cli_other_cost_text = [];
    if ($('.cli_other_cost_text').length > 0) {
        $('.cli_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            cli_other_cost_text.push(val);
        });
    } else {
        cli_other_cost_text = 'null';
    }

    var cli_other_cost_value = [];
    if ($('.cli_other_cost_value').length > 0) {
        $('.cli_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            cli_other_cost_value.push(val);
        });
    } else {
        cli_other_cost_value = 'null';
    }

    var ins_currency = $('#ins_currency').val();
    var ins_md_charge = $('#ins_md_charge').val();
    var ins_travel_cost = $('#ins_travel_cost').val();
    var ins_hotel_cost = $('#ins_hotel_cost').val();
    var ins_ot_cost = $('#ins_ot_cost').val();
    var ins_other_cost_text = [];
    if ($('.ins_other_cost_text').length > 0) {
        $('.ins_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            ins_other_cost_text.push(val);
        });
    } else {
        ins_other_cost_text = 'null';
    }

    var ins_other_cost_value = [];
    if ($('.ins_other_cost_value').length > 0) {
        $('.ins_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            ins_other_cost_value.push(val);
        });
    } else {
        ins_other_cost_value = 'null';
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

    var percentageSpkFri = "";
    if ($("#service").val() == "SPK") {
        percentageSpkFri = $('#SPK').val();
    } else if ($("#service").val() == "FRI") {
        percentageSpkFri = $('#FRI').val();
    } else {
        percentageSpkFri = "";
    }

    var manday = $('#manday').val();

    $.ajax({
        url: '/publishdraftwoutfiles-mrn',
        type: 'POST',
        data: {
            _token: token,
            send_email:send_email,
            service: service,
            reference_number: reference_number,
            report_id: report_id,
            mrn_inspection_id: mrn_inspection_id,
            inspection_date: inspection_date,
            inspection_date_to: inspection_date_to,
            client: client,
            edit_inspection_id: edit_inspection_id,
            inspector: inspector,
            old_inspector: old_inspector,
            factory: factory,
            factory_contact_person: factory_contact_person,
            requirement: requirement,
            memo: memo,
            invisible: invisible,
            template: template,
            template_word: template_word,
            client_project_number: client_project_number,
            percentageSpkFri: percentageSpkFri,
            word_template: word_template,
            blank_report_type: blank_report_type,
            is_new_product_added: is_new_product_added,
            type_of_project: type_of_project,
            contact_person: contact_person,
            factory_contact_person2_psi: factory_contact_person2_psi,
            hidden_product_id: hidden_product_id,
            product_name: product_name,
            product_category: product_category,
            product_sub_category: product_sub_category, //04-16-2021
            brand: brand,
            po_number: po_number,
            model_no: model_no,
            p_unit: p_unit,
            aql_qty: aql_qty,
            prod_addtl_info: prod_addtl_info,
            aql_normal_level: aql_normal_level,
            aql_special_level: aql_special_level,
            aql_major: aql_major,
            max_major: max_major,
            aql_minor: aql_minor,
            max_minor: max_minor,
            aql_normal_letter: aql_normal_letter,
            aql_normal_sampsize: aql_normal_sampsize,
            aql_special_letter: aql_special_letter,
            aql_special_sampsize: aql_special_sampsize,
            new_product_name: new_product_name,
            new_product_category: new_product_category,
            new_product_sub_category: new_product_sub_category,
            new_brand: new_brand,
            new_po_number: new_po_number,
            new_model_no: new_model_no,
            new_product_unit: new_product_unit,
            new_prod_addtl_info: new_prod_addtl_info,
            new_aql_qty: new_aql_qty,
            new_aql_qty_unit: new_aql_qty_unit,
            new_aql_normal_level: new_aql_normal_level,
            new_aql_special_level: new_aql_special_level,
            new_aql_major: new_aql_major,
            new_max_major: new_max_major,
            new_aql_minor: new_aql_minor,
            new_max_minor: new_max_minor,
            new_aql_normal_letter: new_aql_normal_letter,
            new_aql_normal_sampsize: new_aql_normal_sampsize,
            new_aql_special_letter: new_aql_special_letter,
            new_aql_special_sampsize: new_aql_special_sampsize,

            client_cost_id: client_cost_id,
            inspector_cost_id: inspector_cost_id,
            cli_currency: cli_currency,
            cli_md_charge: cli_md_charge,
            cli_travel_cost: cli_travel_cost,
            cli_hotel_cost: cli_hotel_cost,
            cli_ot_cost: cli_ot_cost,
            cli_other_cost_text: cli_other_cost_text,
            cli_other_cost_value: cli_other_cost_value,
            ins_currency: ins_currency,
            ins_md_charge: ins_md_charge,
            ins_travel_cost: ins_travel_cost,
            ins_hotel_cost: ins_hotel_cost,
            ins_ot_cost: ins_ot_cost,
            ins_other_cost_text: ins_other_cost_text,
            ins_other_cost_value: ins_other_cost_value,
            second_inspector: second_inspector,
            manday: manday
        },
        beforeSend: function() {
            $('.send-loading ').show();
        },
        success: function(response) {
            $('.send-loading ').hide();
            swal({
                title: "Success!",
                text: "Inspection project has been published",
                type: "success",
            }, function() {
                window.location.href = '/panel/' + auth_id;
            });

        },
        error: function(error) {
            console.log(error);
            $('.send-loading').hide();
            //alert("Error: Server encountered an error. Please try again or contact your system administrator.");
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}

function updatePsiDraft() {
    var service = $("#service").val();
    var mrn_no = $("#mrn_no").val();
    var report_id = [];
    $('.report_id').each(function(i, obj) {
        var val = $(this).val();
        report_id.push(val);
    });
    var mrn_inspection_id = [];
    $('.mrn_inspection_id').each(function(i, obj) {
        var val = $(this).val();
        mrn_inspection_id.push(val);
    });
    // var reference_number = $("#reference_number").val();
    var reference_number = [];
    $('.reference_number').each(function(i, obj) {
        var val = $(this).val();
        reference_number.push(val);
    });
    var inspection_date = $("#inspection_date").val();
    var inspection_date_to = $("#inspection_date_to").val();
    var client = $('#client').val();
    var edit_inspection_id = $('#edit_inspection_id').val();
    var inspector = $('#inspector').val();
    var factory = $('#factory').val();
    var factory_contact_person = $('#factory_contact_person').val();
    var requirement = $('#requirement').val();
    var memo = $('#memo_psi').val();
    var invisible = $('#invisible').val();
    var template = $('#template').val();
    //04-29-2021
    //if (template == "") { template = 0; }
    var template_word = $('#template_word').val(); //04-29-2021
    //04-28-2021
    //if (template_word == "") { template_word = 0; }
    var client_project_number = $('#client_project_number').val();
    var factory_contact_person2_psi = "";
    var report_template = $('#report_template').val();
    var blank_report_type = $('input[name=blank_report_type]:checked').val();

    var type_of_project = $('input[name=project_type]:checked').val();

    //04-29-2021
    // if (template_word != ""){ type_of_project = "app_project";}

    var is_new_product_added = $('#is_new_product_added').val();

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

    var contact_person = new_contact_person;

    var factory_contact_person2_psi = "";
    var new_fcontact_person = null;
    var added_fcontact_person = jQuery('.factory_contact_added');
    if (added_fcontact_person.length > 0) {
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
        factory_contact_person2_psi = "N/A";
    }

    var hidden_product_id = [];
    var product_name = [];
    //added 04-16-2021
    var product_category = [];
    var product_sub_category = [];

    var brand = [];
    var po_number = [];
    var model_no = [];
    var aql_qty = [];
    var aql_normal_level = [];
    var aql_special_level = [];
    var aql_major = [];
    var max_major = [];
    var aql_minor = [];
    var max_minor = [];
    var aql_normal_letter = [];
    var aql_normal_sampsize = [];
    var aql_special_letter = [];
    var aql_special_sampsize = [];

    //new product
    var new_product_name = [];
    var new_brand = [];
    var new_po_number = [];
    var new_model_no = [];
    //04-26-2021
    var new_product_unit = [];
    //04-27-2021
    var new_product_category = [];
    var new_product_sub_category = [];

    var new_aql_qty = [];
    var new_aql_qty_unit = [];
    var new_aql_normal_level = [];
    var new_aql_special_level = [];
    var new_aql_major = [];
    var new_max_major = [];
    var new_aql_minor = [];
    var new_max_minor = [];
    var new_aql_normal_letter = [];
    var new_aql_normal_sampsize = [];
    var new_aql_special_letter = [];
    var new_aql_special_sampsize = [];



    $('.hidden_product_id').each(function(i, obj) {
        var val = $(this).val();
        hidden_product_id.push(val);
    });

    $('.product_name').each(function(i, obj) {
        var val = $(this).val();
        product_name.push(val);
    });
    //added 04-16-2021
    $('.product_category').each(function(i, obj) {
        var val = $(this).val();
        product_category.push(val);
    });
    $('.product_sub_category').each(function(i, obj) {
        var val = $(this).val();
        product_sub_category.push(val);
    });


    $('.brand').each(function(i, obj) {
        var val = $(this).val();
        brand.push(val);
    });

    $('.po_number').each(function(i, obj) {
        var val = $(this).val();
        po_number.push(val);
    });

    $('.model_no').each(function(i, obj) {
        var val = $(this).val();
        model_no.push(val);
    });

    var p_unit = [];
    $('.p_unit').each(function(i, obj) {
        var val = $(this).val();
        p_unit.push(val);
    });
    var cmf = [];
    $('.cmf').each(function(i, obj) {
        var val = $(this).val();
        cmf.push(val);
    });
    var technical = [];
    $('.technical').each(function(i, obj) {
        var val = $(this).val();
        technical.push(val);
    });
    var shipping = [];
    $('.shipping').each(function(i, obj) {
        var val = $(this).val();
        shipping.push(val);
    });
    var prod_addtl_info = [];
    $('.prod_addtl_info').each(function(i, obj) {
        var val = $(this).val();
        prod_addtl_info.push(val);
    });

    $('.jesserjOE').each(function(i, obj) {
        var val = $(this).val();
        console.log("push " + val);
        aql_qty.push(val);
    });

    $('.aql_normal_level').each(function(i, obj) {
        var val = $(this).val();
        aql_normal_level.push(val);
    });

    $('.aql_special_level').each(function(i, obj) {
        var val = $(this).val();
        aql_special_level.push(val);
    });

    $('.aql_major').each(function(i, obj) {
        var val = $(this).val();
        aql_major.push(val);
    });

    $('.max_major').each(function(i, obj) {
        var val = $(this).val();
        max_major.push(val);
    });

    $('.aql_minor').each(function(i, obj) {
        var val = $(this).val();
        aql_minor.push(val);
    });

    $('.max_minor').each(function(i, obj) {
        var val = $(this).val();
        max_minor.push(val);
    });

    $('.aql_normal_letter').each(function(i, obj) {
        var val = $(this).val();
        aql_normal_letter.push(val);
    });

    $('.aql_normal_sampsize').each(function(i, obj) {
        var val = $(this).val();
        aql_normal_sampsize.push(val);
    });

    $('.aql_special_letter').each(function(i, obj) {
        var val = $(this).val();
        aql_special_letter.push(val);
    });

    $('.aql_special_sampsize').each(function(i, obj) {
        var val = $(this).val();
        aql_special_sampsize.push(val);
    });

    // new product added

    $('.new_product_name').each(function(i, obj) {
        var val = $(this).val();
        new_product_name.push(val);
    });
    //04-27-2021
    $('.new_product_category').each(function(i, obj) {
        var val = $(this).val();
        new_product_category.push(val);
    });
    $('.new_product_sub_category').each(function(i, obj) {
        var val = $(this).val();
        new_product_sub_category.push(val);
    });


    $('.new_brand').each(function(i, obj) {
        var val = $(this).val();
        new_brand.push(val);
    });

    $('.new_po_number').each(function(i, obj) {
        var val = $(this).val();
        new_po_number.push(val);
    });

    $('.new_model_no').each(function(i, obj) {
        var val = $(this).val();
        new_model_no.push(val);
    });
    //04-26-2021
    $('.new_product_unit').each(function(i, obj) {
        var val = $(this).val();
        new_product_unit.push(val);
    });
    //04-27-2021
    var new_prod_addtl_info = [];
    $('.new_prod_addtl_info').each(function(i, obj) {
        var val = $(this).val();
        new_prod_addtl_info.push(val);
    });

    $('.new_aql_qty').each(function(i, obj) {
        var val = $(this).val();
        new_aql_qty.push(val);
    });

    $('.new_aql_qty_unit').each(function(i, obj) {
        var val = $(this).val();
        new_aql_qty_unit.push(val);
    });

    $('.new_aql_normal_level').each(function(i, obj) {
        var val = $(this).val();
        new_aql_normal_level.push(val);
    });


    $('.new_aql_special_level').each(function(i, obj) {
        var val = $(this).val();
        new_aql_special_level.push(val);
    });

    $('.new_aql_major').each(function(i, obj) {
        var val = $(this).val();
        new_aql_major.push(val);
    });

    $('.new_max_major').each(function(i, obj) {
        var val = $(this).val();
        new_max_major.push(val);
    });

    $('.new_aql_minor').each(function(i, obj) {
        var val = $(this).val();
        new_aql_minor.push(val);
    });

    $('.new_max_minor').each(function(i, obj) {
        var val = $(this).val();
        new_max_minor.push(val);
    });

    $('.new_aql_normal_letter').each(function(i, obj) {
        var val = $(this).val();
        new_aql_normal_letter.push(val);
    });

    $('.new_aql_normal_sampsize').each(function(i, obj) {
        var val = $(this).val();
        new_aql_normal_sampsize.push(val);
    });

    $('.new_aql_special_letter').each(function(i, obj) {
        var val = $(this).val();
        new_aql_special_letter.push(val);
    });

    $('.new_aql_special_sampsize').each(function(i, obj) {
        var val = $(this).val();
        new_aql_special_sampsize.push(val);
    });

    if (new_product_name == "") {
        new_product_name = null;
    }

    var client_cost_id = $('#client_cost_id').val();
    var inspector_cost_id = $('#inspector_cost_id').val();

    var cli_currency = $('#cli_currency').val();
    var cli_md_charge = $('#cli_md_charge').val();
    var cli_travel_cost = $('#cli_travel_cost').val();
    var cli_hotel_cost = $('#cli_hotel_cost').val();
    var cli_ot_cost = $('#cli_ot_cost').val();
    var cli_other_cost_text = [];
    if ($('.cli_other_cost_text').length > 0) {
        $('.cli_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            cli_other_cost_text.push(val);
        });
    } else {
        cli_other_cost_text = 'null';
    }

    var cli_other_cost_value = [];
    if ($('.cli_other_cost_value').length > 0) {
        $('.cli_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            cli_other_cost_value.push(val);
        });
    } else {
        cli_other_cost_value = 'null';
    }

    var ins_currency = $('#ins_currency').val();
    var ins_md_charge = $('#ins_md_charge').val();
    var ins_travel_cost = $('#ins_travel_cost').val();
    var ins_hotel_cost = $('#ins_hotel_cost').val();
    var ins_ot_cost = $('#ins_ot_cost').val();
    var ins_other_cost_text = [];
    if ($('.ins_other_cost_text').length > 0) {
        $('.ins_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            ins_other_cost_text.push(val);
        });
    } else {
        ins_other_cost_text = 'null';
    }

    var ins_other_cost_value = [];
    if ($('.ins_other_cost_value').length > 0) {
        $('.ins_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            ins_other_cost_value.push(val);
        });
    } else {
        ins_other_cost_value = 'null';
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

    var percentageSpkFri = "";
    if ($("#service").val() == "SPK") {
        percentageSpkFri = $('#SPK').val();
    } else if ($("#service").val() == "FRI") {
        percentageSpkFri = $('#FRI').val();
    } else {
        percentageSpkFri = "";
    }

    var manday = $('#manday').val();


    $.ajax({
        url: '/editpsidraft-mrn',
        type: 'POST',
        data: {
            _token: token,
            service: service,
            mrn_no: mrn_no,
            report_id: report_id,
            mrn_inspection_id: mrn_inspection_id,
            reference_number: reference_number,
            inspection_date: inspection_date,
            inspection_date_to: inspection_date_to,
            client: client,
            edit_inspection_id: edit_inspection_id,
            inspector: inspector,
            factory: factory,
            factory_contact_person: factory_contact_person,
            requirement: requirement,
            memo: memo,
            template: template,
            template_word: template_word, //04-29-2021
            client_project_number: client_project_number,
            percentageSpkFri: percentageSpkFri,
            factory_contact_person2_psi: factory_contact_person2_psi,
            type_of_project: type_of_project,
            report_template: report_template,
            blank_report_type: blank_report_type,
            contact_person: contact_person,
            type_of_project: type_of_project,
            hidden_product_id: hidden_product_id,
            product_name: product_name,
            product_category: product_category,
            product_sub_category: product_sub_category,
            brand: brand,
            po_number: po_number,
            model_no: model_no,
            p_unit: p_unit,
            cmf: cmf,
            technical: technical,
            shipping: shipping,
            prod_addtl_info: prod_addtl_info,
            aql_qty: aql_qty,
            aql_normal_level: aql_normal_level,
            aql_special_level: aql_special_level,
            aql_major: aql_major,
            max_major: max_major,
            aql_minor: aql_minor,
            max_minor: max_minor,
            aql_normal_letter: aql_normal_letter,
            aql_normal_sampsize: aql_normal_sampsize,
            aql_special_letter: aql_special_letter,
            aql_special_sampsize: aql_special_sampsize,

            new_product_name: new_product_name,
            new_product_category: new_product_category,
            new_product_sub_category: new_product_sub_category,
            new_brand: new_brand,
            new_po_number: new_po_number,
            new_model_no: new_model_no,
            new_product_unit: new_product_unit,
            new_prod_addtl_info: new_prod_addtl_info,
            new_aql_qty: new_aql_qty,
            new_aql_qty_unit: new_aql_qty_unit,
            new_aql_normal_level: new_aql_normal_level,
            new_aql_special_level: new_aql_special_level,
            new_aql_major: new_aql_major,
            new_max_major: new_max_major,
            new_aql_minor: new_aql_minor,
            new_max_minor: new_max_minor,
            new_aql_normal_letter: new_aql_normal_letter,
            new_aql_normal_sampsize: new_aql_normal_sampsize,
            new_aql_special_letter: new_aql_special_letter,
            new_aql_special_sampsize: new_aql_special_sampsize,
            has_file: 'false',
            is_new_product_added: is_new_product_added,
            client_cost_id: client_cost_id,
            inspector_cost_id: inspector_cost_id,
            cli_currency: cli_currency,
            cli_md_charge: cli_md_charge,
            cli_travel_cost: cli_travel_cost,
            cli_hotel_cost: cli_hotel_cost,
            cli_ot_cost: cli_ot_cost,
            cli_other_cost_text: cli_other_cost_text,
            cli_other_cost_value: cli_other_cost_value,
            ins_currency: ins_currency,
            ins_md_charge: ins_md_charge,
            ins_travel_cost: ins_travel_cost,
            ins_hotel_cost: ins_hotel_cost,
            ins_ot_cost: ins_ot_cost,
            ins_other_cost_text: ins_other_cost_text,
            ins_other_cost_value: ins_other_cost_value,
            second_inspector: second_inspector,
            manday: manday
        },
        beforeSend: function() {
            $('.send-loading ').show();
        },
        success: function(response) {
            $('.send-loading ').hide();
            swal({
                title: "Success!",
                text: "Inspection project has been updated",
                type: "success",
            }, function() {
                window.location.href = '/panel/' + auth_id;
            });

        },
        error: function(error) {
            console.log(error);
            $('.send-loading').hide();
            //alert("Error: Server encountered an error. Please try again or contact your system administrator.");
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}