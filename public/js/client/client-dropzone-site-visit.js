var current_url = '/panel-client/';
$(document).ready(function() {
    if (window.location.href.indexOf("tic-sera") > -1) {
        current_url = '/panel-client-tic-sera/';
    }
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
                if (empty.length == 0 && count_null == 0) {
                    if (myDropzone.getQueuedFiles().length > 0) {
                        //process dropzone if there is/are attached file
                        myDropzone.processQueue();
                        $('.send-loading ').show();
                    } else {
                        $('.send-loading ').hide();
                        swal({
                            title: "Oops!",
                            text: "Please add an attachment!",
                            type: "error",
                        }, function() {
                            $('.send-loading ').hide();
                        });
                    }
                } else {
                    $('.send-loading ').hide();
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
                var chosen_service = $("#site_service_inspection").val();

                formData.append("site_service", chosen_service);
                formData.append("site_reference_number", $("#site_reference_number").val());
                formData.append("site_inspection_date", $("#site_inspection_date").val());
                formData.append("site_inspection_date_to", $("#site_inspection_date_to").val());
                formData.append("site_client", $('#site_client').val());
                formData.append("site_inspector", 0);
                formData.append("site_requirements", $('#site_requirements').val());
                formData.append("site_memo", $('#site_memo').val());
                formData.append("site_project_number", $('#site_project_number').val());

                formData.append("site_template", 0);
                formData.append("site_report_template", 0);

                formData.append("com_name", $('#site_company_name').val());
                formData.append("comp_addr", $('#site_company_addr').val());
                formData.append("comp_other_info", $('#site_company_other_info').val());


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

                formData.append("project_type_site", null);


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
                formData.append('site_contact_person', new_contact_person);


            });
            this.on("successmultiple", function(files, response) {
                console.log(response);
                swal({
                    title: "Success!",
                    text: "Inspection project has been created we will be reviewing this and get back to you as soon as possible. Thank you!",
                    type: "success",
                }, function() {
                    window.location.href = current_url + auth_id;
                });
            });
            this.on("errormultiple", function(files, response) {
                $('.send-loading ').hide();
                console.log(response);
                myDropzone.removeAllFiles();
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