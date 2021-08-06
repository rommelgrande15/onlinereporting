$(document).ready(function() {
    var count_ef_cbpi = 0;
    var change_dropzone_url_site = "";
    var site_visit_temp_id = 1054;

    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div.site_file_upload", {
        url: saveSiteVisit,
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
            $("#site_submit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                change_dropzone_url_site = saveSiteVisit;
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
                    alert("Please choose type of project");
                } else if (count_null == 1 && !$("input[name='project_type_site']:checked").val()) {
                    alert("Please choose type of project");
                } else if (count_null > 0) {
                    alert("Please fill up the required fields");
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
                change_dropzone_url_site = "savedraftinspectionsite";
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
                formData.append("site_client", $('#site_client').val());
                //formData.append("loading_contact_person", $('#loading_contact_person').val());
                formData.append("site_inspector", $('#site_inspector').val());
                formData.append("site_factory", $('#site_factory').val());
                formData.append("site_factory_contact_person", $('#site_factory_contact_person').val());
                formData.append("site_client_name", $('#site_client_name').val());
                formData.append("site_supplier_name", $('#site_supplier_name').val());
                formData.append("site_requirements", $('#site_requirements').val());
                formData.append("site_memo", $('#site_memo').val());
                /* formData.append("loading_invisible", $('#loading_invisible').val()); */

                var template = $('#site_template').val();
                if (chosen_service == 'site_visit') {
                    template = site_visit_temp_id;
                }
                formData.append("site_template", template);
                formData.append("site_project_number_site", $('#site_project_number_site').val());
                //formData.append("factory_contact_person2_cbpi", $('#factory_contact_person2_cbpi').val());
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


                /* formData.append('aql_qty', $('#cbpi_aql_qty').val());
                formData.append('aql_qty_unit', $('#cbpi_aql_qty_unit').val());
                formData.append('aql_normal_level', $('#cbpi_aql_normal_level').val());
                formData.append('aql_special_level', $('#cbpi_aql_special_level').val());
                formData.append('aql_major', $('#cbpi_aql_major').val());
                formData.append('max_major', $('#cbpi_max_major').val());
                formData.append('aql_minor', $('#cbpi_aql_minor').val());
                formData.append('max_minor', $('#cbpi_max_minor').val());
                formData.append('aql_normal_letter', $('#cbpi_aql_normal_letter').val());
                formData.append('aql_normal_sampsize', $('#cbpi_aql_normal_sampsize').val());
                formData.append('aql_special_letter', $('#cbpi_aql_special_letter').val());
                formData.append('aql_special_sampsize', $('#cbpi_aql_special_sampsize').val()) */


                /* $('.sub_service').append($("<option selected disabled>Select Sub-service</option>")); */

                var type_of_project = $('input[name=project_type_site]:checked').val();
                formData.append("project_type_site", type_of_project);


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
                    new_contact_person = $('#site_contact_person').val();
                } else {
                    new_contact_person = new_contact_person + ',' + $('#site_contact_person').val();
                }
                //new_contact_person = new_contact_person + ',' + $('#loading_contact_person').val();
                formData.append('site_contact_person', new_contact_person);

                var new_fcontact_person = null;
                var added_fcontact_person = jQuery('.factory_contact_added_site');
                if (added_fcontact_person.length > 0 && $(".clone_fcp_site").is(":visible")) {
                    for (var i = 0; i < added_fcontact_person.length; i++) {
                        var data = $(added_fcontact_person[i]).val();
                        if (i == 0) {
                            new_fcontact_person = data;
                        } else {
                            new_fcontact_person = new_fcontact_person + ',' + data;
                        }
                    }
                    formData.append("factory_contact_person2_site", new_fcontact_person);
                } else {
                    formData.append("factory_contact_person2_site", 'N/A');
                }

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
    var loading_service = $("#site_service_inspection").val();

    var loading_reference_number = $("#site_reference_number").val();
    var loading_inspection_date = $("#site_inspection_date").val();
    var loading_client = $('#site_client').val();
    var loading_inspector = $('#site_inspector').val();
    var loading_factory = $('#site_factory').val();
    var loading_factory_contact_person = $('#site_factory_contact_person').val();
    var loading_client_name = $('#site_client_name').val();
    var loading_supplier_name = $('#site_supplier_name').val();
    var loading_requirements = $('#site_requirements').val();
    var memo_cbpi = $('#site_memo').val();

    var loading_template = $('#site_template').val();
    if (loading_service == 'site_visit') {
        loading_template = site_visit_temp_id;
    }
    var client_project_number_cbpi = $('#client_project_number_site').val();
    //var factory_contact_person2_cbpi = $('#factory_contact_person2_cbpi').val();
    var factory_contact_person2_cbpi = "";
    if (loading_template == "") { loading_template = 0; }

    var type_of_project = $('input[name=project_type_site]:checked').val();
    var blank_report_type = $('input[name=blank_report_type_site]:checked').val();
    var loading_report_template = $('#site_report_template').val();
    if (type_of_project == "") { type_of_project = "N/A"; }
    if (blank_report_type == "") { blank_report_type = "N/A"; }
    /* if (loading_report_template == "") { loading_report_template = "N/A"; } */

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
        new_contact_person = $('#site_contact_person').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#site_contact_person').val();
    }
    var contact_person = new_contact_person;

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
        factory_contact_person2_cbpi = new_fcontact_person;
    } else {
        factory_contact_person2_cbpi = 'N/A';
    }


    var cbpi_cli_currency = $('#site_cli_currency').val();
    var cbpi_cli_md_charge = $('#site_cli_md_charge').val();
    var cbpi_cli_travel_cost = $('#site_cli_travel_cost').val();
    var cbpi_cli_hotel_cost = $('#site_cli_hotel_cost').val();
    var cbpi_cli_ot_cost = $('#site_cli_ot_cost').val();
    var cbpi_cli_other_cost_text = [];
    if ($('.site_cli_other_cost_text').length > 0) {
        $('.site_cli_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            cbpi_cli_other_cost_text.push(val);
        });
    } else {
        cbpi_cli_other_cost_text = 'null';
    }
    var cbpi_cli_other_cost_value = [];
    if ($('.site_cli_other_cost_value').length > 0) {
        $('.site_cli_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            cbpi_cli_other_cost_value.push(val);
        });
    } else {
        cbpi_cli_other_cost_value = 'null';
    }

    var cbpi_ins_currency = $('#site_ins_currency').val();
    var cbpi_ins_md_charge = $('#site_ins_md_charge').val();
    var cbpi_ins_travel_cost = $('#site_ins_travel_cost').val();
    var cbpi_ins_hotel_cost = $('#site_ins_hotel_cost').val();
    var cbpi_ins_ot_cost = $('#site_ins_ot_cost').val();
    var cbpi_ins_other_cost_text = [];
    if ($('.site_ins_other_cost_text').length > 0) {
        $('.site_ins_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            cbpi_ins_other_cost_text.push(val);
        });
    } else {
        cbpi_ins_other_cost_text = 'null';
    }
    var cbpi_ins_other_cost_value = [];
    if ($('.site_ins_other_cost_value').length > 0) {
        $('.site_ins_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            cbpi_ins_other_cost_value.push(val);
        });
    } else {
        cbpi_ins_other_cost_value = 'null';
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
    var manday = $('#site_manday').val();



    $.ajax({
        url: '/savedraftinspectionsite',
        type: 'POST',
        data: {
            _token: token,
            loading_service: loading_service,
            loading_reference_number: loading_reference_number,
            loading_inspection_date: loading_inspection_date,
            loading_client: loading_client,
            loading_inspector: loading_inspector,
            loading_factory: loading_factory,
            loading_factory_contact_person: loading_factory_contact_person,
            loading_requirements: loading_requirements,
            memo: memo_cbpi,
            loading_template: loading_template,
            client_project_number: client_project_number_cbpi,
            factory_contact_person2_cbpi: factory_contact_person2_cbpi,
            project_type_cbpi: type_of_project,
            loading_report_template: loading_report_template,
            loading_contact_person: contact_person,
            loading_supplier_name: loading_supplier_name,
            has_file: 'false',
            cbpi_cli_currency: cbpi_cli_currency,
            cbpi_cli_md_charge: cbpi_cli_md_charge,
            cbpi_cli_travel_cost: cbpi_cli_travel_cost,
            cbpi_cli_hotel_cost: cbpi_cli_hotel_cost,
            cbpi_cli_ot_cost: cbpi_cli_ot_cost,
            cbpi_cli_other_cost_text: cbpi_cli_other_cost_text,
            cbpi_cli_other_cost_value: cbpi_cli_other_cost_value,
            cbpi_ins_currency: cbpi_ins_currency,
            cbpi_ins_md_charge: cbpi_ins_md_charge,
            cbpi_ins_travel_cost: cbpi_ins_travel_cost,
            cbpi_ins_hotel_cost: cbpi_ins_hotel_cost,
            cbpi_ins_ot_cost: cbpi_ins_ot_cost,
            cbpi_ins_other_cost_text: cbpi_ins_other_cost_text,
            cbpi_ins_other_cost_value: cbpi_ins_other_cost_value,
            second_inspector: second_inspector,
            manday: manday

        },
        beforeSend: function() {
            $('.send-loading ').show();
        },
        success: function(response) {
            $('.send-loading ').hide();
            //alert("Draft successfully saved");
            //window.location.href="/panel/1";
            //document.location = './panel/' + auth_id;
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