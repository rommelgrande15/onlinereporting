$(document).ready(function() {
    var count_ef_cbpi = 0;
    var change_draft_dropzone_url_cbpi = "";
    var button_click_cbpi;
    var site_visit_temp_id = 1054;
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div.file_upload_site", {
        url: saveSite,
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
            $("#btn-site-submit-copy").click(function(e) {
                e.preventDefault();
                e.stopPropagation();
                button_click_cbpi = "submit";
                var empty = $('.site_required').filter(function() { return $(this).val() == ""; });
                var pt = $("input[name='project_type_site']:checked").val();

                var site_req = $('.site_required');
                var count_draft_null = 0;

                for (var i = 0; i < site_req.length; i++) {
                    var data = $(site_req[i]).val();
                    if (data == "") {
                        $(site_req[i]).css("border", "1px solid red");
                        count_draft_null += 1;
                    } else {
                        $(site_req[i]).removeAttr("style");
                    }
                }
                console.log('Count empty fields: ' + count_draft_null);
                console.log('Count dropzone files: ' + myDropzone.getQueuedFiles().length);
                if (count_draft_null == 0 && pt != null) {
                    $('.send-loading ').show();
                    if (myDropzone.getQueuedFiles().length > 0) {
                        myDropzone.processQueue();
                    } else {
                        publishSiteCopy();
                    }
                } else {
                    swal({
                        title: "Oops!",
                        text: "Please fill up the required fields",
                        type: "warning",
                    });
                }
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

    var i_id = $('#edit_inspection_id_site').val();
    console.log(i_id);
    var existing_files = [];

    /* $.ajax({
        url: '/findattachments/' + i_id,
        type: 'GET',
        success: function(response) {
            console.log(response.attachment);
            $.each(response.attachment, function(i, element) {
                count_ef_cbpi += 1;
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
    setTimeout(function(){ 
        setRefNumSITE();
    },2000);
})


function publishSiteCopy() {
    var chosen_service = $("#site_service_inspection").val();
    var formData = new FormData();
    formData.append("_token", token);
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
    $.ajax({
        url: saveSite,
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
            //alert("Error: Server encountered an error. Please try again or contact your system administrator.");
            swal({
                title: "Error!",
                text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                type: "error",
            });
        }
    });
}

function setRefNumSITE(){
	console.log('dsda');
	var client_code=$('#site_client').val();
		if(client_code!=""){
			var d = new Date();
			//var date_now = d.getDate()+'-'+(d.getMonth()+1)+'-'+d.getFullYear();
			var date_now = d.getFullYear()+''+(d.getMonth()+1);

			var options_year = {
    	    year: '2-digit'
    	};
    	var options_month = {
    	    month: '2-digit'
    	};
		var today = new Date();
    	var two_digit_y = today.toLocaleDateString("en-US", options_year);
    	var two_digit_m = today.toLocaleDateString("en-US", options_month);
    	var date_today = two_digit_y + '' + two_digit_m;
		var set_pn=client_code+"-"+date_today;
		$.ajax({
        	type: "GET",
        	url: '/getclientcountinspection/'+client_code,
        	success: function(data) {				
				var c_count=data.count;
				var get_count=parseInt(c_count)+1;
				var set_count;
				// get_count=10;
				if(get_count<=9){
					set_count='0'+get_count;
				}else{
					set_count=get_count;
				}
				set_pn=set_pn+'-'+set_count;
				$('#site_reference_number').val(set_pn);			
        	}
    	});
	}else{
		$('#site_reference_number').val("");
	}
}