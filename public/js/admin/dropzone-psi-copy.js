$(document).ready(function() {
    var count_ef = 0;
    var change_draft_dropzone_url = "";
    var button_click;
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
            $("#btn-psi-copy").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                var empty = $('.psi_required').filter(function() { return $(this).val() == ""; });
                var pt = $("input[name='project_type']:checked").val();
                var psi_req = $('.psi_required');
                var count_draft_null = 0;
                /* for (var i = 0; i < psi_req.length; i++) {
                    $(psi_req[i]).removeAttr("style");
                } */
                for (var i = 0; i < psi_req.length; i++) {
                    var data = $(psi_req[i]).val();
                    if (data == "") {
                        $(psi_req[i]).css("border", "1px solid red");
                        count_draft_null += 1;
                    } else {
                        $(psi_req[i]).removeAttr("style");
                    }
                }
                console.log('Count empty fields: ' + count_draft_null);
                console.log('Count dropzone files: ' + myDZ.getQueuedFiles().length);
                if (count_draft_null == 0 && pt != null) {
                    $('.send-loading ').show();
                    if (myDZ.getQueuedFiles().length > 0) {
                        myDZ.processQueue();
                    } else {
                        saveCopiedPsi();
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
                formData.append("service", $("#service").val());
                formData.append("reference_number", $("#reference_number").val());
                formData.append("inspection_date", $("#inspection_date").val());
                formData.append("inspection_date_to", $("#inspection_date_to").val());
                formData.append("client", $('#client').val());
                formData.append("edit_inspection_id", $('#edit_inspection_id').val());
                formData.append("inspector", $('#inspector').val());
                formData.append("fm_username", $('#fm_username').val());
                formData.append("fm_password", $('#fm_password').val());
                formData.append("fm_inspector", $('#fm_inspector').val());
                formData.append("old_inspector", $('#old_inspector').val());
                formData.append("factory", $('#factory').val());
                formData.append("factory_contact_person", $('#factory_contact_person').val());
                formData.append("requirement", $('#requirement').val());
                formData.append("memo", $('#memo_psi').val());
                formData.append("invisible", $('#invisible').val());
                formData.append("template", $('#template').val());
                formData.append("template_word", $('#template_word').val()); //04-29-2021
                formData.append("client_project_number", $('#client_project_number').val());

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
                 //04-28-2021
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

                // new product added
                var new_product_name = [];
                $('.product_name').each(function(i, obj) {
                    var val = $(this).val();
                    //formData.append('new_product_name[]', val);
                    /* console.log("test=" + val);
                    new_product_name.push(val); */
                    formData.append('new_product_name[]', val);
                });
                /* if (new_product_name == "" || new_product_name == null) {
                    formData.append('new_product_name[]', null);
                } else {
                    formData.append('new_product_name[]', new_product_name);
                } */

                console.log(new_product_name);


                $('.brand').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_brand[]', val);
                });

                $('.product_category').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_product_category[]', val);
                });
                //04-16-2021
                $('.product_sub_category').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_product_sub_category[]', val);
                });

                $('.po_number').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_po_number[]', val);
                });

                $('.model_no').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_model_no[]', val);
                });

                $('.new_aql_qty').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_qty[]', val);
                });

                $('.p_unit').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_qty_unit[]', val);
                });

                $('.new_aql_qty_unit2').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_aql_qty_unit2[]', val);
                });

                $('.prod_addtl_info').each(function(i, obj) {
                    var val = $(this).val();
                    formData.append('new_add_product_info[]', val);
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
        }
    });

    $('#loading_service_inspection').on('change', function() {
        console.log($(this).val());
    })


    var i_id = $('#edit_inspection_id').val();
    console.log(i_id);
    var existing_files = [];

    /*  $.ajax({
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
         error: function(error) {
             console.log(error);
         }
     }); */

})

function saveCopiedPsi() {
    var formData = new FormData();
    formData.append('_token', token);
    formData.append("service", $("#service").val());
    formData.append("reference_number", $("#reference_number").val());
    formData.append("inspection_date", $("#inspection_date").val());
    formData.append("inspection_date_to", $("#inspection_date_to").val());
    formData.append("client", $('#client').val());
    formData.append("edit_inspection_id", $('#edit_inspection_id').val());
    formData.append("inspector", $('#inspector').val());
    formData.append("fm_username", $('#fm_username').val());
    formData.append("fm_password", $('#fm_password').val());
    formData.append("fm_inspector", $('#fm_inspector').val());
    formData.append("old_inspector", $('#old_inspector').val());
    formData.append("factory", $('#factory').val());
    formData.append("factory_contact_person", $('#factory_contact_person').val());
    formData.append("requirement", $('#requirement').val());
    formData.append("memo", $('#memo_psi').val());
    formData.append("invisible", $('#invisible').val());
    formData.append("template", $('#template').val());
    formData.append("template_word", $('#template_word').val());
    formData.append("client_project_number", $('#client_project_number').val());
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
    // new product added
    var new_product_name = [];
    $('.product_name').each(function(i, obj) {
        var val = $(this).val();
        //formData.append('new_product_name[]', val);
        /* console.log("test=" + val);
        new_product_name.push(val); */
        formData.append('new_product_name[]', val);
    });
    /* if (new_product_name == "" || new_product_name == null) {
        formData.append('new_product_name[]', null);
    } else {
        formData.append('new_product_name[]', new_product_name);
    }
    console.log(new_product_name); */
    $('.brand').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_brand[]', val);
    });
    $('.product_category').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_product_category[]', val);
    });
    //04-16-2021
    $('.product_sub_category').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_product_sub_category[]', val);
    });
    $('.po_number').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_po_number[]', val);
    });
    $('.model_no').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_model_no[]', val);
    });
    $('.new_aql_qty').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_aql_qty[]', val);
    });
    $('.p_unit').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_aql_qty_unit[]', val);
    });

    $('.new_aql_qty_unit2').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_aql_qty_unit2[]', val);
    });

    $('.prod_addtl_info').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_add_product_info[]', val);
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

    $.ajax({
        url: savePSI,
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