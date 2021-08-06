var current_url = '/panel-supplier/';
$(document).ready(function() {
    if (window.location.href.indexOf("tic-sera") > -1) {
        current_url = '/panel-supplier-tic-sera/';
    }
    //Dropzone.autoDiscover = false;
    var myDZ = new Dropzone("div.file_upload_psi", {
        url: editPSI,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        autoProcessQueue: false,
        addRemoveLinks: true,
        dictRemoveFileConfirmation: "Are you sure you want to remove this file? Once removed, you will not be able to recover this file on our database.",
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        acceptedFiles: 'application/pdf, .doc, .docx, .pub, .jpeg, .jpg, .png, .gif, .xls, .xlsx, .ppt, .pptx, .zip, .ZIP, .rar, .RAR, .DOC, .DOCX, .PUB, .JPEG, .JPG, .PNG, .GIF, .XLS, .XLSX, .PPT, .PPTX',
        maxFilesize: 500000000,
        paramName: "file",
        init: function() {
                $("#btn-psi-submit").click(function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var empty = $('.psi_required').filter(function() { return $(this).val() == ""; });
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
                    if (empty.length == 0 && count_null == 0) {
                        if (myDZ.getQueuedFiles().length > 0) {
                            myDZ.processQueue();
                            $('.send-loading ').show();
                        } else {
                            saveNoAttachment();
                            /* swal({
                                title: "Oops!",
                                text: "Please add an attachment!",
                                type: "warning",
                            }, function() {
                                $('.send-loading ').hide();
                            }); */
                        }
                    } else {
                        swal({
                            title: "Oops!",
                            text: "Please fill up required fields!",
                            type: "warning",
                        });
                    }
                })
                 //06-02-2021
                 this.on('removedfile', function(file) {
                    var mrn_id = [];
                    $('.mrn_inspection_id').each(function(i, obj) {
                        var val = $(this).val();
                        mrn_id.push(val);
                    });
                    var name = file.name;
                    var pass_file = file;
                    var _ref;
    
                    $.ajax({
                        url: '/delete-supplier-attachments-mrn',
                        type: 'POST',
                        data: {
                            _token: token,
                            mrn_inspection_id: mrn_id,
                            file_name: name
                        },
                        success: function() {
                            swal("Success", "File has been removed!", "success");
                            
                            count_ef -= 1;
                            
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
                    formData.append("inspection_id", $("#edit_inspection_id").val());
                    formData.append("service", $("#service").val());
                    formData.append("reference_number", $("#reference_number").val());
                    formData.append("inspection_date", $("#inspection_date").val());
                    formData.append("inspection_date_to", $("#inspection_date").val());
                    formData.append("psi_shipment_date", $("#psi_shipment_date").val());
                    // formData.append("fac_change_date", $("#fac_change_date").val());
                    formData.append("client", $('#client').val());
                    formData.append("factory", $('#factory').val());
                    formData.append("factory_contact_person", $('#factory_contact_person').val());
                    formData.append("supplier", $('#supplier').val());
                    formData.append("supplier_name", $('#supplier_name').val());
                    formData.append("supplier_contact_person", $('#supplier_cp').val());
                    formData.append("requirement", $('#requirement').val());
                    formData.append("memo", $('#memo_psi').val());
                    formData.append("client_project_number", $('#client_project_number').val());

                    formData.append("has_file", 'true');


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
                        new_contact_person = $('#client_cp').val();
                    } else {
                        new_contact_person = new_contact_person + ',' + $('#client_cp').val();
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
                     //06-02-2021
                    $('.mrn_inspection_id').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('mrn_inspection_id[]', val);
                    });

                    $('.report_id').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('report_id[]', val);
                    });


                    $('.edit_pid').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('edit_pid[]', val);
                    });

                    $('.s_pname').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('product_id[]', val);
                    });

                    $('.s_pname').each(function(i, obj) {
                        var val = $(this).find('option:selected').text();
                        formData.append('product_name[]', val);
                    });

                    $('.s_pcat').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('product_category[]', val);
                    });

                    $('.s_scat').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('product_sub_category[]', val);
                    });

                    $('.s_brand').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('brand[]', val);
                    });

                    $('.s_po').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('po_number[]', val);
                    });

                    $('.s_model').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('model_no[]', val);
                    });

                    $('.s_qty').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_qty[]', val);
                    });

                    $('.edit_aql_qty_unit').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_qty_unit[]', val);
                    });

                    $('.edit_aql_normal_level').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_normal_level[]', val);
                    });

                    $('.edit_aql_normal_level').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_normal_level[]', val);
                    });

                    $('.edit_aql_special_level').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_special_level[]', val);
                    });

                    $('.edit_aql_major').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_major[]', val);
                    });

                    $('.edit_max_major').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('max_major[]', val);
                    });

                    $('.edit_aql_minor').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_minor[]', val);
                    });

                    $('.edit_max_minor').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('max_minor[]', val);
                    });

                    $('.edit_aql_normal_letter').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_normal_letter[]', val);
                    });

                    $('.edit_aql_normal_sampsize').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_normal_sampsize[]', val);
                    });

                    $('.edit_aql_special_letter').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_special_letter[]', val);
                    });

                    $('.edit_aql_special_sampsize').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('aql_special_sampsize[]', val);
                    });

                    //new product
                    $('.n_pname').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('new_product_id[]', val);
                    });

                    $('.n_pname').each(function(i, obj) {
                        var val = $(this).find('option:selected').text();
                        formData.append('new_product_name[]', val);
                    });

                    $('.n_pcat').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('new_product_category[]', val);
                    });

                    $('.n_scat').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('new_product_sub_category[]', val);
                    });

                    $('.n_brand').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('new_brand[]', val);
                    });

                    $('.n_po').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('new_po_number[]', val);
                    });

                    $('.n_model').each(function(i, obj) {
                        var val = $(this).val();
                        formData.append('new_model_no[]', val);
                    });

                    $('.n_qty').each(function(i, obj) {
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
                        swal({
                            title: "Success!",
                            text: "Inspection project has been successfully updated we will be reviewing this and get back to you as soon as possible. Thank you!",
                            type: "success",
                        }, function() {
                            window.location.href = current_url + auth_id;
                        });
                });
                this.on("errormultiple", function(files, response) {
                    console.log(response);
                    //myDZ.removeAllFiles();
                    if(response.responseJSON.message=="Empty fields"){
                        swal({
                            title: "Warning!",
                            text: "Please fill up required fields",
                            type: "warning",
                        });
                    }else{
                        swal({
                            title: "Error!",
                            text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
                            type: "error",
                        });
                    }
                });


            } //init

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
    });

})

