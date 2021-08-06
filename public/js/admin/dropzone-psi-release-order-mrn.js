$(document).ready(function () {
    var count_ef = 0;
    var change_draft_dropzone_url_psi = "";
    var button_click;
    var inspection_status = "";
    Dropzone.autoDiscover = false;
    var myDZ = new Dropzone("div.file_upload_psi", {
        url: releaseorder,
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
        init: function () {
            $("#btn-psi-submit").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                button_click = "submit";
                inspection_status = "Released";
                change_draft_dropzone_url_psi = releaseorder;
                var empty = $('.psi_required').filter(function () {
                    return $(this).val() == "";
                });
                var pt = $("input[name='project_type']:checked").val();
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
                console.log(count_ef);
                if (empty.length == 0 && pt != null) {
                    if (myDZ.getQueuedFiles().length > 0) {
                        myDZ.processQueue();
                        $('.send-loading ').show();
                    } else if (count_ef > 0) {
                        //manually save here
                        //publishDraft();
                        saveNoAttachment('Released');
                    } else {
                        saveNoAttachment('Released');
                    }
                } else {
                    swal({
                        title: "Oops!",
                        text: "Please fill-up required fields!",
                        type: "warning",
                    });
                }
            })

            $("#btn-psi-hold").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                button_click = "submit";
                inspection_status = "Hold";
                change_draft_dropzone_url_psi = holdorder;
                var empty = $('.psi_required').filter(function () {
                    return $(this).val() == "";
                });
                var pt = $("input[name='project_type']:checked").val();
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
                console.log(count_ef);
                if (empty.length == 0 && pt != null) {
                    if (myDZ.getQueuedFiles().length > 0) {
                        myDZ.processQueue();
                        $('.send-loading ').show();
                    } else if (count_ef > 0) {
                        //manually save here
                        //publishDraft();
                        saveNoAttachment('Hold');
                    } else {
                        saveNoAttachment('Hold');
                    }
                } else {
                    swal({
                        title: "Oops!",
                        text: "Please fill-up required fields!",
                        type: "warning",
                    });
                }
            })

            this.on("processing", function (file) {
                this.options.url = change_draft_dropzone_url_psi;
            })


            this.on('removedfile', function (file) {
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
                    success: function () {
                        swal("Success", "File has been removed!", "success");
                        count_ef -= 1;
                        return (_ref = pass_file.previewElement) != null ? _ref.parentNode.removeChild(pass_file.previewElement) : void 0;
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });




            })

            this.on('addedfile', function (file) {
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
            this.on("sendingmultiple", function (data, xhr, formData) {
                formData.append("service", $("#service").val());
                formData.append("reference_number", $("#reference_number").val());
                formData.append("inspection_date", $("#inspection_date").val());
                formData.append("inspection_date_to", $("#inspection_date_to").val());
                formData.append("client", $('#client').val());
                formData.append("edit_inspection_id", $('#edit_inspection_id').val());
                formData.append("inspector", $('#inspector').val());
                formData.append("factory", $('#factory').val());
                formData.append("factory_address", $('#factory_address').val());
                formData.append("factory_contact_person", $('#factory_contact_person').val());
                formData.append("supplier", $('#supplier').val());
                formData.append("supplier_contact_person", $('#supplier_contact_person').val());
                formData.append("requirement", $('#requirement').val());
                formData.append("memo", $('#memo_psi').val());
                formData.append("template", $('#template').val());
                formData.append("template_word", $('#template_word').val());
                formData.append("client_project_number", $('#client_project_number').val());
                formData.append("inspection_status", inspection_status);

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

                var type_of_project = $('input[name=project_type]:checked').val();
                //04-30-2021
                // var template_word = $('#template_word').val();
                // if (template_word != ""){ type_of_project = "app_project";}
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
                    $('.cli_other_cost_text').each(function (i, obj) {
                        var val = $(this).val();
                        formData.append('cli_other_cost_text[]', val);
                    });
                } else {
                    formData.append('cli_other_cost_text', 'null');
                }
                if ($('.cli_other_cost_value').length > 0) {
                    $('.cli_other_cost_value').each(function (i, obj) {
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
                    $('.ins_other_cost_text').each(function (i, obj) {
                        var val = $(this).val();
                        formData.append('ins_other_cost_text[]', val);
                    });
                } else {
                    formData.append('ins_other_cost_text', 'null');
                }
                if ($('.ins_other_cost_value').length > 0) {
                    $('.ins_other_cost_value').each(function (i, obj) {
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
                //06-03-2021
                $('.mrn_inspection_id').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('mrn_inspection_id[]', val);
                });
                $('.report_id').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('report_id[]', val);
                });


                $('.hidden_product_id').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('edit_pid[]', val);
                });

                $('.s_pname').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('product_id[]', val);
                });

                $('.s_pname').each(function (i, obj) {
                    var val = $(this).find('option:selected').text();
                    formData.append('product_name[]', val);
                });

                $('.s_pcat').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('product_category[]', val);
                });

                $('.s_scat').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('product_sub_category[]', val);
                });

                $('.s_brand').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('brand[]', val);
                });

                $('.s_po').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('po_number[]', val);
                });

                $('.s_model').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('model_no[]', val);
                });

                $('.s_unit').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('product_unit[]', val);
                });

                $('.s_add_info').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('addtl_info[]', val);
                });

                $('.s_item_description').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('item_description[]', val);
                });

                $('.s_qty').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_qty[]', val);
                });

                $('.edit_aql_qty_unit').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_qty_unit[]', val);
                });

                $('.edit_aql_normal_level').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_normal_level[]', val);
                });

                $('.edit_aql_normal_level').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_normal_level[]', val);
                });

                $('.edit_aql_special_level').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_special_level[]', val);
                });

                $('.edit_aql_major').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_major[]', val);
                });

                $('.edit_max_major').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('max_major[]', val);
                });

                $('.edit_aql_minor').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_minor[]', val);
                });

                $('.edit_max_minor').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('max_minor[]', val);
                });

                $('.edit_aql_normal_letter').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_normal_letter[]', val);
                });

                $('.edit_aql_normal_sampsize').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_normal_sampsize[]', val);
                });

                $('.edit_aql_special_letter').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_special_letter[]', val);
                });

                $('.edit_aql_special_sampsize').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('aql_special_sampsize[]', val);
                });

                //new product
                $('.n_pname').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_product_id[]', val);
                });

                $('.n_pname').each(function (i, obj) {
                    var val = $(this).find('option:selected').text();
                    formData.append('new_product_name[]', val);
                });

                $('.n_pcat').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_product_category[]', val);
                });

                $('.n_scat').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_product_sub_category[]', val);
                });

                $('.n_brand').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_brand[]', val);
                });

                $('.n_po').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_po_number[]', val);
                });

                $('.n_model').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_model_no[]', val);
                });

                $('.n_unit').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_product_unit[]', val);
                });

                $('.n_add_info').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_addtl_info[]', val);
                });

                $('.n_item_description').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_item_description[]', val);
                });

                $('.n_qty').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_qty[]', val);
                });

                $('.new_aql_qty_unit').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_qty_unit[]', val);
                });

                $('.new_aql_normal_level').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_normal_level[]', val);
                });

                $('.new_aql_normal_level').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_normal_level[]', val);
                });

                $('.new_aql_special_level').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_special_level[]', val);
                });

                $('.new_aql_major').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_major[]', val);
                });

                $('.new_max_major').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_max_major[]', val);
                });

                $('.new_aql_minor').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_minor[]', val);
                });

                $('.new_max_minor').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_max_minor[]', val);
                });

                $('.new_aql_normal_letter').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_normal_letter[]', val);
                });

                $('.new_aql_normal_sampsize').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_normal_sampsize[]', val);
                });

                $('.new_aql_special_letter').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_special_letter[]', val);
                });

                $('.new_aql_special_sampsize').each(function (i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_special_sampsize[]', val);
                });

            });
            this.on("successmultiple", function (files, response) {
                console.log(response);
                if (inspection_status == 'Hold') {
                    swal({
                        title: "Success!",
                        text: "Inspection project has been hold",
                        type: "success",
                    }, function () {
                        window.location.href = '/client-booking/';
                    });
                } else {
                    swal({
                        title: "Success!",
                        text: "Inspection project has been released",
                        type: "success",
                    }, function () {
                        window.location.href = '/client-booking/';
                    });
                }

            });
            this.on("errormultiple", function (files, response) {
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

    $('#loading_service_inspection').on('change', function () {
        console.log($(this).val());
    })


    var i_id = $('#edit_inspection_id').val();
    console.log(i_id);
    var existing_files = [];

    $.ajax({
        url: '/findattachments/' + i_id,
        type: 'GET',
        success: function (response) {
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
                //count_ef += 1;
                existing_files.push({
                    name: element.file_name,
                    size: element.file_size
                });
                for (i = 0; i < existing_files.length; i++) {
                    var new_src = "http://ticapp.tk/images/project2/" + i_id + "/" + element.file_name;
                    myDZ.emit("addedfile", existing_files[i], "images/project2/" + i_id + "/");
                    myDZ.emit("complete", existing_files[i], "images/project2/" + i_id + "/");
                    if (ext == "pdf" || ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1 || ext.indexOf("pub") != -1 || ext.indexOf("zip") != -1) {
                        myDZ.emit('thumbnail', existing_files[i], thumb_src)
                    } else {
                        existing_files[i].previewElement.querySelector("img").src = new_src;
                    }
                    myDZ.files.push(existing_files[i], "images/project2/" + i_id + "/");
                }
                existing_files = [];
            });
        },
        error: function (error) {
            console.log(error);
        }
    });

})

