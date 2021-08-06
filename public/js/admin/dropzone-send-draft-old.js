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
        acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx',
        maxFilesize: 700000000,
        paramName: "file",
        init: function() {
            $("#CBPI_submit").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                change_draft_dropzone_url_cbpi = saveCBPI;
                button_click_cbpi = "submit";
                var empty = $('.cli_required').filter(function() { return $(this).val() == ""; });
                var pt = $("input[name='project_type_cbpi']:checked").val();
                console.log(empty.length);
                if (empty.length == 0 && pt != null) {
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                        $('.send-loading ').show();
                    } else if (count_ef_cbpi > 0) {
                        //manually save here
                        publishCbpiDraft();
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

            $("#btn-cbpi-edit-draft").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                button_click_cbpi = "draft";
                change_draft_dropzone_url_cbpi = routeditdraftCbpi;
                var cbpi_draft_req = $('.cli_draft_required');
                var cbpi_req = $('.cli_required');
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
                        updateCbpiDraft();
                    } else {
                        //console.log('No file added in edit mode');
                        updateCbpiDraft();
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
                var i_id = $('#edit_inspection_id_cbpi').val();
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
                var chosen_service = $("#loading_service_inspection").val();

                formData.append("loading_service", chosen_service);
                formData.append("loading_reference_number", $("#loading_reference_number").val());
                formData.append("loading_inspection_date", $("#loading_inspection_date").val());
                formData.append("loading_client", $('#loading_client').val());
                //formData.append("loading_contact_person", $('#loading_contact_person').val());
                formData.append("loading_inspector", $('#loading_inspector').val());
                formData.append("loading_factory", $('#loading_factory').val());
                formData.append("loading_factory_contact_person", $('#loading_factory_contact_person').val());
                formData.append("loading_client_name", $('#loading_client_name').val());
                formData.append("loading_supplier_name", $('#loading_supplier_name').val());
                formData.append("loading_requirements", $('#loading_requirements').val());
                formData.append("memo", $('#memo_cbpi').val());
                formData.append("loading_invisible", $('#loading_invisible').val());

                var loading_template = $('#loading_template').val();
                if (loading_service == 'site_visit') {
                    loading_template = site_visit_temp_id;
                }
                formData.append("loading_template", loading_template);
                formData.append("client_project_number_cbpi", $('#client_project_number_cbpi').val());
                //formData.append("factory_contact_person2_cbpi", $('#factory_contact_person2_cbpi').val());
                formData.append("loading_report_template", $('#loading_report_template').val());

                formData.append("has_file", 'true');

                formData.append("edit_inspection_id_cbpi", $('#edit_inspection_id_cbpi').val());

                /* $('.sub_service').append($("<option selected disabled>Select Sub-service</option>")); */

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

    $('#loading_service_inspection').on('change', function() {
        console.log($(this).val());
    })

    var i_id = $('#edit_inspection_id_cbpi').val();
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

function updateCbpiDraft() {
    var edit_inspection_id_cbpi = $("#edit_inspection_id_cbpi").val();
    var loading_service = $("#loading_service_inspection").val();

    var loading_reference_number = $("#loading_reference_number").val();
    var loading_inspection_date = $("#loading_inspection_date").val();
    var loading_client = $('#loading_client').val();
    var loading_contact_person = $('#loading_contact_person').val();

    var loading_inspector = $('#loading_inspector').val();
    var loading_factory = $('#loading_factory').val();
    var loading_factory_contact_person = $('#loading_factory_contact_person').val();
    var loading_client_name = $('#loading_client_name').val();
    var loading_supplier_name = $('#loading_supplier_name').val();
    var memo = $('#memo_cbpi').val();
    var loading_requirements = $('#loading_requirements').val();
    var loading_template = $('#loading_template').val();
    if (loading_service == 'site_visit') {
        loading_template = site_visit_temp_id;
    }
    var client_project_number_cbpi = $('#client_project_number_cbpi').val();
    //var factory_contact_person2_cbpi = $('#factory_contact_person2_cbpi').val();
    var factory_contact_person2_cbpi = "";
    if (loading_template == "") { loading_template = 0; }

    var type_of_project = $('input[name=project_type_cbpi]:checked').val();
    var loading_report_template = $('#loading_report_template').val();
    if (type_of_project == "") { type_of_project = "N/A"; }

    if (loading_report_template == "") { loading_report_template = "N/A"; }

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
        new_contact_person = $('#loading_contact_person').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#loading_contact_person').val();
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

    var client_cost_id = $('#client_cost_id').val();
    var inspector_cost_id = $('#inspector_cost_id').val();

    var cbpi_cli_currency = $('#cbpi_cli_currency').val();
    var cbpi_cli_md_charge = $('#cbpi_cli_md_charge').val();
    var cbpi_cli_travel_cost = $('#cbpi_cli_travel_cost').val();
    var cbpi_cli_hotel_cost = $('#cbpi_cli_hotel_cost').val();
    var cbpi_cli_ot_cost = $('#cbpi_cli_ot_cost').val();
    var cbpi_cli_other_cost_text = [];
    if ($('.cbpi_cli_other_cost_text').length > 0) {
        $('.cbpi_cli_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            cbpi_cli_other_cost_text.push(val);
        });
    } else {
        cbpi_cli_other_cost_text = 'null';
    }
    var cbpi_cli_other_cost_value = [];
    if ($('.cbpi_cli_other_cost_value').length > 0) {
        $('.cbpi_cli_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            cbpi_cli_other_cost_value.push(val);
        });
    } else {
        cbpi_cli_other_cost_value = 'null';
    }

    var cbpi_ins_currency = $('#cbpi_ins_currency').val();
    var cbpi_ins_md_charge = $('#cbpi_ins_md_charge').val();
    var cbpi_ins_travel_cost = $('#cbpi_ins_travel_cost').val();
    var cbpi_ins_hotel_cost = $('#cbpi_ins_hotel_cost').val();
    var cbpi_ins_ot_cost = $('#cbpi_ins_ot_cost').val();
    var cbpi_ins_other_cost_text = [];
    if ($('.cbpi_ins_other_cost_text').length > 0) {
        $('.cbpi_ins_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            cbpi_ins_other_cost_text.push(val);
        });
    } else {
        cbpi_ins_other_cost_text = 'null';
    }
    var cbpi_ins_other_cost_value = [];
    if ($('.cbpi_ins_other_cost_value').length > 0) {
        $('.cbpi_ins_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            cbpi_ins_other_cost_value.push(val);
        });
    } else {
        cbpi_ins_other_cost_value = 'null';
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
    var manday = $('#cbpi_manday').val();


    $.ajax({
        url: '/editcbpidraft',
        type: 'POST',
        data: {
            _token: token,
            edit_inspection_id_cbpi: edit_inspection_id_cbpi,
            loading_service: loading_service,
            loading_reference_number: loading_reference_number,
            loading_inspection_date: loading_inspection_date,
            loading_client: loading_client,
            loading_contact_person: contact_person,
            loading_inspector: loading_inspector,
            loading_factory: loading_factory,
            loading_factory_contact_person: loading_factory_contact_person,
            loading_requirements: loading_requirements,
            memo: memo,
            loading_template: loading_template,
            client_project_number_cbpi: client_project_number_cbpi,
            factory_contact_person2_cbpi: factory_contact_person2_cbpi,
            project_type_cbpi: type_of_project,
            loading_report_template: loading_report_template,
            loading_supplier_name: loading_supplier_name,
            has_file: 'false',
            client_cost_id: client_cost_id,
            inspector_cost_id: inspector_cost_id,
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
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}


function publishCbpiDraft() {
    var edit_inspection_id_cbpi = $("#edit_inspection_id_cbpi").val();
    var loading_service = $("#loading_service_inspection").val();

    var loading_reference_number = $("#loading_reference_number").val();
    var loading_inspection_date = $("#loading_inspection_date").val();
    var loading_client = $('#loading_client').val();
    var loading_contact_person = $('#loading_contact_person').val();

    var loading_inspector = $('#loading_inspector').val();
    var loading_factory = $('#loading_factory').val();
    var loading_factory_contact_person = $('#loading_factory_contact_person').val();
    var loading_client_name = $('#loading_client_name').val();
    var loading_supplier_name = $('#loading_supplier_name').val();
    var memo = $('#memo_cbpi').val();
    var loading_requirements = $('#loading_requirements').val();
    var loading_template = $('#loading_template').val();
    if (loading_service == 'site_visit') {
        loading_template = site_visit_temp_id;
    }
    var client_project_number_cbpi = $('#client_project_number_cbpi').val();
    //var factory_contact_person2_cbpi = $('#factory_contact_person2_cbpi').val();
    var factory_contact_person2_cbpi = "";
    if (loading_template == "") { loading_template = 0; }

    var type_of_project = $('input[name=project_type_cbpi]:checked').val();
    var word_template = $('#word_template_cbpi').val();
    if (type_of_project == "") { type_of_project = "N/A"; }

    if (word_template == "") { word_template = "N/A"; }

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
        new_contact_person = $('#loading_contact_person').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#loading_contact_person').val();
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

    var client_cost_id = $('#client_cost_id').val();
    var inspector_cost_id = $('#inspector_cost_id').val();

    var cbpi_cli_currency = $('#cbpi_cli_currency').val();
    var cbpi_cli_md_charge = $('#cbpi_cli_md_charge').val();
    var cbpi_cli_travel_cost = $('#cbpi_cli_travel_cost').val();
    var cbpi_cli_hotel_cost = $('#cbpi_cli_hotel_cost').val();
    var cbpi_cli_ot_cost = $('#cbpi_cli_ot_cost').val();
    var cbpi_cli_other_cost_text = [];
    if ($('.cbpi_cli_other_cost_text').length > 0) {
        $('.cbpi_cli_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            cbpi_cli_other_cost_text.push(val);
        });
    } else {
        cbpi_cli_other_cost_text = 'null';
    }
    var cbpi_cli_other_cost_value = [];
    if ($('.cbpi_cli_other_cost_value').length > 0) {
        $('.cbpi_cli_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            cbpi_cli_other_cost_value.push(val);
        });
    } else {
        cbpi_cli_other_cost_value = 'null';
    }

    var cbpi_ins_currency = $('#cbpi_ins_currency').val();
    var cbpi_ins_md_charge = $('#cbpi_ins_md_charge').val();
    var cbpi_ins_travel_cost = $('#cbpi_ins_travel_cost').val();
    var cbpi_ins_hotel_cost = $('#cbpi_ins_hotel_cost').val();
    var cbpi_ins_ot_cost = $('#cbpi_ins_ot_cost').val();
    var cbpi_ins_other_cost_text = [];
    if ($('.cbpi_ins_other_cost_text').length > 0) {
        $('.cbpi_ins_other_cost_text').each(function(i, obj) {
            var val = $(this).val();
            cbpi_ins_other_cost_text.push(val);
        });
    } else {
        cbpi_ins_other_cost_text = 'null';
    }
    var cbpi_ins_other_cost_value = [];
    if ($('.cbpi_ins_other_cost_value').length > 0) {
        $('.cbpi_ins_other_cost_value').each(function(i, obj) {
            var val = $(this).val();
            cbpi_ins_other_cost_value.push(val);
        });
    } else {
        cbpi_ins_other_cost_value = 'null';
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
    var manday = $('#cbpi_manday').val();

    $.ajax({
        url: '/publishdraftwoutfilescbpi',
        type: 'POST',
        data: {
            _token: token,
            edit_inspection_id_cbpi: edit_inspection_id_cbpi,
            loading_service: loading_service,
            loading_reference_number: loading_reference_number,
            loading_inspection_date: loading_inspection_date,
            loading_client: loading_client,
            loading_contact_person: contact_person,
            loading_inspector: loading_inspector,
            loading_factory: loading_factory,
            loading_factory_contact_person: loading_factory_contact_person,
            loading_requirements: loading_requirements,
            memo: memo,
            loading_template: loading_template,
            client_project_number_cbpi: client_project_number_cbpi,
            factory_contact_person2_cbpi: factory_contact_person2_cbpi,
            project_type_cbpi: type_of_project,
            word_template: word_template,
            loading_supplier_name: loading_supplier_name,
            has_file: 'false',
            client_cost_id: client_cost_id,
            inspector_cost_id: inspector_cost_id,
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
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}