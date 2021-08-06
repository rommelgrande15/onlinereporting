$(document).ready(function() {
    $('.products-list').find('.btn-remove').css('display', 'none');

    var dateToday = new Date();
    $('.inspection_date').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: dateToday,
    });

    $('#aql_btn').click(function() {
        $('#aqlModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $('#po_qty').click(function() {
        $('#aqlModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    }).focus(function() {
        $('#aqlModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });


    $('#confirmAql').click(function() {
        if ($('#new_inspection_form').valid()) {
            $('#po_qty').val($('#qty').val());
            $('#aqlModal').modal('hide');
        } else {
            alert('Please fill in all fields');
        }
    })

    $('body').on('click', '.btn-rm', function() {

        var h = $(this).closest('.clone-inputs').find('.qty-modal').height();
        var count = $('.clone-inputs').length;
        console.log(count)
        if (count < 3) { // why 3? because length is based 1, count initiates before removing so the removed element is still being count
            var height = 250 - (h * 2);
            $('.product-clone').css({
                'height': height + 'px'
            });
        }
        $(this).closest('.clone-inputs').remove();
    });

    $('body').on('click', '.btn-rm-edit-product', function () {
       
        var count_prod = $('.product-clone-edit .clone-inputs-edit').length;
        var dis_btn = this;
        var id = $(this).data('id');
        //var sure_delete = confirm("Are you sure you want to delete this product?");
        if (count_prod == 1){
            swal("Oops!", "Product can't be empty!, Just update the old one.", "error")
        }else if( confirm("Are you sure you want to delete this product?")){
            if(id != null || id != 'undefined'){
               
                $.ajax({
                    url: '/deletedraftproduct/' + id,
                    type: 'GET',
                    success: function() {
                        alert("Product successfully deleted.");
                        $(dis_btn).closest('.clone-inputs-edit').remove();
                    }
                });
            }else{
                if (count_prod > 1) {
                    //$(this).closest('.clone-inputs').remove();
                } else {
    
                }
            }
           
        }else{
            if (count_prod > 1) {
                // $(this).closest('.clone-inputs').remove();
            } else {

            }
        }


    });

    $('body').on('click', '.btn-qty-modal', function() {
        $(this).closest('.qty-modal').find('.EditAQLModal').modal('show');

    });
    $('body').on('click', '.btn-qty-modal-edit', function() {
        var dis = this;
        $.ajax({
            url: '/geteditaql/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);
                $(dis).closest('.qty-modal').find('.aql_qty').val(response.psi_product.aql_qty);
                $(dis).closest('.qty-modal').find('.aql_normal_level').val(response.psi_product.aql_normal_level);
                $(dis).closest('.qty-modal').find('.aql_special_level').val(response.psi_product.aql_special_level);
                $(dis).closest('.qty-modal').find('.aql_major').val(response.psi_product.aql_major);
                $(dis).closest('.qty-modal').find('.max_major').val(response.psi_product.max_allowed_major);
                $(dis).closest('.qty-modal').find('.aql_minor').val(response.psi_product.aql_minor);
                $(dis).closest('.qty-modal').find('.max_minor').val(response.psi_product.max_allowed_minor);
                $(dis).closest('.qty-modal').find('.aql_normal_letter').val(response.psi_product.aql_normal_letter);
                $(dis).closest('.qty-modal').find('.aql_normal_sampsize').val(response.psi_product.aql_normal_sampsize);
                $(dis).closest('.qty-modal').find('.aql_special_letter').val(response.psi_product.aql_special_letter);
                $(dis).closest('.qty-modal').find('.aql_special_sampsize').val(response.psi_product.aql_special_sampsize);
                $(dis).closest('.qty-modal').find('.aql_product_id').val(response.psi_product.id);


                $(dis).closest('.qty-modal').find('.AQLModal').modal('show');
            }
        });


    });



    $('body').on('click', '.confirm_aql', function() {
        var dis = $(this);
        dis.closest('.clone-inputs-edit').find('.qty').val(dis.closest('.clone-inputs-edit').find('.aql_qty').val());
        dis.closest('.clone-inputs-edit').find('.AQLModal').modal('toggle');

    });



    $('body').on('change', '.contact_persons', function() {

        var tis = $(this);
        $.ajax({
            url: '/getoneclientcontact/' + tis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                tis.closest('.contact-select').find('.contact_number').val(response.contact.contact_number);
                tis.closest('.contact-select').find('.contact_email').val(response.contact.email_address);
            }
        });
    });

    //Inspector Address

    $('body').on('change', '.select_address', function() {

        var ads2 = $(this);
        console.log(ads2.val());
        $.ajax({
            url: '/getinspectoraddress/' + ads2.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);

                ads2.closest('.contact-select').find('.inspector_address').val(response.address[0]['address']);

            }
        });



    });


    $('body').on('change', '.factory', function() {
        var dis = $(this);
        $('#new_factory_id').val(dis.val());
        $.ajax({
            url: '/getonefactory/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response.contacts);
                localStorage.setItem("factory_contacts", JSON.stringify(response.contacts));
                dis.closest('.factory-select').find('.factory_address').val(response.factory_address);
                dis.closest('.factory-select').find('.factory_contact_person option').remove();

                dis.closest('.factory-select').find('.factory_contact_person').append($("<option selected disabled>Select Contact Person</option>"));
                var count = response.contacts.length;
                for (var i = 0; i <= count - 1; i++) {
                    dis.closest('.factory-select').find('.factory_contact_person').append($("<option></option>").attr("value", response.contacts[i].id).text(response.contacts[i].factory_contact_person));
                }

                if (count > 1) {
                    $('.fcp2').css("display", "block");
                } else {
                    $('.fcp2').css("display", "none");
                }

                //jesser
                $('.factory_contact_person2').empty();
                $('.factory_contact_person2').append('<option value="">Select Contact Person 2</option>');
                for (var i = 0; i <= count - 1; i++) {
                    $('.factory_contact_person2').append('<option value="' + response.contacts[i].id + '">' + response.contacts[i].factory_contact_person + '</option>');
                }
            }

        });
    });


    $('#loading_factory').on('change', function() {
        $('#new_factory_id').val($(this).val());
        $('#loading_factory_contact_number').val('');
        $('#loading_factory_email').val('');
        $.ajax({
            url: '/getonefactory/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('#loading_factory_address').val(response.factory_address);
                $('#new_factory_client_code').val(response.client_code);
                $('#loading_factory_contact_person option').remove();
                $('#loading_factory_contact_person').append($("<option selected disabled>Select Contact Person</option>"));
                var count = response.contacts.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('#loading_factory_contact_person').append($("<option></option>").attr("value", response.contacts[i].id).text(response.contacts[i].factory_contact_person));
                }

            }

        });
    });

    $('body').on('change', '.factory_contact_person', function() {
        var dis = $(this)
        $.ajax({
            url: '/getonefactorycontact/' + dis.val(),
            type: 'GET',
            success: function(response) {
                dis.closest('.factory-select').find('.factory_contact_number').val(response.contact.factory_contact_number);
                dis.closest('.factory-select').find('.factory_email').val(response.contact.factory_email);
                //jesser
                $('.factory_contact_person2').empty();
                $('.factory_contact_person2').append('<option value="">Select Contact Person 2</option>');
                $('.factory_contact_person2').append('<option value="0">N/A</option>');
                $('.factory_contact_number2').val('');
                $('.factory_email2').val('');
                var get_c_p = JSON.parse(localStorage.getItem('factory_contacts'));
                console.log(get_c_p);
                get_c_p.forEach(element => {
                    if (element.id != dis.val()) {
                        $('.factory_contact_person2').append('<option value="' + element.id + '">' + element.factory_contact_person + '</option>');
                    }
                });

            }
        })
    });

    $('body').on('change', '.factory_contact_person2', function() {
        var dis = $(this);
        if (dis.val() == '0' || dis.val() == 0) {
            $('.factory_contact_number2').val('N/A');
            $('.factory_email2').val('N/A');
        } else {
            $.ajax({
                url: '/getonefactorycontact/' + dis.val(),
                type: 'GET',
                success: function(response) {
                    $('.factory_contact_number2').val(response.contact.factory_contact_number);
                    $('.factory_email2').val(response.contact.factory_email);

                }
            });
        }

    });



    $('#saveclientcontact').click(function() {
        var client_code = $('#add_client_code').val();
        var contact_person = $('#add_contact_person').val();
        var contact_person_email = $('#add_contact_person_email').val();
        var contact_person_number = $('#add_contact_person_number').val();

        if (contact_person == '' || contact_person == null) {
            $('#contact_person_error').html('This field is required!');
        } else if (contact_person_email == '' || contact_person_email == null) {
            $('#contact_person_email_error').html('This field is required!');
        } else if (contact_person_number == '' || contact_person_number == null) {
            $('#contact_person_number_error').html('This field is required!');
        } else {
            $.ajax({
                url: newcontactclient,
                type: 'POST',
                data: {
                    _token: token,
                    client_code: client_code,
                    contact_person: contact_person,
                    contact_person_email: contact_person_email,
                    contact_person_number: contact_person_number
                },
                success: function(response) {
                    $('.contact_persons').append($("<option></option>")
                        .attr("value", response.contact.id)
                        .text(response.contact.contact_person));

                    $('#newClientContact').modal('hide');
                    swal("Success!", "New client contact has been added successfully!", "success");
                    $('#add_contact_person').val('');
                    $('#add_contact_person_email').val('');
                    $('#add_contact_person_number').val('');
                }
            });
        }
    });



    $('.contact_modal_button').click(function() {
        var dis = $(this);
        if (dis.closest('.form-inspection').find('.client_select').val() == null || dis.closest('.form-inspection').find('.client_select').val() == '') {
            swal("Oops!", "Please select a client first!", "error")
        } else {
            $('#newClientContact').modal('show');
        }
    });

    $('body').on('click', '.new-factory-contact', function() {
        var dis = $(this);

        if ($('#new_factory_id').val() == null || $('#new_factory_id').val() == '') {
            swal("Oops!", "Please select a factory first!", "error")
        } else if ($('#new_factory_client_code').val() == null || $('#new_factory_client_code').val() == '') {
            swal("Oops!", "Please select a client first!", "error")
        } else {
            $('#newFactoryContact').modal('show');
        }
    });



    $('body').on('keyup', '.aql_qty', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal').find('.aql_minor').val();
        var major = dis.closest('.AQLModal').find('.aql_major').val();
        var lvl = dis.closest('.AQLModal').find('.aql_normal_level').val();
        var special_lvl = dis.closest('.AQLModal').find('.aql_special_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal').find('.max_major').val(majorMax);
        dis.closest('.AQLModal').find('.max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_special_letter').val(special_letter);
        dis.closest('.AQLModal').find('.aql_normal_sampsize').val(sampsize);
        dis.closest('.AQLModal').find('.aql_special_sampsize').val(special_sampsize);
    })

    $('body').on('change', '.aql_normal_level', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.aql_qty').val();
        var minor = dis.closest('.AQLModal').find('.aql_minor').val();
        var major = dis.closest('.AQLModal').find('.aql_major').val();
        var lvl = dis.val();




        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal').find('.max_major').val(majorMax);
        dis.closest('.AQLModal').find('.max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_normal_sampsize').val(sampsize);
    })

    $('body').on('change', '.aql_special_level', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.aql_qty').val();
        var minor = dis.closest('.AQLModal').find('.aql_minor').val();
        var major = dis.closest('.AQLModal').find('.aql_major').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal').find('.aql_special_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_special_sampsize').val(sampsize);
    })

    $('body').on('change', '.aql_major', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.aql_qty').val();
        var minor = dis.closest('.AQLModal').find('.aql_minor').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal').find('.aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal').find('.max_major').val(majorMax);
        dis.closest('.AQLModal').find('.max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_normal_sampsize').val(sampsize);
    })

    $('body').on('change', '.aql_minor', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.aql_qty').val();
        var major = dis.closest('.AQLModal').find('.aql_major').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal').find('.aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal').find('.max_major').val(majorMax);
        dis.closest('.AQLModal').find('.max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_normal_sampsize').val(sampsize);
    })

    $('#loading_inspector').on('change', function() {

        var ads = $(this);
        $.ajax({
            url: '/getinspectoraddress/' + ads.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);


                ads.closest('.contact-select').find('.inspector_address_2').val(response.address[0]['address']);
            }
        });


        var id = $(this).val();

        $.ajax({
            url: '/inspectorassignment/' + id,
            type: 'GET',
            success: function(response) {
                var count = response.count;
                if (count == 1) {
                    swal("Inspector has " + count + " inspection assigned already!", "You might want to assign it to other inspectors!", "warning");
                } else if (count > 1) {
                    swal("Inspector has " + count + " inspections assigned already!", "You might want to assign it to other inspectors!", "warning");
                } else {
                    console.log('assigned!');
                }
            }
        });
    });

    $('body').on('click', '#add_more_po_num', function() {
        $('#po_num_container').append('<div class="input-group added_more_fields_po">' +
            '<input type="text"  class="form-control product_input new_po_number" required data-parsley-required-message="Please enter the PO number!" data-parsley-errors-container=".po_error">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger" type="button" id="remove_more_po_num">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>');
    });

    $('body').on('click', '#remove_more_po_num', function() {
        $(this).closest('.input-group').remove();

    });

    $('body').on('click', '#add_more_model_num', function() {
        $('#model_num_container').append('<div class="input-group added_more_fields_model">' +
            '<input type="text"  class="form-control product_input new_model_number" required data-parsley-required-message="Please enter the PO number!" data-parsley-errors-container=".po_error">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger" type="button" id="remove_more_model_num">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>');
    });

    $('body').on('click', '#remove_more_model_num', function() {
        $(this).closest('.input-group').remove();

    });

    $('body').on('click', '#add_more_brand', function() {
        $('#brand_container').append('<div class="input-group added_more_fields_brand">' +
            '<input type="text" class="form-control product_input new_brand" required data-parsley-required-message="Please enter the PO number!" data-parsley-errors-container=".po_error">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger" type="button" id="remove_more_brand">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>');
    });

    $('body').on('click', '#remove_more_brand', function() {
        $(this).closest('.input-group').remove();

    });

    $('body').on('click', '#add_more_color', function() {
        $('#color_container').append('<div class="input-group added_more_fields_color">' +
            '<input type="text" class="form-control product_input new_cmf" required data-parsley-required-message="Please enter the PO number!" data-parsley-errors-container=".po_error">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger" type="button" id="remove_more_color">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>');
    });

    $('body').on('click', '#remove_more_color', function() {
        $(this).closest('.input-group').remove();

    });

    $('body').on('click', '#add_more_tech', function() {
        $('#tech_container').append('<div class="input-group added_more_fields_tech">' +
            '<input type="text" class="form-control product_input new_tech_specs" required data-parsley-required-message="Please enter the PO number!" data-parsley-errors-container=".po_error">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger" type="button" id="remove_more_tech">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>');
    });

    $('body').on('click', '#remove_more_tech', function() {
        $(this).closest('.input-group').remove();

    });

    $('body').on('click', '#add_more_sm', function() {
        $('#sm_container').append('<div class="input-group added_more_fields_sm">' +
            '<input type="text" class="form-control product_input new_shipping_mark" required data-parsley-required-message="Please enter the PO number!" data-parsley-errors-container=".po_error">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger" type="button" id="remove_more_sm">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>');
    });

    $('body').on('click', '#remove_more_sm', function() {
        $(this).closest('.input-group').remove();

    });

    $('body').on('click', '#add_more_addtl', function() {
        $('#addtl_container').append('<div class="input-group added_more_fields_addtl">' +
            '<input type="text" name="new_po_number" class="form-control product_input new_additional_product_info" required data-parsley-required-message="Please enter the PO number!" data-parsley-errors-container=".po_error">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger" type="button" id="remove_more_addtl">' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>');
    });

    $('body').on('click', '#remove_more_addtl', function() {
        $(this).closest('.input-group').remove();

    });

    $('body').on('click', '#add_more_client_c_p', function() {

        var dis = $(this);

        $('#add_more_contact_container').append('<div class="am_cp_parent"><div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Contact Person</label>' +
            '<select class="form-control psi_required added_contact_persons"  name="contact_person">' +
            '<option value="1234" selected>Select Contact</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Contact Number</label>' +
            '<input type="text" class= "form-control psi_required numeric am_contact_number" required>' +
            '</div>' +
            '</div>' +

            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Email Address</label>' +
            '<div class="input-group">' +
            '<input type="text" class= "form-control psi_required numeric am_contact_email" required>' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger del_more_client_c_p" type="button">' +
            '<i class="fa fa-times"></i> ' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '</div>' +

            '</div>');

        $.ajax({
            url: '/getallclientcontacts/' + $('#client').val(),
            type: 'GET',
            success: function(response) {
                $('.am_cp_parent').find('.added_contact_persons option').remove();

                $('.am_cp_parent').find('.added_contact_persons').append($("<option selected disabled>Select Contact</option>"));
                var count = response.contacts.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('.am_cp_parent').find('.added_contact_persons').append($("<option></option>")
                        .attr("value", response.contacts[i].id)
                        .text(response.contacts[i].contact_person));
                }

            },
            error: function(error) {
                console.log(error);
            }
        });

    });

    $('body').on('click', '#add_more_client_c_p_cbpi', function() {

        var dis = $(this);

        $('#add_more_contact_container_cbpi').append('<div class="am_cp_parent"><div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Contact Person</label>' +
            '<select class="form-control psi_required added_contact_persons"  name="contact_person">' +
            '<option value="1234" selected>Select Contact</option>' +
            '</select>' +
            '</div>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Contact Number</label>' +
            '<input type="text" class= "form-control psi_required numeric am_contact_number" required>' +
            '</div>' +
            '</div>' +

            '<div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Email Address</label>' +
            '<div class="input-group">' +
            '<input type="text" class= "form-control psi_required numeric am_contact_email" required>' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger del_more_client_c_p" type="button">' +
            '<i class="fa fa-times"></i> ' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +

            '</div>' +

            '</div>');

        $.ajax({
            url: '/getallclientcontacts/' + $('#loading_client').val(),
            type: 'GET',
            success: function(response) {
                $('.am_cp_parent').find('.added_contact_persons option').remove();

                $('.am_cp_parent').find('.added_contact_persons').append($("<option selected disabled>Select Contact</option>"));
                var count = response.contacts.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('.am_cp_parent').find('.added_contact_persons').append($("<option></option>")
                        .attr("value", response.contacts[i].id)
                        .text(response.contacts[i].contact_person));
                }

            },
            error: function(error) {
                console.log(error);
            }
        });

    });

    $('body').on('change', '.added_contact_persons', function() {

        var tis = $(this);
        $.ajax({
            url: '/getoneclientcontact/' + tis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                tis.closest('.am_cp_parent').find('.am_contact_number').val(response.contact.contact_number);
                tis.closest('.am_cp_parent').find('.am_contact_email').val(response.contact.email_address);
            }
        });
    });


    $('body').on('click', '.del_more_client_c_p', function() {
        $(this).closest('.am_cp_parent').remove();
    });

    $('body').on('click', '.btn-cli-factory', function() {
        var supp_val = $('#supplier').val();
        if (supp_val == "") {
            swal("Warning!", "Please select supplier first!", "warning");
        } else {
            $('#newFactory').modal('show');
        }

    });
    $('body').on('change', '.supplier', function() {
        var dis = $(this);
        //$('#new_factory_id').val(dis.val());
        $.ajax({
            url: '/getfactorysupplier/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                dis.closest('.factory-select').find('.supplier_contact_number').val('');
                dis.closest('.factory-select').find('.supplier_email').val('');
                dis.closest('.factory-select').find('.factory_address').val('');
                dis.closest('.factory-select').find('.factory_contact_number').val('');
                dis.closest('.factory-select').find('.factory_email').val('');
                dis.closest('.factory-select').find('.factory_contact_person option').remove();
                dis.closest('.factory-select').find('.factory_contact_person').append($("<option selected disabled>Select Factory Contact Person</option>"));

                dis.closest('.factory-select').find('.supplier_address').val(response.supplier.supplier_address);
                dis.closest('.factory-select').find('.supplier_contact_person option').remove();
                dis.closest('.factory-select').find('.supplier_contact_person').append($("<option selected disabled>Select Supplier Contact Person</option>"));
                response.contacts.forEach(element => {
                    dis.closest('.factory-select').find('.supplier_contact_person').append($("<option></option>").attr("value", element.id).text(element.supplier_contact_person));
                });

                dis.closest('.factory-select').find('.factory option').remove();
                dis.closest('.factory-select').find('.factory').append($("<option selected disabled>Select Factory</option>"));
                response.factories.forEach(element => {
                    dis.closest('.factory-select').find('.factory').append($("<option></option>").attr("value", element.id).text(element.factory_name));
                });

            }

        });
    })

    $('body').on('change', '.supplier_contact_person', function() {
        var dis = $(this);
        $.ajax({
            url: '/getonesuppliercontact/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                dis.closest('.factory-select').find('.supplier_contact_number').val(response.contacts.supplier_tel_number);
                dis.closest('.factory-select').find('.supplier_email').val(response.contacts.supplier_email);

            }

        });
    })

    $('body').on('click', '.view_prod_attachment', function() {
        $('#id_edit_prod_spec').val("N/A");
        $('#id_edit_tech_details').val("N/A");
        $('#id_edit_art_work').val("N/A");
        $('#id_edit_shipping_mark').val("N/A");
        $('#id_edit_packing').val("N/A");
        $('#id_edit_photo_files').val("N/A");
        $('#form_edit_prod_spec').hide();
        $('#form_edit_tech_details').hide();
        $('#form_edit_art_work').hide();
        $('#form_edit_shipping_mark').hide();
        $('#form_edit_packing').hide();
        $('#form_edit_photo_files').hide();


        var id = $(this).closest('.clone-inputs-edit').find('.product_name').val();
        $('#edit_product_id').val(id);
        $('#editProduct').modal();
    });

    $('body').on('change', '.product_name', function() {
        var dis = $(this);
        var id = $(this).val();
        console.log('choosing product...');
        $.ajax({
            url: getproduct,
            type: 'POST',
            data: {
                _token: token,
                product_id: id
            },
            success: function(response) {
                console.log(response);
                //dis.closest('.clone-inputs').find('.p_unit').val(response.product.product_unit);
                dis.closest('.clone-inputs-edit').find('.pcat').val(response.product.product_category);
                // dis.closest('.clone-inputs').find('.product_sub_category').val(response.product.product_sub_category);
                dis.closest('.clone-inputs-edit').find('.brand').val(response.product.brand);
                dis.closest('.clone-inputs-edit').find('.po_number').val('');
                dis.closest('.clone-inputs-edit').find('.model_no').val(response.product.model_no);
                dis.closest('.clone-inputs-edit').find('.p_unit').val(response.product.product_unit);
                dis.closest('.clone-inputs-edit').find('.prod_addtl_info').val(response.product.additional_product_info);
                dis.closest('.clone-inputs-edit').find('.prod_item_description').val(response.product.item_description);
                //dis.closest('.clone-inputs').find('.prod_number').val(response.product.product_number);

                dis.closest('.clone-inputs-edit').find('.psubcat').empty();
                dis.closest('.clone-inputs-edit').find('.psubcat').append('<option value="">Select Sub-product Category</option>');
                var cat_val = dis.closest('.clone-inputs-edit').find('.pcat').val();
                getSubCategory(cat_val, dis)
                setTimeout(function() {
                    dis.closest('.clone-inputs-edit').find('.psubcat').val(response.product.product_sub_category);
                }, 1000);
                var pid = $(dis).closest('.clone-inputs-edit').find('.product_name').val();
                getCountAttachments(pid, dis);
                var add = $('.input-new-prod');
                for (var i = 0; i < add.length; i++) {
                    $(add[i]).removeAttr("style");
                }
            }

        });
    });


    $('.product_category').on('change', function() {
        var dis = this;
        $('.product_sub_category').empty();
        $('.product_sub_category').append('<option value="">Select Sub-product Category</option>');
        var cat_val = $(dis).val();
        console.log(cat_val);
        var sub_cat_arr = [];
        $.ajax({
            url: '/get-saved-sub-category',
            type: 'POST',
            data: {
                _token: token,
                id: cat_val
            },
            success: function(response) {
                console.log(response);
                response.sub_categories.forEach(element => {
                    sub_cat_arr.push(element.sub_category);
                });
                if (response.orig_sub_categories.length > 0) {
                    response.orig_sub_categories.forEach(element => {
                        sub_cat_arr.push(element.name);
                    });
                }
                sub_cat_arr.sort();
                sub_cat_arr.forEach(element => {
                    $('.product_sub_category').append('<option value="' + element + '">' + element + '</option>');
                });
                $('.product_sub_category').append('<option value="Others">Others</option>');
            }
        });
    });
    //added 04-16-2021
    $('body').on('change', '.pcat', function() {
        var dis = this;
        //dis.closest('.clone-inputs').find('.col-view-att').hide();
        $(dis).closest('.clone-inputs-edit').find('.psubcat').empty();
        $(dis).closest('.clone-inputs-edit').find('.psubcat').append('<option value="">Select Sub-product Category</option>');
        var cat_val = $(dis).val();
        console.log(cat_val);
        getSubCategory(cat_val, dis);
        if (cat_val == 'Others' || cat_val == 'others') {
            $(this).closest('.div_category').find('.modalCategory').modal('show');
        }
    });
     //04-15-2021
     $('body').on('click', '.btn-show-cat-modal', function() {
        $(this).closest('.div_category').find('.modalCategory').modal('show');
    });
    //added 04-16-2021
    $('body').on('click', '.btn-add-sub-cat-modal-edit', function() {
        var dis = this;
        var pval = $(dis).closest('.clone-inputs-edit').find('.pcat').val();
        if (pval == '' || pval == null || pval == 'Others') {
            swal({
                title: "Warning!",
                text: "Please select product category first",
                type: "warning",
            });
        } else {
            $(this).closest('.div_sub_category').find('.modalSubCategory').modal('show');
        }

    });
    ///save category 04-15-2021
    $('body').on('click', '.btn_save_category', function() {
        var dis = this;
        var new_cat_other = $(dis).closest('.modalCategory').find('.prod_category').val();
        var new_sub_cat_other = $(dis).closest('.modalCategory').find('.prod_sub_category').val();
        if (new_cat_other != '' && new_sub_cat_other != '') {
            $('.send-loading ').show();
            var request = 'save_category';

            $.ajax({
                url: '/save-new-category',
                type: 'POST',
                data: {
                    _token: token,
                    user_id: auth_id,
                    category: new_cat_other,
                    sub_category: new_sub_cat_other,
                    req: request
                },
                success: function(response) {
                    $('.send-loading ').hide();
                    console.log(response);
                    $('.pcat').append('<option value="' + new_cat_other + '">' + new_cat_other + '</option>');
                    $(dis).closest('.clone-inputs-edit').find('.pcat').val(new_cat_other);
                    $(dis).closest('.clone-inputs-edit').find('.psubcat').empty();
                    $(dis).closest('.clone-inputs-edit').find('.psubcat').append('<option value="">Select Sub-product Category</option>');
                    $(dis).closest('.clone-inputs-edit').find('.psubcat').append('<option value="' + new_sub_cat_other + '">' + new_sub_cat_other + '</option>');
                    $(dis).closest('.clone-inputs-edit').find('.psubcat').append('<option value="Others">Others</option>');
                    $(dis).closest('.clone-inputs-edit').find('.psubcat').val(new_sub_cat_other);

                    swal({
                        title: "Success!",
                        text: "Category successfully added.",
                        type: "success",
                    }, function() {
                        $(dis).closest('.modalCategory').find('.prod_category').val('');
                        $(dis).closest('.modalCategory').find('.prod_sub_category').val('');
                        $(dis).closest('.div_category').find('.modalCategory').modal('toggle');
                    });

                }
            });
        } else {
            swal({
                title: "Warning!",
                text: "Please please fill up required fields.",
                type: "warning",
            });
        }

    });
    //save product sub-category 04-15-2021
    $('body').on('click', '.btn_save_sub_category', function() {
        var dis = this;
        var category = $(dis).closest('.clone-inputs-edit').find('.pcat').val();
        var new_sub_cat_other = $(dis).closest('.modalSubCategory').find('.sub_categ').val();
        console.log('c:' + category);
        console.log('sc:' + new_sub_cat_other);
        if (new_sub_cat_other != '') {
            $('.send-loading ').show();
            var request = 'save_sub_category';

            $.ajax({
                url: '/save-new-category',
                type: 'POST',
                data: {
                    _token: token,
                    user_id: auth_id,
                    category_id: category,
                    category: category,
                    sub_category: new_sub_cat_other,
                    req: request
                },
                success: function(response) {
                    $('.send-loading ').hide();
                    console.log(response);
                    $(dis).closest('.clone-inputs-edit').find('.psubcat').append('<option value="' + new_sub_cat_other + '">' + new_sub_cat_other + '</option>');
                    $(dis).closest('.clone-inputs-edit').find('.psubcat').val(new_sub_cat_other);
                    swal({
                        title: "Success!",
                        text: "Category successfully added.",
                        type: "success",
                    }, function() {
                        $(dis).closest('.modalSubCategory').find('.sub_categ').val('');
                        $(dis).closest('.div_sub_category').find('.modalSubCategory').modal('toggle');
                    });

                }
            });
        } else {
            swal({
                title: "Warning!",
                text: "Please please fill up required fields.",
                type: "warning",
            });
        }


    });

    $('body').on('click', '#add_inspector', function() {
        //$('.clone-inspector:first').clone().find("input:text").val("").end().appendTo('.clone-inspector-container');
        var content_clone = $('.clone-inspector:first').clone();
        content_clone.find("input:text").val("");
        //content_clone.find(".insp-addr").val();
        content_clone.find(".sel-inspector").val('');
        content_clone.find(".sel-inspector").removeAttr("id");
        content_clone.find(".sel-inspector").addClass("sel-added-inspector");
        content_clone.find(".insp-addr").removeAttr("id");
        content_clone.find(".insp-addr").removeClass("inspector_address");
        content_clone.find(".insp-addr").addClass("added-inspector-address");
        content_clone.appendTo('.clone-inspector-container');
        $('.clone-inspector:last').append('<div class="col-md-12"><button class="btn btn-danger btn-rm-inspector" type="button"><i class="fa fa-times"></i> Remove</button><br><br></div>');
        var md_val = $('#manday').val();
        var temp = parseInt(md_val) + 1;
        $('#manday').val(temp);
    });
    //Inspector Address

    $('body').on('change', '.sel-inspector', function() {
        var dis = $(this);
        console.log(dis.val());
        $.ajax({
            url: '/getinspectoraddress/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                dis.closest('.clone-inspector').find('.add_inspector').val(response.address[0]['address']);

            }
        });
    });

    $('body').on('keyup', '.aql_qty', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal').find('.aql_minor').val();
        var major = dis.closest('.AQLModal').find('.aql_major').val();
        var lvl = dis.closest('.AQLModal').find('.aql_normal_level').val();
        var special_lvl = dis.closest('.AQLModal').find('.aql_special_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal').find('.max_major').val(majorMax);
        dis.closest('.AQLModal').find('.max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.aql_special_letter').val(special_letter);
        dis.closest('.AQLModal').find('.aql_normal_sampsize').val(sampsize);
        dis.closest('.AQLModal').find('.aql_special_sampsize').val(special_sampsize);
    })

    $('#btn_more_product').click(function() {

        var add = $('.prod_valid');
        var add_count_null = 0;
        for (var i = 0; i < add.length; i++) {
            var data = $(add[i]).val();
            if (data == "") {
                $(add[i]).css("border", "1px solid red");
                add_count_null += 1;
            } else {
                $(add[i]).removeAttr("style");
            }
        }

        if (add_count_null >= 1) {
            swal({
                title: "Warning!",
                text: "Fill all fields in product details first!",
                type: "warning",
            });
        } else {

            // var pr_clone = $('.clone-inputs-edit');
            // var clone_count = pr_clone.length;
            // console.log('clone_count: ' + clone_count);
            // var new_id = 'pclick-' + clone_count;
            var content_clone = $('.clone-inputs-edit:first').clone();
            // content_clone.find(".product-click").attr('id', new_id);
            content_clone.find(".col-view-att").hide();
            //product id saved
            content_clone.find(".hidden_product_id").remove();
            content_clone.find(".epsc_value").remove();
            //product name
            content_clone.find(".product_name").removeClass('s_pname');
            content_clone.find(".product_name").addClass('n_pname');
            content_clone.find(".product_name").val('');
            //category
            content_clone.find(".pcat").removeClass('s_pcat');
            content_clone.find(".pcat").addClass('n_pcat');
            content_clone.find(".pcat").val('');
            //sub category
            content_clone.find(".psubcat").removeClass('s_scat');
            content_clone.find(".psubcat").addClass('n_scat');
            content_clone.find(".psubcat").empty();
            content_clone.find(".psubcat").append('<option value="">Select Sub-product Category</option>');
            content_clone.find(".psubcat").val('');
            //unit
            content_clone.find(".p_unit").removeClass('s_unit');
            content_clone.find(".p_unit").addClass('n_unit');
            content_clone.find(".p_unit").val('');
            
            //Additional Info
            content_clone.find(".prod_addtl_info").removeClass('s_add_info');
            content_clone.find(".prod_addtl_info").addClass('n_add_info');
            content_clone.find(".prod_addtl_info").val('');
        
            //Product Description
            content_clone.find(".prod_item_description").removeClass('s_item_description');
            content_clone.find(".prod_item_description").addClass('n_item_description');
            content_clone.find(".prod_item_description").val('');
            //brand
            content_clone.find(".brand").removeClass('s_brand');
            content_clone.find(".brand").addClass('n_brand');
            content_clone.find(".brand").val('');
            //po_number
            content_clone.find(".po_number").removeClass('s_po');
            content_clone.find(".po_number").addClass('n_po');
            content_clone.find(".po_number").val('');
            //model_no
            content_clone.find(".model_no").removeClass('s_model');
            content_clone.find(".model_no").addClass('n_model');
            content_clone.find(".model_no").val('');
            //edit_qty
            content_clone.find(".edit_qty").removeClass('s_qty');
            content_clone.find(".edit_qty").addClass('n_qty');
            content_clone.find(".edit_qty").val('');
            //modal quantity
            content_clone.find(".e_aql").val('');
            //qty unit
            content_clone.find(".e_unit").removeClass('edit_aql_qty_unit');
            content_clone.find(".e_unit").addClass('new_aql_qty_unit');
            //normal level
            content_clone.find(".e_anlvl").removeClass('edit_aql_normal_level');
            content_clone.find(".e_anlvl").addClass('new_aql_normal_level');
            //special level
            content_clone.find(".e_aslvl").removeClass('edit_aql_special_level');
            content_clone.find(".e_aslvl").addClass('new_aql_special_level');
            //edit_aql_major
            content_clone.find(".e_aqmj").removeClass('edit_aql_major');
            content_clone.find(".e_aqmj").addClass('new_aql_major');
            //edit_max_major allowed
            content_clone.find(".e_mxmj").removeClass('edit_max_major');
            content_clone.find(".e_mxmj").addClass('new_max_major');
            //edit_aql_minor
            content_clone.find(".e_aqmn").removeClass('edit_aql_minor');
            content_clone.find(".e_aqmn").addClass('new_aql_minor');
            //edit_max_minor allowed
            content_clone.find(".e_mxmn").removeClass('edit_max_minor');
            content_clone.find(".e_mxmn").addClass('new_max_minor');
            //edit_aql_normal_letter
            content_clone.find(".e_anl").removeClass('edit_aql_normal_letter');
            content_clone.find(".e_anl").addClass('new_aql_normal_letter');
            //edit_aql_normal_sampsize
            content_clone.find(".e_ans").removeClass('edit_aql_normal_sampsize');
            content_clone.find(".e_ans").addClass('new_aql_normal_sampsize');
            //edit_aql_special_letter
            content_clone.find(".e_asl").removeClass('edit_aql_special_letter');
            content_clone.find(".e_asl").addClass('new_aql_special_letter');
            //edit_aql_special_sampsize
            content_clone.find(".e_ass").removeClass('edit_aql_special_sampsize');
            content_clone.find(".e_ass").addClass('new_aql_special_sampsize');

            content_clone.appendTo('.product-clone-edit');
        }
    });


});

