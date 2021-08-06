$(document).ready(function() {
    var count_ef_cbpi = 0;
    var change_draft_dropzone_url_cbpi = "";
    var button_click_cbpi;
    var site_visit_temp_id = 1054;
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
        acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsb, .xlsx, .xlsm, .ppt, .pptx, .DOC, .DOCX, .PUB, .JPEG, .JPG, .PNG, .GIF, .XLS, .XLSB, .XLSX, .XLSM, .PPT, .PPTX, .tif, .TIF',
        maxFilesize: 700000000,
        paramName: "file",
        init: function() {
            $("#btn-cbpi-copy").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                button_click_cbpi = "submit";
                var empty = $('.cli_required').filter(function() { return $(this).val() == ""; });
                var pt = $("input[name='project_type_cbpi']:checked").val();
                var cli_req = $('.cli_required');
                var count_draft_null = 0;
                for (var i = 0; i < cli_req.length; i++) {
                    var data = $(cli_req[i]).val();
                    if (data == "") {
                        $(cli_req[i]).css("border", "1px solid red");
                        count_draft_null += 1;
                    } else {
                        $(cli_req[i]).removeAttr("style");
                    }
                }
                console.log('Count empty fields: ' + count_draft_null);
                console.log('Count dropzone files: ' + myDropzone.getQueuedFiles().length);
                if (count_draft_null == 0 && pt != null) {
                    $('.send-loading ').show();
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                    } else {
                        saveCBPICopy();
                    }
                } else {
                    swal({
                        title: "Oops!",
                        text: "Please fill up the required fields",
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
                var chosen_service = $("#loading_service_inspection").val();

                formData.append("loading_service", chosen_service);
                formData.append("loading_reference_number", $("#loading_reference_number").val());
                formData.append("loading_inspection_date", $("#loading_inspection_date").val());
                formData.append("loading_inspection_date_to", $("#loading_inspection_date_to").val());
                formData.append("loading_client", $('#loading_client').val());
                formData.append("loading_inspector", $('#loading_inspector').val());
                formData.append("fm_username_cbpi", $('#fm_username_cbpi_copy').val());
                formData.append("fm_password_cbpi", $('#fm_password_cbpi_copy').val());
                formData.append("fm_inspector_cbpi", $('#fm_inspector_cbpi_copy').val());
                formData.append("old_inspector", $('#old_inspector_cbpi').val());
                formData.append("loading_factory", $('#loading_factory').val());
                formData.append("loading_factory_contact_person", $('#loading_factory_contact_person').val());
                formData.append("loading_client_name", $('#loading_client_name').val());
                formData.append("loading_supplier_name", $('#loading_supplier_name').val());
                formData.append("loading_requirements", $('#loading_requirements').val());
                formData.append("memo", $('#memo_cbpi').val());
                formData.append("loading_invisible", $('#loading_invisible').val());

                var loading_template = $('#loading_template').val();
                if (chosen_service == 'site_visit') {
                    loading_template = site_visit_temp_id;
                }
                //05-28-2021
                var loading_template_word = $('#loading_template_word').val();
                if (chosen_service == 'site_visit') {
                    loading_template_word = site_visit_temp_id;
                }
                formData.append("loading_template", loading_template);
                formData.append("loading_template_word", loading_template_word);
                formData.append("client_project_number_cbpi", $('#client_project_number_cbpi').val());

                formData.append("loading_report_template", $('#loading_report_template').val());

                formData.append("has_file", 'true');

                formData.append("edit_inspection_id_cbpi", $('#edit_inspection_id_cbpi').val());

                var type_of_project = $('input[name=project_type_cbpi]:checked').val();
                formData.append("project_type_cbpi", type_of_project);

                formData.append("client_cost_id", $('#client_cost_id').val());
                formData.append("inspector_cost_id", $('#inspector_cost_id').val());


                formData.append("cbpi_cli_currency", $('#cbpi_cli_currency').val());
                formData.append("cbpi_cli_md_charge", $('#cbpi_cli_md_charge').val());
                formData.append("cbpi_cli_travel_cost", $('#cbpi_cli_travel_cost').val());
                formData.append("cbpi_cli_hotel_cost", $('#cbpi_cli_hotel_cost').val());
                formData.append("cbpi_cli_ot_cost", $('#cbpi_cli_ot_cost').val());
                if ($('.cbpi_cli_other_cost_text').length > 0) {
                    $('.cbpi_cli_other_cost_text').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('cbpi_cli_other_cost_text[]', val);
                    });
                } else {
                    formData.append('cbpi_cli_other_cost_text', 'null');
                }
                if ($('.cbpi_cli_other_cost_value').length > 0) {
                    $('.cbpi_cli_other_cost_value').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('cbpi_cli_other_cost_value[]', val);
                    });
                } else {
                    formData.append('cbpi_cli_other_cost_value', 'null');
                }

                formData.append("cbpi_ins_currency", $('#cbpi_ins_currency').val());
                formData.append("cbpi_ins_md_charge", $('#cbpi_ins_md_charge').val());
                formData.append("cbpi_ins_travel_cost", $('#cbpi_ins_travel_cost').val());
                formData.append("cbpi_ins_hotel_cost", $('#cbpi_ins_hotel_cost').val());
                formData.append("cbpi_ins_ot_cost", $('#cbpi_ins_ot_cost').val());
                if ($('.cbpi_ins_other_cost_text').length > 0) {
                    $('.cbpi_ins_other_cost_text').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('cbpi_ins_other_cost_text[]', val);
                    });
                } else {
                    formData.append('cbpi_ins_other_cost_text', 'null');
                }
                if ($('.cbpi_ins_other_cost_value').length > 0) {
                    $('.cbpi_ins_other_cost_value').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('cbpi_ins_other_cost_value[]', val);
                    });
                } else {
                    formData.append('cbpi_ins_other_cost_value', 'null');
                }

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
                    new_contact_person = $('#loading_contact_person').val();
                } else {
                    new_contact_person = new_contact_person + ',' + $('#loading_contact_person').val();
                }
                //new_contact_person = new_contact_person + ',' + $('#loading_contact_person').val();
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
                    //factory_contact_person2_cbpi = new_fcontact_person;
                    formData.append("factory_contact_person2_cbpi", new_fcontact_person);
                } else {
                    //factory_contact_person2_cbpi = 'N/A';
                    formData.append("factory_contact_person2_cbpi", "N/A");
                }

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
                //myDropzone.removeAllFiles();
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

    var i_id = $('#edit_inspection_id_cbpi').val();
    console.log(i_id);
    var existing_files = [];

    /* $.ajax({
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
    }); */
})