function saveNoAttachment() {
    var formData = new FormData();
    formData.append("inspection_id", $("#edit_inspection_id").val());
    formData.append("service", $("#service").val());
    formData.append("reference_number", $("#reference_number").val());
    formData.append("inspection_date", $("#inspection_date").val());
    formData.append("inspection_date_to", $("#inspection_date").val());
    formData.append("psi_shipment_date", $("#psi_shipment_date").val());
    // formData.append("fac_change_date", $("#fac_change_date").val());
    formData.append("client", $('#client').val());
    formData.append("inspector", 0);
    formData.append("factory", $('#factory').val());
    formData.append("factory_contact_person", $('#factory_contact_person').val());
    formData.append("supplier", $('#supplier').val());
    formData.append("supplier_name", $('#supplier_name').val());
    formData.append("supplier_contact_person", $('#supplier_cp').val());
    formData.append("requirement", $('#requirement').val());
    formData.append("client_project_number", $('#client_project_number').val());
    formData.append("memo", $('#memo_psi').val());
    formData.append("has_file", 'true');
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
        new_contact_person = $('#client_cp').val();
    } else {
        new_contact_person = new_contact_person + ',' + $('#client_cp').val();
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
    //06-02-2021
    $('.mrn_inspection_id').each(function(i, obj) {
        var val = $(this).val();
        formData.append('mrn_inspection_id[]', val);
    });

    $('.report_id').each(function(i, obj) {
        var val = $(this).val();
        formData.append('report_id[]', val);
    });

    $('.edit_pid').each(function(i, obj) {
        var val = $(this).val();
        formData.append('edit_pid[]', val);
    });

    $('.s_pname').each(function(i, obj) {
        var val = $(this).val();
        formData.append('product_id[]', val);
    });

    $('.s_pname').each(function(i, obj) {
        var val = $(this).find('option:selected').text();
        formData.append('product_name[]', val);
    });

    $('.s_pcat').each(function(i, obj) {
        var val = $(this).val();
        formData.append('product_category[]', val);
    });

    $('.s_scat').each(function(i, obj) {
        var val = $(this).val();
        formData.append('product_sub_category[]', val);
    });

    $('.s_brand').each(function(i, obj) {
        var val = $(this).val();
        formData.append('brand[]', val);
    });

    $('.s_po').each(function(i, obj) {
        var val = $(this).val();
        formData.append('po_number[]', val);
    });

    $('.s_model').each(function(i, obj) {
        var val = $(this).val();
        formData.append('model_no[]', val);
    });

    $('.s_qty').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_qty[]', val);
    });

    $('.edit_aql_qty_unit').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_qty_unit[]', val);
    });

    $('.edit_aql_normal_level').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_level[]', val);
    });

    $('.edit_aql_normal_level').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_level[]', val);
    });

    $('.edit_aql_special_level').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_special_level[]', val);
    });

    $('.edit_aql_major').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_major[]', val);
    });

    $('.edit_max_major').each(function(i, obj) {
        var val = $(this).val();
        formData.append('max_major[]', val);
    });

    $('.edit_aql_minor').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_minor[]', val);
    });

    $('.edit_max_minor').each(function(i, obj) {
        var val = $(this).val();
        formData.append('max_minor[]', val);
    });

    $('.edit_aql_normal_letter').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_letter[]', val);
    });

    $('.edit_aql_normal_sampsize').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_normal_sampsize[]', val);
    });

    $('.edit_aql_special_letter').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_special_letter[]', val);
    });

    $('.edit_aql_special_sampsize').each(function(i, obj) {
        var val = $(this).val();
        formData.append('aql_special_sampsize[]', val);
    });

    //new product
    $('.n_pname').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_product_id[]', val);
    });

    $('.n_pname').each(function(i, obj) {
        var val = $(this).find('option:selected').text();
        formData.append('new_product_name[]', val);
    });

    $('.n_pcat').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_product_category[]', val);
    });

    $('.n_scat').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_product_sub_category[]', val);
    });

    $('.n_brand').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_brand[]', val);
    });

    $('.n_po').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_po_number[]', val);
    });

    $('.n_model').each(function(i, obj) {
        var val = $(this).val();
        formData.append('new_model_no[]', val);
    });

    $('.n_qty').each(function(i, obj) {
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

    formData.append("has_file", 'false');
    formData.append('_token', token);

    $.ajax({
        url: '/supplier-editinspection-mrn',
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
                    text: "Inspection project has been successfully updated we will be reviewing this and get back to you as soon as possible. Thank you!",
                    type: "success",
                }, function() {
                    window.location.href = current_url + auth_id;
                });
        },
        error: function(error) {
            $('.send-loading ').hide();
            console.log(error);
            if(error.responseJSON.message=="Empty fields"){
                swal({
                    title: "Warning!",
                    text: "Please fill up required fields",
                    type: "warning",
                });
            }else{
                swal({
                    title: "Error!",
                    text: "Error: Server encountered an error. Please try again later or contact your system administrator.",
                    type: "error",
                });
            }
        }
    });
}