function concatProduct(input_name) {
    var get_input = jQuery('.' + input_name);
    var result;
    var get_input_len = get_input.length;
    for (var i = 0; i < get_input_len; i++) {
        var data = $(get_input[i]).val();
        if (i == 0) {
            result = data;
        } else {
            result = result + '/ ' + data;
        }
    }
    return result;
}

function changeProjectType(type) {
    if (type == 'word') {
        $('#template').removeClass("psi_required");
        $('#word_project').val('word_project');
        $('#app_project').val('null');
        $('#div_template_word').show(); //04-30-2021
        $('#div_template').hide();
    } else {
        $('#template').addClass("psi_required");
        $('#app_project').val('app_project');
        $('#word_project').val('null');
        $('#div_template').show();
        $('#div_template_word').hide(); //04-30-2021
    }
}

function changeProjectTypeCbpi(type) {
    if (type == 'word') {
        $('#app_project_cbpi').val('null');
        $('#word_project_cbpi').val('word_project');
    } else {
        $('#app_project_cbpi').val('app_project');
        $('#word_project_cbpi').val('null');
    }
}

function getSubCategory(cat_val, dis) {
    var sub_cat_arr = [];
    $.ajax({
        url: '/get-saved-sub-category',
        type: 'POST',
        data: {
            _token: token,
            id: cat_val
        },
        success: function(response) {
            console.log(response);
            response.sub_categories.forEach(element => {
                sub_cat_arr.push(element.sub_category);
            });
            if (response.orig_sub_categories.length > 0) {
                response.orig_sub_categories.forEach(element => {
                    sub_cat_arr.push(element.name);
                });
            }
            sub_cat_arr.sort();
            sub_cat_arr.forEach(element => {
                $(dis).closest('.clone-inputs-edit').find('.psubcat').append('<option value="' + element + '">' + element + '</option>');
            });
            $(dis).closest('.clone-inputs-edit').find('.psubcat').append('<option value="Others">Others</option>');
        }
    });
}

function getCountAttachments(id, dis) {
    var count = 0;
    $.ajax({
        url: '/getProductPhoto',
        type: 'POST',
        data: {
            id: id,
            _token: token
        },
        success: function(response) {
            count = response.productphoto.length;
            console.log(count);
            if (count == 0) {
                dis.closest('.clone-inputs-edit').find('.col-view-att').hide();
            } else {
                dis.closest('.clone-inputs-edit').find('.col-view-att').show();
            }
        }
    });
}