function saveNoAttachment(inspect_status) {
    var save_link = releaseorder;
    if (inspect_status == 'Hold') {
        save_link = holdorder;
    }
    var formData = new FormData();
    formData.append("service", $("#service").val());
    formData.append("reference_number", $("#reference_number").val());
    formData.append("inspection_date", $("#inspection_date").val());
    formData.append("inspection_date_to", $("#inspection_date_to").val());
    formData.append("client", $('#client').val());
    formData.append("edit_inspection_id", $('#edit_inspection_id').val());
    formData.append("inspector", $('#inspector').val());
    formData.append("factory", $('#factory').val());
    formData.append("factory_address", $('#factory_address').val());
    formData.append("factory_contact_person", $('#factory_contact_person').val());
    formData.append("supplier", $('#supplier').val());
    formData.append("supplier_contact_person", $('#supplier_contact_person').val());
    formData.append("requirement", $('#requirement').val());
    formData.append("memo", $('#memo_psi').val());
    formData.append("template", $('#template').val());
    formData.append("template_word", $('#template_word').val());
    formData.append("client_project_number", $('#client_project_number').val());
    formData.append("inspection_status", inspect_status);
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
    var type_of_project = $('input[name=project_type]:checked').val();
    //04-30-2021
    // var template_word = $('#template_word').val();
    // if (template_word != ""){ type_of_project = "app_project";}
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
        $('.cli_other_cost_text').each(function (i, obj) {
            var val = $(this).val();
            formData.append('cli_other_cost_text[]', val);
        });
    } else {
        formData.append('cli_other_cost_text', 'null');
    }
    if ($('.cli_other_cost_value').length > 0) {
        $('.cli_other_cost_value').each(function (i, obj) {
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
        $('.ins_other_cost_text').each(function (i, obj) {
            var val = $(this).val();
            formData.append('ins_other_cost_text[]', val);
        });
    } else {
        formData.append('ins_other_cost_text', 'null');
    }
    if ($('.ins_other_cost_value').length > 0) {
        $('.ins_other_cost_value').each(function (i, obj) {
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
    //06-03-2021
    $('.mrn_inspection_id').each(function (i, obj) {
        var val = $(this).val();
        formData.append('mrn_inspection_id[]', val);
    });
    $('.report_id').each(function (i, obj) {
        var val = $(this).val();
        formData.append('report_id[]', val);
    });

    $('.hidden_product_id').each(function (i, obj) {
        var val = $(this).val();
        formData.append('edit_pid[]', val);
    });
    $('.s_pname').each(function (i, obj) {
        var val = $(this).val();
        formData.append('product_id[]', val);
    });
    $('.s_pname').each(function (i, obj) {
        var val = $(this).find('option:selected').text();
        formData.append('product_name[]', val);
    });
    $('.s_pcat').each(function (i, obj) {
        var val = $(this).val();
        formData.append('product_category[]', val);
    });
    $('.s_scat').each(function (i, obj) {
        var val = $(this).val();
        formData.append('product_sub_category[]', val);
    });
    $('.s_brand').each(function (i, obj) {
        var val = $(this).val();
        formData.append('brand[]', val);
    });
    $('.s_po').each(function (i, obj) {
        var val = $(this).val();
        formData.append('po_number[]', val);
    });
    $('.s_model').each(function (i, obj) {
        var val = $(this).val();
        formData.append('model_no[]', val);
    });
    $('.s_unit').each(function (i, obj) {
        var val = $(this).val();
        formData.append('product_unit[]', val);
    });
    $('.s_add_info').each(function (i, obj) {
        var val = $(this).val();
        formData.append('addtl_info[]', val);
    });
    $('.s_item_description').each(function (i, obj) {
        var val = $(this).val();
        formData.append('item_description[]', val);
    });
    $('.s_qty').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_qty[]', val);
    });
    $('.edit_aql_qty_unit').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_qty_unit[]', val);
    });
    $('.edit_aql_normal_level').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_level[]', val);
    });
    $('.edit_aql_normal_level').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_level[]', val);
    });
    $('.edit_aql_special_level').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_special_level[]', val);
    });
    $('.edit_aql_major').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_major[]', val);
    });
    $('.edit_max_major').each(function (i, obj) {
        var val = $(this).val();
        formData.append('max_major[]', val);
    });
    $('.edit_aql_minor').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_minor[]', val);
    });
    $('.edit_max_minor').each(function (i, obj) {
        var val = $(this).val();
        formData.append('max_minor[]', val);
    });
    $('.edit_aql_normal_letter').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_letter[]', val);
    });
    $('.edit_aql_normal_sampsize').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_sampsize[]', val);
    });
    $('.edit_aql_special_letter').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_special_letter[]', val);
    });
    $('.edit_aql_special_sampsize').each(function (i, obj) {
        var val = $(this).val();
        formData.append('aql_special_sampsize[]', val);
    });
    //new product
    $('.n_pname').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_product_id[]', val);
    });
    $('.n_pname').each(function (i, obj) {
        var val = $(this).find('option:selected').text();
        formData.append('new_product_name[]', val);
    });
    $('.n_pcat').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_product_category[]', val);
    });
    $('.n_scat').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_product_sub_category[]', val);
    });
    $('.n_brand').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_brand[]', val);
    });
    $('.n_po').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_po_number[]', val);
    });
    $('.n_model').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_model_no[]', val);
    });
    $('.n_unit').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_product_unit[]', val);
    });
    $('.n_add_info').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_addtl_info[]', val);
    });

    $('.n_item_description').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_item_description[]', val);
    });

    $('.n_qty').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_qty[]', val);
    });
    $('.new_aql_qty_unit').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_qty_unit[]', val);
    });
    $('.new_aql_normal_level').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_normal_level[]', val);
    });
    $('.new_aql_normal_level').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_normal_level[]', val);
    });
    $('.new_aql_special_level').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_special_level[]', val);
    });
    $('.new_aql_major').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_major[]', val);
    });
    $('.new_max_major').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_max_major[]', val);
    });
    $('.new_aql_minor').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_minor[]', val);
    });
    $('.new_max_minor').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_max_minor[]', val);
    });
    $('.new_aql_normal_letter').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_normal_letter[]', val);
    });
    $('.new_aql_normal_sampsize').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_normal_sampsize[]', val);
    });
    $('.new_aql_special_letter').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_special_letter[]', val);
    });
    $('.new_aql_special_sampsize').each(function (i, obj) {
        var val = $(this).val();
        formData.append('new_aql_special_sampsize[]', val);
    });

    formData.append('_token', token);
    // Display the key/value pairs
    for (var pair of formData.entries()) {
        console.log(pair[0] + ', ' + pair[1]);
    }
    $.ajax({
        url: save_link,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $('.send-loading ').show();
        },
        success: function (response) {
            $('.send-loading ').hide();
            if (inspect_status == 'Hold') {
                swal({
                    title: "Success!",
                    text: "Inspection project has been hold",
                    type: "success",
                }, function () {
                    window.location.href = '/client-booking/';
                });
            } else {
                swal({
                    title: "Success!",
                    text: "Inspection project has been released",
                    type: "success",
                }, function () {
                    window.location.href = '/client-booking/';
                });
            }


        },
        error: function (error) {
            console.log(error);
            $('.send-loading').hide();
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}
