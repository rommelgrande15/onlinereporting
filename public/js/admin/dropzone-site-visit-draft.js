$(document).ready(function() {
    var count_ef_cbpi = 0;
    var change_draft_dropzone_url_cbpi = "";
    var button_click_cbpi;
    var send_email=true;
    var site_visit_temp_id = 1054;
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div.file_upload_site", {
        url: saveEditedSite,
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
            $("#btn-site-submit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                change_draft_dropzone_url_cbpi = saveEditedSite;
                button_click_cbpi = "submit";
                send_email=true;
                var empty = $('.site_required').filter(function() { return $(this).val() == ""; });
                var pt = $("input[name='project_type_site']:checked").val();
                console.log(empty.length);
                if (empty.length == 0 && pt != null) {
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                        $('.send-loading ').show();
                    } else if (count_ef_cbpi > 0) {
                        //manually save here
                        publishSiteDraft(true);
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
                    //swal('Ooops!', 'Please fill up all fields', 'info');
                }
            })

            $("#btn-site-submit-no-email").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                change_draft_dropzone_url_cbpi = saveEditedSite;
                button_click_cbpi = "submit";
                send_email=false;
                var empty = $('.site_required').filter(function() { return $(this).val() == ""; });
                var pt = $("input[name='project_type_site']:checked").val();
                console.log(empty.length);
                if (empty.length == 0 && pt != null) {
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                        $('.send-loading ').show();
                    } else if (count_ef_cbpi > 0) {
                        //manually save here
                        publishSiteDraft(false);
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
                    //swal('Ooops!', 'Please fill up all fields', 'info');
                }
            })

            $("#btn-site-edit-draft").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                button_click_cbpi = "draft";
                change_draft_dropzone_url_cbpi = routeupdateSiteDraft;
                var cbpi_draft_req = $('.site_draft_required');
                var cbpi_req = $('.site_required');
                var count_draft_null = 0;
                for (var i = 0; i < cbpi_req.length; i++) {
                    $(cbpi_req[i]).removeAttr("style");
                }
                for (var i = 0; i < cbpi_draft_req.length; i++) {
                    var data = $(cbpi_draft_req[i]).val();
                    if (data == "") {
                        $(cbpi_draft_req[i]).css("border", "1px solid red");
                        count_draft_null += 1;
                    } else {
                        $(cbpi_draft_req[i]).removeAttr("style");
                    }
                }
                if (count_draft_null == 0) {
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                        $('.send-loading ').show();
                    } else if (count_ef_cbpi > 0) {
                        //manually update here
                        updateSiteDraft();
                    } else {
                        //console.log('No file added in edit mode');
                        updateSiteDraft();
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
                this.options.url = change_draft_dropzone_url_cbpi;
            })

            this.on('removedfile', function(file) {
                var i_id = $('#edit_inspection_id_site').val();
                var name = file.name;
                var pass_file = file;
                var _ref;

                $.ajax({
                    url: '/deleteattachments',
                    type: 'POST',
                    data: {
                        _token: token,
                        inspection_id: i_id,
                        file_name: name
                    },
                    success: function() {
                        count_ef_cbpi -= 1;
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
                var chosen_service = $("#site_service_inspection").val();

                formData.append("site_service", chosen_service);
                formData.append("site_reference_number", $("#site_reference_number").val());
                formData.append("site_inspection_date", $("#site_inspection_date").val());
                formData.append("site_inspection_date_to", $("#site_inspection_date_to").val());
                formData.append("site_client", $('#site_client').val());
                formData.append("site_inspector", $('#site_inspector').val());
                formData.append("site_requirements", $('#site_requirements').val());
                formData.append("site_memo", $('#site_memo').val());

                //send email send_email
                formData.append("send_email", send_email);

                var template = $('#site_template').val();
                //if (chosen_service == 'site_visit') {
                //    var site_visit_temp_id = 1054;
                //    template = site_visit_temp_id;
                //}

                formData.append("site_template", template);
                formData.append("site_project_number", $('#client_project_number_site').val());
                formData.append("site_report_template", $('#site_report_template').val());


                formData.append("com_name", $('#site_company_name').val());
                formData.append("comp_addr", $('#site_company_addr').val());
                formData.append("comp_other_info", $('#site_company_other_info').val());

                formData.append("has_file", 'true');

                formData.append("edit_inspection_id_site", $('#edit_inspection_id_site').val());

                var type_of_project = $('input[name=project_type_site]:checked').val();
                formData.append("project_type_site", type_of_project);

                formData.append("client_cost_id", $('#client_cost_id').val());
                formData.append("inspector_cost_id", $('#inspector_cost_id').val());


                formData.append("site_cli_currency", $('#site_cli_currency').val());
                formData.append("site_cli_md_charge", $('#site_cli_md_charge').val());
                formData.append("site_cli_travel_cost", $('#site_cli_travel_cost').val());
                formData.append("site_cli_hotel_cost", $('#site_cli_hotel_cost').val());
                formData.append("site_cli_ot_cost", $('#site_cli_ot_cost').val());
                if ($('.site_cli_other_cost_text').length > 0) {
                    $('.site_cli_other_cost_text').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('site_cli_other_cost_text[]', val);
                    });
                } else {
                    formData.append('site_cli_other_cost_text', 'null');
                }
                if ($('.site_cli_other_cost_value').length > 0) {
                    $('.site_cli_other_cost_value').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('site_cli_other_cost_value[]', val);
                    });
                } else {
                    formData.append('site_cli_other_cost_value', 'null');
                }

                formData.append("site_ins_currency", $('#site_ins_currency').val());
                formData.append("site_ins_md_charge", $('#site_ins_md_charge').val());
                formData.append("site_ins_travel_cost", $('#site_ins_travel_cost').val());
                formData.append("site_ins_hotel_cost", $('#site_ins_hotel_cost').val());
                formData.append("site_ins_ot_cost", $('#site_ins_ot_cost').val());
                if ($('.site_ins_other_cost_text').length > 0) {
                    $('.site_ins_other_cost_text').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('site_ins_other_cost_text[]', val);
                    });
                } else {
                    formData.append('site_ins_other_cost_text', 'null');
                }
                if ($('.site_ins_other_cost_value').length > 0) {
                    $('.site_ins_other_cost_value').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('site_ins_other_cost_value[]', val);
                    });
                } else {
                    formData.append('site_ins_other_cost_value', 'null');
                }

                var second_inspector = null;
                var added_inspector = jQuery('.site-sel-added-inspector');
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
                formData.append('site_manday', $('#site_manday').val());

                var new_contact_person;
                var added_contact_person = jQuery('.added_contact_persons_site');
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
                    new_contact_person = $('#site_contact_person').val();
                } else {
                    new_contact_person = new_contact_person + ',' + $('#site_contact_person').val();
                }

                formData.append('site_contact_person', new_contact_person);

            });
            this.on("successmultiple", function(files, response) {
                console.log(response);
                if (button_click_cbpi == 'draft') {
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
                $('.send-loading ').hide();
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

    $('#site_service_inspection').on('change', function() {
        console.log($(this).val());
    })

    var i_id = $('#edit_inspection_id_site').val();
    console.log(i_id);
    var existing_files = [];

    $.ajax({
        url: '/findattachments/' + i_id,
        type: 'GET',
        success: function(response) {
            console.log(response.attachment);
            response.attachment.forEach(element => {
                count_ef_cbpi += 1;
                existing_files.push({ name: element.file_name, size: element.file_size });
                for (i = 0; i < existing_files.length; i++) {
                    myDropzone.emit("addedfile", existing_files[i], "images/project2/" + i_id + "/");
                    myDropzone.emit("complete", existing_files[i], "images/project2/" + i_id + "/");
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

function updateSiteDraft() {
    var edit_inspection_id_site = $("#edit_inspection_id_site").val();
    var site_service_inspection = $("#site_service_inspection").val();

    var site_reference_number = $("#site_reference_number").val();
    var site_inspection_date = $("#site_inspection_date").val();
    var site_inspection_date_to = $("#site_inspection_date_to").val();
    var site_client = $('#site_client').val();
    var site_contact_person = $('#site_contact_person').val();

    var com_name = $('#site_company_name').val();
    var comp_addr = $('#site_company_addr').val();
    var comp_other_info = $('#site_company_other_info').val();

    var site_inspector = $('#site_inspector').val();

    var site_client_name = $('#site_client_name').val();

    var site_memo = $('#site_memo').val();
    var site_requirements = $('#site_requirements').val();
    var site_template = $('#site_template').val();
    //if (site_service_inspection == 'site_visit') {
    //    var site_visit_temp_id = 1054;
    //    site_template = site_visit_temp_id;
    //}
    var client_project_number_site = $('#client_project_number_site').val();

    if (site_template == "") { site_template = 0; }

    var type_of_project = $('input[name=project_type_site]:checked').val();
    var site_report_template = $('#site_report_template').val();
    if (type_of_project == "") { type_of_project = "N/A"; }

    if (site_report_template == "") { site_report_template = "N/A"; }

    var new_contact_person = null;
    var added_contact_person = jQuery('.added_contact_persons_site');
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
        new_contact_person = $('#site_contact_person').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#site_contact_person').val();
    }
    var contact_person = new_contact_person;


    var client_cost_id = $('#client_cost_id').val();
    var inspector_cost_id = $('#inspector_cost_id').val();

    var site_cli_currency = $('#site_cli_currency').val();
    var site_cli_md_charge = $('#site_cli_md_charge').val();
    var site_cli_travel_cost = $('#site_cli_travel_cost').val();
    var site_cli_hotel_cost = $('#site_cli_hotel_cost').val();
    var site_cli_ot_cost = $('#site_cli_ot_cost').val();
    var site_cli_other_cost_text = [];
    if ($('.site_cli_other_cost_text').length > 0) {
        $('.site_cli_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            site_cli_other_cost_text.push(val);
        });
    } else {
        site_cli_other_cost_text = 'null';
    }
    var site_cli_other_cost_value = [];
    if ($('.site_cli_other_cost_value').length > 0) {
        $('.site_cli_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            site_cli_other_cost_value.push(val);
        });
    } else {
        site_cli_other_cost_value = 'null';
    }

    var site_ins_currency = $('#site_ins_currency').val();
    var site_ins_md_charge = $('#site_ins_md_charge').val();
    var site_ins_travel_cost = $('#site_ins_travel_cost').val();
    var site_ins_hotel_cost = $('#site_ins_hotel_cost').val();
    var site_ins_ot_cost = $('#site_ins_ot_cost').val();
    var site_ins_other_cost_text = [];
    if ($('.site_ins_other_cost_text').length > 0) {
        $('.site_ins_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            site_ins_other_cost_text.push(val);
        });
    } else {
        site_ins_other_cost_text = 'null';
    }
    var cbpi_ins_other_cost_value = [];
    if ($('.site_ins_other_cost_value').length > 0) {
        $('.site_ins_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            site_ins_other_cost_value.push(val);
        });
    } else {
        site_ins_other_cost_value = 'null';
    }

    var second_inspector = null;
    var added_inspector = jQuery('.site-sel-added-inspector');
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
    var site_manday = $('#site_manday').val();


    $.ajax({
        url: '/editsitedraft',
        type: 'POST',
        data: {
            _token: token,
            edit_inspection_id_site: edit_inspection_id_site,
            site_service: site_service_inspection,
            site_reference_number: site_reference_number,
            site_inspection_date: site_inspection_date,
            site_inspection_date_to: site_inspection_date_to,
            site_client: site_client,
            site_contact_person: contact_person,
            com_name: com_name,
            comp_addr: comp_addr,
            comp_other_info: comp_other_info,
            site_inspector: site_inspector,
            site_requirements: site_requirements,
            site_memo: site_memo,
            site_template: site_template,
            site_project_number: client_project_number_site,
            project_type_site: type_of_project,
            site_report_template: site_report_template,
            has_file: 'false',
            client_cost_id: client_cost_id,
            inspector_cost_id: inspector_cost_id,
            site_cli_currency: site_cli_currency,
            site_cli_md_charge: site_cli_md_charge,
            site_cli_travel_cost: site_cli_travel_cost,
            site_cli_hotel_cost: site_cli_hotel_cost,
            site_cli_ot_cost: site_cli_ot_cost,
            site_cli_other_cost_text: site_cli_other_cost_text,
            site_cli_other_cost_value: site_cli_other_cost_value,
            site_ins_currency: site_ins_currency,
            site_ins_md_charge: site_ins_md_charge,
            site_ins_travel_cost: site_ins_travel_cost,
            site_ins_hotel_cost: site_ins_hotel_cost,
            site_ins_ot_cost: site_ins_ot_cost,
            site_ins_other_cost_text: site_ins_other_cost_text,
            site_ins_other_cost_value: site_ins_other_cost_value,
            second_inspector: second_inspector,
            site_manday: site_manday

        },
        beforeSend: function() {
            $('.send-loading ').show();
        },
        success: function(response) {
            $('.send-loading ').hide();
            //alert("Draft successfully saved");
            //location.reload();
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
            //alert("Error: Server encountered an error. Please try again or contact your system administrator.");
            $('.send-loading ').hide();
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}


function publishSiteDraft(send_email) {
    var edit_inspection_id_site = $("#edit_inspection_id_site").val();
    var site_service = $("#site_service_inspection").val();

    var site_reference_number = $("#site_reference_number").val();
    var site_inspection_date = $("#site_inspection_date").val();
    var site_inspection_date_to = $("#site_inspection_date_to").val();
    var site_client = $('#site_client').val();
    var site_contact_person = $('#site_contact_person').val();

    var com_name = $('#site_company_name').val();
    var comp_addr = $('#site_company_addr').val();
    var comp_other_info = $('#site_company_other_info').val();


    var site_inspector = $('#site_inspector').val();

    var site_client_name = $('#site_client_name').val();

    var site_memo = $('#site_memo').val();
    var site_requirements = $('#site_requirements').val();
    var site_template = $('#site_template').val();
    //if (site_service_inspection == 'site_visit') {
    //    var site_visit_temp_id = 1054;
    //    site_template = site_visit_temp_id;
    //}
    var client_project_number_site = $('#client_project_number_site').val();

    if (site_template == "") { site_template = 0; }

    var type_of_project = $('input[name=project_type_site]:checked').val();
    var site_report_template = $('#site_report_template').val();
    if (type_of_project == "") { type_of_project = "N/A"; }

    if (site_report_template == "") { site_report_template = "N/A"; }

    var new_contact_person = null;
    var added_contact_person = jQuery('.added_contact_persons_site');
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
        new_contact_person = $('#site_contact_person').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#site_contact_person').val();
    }
    var contact_person = new_contact_person;



    var client_cost_id = $('#client_cost_id').val();
    var inspector_cost_id = $('#inspector_cost_id').val();

    var site_cli_currency = $('#site_cli_currency').val();
    var site_cli_md_charge = $('#site_cli_md_charge').val();
    var site_cli_travel_cost = $('#site_cli_travel_cost').val();
    var site_cli_hotel_cost = $('#site_cli_hotel_cost').val();
    var site_cli_ot_cost = $('#site_cli_ot_cost').val();
    var site_cli_other_cost_text = [];
    if ($('.site_cli_other_cost_text').length > 0) {
        $('.site_cli_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            site_cli_other_cost_text.push(val);
        });
    } else {
        site_cli_other_cost_text = 'null';
    }
    var site_cli_other_cost_value = [];
    if ($('.site_cli_other_cost_value').length > 0) {
        $('.site_cli_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            site_cli_other_cost_value.push(val);
        });
    } else {
        site_cli_other_cost_value = 'null';
    }

    var site_ins_currency = $('#site_ins_currency').val();
    var site_ins_md_charge = $('#site_ins_md_charge').val();
    var site_ins_travel_cost = $('#site_ins_travel_cost').val();
    var site_ins_hotel_cost = $('#site_ins_hotel_cost').val();
    var site_ins_ot_cost = $('#site_ins_ot_cost').val();
    var site_ins_other_cost_text = [];
    if ($('.site_ins_other_cost_text').length > 0) {
        $('.site_ins_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            site_ins_other_cost_text.push(val);
        });
    } else {
        site_ins_other_cost_text = 'null';
    }
    var site_ins_other_cost_value = [];
    if ($('.site_ins_other_cost_value').length > 0) {
        $('.site_ins_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            site_ins_other_cost_value.push(val);
        });
    } else {
        site_ins_other_cost_value = 'null';
    }

    var second_inspector = null;
    var added_inspector = jQuery('.site-sel-added-inspector');
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
    var site_manday = $('#site_manday').val();

    $.ajax({
        url: '/publishdraftwoutfilessite',
        type: 'POST',
        data: {
            _token: token,
            send_email:send_email,
            edit_inspection_id_site: edit_inspection_id_site,
            site_service: site_service,
            site_reference_number: site_reference_number,
            site_inspection_date: site_inspection_date,
            site_inspection_date_to: site_inspection_date_to,
            site_client: site_client,
            site_contact_person: contact_person,
            com_name: com_name,
            comp_addr: comp_addr,
            comp_other_info: comp_other_info,
            site_inspector: site_inspector,
            site_requirements: site_requirements,
            site_memo: site_memo,
            site_template: site_template,
            site_project_number: client_project_number_site,
            project_type_site: type_of_project,
            site_report_template: site_report_template,
            has_file: 'false',
            client_cost_id: client_cost_id,
            inspector_cost_id: inspector_cost_id,
            site_cli_currency: site_cli_currency,
            site_cli_md_charge: site_cli_md_charge,
            site_cli_travel_cost: site_cli_travel_cost,
            site_cli_hotel_cost: site_cli_hotel_cost,
            site_cli_ot_cost: site_cli_ot_cost,
            site_cli_other_cost_text: site_cli_other_cost_text,
            site_cli_other_cost_value: site_cli_other_cost_value,
            site_ins_currency: site_ins_currency,
            site_ins_md_charge: site_ins_md_charge,
            site_ins_travel_cost: site_ins_travel_cost,
            site_ins_hotel_cost: site_ins_hotel_cost,
            site_ins_ot_cost: site_ins_ot_cost,
            site_ins_other_cost_text: site_ins_other_cost_text,
            site_ins_other_cost_value: site_ins_other_cost_value,
            second_inspector: second_inspector,
            site_manday: site_manday

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
            //alert("Error: Server encountered an error. Please try again or contact your system administrator.");
            $('.send-loading ').hide();
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}