function saveCBPICopy() {
    var formData = new FormData();
    var chosen_service = $("#loading_service_inspection").val();

    formData.append('_token', token);
    formData.append("loading_service", chosen_service);
    formData.append("loading_reference_number", $("#loading_reference_number").val());
    formData.append("loading_inspection_date", $("#loading_inspection_date").val());
    formData.append("loading_inspection_date_to", $("#loading_inspection_date_to").val());
    formData.append("loading_client", $('#loading_client').val());
    formData.append("loading_inspector", $('#loading_inspector').val());
    formData.append("fm_username_cbpi", $('#fm_username_cbpi_copy').val());
    formData.append("fm_password_cbpi", $('#fm_password_cbpi_copy').val());
    formData.append("fm_inspector_cbpi", $('#fm_inspector_cbpi_copy').val());
    formData.append("old_inspector", $('#old_inspector_cbpi').val());
    formData.append("loading_factory", $('#loading_factory').val());
    formData.append("loading_factory_contact_person", $('#loading_factory_contact_person').val());
    formData.append("loading_client_name", $('#loading_client_name').val());
    formData.append("loading_supplier_name", $('#loading_supplier_name').val());
    formData.append("loading_requirements", $('#loading_requirements').val());
    formData.append("memo", $('#memo_cbpi').val());
    formData.append("loading_invisible", $('#loading_invisible').val());
    var loading_template = $('#loading_template').val();
    if (chosen_service == 'site_visit') {
        loading_template = site_visit_temp_id;
    }
    //05-28-2021
    var loading_template_word = $('#loading_template_word').val();
    if (chosen_service == 'site_visit') {
        loading_template_word = site_visit_temp_id;
    }
    formData.append("loading_template", loading_template);
    formData.append("loading_template_word", loading_template_word);
    formData.append("client_project_number_cbpi", $('#client_project_number_cbpi').val());
    formData.append("loading_report_template", $('#loading_report_template').val());
    formData.append("has_file", 'true');
    formData.append("edit_inspection_id_cbpi", $('#edit_inspection_id_cbpi').val());
    var type_of_project = $('input[name=project_type_cbpi]:checked').val();
    formData.append("project_type_cbpi", type_of_project);
    formData.append("client_cost_id", $('#client_cost_id').val());
    formData.append("inspector_cost_id", $('#inspector_cost_id').val());
    formData.append("cbpi_cli_currency", $('#cbpi_cli_currency').val());
    formData.append("cbpi_cli_md_charge", $('#cbpi_cli_md_charge').val());
    formData.append("cbpi_cli_travel_cost", $('#cbpi_cli_travel_cost').val());
    formData.append("cbpi_cli_hotel_cost", $('#cbpi_cli_hotel_cost').val());
    formData.append("cbpi_cli_ot_cost", $('#cbpi_cli_ot_cost').val());
    if ($('.cbpi_cli_other_cost_text').length > 0) {
        $('.cbpi_cli_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            formData.append('cbpi_cli_other_cost_text[]', val);
        });
    } else {
        formData.append('cbpi_cli_other_cost_text', 'null');
    }
    if ($('.cbpi_cli_other_cost_value').length > 0) {
        $('.cbpi_cli_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            formData.append('cbpi_cli_other_cost_value[]', val);
        });
    } else {
        formData.append('cbpi_cli_other_cost_value', 'null');
    }
    formData.append("cbpi_ins_currency", $('#cbpi_ins_currency').val());
    formData.append("cbpi_ins_md_charge", $('#cbpi_ins_md_charge').val());
    formData.append("cbpi_ins_travel_cost", $('#cbpi_ins_travel_cost').val());
    formData.append("cbpi_ins_hotel_cost", $('#cbpi_ins_hotel_cost').val());
    formData.append("cbpi_ins_ot_cost", $('#cbpi_ins_ot_cost').val());
    if ($('.cbpi_ins_other_cost_text').length > 0) {
        $('.cbpi_ins_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            formData.append('cbpi_ins_other_cost_text[]', val);
        });
    } else {
        formData.append('cbpi_ins_other_cost_text', 'null');
    }
    if ($('.cbpi_ins_other_cost_value').length > 0) {
        $('.cbpi_ins_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            formData.append('cbpi_ins_other_cost_value[]', val);
        });
    } else {
        formData.append('cbpi_ins_other_cost_value', 'null');
    }
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
        new_contact_person = $('#loading_contact_person').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#loading_contact_person').val();
    }
    //new_contact_person = new_contact_person + ',' + $('#loading_contact_person').val();
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
        //factory_contact_person2_cbpi = new_fcontact_person;
        formData.append("factory_contact_person2_cbpi", new_fcontact_person);
    } else {
        //factory_contact_person2_cbpi = 'N/A';
        formData.append("factory_contact_person2_cbpi", "N/A");
    }
    $.ajax({
        url: saveCBPI,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            $('.send-loading ').hide();
            swal({
                title: "Success!",
                text: "Inspection project has been successfully copied and published",
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