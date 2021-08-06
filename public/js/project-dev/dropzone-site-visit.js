$(document).ready(function() {
    var count_ef_cbpi = 0;
    var change_dropzone_url_site = "";
    var site_visit_temp_id = 1054;

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div.file_upload_site", {
        url: saveSite,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoProcessQueue: false,
        addRemoveLinks: true,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
        maxFilesize: 700000000,
        paramName: "file",
        init: function() {
            $("#btn-site-submit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                change_dropzone_url_site = saveSite;
                var empty = $('.site_required').filter(function() { return $(this).val() == ""; });
                console.log(empty.length);
                var cbpi_req = $('.site_required');
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
                if (count_null == 0 && !$("input[name='project_type_site']:checked").val()) {
                    //alert("Please choose type of project");
                    swal({
                        title: "Oops!",
                        text: "Please choose type of project",
                        type: "error",
                    });
                } else if (count_null == 1 && !$("input[name='project_type_site']:checked").val()) {
                    //alert("Please choose type of project");
                    swal({
                        title: "Oops!",
                        text: "Please choose type of project",
                        type: "error",
                    });
                } else if (count_null > 0) {
                    //alert("Please fill up the required fields");
                    swal({
                        title: "Oops!",
                        text: "Please fill up the required fields",
                        type: "error",
                    });
                } else {
                    if (empty.length == 0) {
                        if (myDropzone.getQueuedFiles().length > 0) {
                            //process dropzone if there is/are attached file

                            myDropzone.processQueue();
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
                        //swal('Ooops!', 'Please fill up all fields', 'info');
                    }
                }

            })

            $("#btn-site-submit-draft").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                change_dropzone_url_site = "savedraftinspectionsitewithfiles";
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
                        //alert("Good to go");
                        $('.send-loading ').show();
                        myDropzone.processQueue();
                    } else {
                        //alert("draft");
                        saveSiteDraft();
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
                this.options.url = change_dropzone_url_site;
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

                formData.append("has_file", 'true');


                var type_of_project = $('input[name=project_type_site]:checked').val();
                formData.append("project_type_site", type_of_project);


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
                swal({
                    title: "Success!",
                    text: "New inspection project has been created",
                    type: "success",
                }, function() {
                    window.location.href = '/panel/' + auth_id;
                });
            });
            this.on("errormultiple", function(files, response) {
                console.log(response);
                myDropzone.removeAllFiles();
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




})

function saveSiteDraft() {
    var site_service = $("#site_service_inspection").val();

    var site_reference_number = $("#site_reference_number").val();
    var site_inspection_date = $("#site_inspection_date").val();
    var site_inspection_date_to = $("#site_inspection_date_to").val();
    var site_client = $('#site_client').val();
    var site_inspector = $('#site_inspector').val();
    var site_client_name = $('#site_client_name').val();
    var site_requirements = $('#site_requirements').val();
    var site_memo = $('#site_memo').val();

    var com_name = $('#site_company_name').val();
    var comp_addr = $('#site_company_addr').val();
    var comp_other_info = $('#site_company_other_info').val();

    var site_template = $('#site_template').val();
    //if (site_service == 'site_visit') {
    //    var site_visit_temp_id = 1054;
    //    site_template = site_visit_temp_id;
    //}
    var site_project_number = $('#client_project_number_site').val();

    if (site_template == "") { site_template = 0; }

    var project_type_site = $('input[name=project_type_site]:checked').val();
    var site_report_template = $('#site_report_template').val();
    if (project_type_site == "") { project_type_site = "N/A"; }

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
        url: '/savedraftinspectionsite',
        type: 'POST',
        data: {
            _token: token,
            site_service: site_service,
            site_reference_number: site_reference_number,
            site_inspection_date: site_inspection_date,
            site_inspection_date_to: site_inspection_date_to,
            site_client: site_client,
            site_inspector: site_inspector,
            site_requirements: site_requirements,
            site_memo: site_memo,
            site_template: site_template,
            site_project_number: site_project_number,
            project_type_site: project_type_site,
            site_report_template: site_report_template,
            site_contact_person: contact_person,
            com_name: com_name,
            comp_addr: comp_addr,
            comp_other_info: comp_other_info,
            has_file: 'false',
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
                text: "Inspection project has been save as draft",
                type: "success",
            }, function() {
                window.location.href = '/panel/' + auth_id;
            });
        },
        error: function(error) {
            console.log(error);
            alert("Error: Server encountered an error. Please try again or contact your system administrator.");
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}