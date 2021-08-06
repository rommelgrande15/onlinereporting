$(document).ready(function() {
    $('.products-list').find('.btn-remove').css('display', 'none');
    fillCategories();

    function fillCategories() {

        $('.categories').find('optgroup').remove();
        $.getJSON("json/categories.json", function(json) {
            $.each(json, function(i, optgroups) {
                $.each(optgroups, function(groupName, options) {
                    var $optgroup = $("<optgroup>", {
                        label: groupName
                    });

                    $.each(options, function(j, option) {
                        var $option = $("<option>", {
                            text: option.text,
                            value: option.val
                        });
                        $option.appendTo($optgroup);
                    });
                    $optgroup.appendTo('.categories');
                });
            });
        });
    }
    var dateToday = new Date();
    $('.inspection_date').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: dateToday,
        firstDay: 1,
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

    $('#new_inspection_form').validate({ // initialize the plugin
        errorPlacement: function(error, element) {},
        rules: {
            aql_qty: {
                required: true,
            },
            sample_level: {
                required: true
            },
            sampling_size: {
                required: true
            },
            max_minor: {
                required: true
            },
            max_major: {
                required: true
            },
            max_critical: {
                required: true
            },
            max_functional: {
                required: true
            },
            aql_minor: {
                required: true
            },
            aql_major: {
                required: true
            },
            aql_critical: {
                required: true
            },
            aql_functional: {
                required: true
            },
        },
    });

    $('#confirmAql').click(function() {
        if ($('#new_inspection_form').valid()) {
            $('#po_qty').val($('#qty').val());
            $('#aqlModal').modal('hide');
        } else {
            alert('Please fill in all fields');
        }
    })

    //     $('#btn_product').click(function(){
    //         $('.product-clone').append('<div class="col-md-12 products-list">'+
    // '<div class="product_row">'+
    //     '<div class="group-header">'+
    //         '<button class="btn btn-danger btn-remove btn-xs" type="button"><i class="fa fa-times"></i></button>'+
    //     '</div>'+
    //     '<div class="group-body">'+
    //         '<div class="row">'+
    //             '<div class="col-md-3">'+
    //                 '<div class="form-group">'+
    //                     '<label for="product_name">Product Name</label>'+
    //                         '<input class="form-control product_name" name="product_name" type="text" id="product_name">'+
    //                 '</div>'+
    //             '</div>'+
    //             '<div class="col-md-3">'+
    //                 '<div class="form-group">'+
    //                     '<label for="product_category">Product Name</label>'+
    //                         '<select class="form-control product_category categories" id="product_category" name="product_category"><option selected="selected" value="">Select a Service</option></select>'+
    //                 '</div>'+
    //             '</div>'+
    //             '<div class="col-md-3">'+
    //                 '<div class="form-group">'+
    //                     '<label for="qty">Product Name</label>'+
    //                     '<input class="form-control qty" name="qty" type="text" id="qty">'+
    //                 '</div>'+
    //             '</div>'+
    //             '<div class="col-md-3">'+
    //                 '<div class="form-group">'+
    //                     '<label for="unit">Product Name</label>'+
    //                     '<select class="form-control unit" id="unit" name="unit">'+
    //                         '<option selected="selected" value="">Select a Service</option>'+
    //                         '<option value="piece">Piece/s</option>'+
    //                         '<option value="roll">Roll/s</option>'+
    //                         '<option value="set">Set/s</option>'+
    //                         '<option value="pair">Pair/s</option>'+
    //                         '<option value="piece">Box/es</option>'+
    //                     '</select>'+
    //                 '</div>'+
    //             '</div>'+
    //         '</div>'+
    //     '</div>'+
    // '</div>'+
    // '</div>');
    //     fillCategories()
    //     });
    $('#btn_product').click(function() {

        var arrayName = [
            'product_name ',
            'brand',
            'po_number',
            'model_no',
            'qty'
        ];
        var identifier = 0;
        for (let index = 0; index < arrayName.length; index++) {
            // console.log("array"+arrayName[index]);
            const element = arrayName[index];
            var c_person_number = jQuery('.' + element + '');
            for (var i = 0; i < c_person_number.length; i++) {
                var g_data = $(c_person_number[i]).val();
                //  console.log("data"+g_data);
                if (g_data == "") {
                    identifier += 1;
                } else {

                }
            }

        }
        // console.log(identifier);
        if (identifier >= 1) {
            alert("Fill all fields in Product Details");
        } else {


            // $('.clone_fcp:first').clone().find("input:text").val("").end().appendTo('.fcp_container');
            $('.clone-inputs:first').clone().find("input:text").val("").end().appendTo('.product-clone');
            $('.clone-inputs:last').append('<div class="col-md-1">' +
                '<div class="form-group">' +
                '<br/><button type="button" class="btn btn-danger btn-rm"><i class="fa fa-times"></i></button>' +
                '</div>' +
                '</div>');

            /*  if ($('.product-clone').height() > 250) {
                 $('.product-clone').css({
                     'overflow-y': 'auto',
                     'height': '250px'
                 });
             } */

        }
    });

    $('#btn_product_edit').click(function() {
        var clone = $('.clone-inputs');
        /* var count_clone = clone.length; */
        if ($(clone).css('display') == 'none' || $(clone).css("visibility") == "hidden") {
            $('.clone-inputs').show();
            $('.clone-inputs:last').append('<div class="col-md-1 div_rm_edit">' +
                '<div class="form-group">' +
                '<br/><button type="button" class="btn btn-danger btn-rm-edit"><i class="fa fa-times"></i></button>' +
                '</div>' +
                '</div>');
        } else {
            $('.clone-inputs:first').clone().appendTo('.product-clone');
            /*  if ($('.product-clone').height() > 250) {
                 $('.product-clone').css({
                     'overflow-y': 'auto',
                     'height': '250px'
                 });
             } */
        }


    });

    $('body').on('click', '.btn_add_files', function() {
        $('.file-clone').prepend(
            '<div class="file-clone-inputs">' +
            '<div class="input-group">' +
            '<input type="file" class="form-control other_files" name="other_files">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger btn_rm_add_files" type="button" >' +
            '<i class="fa fa-times"></i>' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    });

    $('body').on('click', '.btn_rm_add_files', function() {
        $(this).closest('.file-clone-inputs').remove();
    });

    $('body').on('click', '.btn-rm-edit', function() {

        var h = $(this).closest('.clone-inputs').find('.qty-modal').height();
        var count = $('.clone-inputs').length;
        console.log(count)
            /* if (count < 2) { // why 3? because length is based 1, count initiates before removing so the removed element is still being count
                var height = 250 - (h * 2);
                $('.product-clone').css({
                    'height': height + 'px'
                });
            } */
        if (count > 1) {
            $(this).closest('.clone-inputs').remove();
        } else {
            $('.clone-inputs').hide();
            $(this).closest('.clone-inputs').find('.div_rm_edit').remove();
        }

    });

    $('body').on('click', '.btn-rm-edit-product', function() {
        var sure_delete = confirm("Are you sure you want to delete this product?");
        var dis_btn = this;
        if (sure_delete) {

            $.ajax({
                url: '/deletedraftproduct/' + $(this).data('id'),
                type: 'GET',
                success: function() {
                    alert("Product successfully deleted.");
                    $(dis_btn).closest('.clone-inputs-edit').remove();
                }
            });

        } else {

        }


    });


    $('body').on('click', '.btn-rm', function() {

        var h = $(this).closest('.clone-inputs').find('.qty-modal').height();
        var count = $('.clone-inputs').length;
        console.log(count)
            /* if (count < 3) { // why 3? because length is based 1, count initiates before removing so the removed element is still being count
                var height = 250 - (h * 2);
                $('.product-clone').css({
                    'height': height + 'px'
                });
            } */
        $(this).closest('.clone-inputs').remove();
    });
    $('body').on('click', '.btn-qty-modal', function() {
        //alert(jQuery('.product_name').val());

        $(this).closest('.qty-modal').find('.AQLModal').modal('show');


    });
    $('body').on('click', '.btn-qty-modal-edit', function() {
        var dis = this;
        $.ajax({
            url: '/geteditaql/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);
                $(dis).closest('.qty-modal').find('.aql_qty').val(response.psi_product.aql_qty);
                $(dis).closest('.qty-modal').find('.aql_qty_unit').val(response.psi_product.aql_qty_unit);
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

    $('body').on('click', '.btn-qty-modal-edit-cbpi', function() {
        var dis = this;
        $.ajax({
            url: '/geteditaql/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);
                $(dis).closest('.qty-modal').find('.aql_qty').val(response.psi_product.aql_qty);
                $(dis).closest('.qty-modal').find('.aql_qty_unit').val(response.psi_product.aql_qty_unit);
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

    $('body').on('click', '.edit_confirm_aql', function() {
        var dis = $(this);

        /* var aql_qty = $('#aql_qty').val();
        var aql_normal_level = $('#aql_normal_level').val();
        var aql_special_level = $('#aql_special_level').val();
        var aql_major = $('#aql_major').val();
        var max_major = $('#max_major').val();
        var aql_minor = $('#aql_minor').val();
        var max_minor = $('#max_minor').val();
        var aql_normal_letter = $('#aql_normal_letter').val();
        var aql_normal_sampsize = $('#aql_normal_sampsize').val();
        var aql_special_letter = $('#aql_special_letter').val();
        var aql_special_sampsize = $('#aql_special_sampsize').val();
        var aql_product_id = $('#aql_product_id').val(); */

        var aql_qty = dis.closest('.qty-modal').find('.aql_qty').val();
        var aql_qty_unit = dis.closest('.qty-modal').find('.aql_qty_unit').val();
        var aql_normal_level = dis.closest('.qty-modal').find('.aql_normal_level').val();
        var aql_special_level = dis.closest('.qty-modal').find('.aql_special_level').val();
        var aql_major = dis.closest('.qty-modal').find('.aql_major').val();
        var max_major = dis.closest('.qty-modal').find('.max_major').val();
        var aql_minor = dis.closest('.qty-modal').find('.aql_minor').val();
        var max_minor = dis.closest('.qty-modal').find('.max_minor').val();
        var aql_normal_letter = dis.closest('.qty-modal').find('.aql_normal_letter').val();
        var aql_normal_sampsize = dis.closest('.qty-modal').find('.aql_normal_sampsize').val();
        var aql_special_letter = dis.closest('.qty-modal').find('.aql_special_letter').val();
        var aql_special_sampsize = dis.closest('.qty-modal').find('.aql_special_sampsize').val();
        var aql_product_id = dis.closest('.qty-modal').find('.aql_product_id').val();

        $.ajax({
            type: 'POST',
            url: '/updatedraftaql',
            data: {
                _token: token,
                aql_product_id: aql_product_id,
                aql_qty: aql_qty,
                aql_qty_unit: aql_qty_unit,
                aql_normal_level: aql_normal_level,
                aql_special_level: aql_special_level,
                aql_major: aql_major,
                max_major: max_major,
                aql_minor: aql_minor,
                max_minor: max_minor,
                aql_normal_letter: aql_normal_letter,
                aql_normal_sampsize: aql_normal_sampsize,
                aql_special_letter: aql_special_letter,
                aql_special_sampsize: aql_special_sampsize

            },
            success: function(data) {
                alert("AQL successfully updated.");
                dis.closest('.qty-modal').find('.qty').val(aql_qty);
                dis.closest('.qty-modal').find('.AQLModal').modal('hide');
            }
        });

    });
    var aql_options = {
        "": "--",
        "0.065": "0.065",
        "0.10": "0.10",
        "0.15": "0.15",
        "0.25": "0.25",
        "0.4": "0.4",
        "0.65": "0.65",
        "1": "1.0",
        "1.5": "1.5",
        "2.5": "2.5",
        "4": "4.0",
        "6.5": "6.5",
        "10": "10.0"
    };

    /* $.each(aql_options, function(key, value) {
        $('.aql_select').append('<option value=' + key + '>' + value + '</option>');
    }); */

    $('.aql_select').append('<option value="">--</option>');
    $('.aql_select').append('<option value="0.065">0.065</option>');
    $('.aql_select').append('<option value="0.10">0.10</option>');
    $('.aql_select').append('<option value="0.15">0.15</option>');
    $('.aql_select').append('<option value="0.25">0.25</option>');
    $('.aql_select').append('<option value="0.4">0.4</option>');
    $('.aql_select').append('<option value="0.65">0.65</option>');
    $('.aql_select').append('<option value="1">1.0</option>');
    $('.aql_select').append('<option value="1.5">1.5</option>');
    $('.aql_select').append('<option value="2.5">2.5</option>');
    $('.aql_select').append('<option value="4">4.0</option>');
    $('.aql_select').append('<option value="6.5">6.5</option>');
    $('.aql_select').append('<option value="10">10.0</option>');

    $('.service').on('change', function() {
        var service = $(this).val();
        var psi_sub_servie = ['Garments', 'Foot wears', 'Decorations', 'Shoes', 'Bags and Pouches', 'Gift and Premiums', 'Wallets', 'Purses', 'Belts', 'Hats', 'Gloves', 'Scarves', 'Cosmetics, Fragrances, Personal Care', 'Pillows', 'Towels', 'Cushions', 'Domestics: Bedding, Linens, Table Cloths', 'Apparel', 'Backpacks & Luggage', 'Headwear', 'Jewelry', 'Outerwear', 'Furnitures', 'SDA and Household Appliances', 'Outdoor Products', 'Car Parts', 'Consumer Electronics and Multimedia', 'Sporting / Gym Equipements', 'Cookwares', 'Stools', 'Trolleys', 'Tables', 'Chairs', 'Sofas', 'Automotive', 'Costumes / Role Play', 'Food & Beverage', 'Office Supplies', 'Outdoor Gear', 'Pet Products', 'Toys & Games', 'Video Games'];

        var cbpi_sub_service = ['Screws', 'Fabric Rolls', 'Garments', 'Artificial Plants', 'Blankets', 'Chemicals', 'Motors', 'Solar Tank / Heaters', 'Medical Supply / Equipments', 'Cotton', 'Textile threads', 'LED Lamps', 'Scooters', 'Wheelchair', 'TV Bracket', 'Hair Dryers', 'Bubble Tea', 'Shanklets', 'Flip Flops', 'Shoes', 'Slippers', 'Trycicle', 'Car Components', 'Wax', 'DIY Straw Sets', 'Tea', 'Scales', 'Sandals', 'Swimwears', 'Rash guards', 'Soap Dish', 'Mattress', 'PVC Films', 'Towels', 'Tea', 'Crutch', 'Baskets', 'Auto Parts', 'Kitchen ware', 'Bags / Purse', 'Hospital Bed', 'Toys', 'Utensils', 'Skates', 'Tires'];

        if (service == 'cli' || service == 'cbpi' || service == 'cbpi_serial' || service == 'cbpi_isce') {
            $('.tic_form').hide();
            $('.loading_form').show();
            $('.FRI_form').hide();
            $('.SPK_form').hide();
            $('.site_form').hide();
            $('#loading_service_inspection').val(service);
        } else if (service == 'site_visit') {
            $('.tic_form').hide();
            $('.loading_form').hide();
            $('.FRI_form').hide();
            $('.SPK_form').hide();
            $('.site_form').show();
            $('#site_service_inspection').val(service);
        } else if (service == 'SPK') {
            $('.tic_form').hide();
            $('.loading_form').hide();
            $('.site_form').hide();
            $('.FRI_form').hide();
            $('.SPK_form').show();
            $('#site_service_inspection').val(service);
        } else if (service == 'FRI') {
            $('.tic_form').hide();
            $('.loading_form').hide();
            $('.site_form').hide();
            $('.SPK_form').hide();
            $('.FRI_form').show();
            $('#site_service_inspection').val(service);
        } else {
            $('.tic_form').show();
            $('.loading_form').hide();
            $('.FRI_form').hide();
            $('.SPK_form').hide();
            $('.site_form').hide();
            $('#service').val(service);
        }
    });

    $('body').on('click', '.confirm_aql', function() {
        var dis = $(this);
        dis.closest('.clone-inputs').find('.qty').val(dis.closest('.clone-inputs').find('.aql_qty').val());
        dis.closest('.clone-inputs').find('.AQLModal').modal('hide');

    });

    $('body').on('click', '.cbpi_confirm_aql', function() {
        var dis = $(this);
        dis.closest('.cbpi_modal_qty').find('.qty').val(dis.closest('.cbpi_modal_qty').find('.aql_qty').val());
        dis.closest('.cbpi_modal_qty').find('.AQLModal').modal('hide');

    });

    $('body').on('click', '.draft_confirm_aql', function() {
        var dis = $(this);
        dis.closest('.clone-inputs').find('.qty').val(dis.closest('.clone-inputs').find('.new_aql_qty').val());
        dis.closest('.clone-inputs').find('.AQLModal').modal('hide');
        $('#is_new_product_added').val(1);

    });

    $('.client_select').on('change', function() {
        var dis = $(this);
        $('#add_client_code').val($(this).val());
        $('#new_factory_client_code').val($(this).val());

        console.log(dis.closest('.contact-select').find('.contact_persons').val());
        $.ajax({
            url: '/getallclientcontacts/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                $('.contact_persons option').remove();

                $('.contact_persons').append($("<option selected disabled>Select Contact</option>"));
                var count = response.contacts.length;
                for (var i = 0; i <= count - 1; i++) {
                    $('.contact_persons').append($("<option></option>")
                        .attr("value", response.contacts[i].id)
                        .text(response.contacts[i].contact_person));
                }
                //jesser
                if (count > 1) {
                    $('.show_client_c_p').show();
                } else {
                    $('.show_client_c_p').hide();
                }

            },
            error: function(error) {
                console.log(error);
            }
        });
        $('.am_cp_parent').remove();
    });

    $('body').on('change', '.contact_persons', function() {

        var tis = $(this);
        $.ajax({
            url: '/getoneclientcontact/' + tis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                tis.closest('.contact-select').find('.contact_number').val(response.contact.tel_number);
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

        var id = $(this).val();
        var inspection_date = $('#inspection_date').val();

        $.ajax({
            url: '/inspectorassignment/' + id + '/' + inspection_date,
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


    $('body').on('change', '#inspection_date', function() {
        var id = $('#inspector').val();
        var inspection_date = $('#inspection_date').val();

        $.ajax({
            url: '/inspectorassignment/' + id + '/' + inspection_date,
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

    $('body').on('change', '#loading_inspection_date', function() {
        var id = $('#loading_inspector').val();
        var inspection_date = $('#loading_inspection_date').val();

        $.ajax({
            url: '/inspectorassignment/' + id + '/' + inspection_date,
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

    /*    $('#client').on('change',function(){
            $.ajax({
                url     : '/getoneclients/'+ $(this).val(),
                type    : 'GET',
                success : function(response){
                    $('#contact_person').val(response.contact_person);
                    $('#contact_number').val(response.contact_number);
                    $('#email_address').val(response.email_address);
                }

            });
        });*/

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
                    var serv = $('.service').val();
                    if (serv == 'cbpi' || serv == 'cbpi_serial' || serv == 'cbpi_isce' || serv == 'cli') {
                        $('.show_fac_c_p_cbpi').css("display", "block");
                    } else {
                        $('.show_fac_c_p').css("display", "block");
                    }
                } else {
                    $('.fcp2').css("display", "none");

                    if (serv == 'cbpi' || serv == 'cbpi_serial' || serv == 'cbpi_isce' || serv == 'cli') {
                        $('.show_fac_c_p_cbpi').css("display", "none");
                    } else {
                        $('.show_fac_c_p').css("display", "none");
                    }
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

    $('body').on('click', '#add_more_fac_c_p', function() {
        var dis = $(this);
        var count = $('.clone_fcp');
        if (count.length == 1 && $(".clone_fcp").is(":hidden")) {

            $('.fcp_sel').addClass('psi-required');
            $('.clone_fcp').css('display', 'block');
            var fac_id = $('.factory').val();
            $.ajax({
                url: '/getonefactory/' + fac_id,
                type: 'GET',
                success: function(response) {
                    console.log(response.contacts);
                    $('.fcp_sel option').remove();
                    $('.fcp_sel').append($("<option selected disabled>Select Contact Person</option>"));
                    var count = response.contacts.length;
                    for (var i = 0; i <= count - 1; i++) {
                        $('.fcp_sel').append($("<option></option>").attr("value", response.contacts[i].id).text(response.contacts[i].factory_contact_person));
                    }

                }

            });
        } else {
            $('.clone_fcp:first').clone().find("input:text").val("").end().appendTo('.fcp_container');
            dis.closest('.clone_fcp').find('.factory_contact_number_added').val("");
        }
        console.log(count.length);

    });


    $('body').on('click', '.rm_fcp', function() {

        var count = $('.clone_fcp');
        if (count.length == 1 && $(".clone_fcp").is(":visible")) {
            $('.clone_fcp').css('display', 'none');
            $('.fcp_sel').removeClass('psi-required');
        } else {
            $(this).closest('.clone_fcp').remove();
        }

    });

    $('body').on('click', '#add_more_fac_c_p_cbpi', function() {
        var dis = $(this);
        var count = $('.clone_fcp_cbpi');
        if (count.length == 1 && $(".clone_fcp_cbpi").is(":hidden")) {

            $('.fcp_sel_cbpi').addClass('cli-required');
            $('.clone_fcp_cbpi').css('display', 'block');
            var fac_id = $('#loading_factory').val();
            $.ajax({
                url: '/getonefactory/' + fac_id,
                type: 'GET',
                success: function(response) {
                    console.log(response.contacts);
                    $('.fcp_sel_cbpi option').remove();
                    $('.fcp_sel_cbpi').append($("<option selected disabled>Select Contact Person</option>"));
                    var count = response.contacts.length;
                    for (var i = 0; i <= count - 1; i++) {
                        $('.fcp_sel_cbpi').append($("<option></option>").attr("value", response.contacts[i].id).text(response.contacts[i].factory_contact_person));
                    }

                }

            });
        } else {
            $('.clone_fcp_cbpi:first').clone().find("input:text").val("").end().appendTo('.fcp_container_cbpi');
            dis.closest('.clone_fcp_cbpi').find('.factory_contact_number_added').val("");
        }

    });

    $('body').on('click', '.rm_fcp_cbpi', function() {

        var count = $('.clone_fcp_cbpi');
        if (count.length == 1 && $(".clone_fcp_cbpi").is(":visible")) {
            $('.clone_fcp_cbpi').css('display', 'none');
            $('.fcp_sel_cbpi').removeClass('cli-required');
        } else {
            $(this).closest('.clone_fcp_cbpi').remove();
        }

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
                dis.closest('.factory-select').find('.factory_contact_number').val(response.contact.factory_tel_number);
                dis.closest('.factory-select').find('.factory_email').val(response.contact.factory_email);
                //jesser
                /* $('.factory_contact_person2').empty();
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
                }); */

            }
        })
    });

    $('body').on('change', '.fcp_sel', function() {
        var dis = $(this)
        $.ajax({
            url: '/getonefactorycontact/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log("success");
                dis.closest('.clone_fcp').find('.factory_contact_number_added').val(response.contact.factory_tel_number);
                dis.closest('.clone_fcp').find('.factory_email_added').val(response.contact.factory_email);

            }
        })
    });

    $('body').on('change', '.fcp_sel_cbpi', function() {
        var dis = $(this)
        $.ajax({
            url: '/getonefactorycontact/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log("success");
                dis.closest('.clone_fcp_cbpi').find('.factory_contact_number_added_cbpi').val(response.contact.factory_tel_number);
                dis.closest('.clone_fcp_cbpi').find('.factory_email_added_cbpi').val(response.contact.factory_email);

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

    //jesser factory
    /* $('body').on('change', '.factory_contact_person2', function() {
        var dis = $(this);
        var fcp1 = $('.factory_contact_person').val;
        $.ajax({
            url: '/getonefactorycontact2/' + fcp1 + '/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                dis.closest('.factory-select').find('.factory_contact_number2').val(response.contact.factory_contact_number);
                dis.closest('.factory-select').find('.factory_email2').val(response.contact.factory_email);
            }
        })
    }); */

    $('#save').click(function() {
        $.ajax({
            url: newclient,
            type: 'POST',
            data: {
                _token: token,
                'client_name': $('#new_client_name').val(),
                'client_code': $('#new_client_code').val(),
            },
            success: function(response) {
                console.log(response);
                $('#client, #loading_client').append('<option value="' + response.client.client_code + '">' + response.client.client_name + '</option>');
                $('#new_client_code_factory,#new_client_code_product').append('<option value="' + response.client.client_code + '">' + response.client.client_name + '</option>');
                $('#newClient').modal('hide');
            }
        });
    })

    $('#save_factory').click(function() {
        $.ajax({
            url: newfactory,
            type: 'POST',
            data: {
                _token: token,
                'client_code': $('#new_client_code_factory').val(),
                'factory_name': $('#new_factory_name').val(),
                'factory_address': $('#new_factory_address').val(),
                'factory_country': $('#new_factory_country').val(),
                'factory_city': $('#new_factory_city').val(),
            },
            success: function(response) {
                console.log(response);
                $('#factory, #loading_factory').append('<option value="' + response.factory.id + '" selected>' + response.factory.factory_name + '</option>');
                $('#factory_contact_person, #loading_factory_contact_person').val(response.factory.factory_contact_person);
                $('#factory_contact_number, #loading_factory_contact_number').val(response.factory.factory_contact_number);
                $('#factory_email,#loading_factory_email').val(response.factory.factory_email);
                $('#factory_address,#loading_factory_address').val(response.factory.factory_address);
                $('#new_factory_id').val(response.factory.id);
                $('#new_factory_client_code').val(response.factory.client_code)
                $('#newFactory').modal('hide');
            }
        });
    })

    $('#save_product').click(function() {
        var dis = $(this);

        var po_num = concatProduct('new_po_number');
        var model_num = concatProduct('new_model_number');
        var new_brand = concatProduct('new_brand');
        var new_cmf = concatProduct('new_cmf');
        var new_tech_specs = concatProduct('new_tech_specs');
        var new_shipping_mark = concatProduct('new_shipping_mark');
        var new_additional_product_info = concatProduct('new_additional_product_info');

        $.ajax({
            url: newproduct,
            type: 'POST',
            data: {
                _token: token,
                'client_code': $('#new_client_code_product').val(),
                'product_name': $('#new_product_name').val(),
                'product_category': $('#new_product_category').val(),
                'product_unit': $('#unit').val(),
                'po_no': po_num,
                'model_no': model_num,
                'brand': new_brand,
                'cmf': new_cmf,
                'tech_specs': new_tech_specs,
                'shipping_mark': new_shipping_mark,
                'additional_product_info': new_additional_product_info,
            },
            beforeSend: function() {
                $('.send-loading ').show();
            },
            success: function(response) {
                console.log(response);
                $('.product_name').append('<option value="' + response.product.id + '">' + response.product.product_name + '</option>');
                $('.product_input').each(function() {
                    $(this).val('');
                });
                $('.added_more_fields_po').remove();
                $('.added_more_fields_model').remove();
                $('.added_more_fields_brand').remove();
                $('.added_more_fields_color').remove();
                $('.added_more_fields_tech').remove();
                $('.added_more_fields_sm').remove();
                $('.added_more_fields_addtl').remove();

                $('#add_more_po_num').removeAttr("disabled");
                $('#add_more_model_num').removeAttr("disabled");
                $('#add_more_brand').removeAttr("disabled");
                $('#add_more_color').removeAttr("disabled");
                $('#add_more_tech').removeAttr("disabled");
                $('#add_more_sm').removeAttr("disabled");
                $('#add_more_addtl').removeAttr("disabled");

                $('#cb_new_po_number').prop('checked', false);
                $('#cb_new_model_number').prop('checked', false);
                $('#cb_new_brand').prop('checked', false);
                $('#cb_new_cmf').prop('checked', false);
                $('#cb_new_tech_specs').prop('checked', false);
                $('#cb_new_shipping_mark').prop('checked', false);
                $('#cb_new_additional_product_info').prop('checked', false);
                alert("successfully added");
                $('.send-loading ').hide();
                $('#newProduct').modal('hide');
            },
            error: function() {
                alert("Error: Server encountered an error. Please try again or contact your system administrator.");
            }
        });
    })

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

    $()

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

    $('#save_factory_contact').click(function() {
        var contact_person = $('#new_factory_contact_name').val();
        var contact_number = $('#new_factory_contact_number').val();
        var contact_email = $('#new_factory_contact_email').val();
        var new_factory_id = $('#new_factory_id').val();
        var new_factory_client_code = $('#new_factory_client_code').val();

        if (contact_person == null || contact_person == '') {
            $('#error_factory_contact_name').html('Enter Contact Person!');
        } else if (contact_number == null || contact_number == '') {
            $('#error_factory_contact_number').html('Enter Contact Number!');
        } else if (contact_email == null || contact_email == '') {
            $('#error_factory_contact_email').html('Enter Contact Email!');
        } else {
            $.ajax({
                url: '/addfactorycontact',
                type: 'POST',
                data: {
                    _token: token,
                    contact_person: contact_person,
                    factory_email: contact_email,
                    contact_number: contact_number,
                    factory_id: new_factory_id,
                    client_code: new_factory_client_code
                },
                success: function(response) {
                    $('.factory_contact_person ').append($("<option></option>")
                        .attr("value", response.contact.id)
                        .text(response.contact.factory_contact_person));

                    $('#new_factory_contact_name').val('');
                    $('#new_factory_contact_number').val('');
                    $('#new_factory_contact_email').val('');
                    $('#newFactoryContact').modal('hide');
                    swal("Success!", "New factory contact has been added successfully!", "success");
                    console.log(response);
                }
            })
        }
    });

    $('body').on('change', '.product_name', function() {
        var dis = $(this);
        var id = $(this).val();

        $.ajax({
            url: getproduct,
            type: 'POST',
            data: {
                _token: token,
                product_id: id
            },
            success: function(response) {
                dis.closest('.clone-inputs').find('.brand').val(response.product.brand);
                dis.closest('.clone-inputs').find('.po_number').val(response.product.po_no);
                dis.closest('.clone-inputs').find('.model_no').val(response.product.model_no);
            }

        });
    });

    $('body').on('change', '.new_product_name', function() {
        var dis = $(this);
        var id = $(this).val();

        $.ajax({
            url: getproduct,
            type: 'POST',
            data: {
                _token: token,
                product_id: id
            },
            success: function(response) {
                dis.closest('.clone-inputs').find('.new_brand').val(response.product.brand);
                dis.closest('.clone-inputs').find('.new_po_number').val(response.product.po_no);
                dis.closest('.clone-inputs').find('.new_model_no').val(response.product.model_no);
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


    $('body').on('keyup', '.new_aql_qty', function() {
        var dis = $(this);
        var batchSize = $(this).val();
        var minor = dis.closest('.AQLModal').find('.new_aql_minor').val();
        var major = dis.closest('.AQLModal').find('.new_aql_major').val();
        var lvl = dis.closest('.AQLModal').find('.new_aql_normal_level').val();
        var special_lvl = dis.closest('.AQLModal').find('.new_aql_special_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var special_letter = specialLevel(batchSize, special_lvl);
        var special_sampsize = sampleSize(special_letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);

        dis.closest('.AQLModal').find('.new_max_major').val(majorMax);
        dis.closest('.AQLModal').find('.new_max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.new_aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.new_aql_special_letter').val(special_letter);
        dis.closest('.AQLModal').find('.new_aql_normal_sampsize').val(sampsize);
        dis.closest('.AQLModal').find('.new_aql_special_sampsize').val(special_sampsize);
    })

    $('body').on('change', '.new_aql_normal_level', function() {

        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.new_aql_qty').val();
        var minor = dis.closest('.AQLModal').find('.new_aql_minor').val();
        var major = dis.closest('.AQLModal').find('.new_aql_major').val();
        var lvl = dis.val();




        var letter = generalLevel(batchSize, lvl);

        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal').find('.new_max_major').val(majorMax);
        dis.closest('.AQLModal').find('.new_max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.new_aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.new_aql_normal_sampsize').val(sampsize);
    })

    $('body').on('change', '.new_aql_special_level', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.new_aql_qty').val();
        var minor = dis.closest('.AQLModal').find('.new_aql_minor').val();
        var major = dis.closest('.AQLModal').find('.new_aql_major').val();
        var lvl = dis.val();
        var letter = specialLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        dis.closest('.AQLModal').find('.new_aql_special_letter').val(letter);
        dis.closest('.AQLModal').find('.new_aql_special_sampsize').val(sampsize);
    })

    $('body').on('change', '.new_aql_major', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.new_aql_qty').val();
        var minor = dis.closest('.AQLModal').find('.new_aql_minor').val();
        var major = dis.val();
        var lvl = dis.closest('.AQLModal').find('.new_aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal').find('.new_max_major').val(majorMax);
        dis.closest('.AQLModal').find('.new_max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.new_aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.new_aql_normal_sampsize').val(sampsize);
    })

    $('body').on('change', '.new_aql_minor', function() {
        var dis = $(this);
        var batchSize = dis.closest('.AQLModal').find('.new_aql_qty').val();
        var major = dis.closest('.AQLModal').find('.new_aql_major').val();
        var minor = dis.val();
        var lvl = dis.closest('.AQLModal').find('.new_aql_normal_level').val();
        var letter = generalLevel(batchSize, lvl);
        var sampsize = sampleSize(letter);
        var majorMax = maxAllowed(sampsize, major);
        var minorMax = maxAllowed(sampsize, minor);
        dis.closest('.AQLModal').find('.new_max_major').val(majorMax);
        dis.closest('.AQLModal').find('.new_max_minor').val(minorMax);
        dis.closest('.AQLModal').find('.new_aql_normal_letter').val(letter);
        dis.closest('.AQLModal').find('.new_aql_normal_sampsize').val(sampsize);
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
        var inspection_date = $('#loading_inspection_date').val();

        $.ajax({
            url: '/inspectorassignment/' + id + '/' + inspection_date,
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

    $('#site_inspector').on('change', function() {

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
        var inspection_date = $('#site_inspection_date').val();

        $.ajax({
            url: '/inspectorassignment/' + id + '/' + inspection_date,
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
        var g_data;
        var datas = [];
        var dis = $(this);
        var data = $(".added_contact_persons option:selected");
        var data2 = $(".added_contact_persons");


        for (let index = 0; index < data.length; index++) {
            g_data = $(data[index]).val();
            if ("Select Contact" != g_data) {
                datas.push(g_data)
                console.log(datas);
            }


        }


        $('#add_more_contact_container').append('<div class="am_cp_parent"><div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Contact Person</label>' +
            '<select class="form-control psi_required added_contact_persons"  name="contact_person">' +
            '<option value="" selected>Select Contact</option>' +
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

        //console.log(.text());




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
                    console.log(response.contacts[i].id);
                }


                for (let index = 0; index < data2.length; index++) {
                    for (let i = 0; i < datas.length; i++) {
                        //  var   g_data=;
                        console.log(g_data);
                        $(data2[index]).val(datas[index])


                    }

                }





            },
            error: function(error) {
                console.log(error);
            }
        });



    });

    //psi other cost
    $('body').on('click', '#add_insp_other_cost', function() {
        $('.ins_other_cost_container').append('<div class="ins_cost_div"><div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Other Cost Description</label>' +
            '<input type="text" class="form-control ins_other_cost_text psi_required" placeholder="Enter description cost here">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Cost</label>' +
            '<div class="input-group">' +
            '<input type="number" class="form-control ins_other_cost_value psi_required">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger del_added_insp_cost" type="button">' +
            '<i class="fa fa-times"></i> ' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    });

    $('body').on('click', '.del_added_insp_cost', function() {
        $(this).closest('.ins_cost_div').remove();

    });

    $('body').on('click', '#add_cli_other_cost', function() {
        $('.cli_other_cost_container').append('<div class="cli_cost_div"><div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Other Cost Description</label>' +
            '<input type="text" class="form-control cli_other_cost_text cli_required" placeholder="Enter description cost here">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Cost</label>' +
            '<div class="input-group">' +
            '<input type="number" class="form-control cli_other_cost_value cli_required">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger del_added_cli_cost" type="button">' +
            '<i class="fa fa-times"></i> ' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    });

    $('body').on('click', '.del_added_cli_cost', function() {
        $(this).closest('.cli_cost_div').remove();

    });

    //cbpi other cost
    $('body').on('click', '#cbpi_add_insp_other_cost', function() {
        $('.cbpi_ins_other_cost_container').append('<div class="cbpi_ins_cost_div"><div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Other Cost Description</label>' +
            '<input type="text" class="form-control cbpi_ins_other_cost_text cli_required" placeholder="Enter description cost here">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Cost</label>' +
            '<div class="input-group">' +
            '<input type="number" class="form-control cbpi_ins_other_cost_value cli_required">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger cbpi_del_added_insp_cost" type="button">' +
            '<i class="fa fa-times"></i> ' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    });

    $('body').on('click', '.cbpi_del_added_insp_cost', function() {
        $(this).closest('.cbpi_ins_cost_div').remove();

    });

    $('body').on('click', '#cbpi_add_cli_other_cost', function() {
        $('.cbpi_cli_other_cost_container').append('<div class="cbpi_cli_cost_div"><div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Other Cost Description</label>' +
            '<input type="text" class="form-control cbpi_cli_other_cost_text cli_required" placeholder="Enter description cost here">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Cost</label>' +
            '<div class="input-group">' +
            '<input type="number" class="form-control cbpi_cli_other_cost_value cli_required">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger cbpi_del_added_cli_cost" type="button">' +
            '<i class="fa fa-times"></i> ' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    });

    $('body').on('click', '.cbpi_del_added_cli_cost', function() {
        $(this).closest('.cbpi_cli_cost_div').remove();

    });

    $('body').on('click', '#add_inspector', function() {
        //$('.clone-inspector:first').clone().find("input:text").val("").end().appendTo('.clone-inspector-container');
        var content_clone = $('.clone-inspector:first').clone();
        content_clone.find("input:text").val("");
        //content_clone.find(".insp-addr").val();
        content_clone.find(".sel-inspector").val('');
        content_clone.find(".sel-inspector").removeClass("select_address");
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

    $('body').on('click', '.btn-rm-inspector', function() {
        $(this).closest('.clone-inspector').remove();
        var md_val = $('#manday').val();
        var temp = parseInt(md_val) - 1;
        $('#manday').val(temp);
    });

    $('body').on('change', '.sel-added-inspector', function() {
        var dis = $(this);
        console.log(dis.val());
        $.ajax({
            url: '/getinspectoraddress/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                dis.closest('.clone-inspector').find('.added-inspector-address').val(response.address[0]['address']);

            }
        });
        var id = $(this).val();
        var inspection_date = $('#inspection_date').val();
        $.ajax({
            url: '/inspectorassignment/' + id + '/' + inspection_date,
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

    $('body').on('click', '#cbpi_add_inspector', function() {
        var content_clone = $('.cbpi-clone-inspector:first').clone();
        content_clone.find("input:text").val("");
        content_clone.find(".sel-inspector").val('');
        content_clone.find(".sel-inspector").removeClass("select_address");
        content_clone.find(".sel-inspector").removeAttr("id");
        content_clone.find(".sel-inspector").addClass("cbpi-sel-added-inspector");
        content_clone.find(".insp-addr").removeAttr("id");
        content_clone.find(".insp-addr").removeClass("inspector_address");
        content_clone.find(".insp-addr").addClass("cbpi-added-inspector-address");
        content_clone.appendTo('.cbpi-clone-inspector-container');
        $('.cbpi-clone-inspector:last').append('<div class="col-md-12"><button class="btn btn-danger cbpi-btn-rm-inspector" type="button"><i class="fa fa-times"></i> Remove</button><br><br></div>');
        var md_val = $('#cbpi_manday').val();
        var temp = parseInt(md_val) + 1;
        $('#cbpi_manday').val(temp);
    });

    $('body').on('click', '.cbpi-btn-rm-inspector', function() {
        $(this).closest('.cbpi-clone-inspector').remove();
        var md_val = $('#cbpi_manday').val();
        var temp = parseInt(md_val) - 1;
        $('#cbpi_manday').val(temp);
    });

    $('body').on('change', '.cbpi-sel-added-inspector', function() {
        var dis = $(this);
        console.log(dis.val());
        $.ajax({
            url: '/getinspectoraddress/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                dis.closest('.cbpi-clone-inspector').find('.cbpi-added-inspector-address').val(response.address[0]['address']);

            }
        });
        var id = $(this).val();
        var inspection_date = $('#loading_inspection_date').val();
        $.ajax({
            url: '/inspectorassignment/' + id + '/' + inspection_date,
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

    $('body').on('click', '#site_add_inspector', function() {
        var content_clone = $('.site-clone-inspector:first').clone();
        content_clone.find("input:text").val("");
        content_clone.find(".sel-inspector").val('');
        content_clone.find(".sel-inspector").removeClass("select_address");
        content_clone.find(".sel-inspector").removeAttr("id");
        content_clone.find(".sel-inspector").addClass("site-sel-added-inspector");
        content_clone.find(".insp-addr").removeAttr("id");
        content_clone.find(".insp-addr").removeClass("inspector_address");
        content_clone.find(".insp-addr").addClass("site-added-inspector-address");
        content_clone.appendTo('.site-clone-inspector-container');
        $('.site-clone-inspector:last').append('<div class="col-md-12"><button class="btn btn-danger site-btn-rm-inspector" type="button"><i class="fa fa-times"></i> Remove</button><br><br></div>');
        var md_val = $('#cbpi_manday').val();
        var temp = parseInt(md_val) + 1;
        $('#cbpi_manday').val(temp);
    });

    $('body').on('click', '.site-btn-rm-inspector', function() {
        $(this).closest('.site-clone-inspector').remove();
        var md_val = $('#site_manday').val();
        var temp = parseInt(md_val) - 1;
        $('#site_manday').val(temp);
    });

    $('body').on('change', '.site-sel-added-inspector', function() {
        var dis = $(this);
        console.log(dis.val());
        $.ajax({
            url: '/getinspectoraddress/' + dis.val(),
            type: 'GET',
            success: function(response) {
                console.log(response);
                dis.closest('.site-clone-inspector').find('.site-added-inspector-address').val(response.address[0]['address']);

            }
        });
        var id = $(this).val();
        var inspection_date = $('#site_inspection_date').val();
        $.ajax({
            url: '/inspectorassignment/' + id + '/' + inspection_date,
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

    $('body').on('click', '#add_more_client_c_p_cbpi', function() {

        var dis = $(this);

        $('#add_more_contact_container_cbpi').append('<div class="am_cp_parent"><div class="col-md-4">' +
            '<div class="form-group">' +
            '<label>Contact Person</label>' +
            '<select class="form-control psi_required added_contact_persons"  name="contact_person">' +
            '<option value="" selected>Select Contact</option>' +
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
                tis.closest('.am_cp_parent').find('.am_contact_number').val(response.contact.tel_number);
                tis.closest('.am_cp_parent').find('.am_contact_email').val(response.contact.email_address);
            }
        });
    });


    $('body').on('click', '.del_more_client_c_p', function() {
        $(this).closest('.am_cp_parent').remove();
    });


    $('body').on('click', '#btn-psi-submit-draft', function() {

        /* var service = $("#service").val();
        var reference_number = $("#reference_number").val();
        var inspection_date = $("#inspection_date").val();
        var client = $('#client').val();
        var inspector = $('#inspector').val();
        var factory = $('#factory').val();
        var factory_contact_person = $('#factory_contact_person').val();
        var requirement = $('#requirement').val();
        var invisible = $('#invisible').val();
        var template = $('#template').val();
        if (template == "") { template = 0; }
        var client_project_number = $('#client_project_number').val();
        var factory_contact_person2_psi = $('#factory_contact_person2_psi').val();
        var sub_service = $('#sub_service').val();
        if (sub_service == "") { sub_service = "N/A"; }

        var type_of_project = $('input[name=project_type]:checked').val();
        var blank_report_type = $('input[name=blank_report_type]:checked').val();
        var word_template = $('#word_template').val();
        if (blank_report_type == "") { blank_report_type = "N/A"; }
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
            new_contact_person = $('#contact_person').val();
        } else {
            new_contact_person = new_contact_person + ',' + $('#contact_person').val();
        }
        var contact_person = new_contact_person;
        var product_name = [];
        var brand = [];
        var po_number = [];
        var model_no = [];
        var aql_qty = [];
        var aql_normal_level = [];
        var aql_special_level = [];
        var aql_major = [];
        var max_major = [];
        var aql_minor = [];
        var max_minor = [];
        var aql_normal_letter = [];
        var aql_normal_sampsize = [];
        var aql_special_letter = [];
        var aql_special_sampsize = [];

        $('.product_name').each(function(i, obj) {
            var val = $(this).val();
            product_name.push(val);
        });
        $('.brand').each(function(i, obj) {
            var val = $(this).val();
            brand.push(val);
        });
        $('.po_number').each(function(i, obj) {
            var val = $(this).val();
            po_number.push(val);
        });
        $('.model_no').each(function(i, obj) {
            var val = $(this).val();
            model_no.push(val);
        });
        $('.aql_qty').each(function(i, obj) {
            var val = $(this).val();
            aql_qty.push(val);
        });

        $('.aql_normal_level').each(function(i, obj) {
            var val = $(this).val();
            aql_normal_level.push(val);
        });
        $('.aql_special_level').each(function(i, obj) {
            var val = $(this).val();
            aql_special_level.push(val);
        });
        $('.aql_major').each(function(i, obj) {
            var val = $(this).val();
            aql_major.push(val);
        });
        $('.max_major').each(function(i, obj) {
            var val = $(this).val();
            max_major.push(val);
        });
        $('.aql_minor').each(function(i, obj) {
            var val = $(this).val();
            aql_minor.push(val);
        });
        $('.max_minor').each(function(i, obj) {
            var val = $(this).val();
            max_minor.push(val);
        });
        $('.aql_normal_letter').each(function(i, obj) {
            var val = $(this).val();
            aql_normal_letter.push(val);
        });
        $('.aql_normal_sampsize').each(function(i, obj) {
            var val = $(this).val();
            aql_normal_sampsize.push(val);
        });
        $('.aql_special_letter').each(function(i, obj) {
            var val = $(this).val();
            aql_special_letter.push(val);
        });
        $('.aql_special_sampsize').each(function(i, obj) {
            var val = $(this).val();
            aql_special_sampsize.push(val);
        });

        $.ajax({
            url: '/savedraftinspection',
            type: 'POST',
            data: {
                _token: token,
                service: service,
                reference_number: reference_number,
                inspection_date: inspection_date,
                client: client,
                inspector: inspector,
                factory: factory,
                factory_contact_person: factory_contact_person,
                requirement: requirement,
                invisible: invisible,
                template: template,
                client_project_number: client_project_number,
                factory_contact_person2_psi: factory_contact_person2_psi,
                sub_service: sub_service,
                type_of_project: type_of_project,
                word_template: word_template,
                blank_report_type: blank_report_type,
                contact_person: contact_person,
                product_name: product_name,
                brand: brand,
                po_number: po_number,
                model_no: model_no,
                aql_qty: aql_qty,
                aql_normal_level: aql_normal_level,
                aql_special_level: aql_special_level,
                aql_major: aql_major,
                max_major: max_major,
                aql_minor: aql_minor,
                max_minor: max_minor,
                aql_normal_letter: aql_normal_letter,
                aql_normal_sampsize: aql_normal_sampsize,
                aql_special_letter: aql_special_letter,
                aql_special_sampsize: aql_special_sampsize

            },
            beforeSend: function() {
                $('.send-loading ').show();
            },
            success: function(response) {
                $('.send-loading ').hide();
                alert("Draft successfully saved");
                //window.location.href="/panel/1";
                document.location = './panel/' + auth_id;

            },
            error: function(error) {
                console.log(error);
            }
        }); */

    });

    $('body').on('click', '#btn-psi-edit-draft', function() {
        /* var service = $("#service").val();
        var reference_number = $("#reference_number").val();
        var inspection_date = $("#inspection_date").val();
        var client = $('#client').val();
        var edit_inspection_id = $('#edit_inspection_id').val();
        var inspector = $('#inspector').val();
        var factory = $('#factory').val();
        var factory_contact_person = $('#factory_contact_person').val();
        var requirement = $('#requirement').val();
        var memo = $('#memo_psi').val();
        var invisible = $('#invisible').val();
        var template = $('#template').val();
        var client_project_number = $('#client_project_number').val();
        var factory_contact_person2_psi = $('#factory_contact_person2_psi').val();
        var word_template = $('#word_template').val();
        var blank_report_type = $('input[name=blank_report_type]:checked').val();

        var type_of_project = $('input[name=project_type]:checked').val();

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

        var contact_person = new_contact_person;

        var hidden_product_id = [];
        var product_name = [];
        var brand = [];
        var po_number = [];
        var model_no = [];
        var aql_qty = [];
        var aql_normal_level = [];
        var aql_special_level = [];
        var aql_major = [];
        var max_major = [];
        var aql_minor = [];
        var max_minor = [];
        var aql_normal_letter = [];
        var aql_normal_sampsize = [];
        var aql_special_letter = [];
        var aql_special_sampsize = [];

        //new product
        var new_product_name = [];
        var new_brand = [];
        var new_po_number = [];
        var new_model_no = [];
        var new_aql_qty = [];
        var new_aql_normal_level = [];
        var new_aql_special_level = [];
        var new_aql_major = [];
        var new_max_major = [];
        var new_aql_minor = [];
        var new_max_minor = [];
        var new_aql_normal_letter = [];
        var new_aql_normal_sampsize = [];
        var new_aql_special_letter = [];
        var new_aql_special_sampsize = [];



        $('.hidden_product_id').each(function(i, obj) {
            var val = $(this).val();
            hidden_product_id.push(val);
        });

        $('.product_name').each(function(i, obj) {
            var val = $(this).val();
            product_name.push(val);
        });


        $('.brand').each(function(i, obj) {
            var val = $(this).val();
            brand.push(val);
        });

        $('.po_number').each(function(i, obj) {
            var val = $(this).val();
            po_number.push(val);
        });

        $('.model_no').each(function(i, obj) {
            var val = $(this).val();
            model_no.push(val);
        });

        $('.edit_qty').each(function(i, obj) {
            var val = $(this).val();
            aql_qty.push(val);
        });

        $('.aql_normal_level').each(function(i, obj) {
            var val = $(this).val();
            aql_normal_level.push(val);
        });

        $('.aql_special_level').each(function(i, obj) {
            var val = $(this).val();
            aql_special_level.push(val);
        });

        $('.aql_major').each(function(i, obj) {
            var val = $(this).val();
            aql_major.push(val);
        });

        $('.max_major').each(function(i, obj) {
            var val = $(this).val();
            max_major.push(val);
        });

        $('.aql_minor').each(function(i, obj) {
            var val = $(this).val();
            aql_minor.push(val);
        });

        $('.max_minor').each(function(i, obj) {
            var val = $(this).val();
            max_minor.push(val);
        });

        $('.aql_normal_letter').each(function(i, obj) {
            var val = $(this).val();
            aql_normal_letter.push(val);
        });

        $('.aql_normal_sampsize').each(function(i, obj) {
            var val = $(this).val();
            aql_normal_sampsize.push(val);
        });

        $('.aql_special_letter').each(function(i, obj) {
            var val = $(this).val();
            aql_special_letter.push(val);
        });

        $('.aql_special_sampsize').each(function(i, obj) {
            var val = $(this).val();
            aql_special_sampsize.push(val);
        });

        // new product added

        $('.new_product_name').each(function(i, obj) {
            var val = $(this).val();
            new_product_name.push(val);
        });


        $('.new_brand').each(function(i, obj) {
            var val = $(this).val();
            new_brand.push(val);
        });

        $('.new_po_number').each(function(i, obj) {
            var val = $(this).val();
            new_po_number.push(val);
        });

        $('.new_model_no').each(function(i, obj) {
            var val = $(this).val();
            new_model_no.push(val);
        });

        $('.new_aql_qty').each(function(i, obj) {
            var val = $(this).val();
            new_aql_qty.push(val);
        });

        $('.new_aql_normal_level').each(function(i, obj) {
            var val = $(this).val();
            new_aql_normal_level.push(val);
        });


        $('.new_aql_special_level').each(function(i, obj) {
            var val = $(this).val();
            new_aql_special_level.push(val);
        });

        $('.new_aql_major').each(function(i, obj) {
            var val = $(this).val();
            new_aql_major.push(val);
        });

        $('.new_max_major').each(function(i, obj) {
            var val = $(this).val();
            new_max_major.push(val);
        });

        $('.new_aql_minor').each(function(i, obj) {
            var val = $(this).val();
            new_aql_minor.push(val);
        });

        $('.new_max_minor').each(function(i, obj) {
            var val = $(this).val();
            new_max_minor.push(val);
        });

        $('.new_aql_normal_letter').each(function(i, obj) {
            var val = $(this).val();
            new_aql_normal_letter.push(val);
        });

        $('.new_aql_normal_sampsize').each(function(i, obj) {
            var val = $(this).val();
            new_aql_normal_sampsize.push(val);
        });

        $('.new_aql_special_letter').each(function(i, obj) {
            var val = $(this).val();
            new_aql_special_letter.push(val);
        });

        $('.new_aql_special_sampsize').each(function(i, obj) {
            var val = $(this).val();
            new_aql_special_sampsize.push(val);
        });

        if (new_product_name == "") {
            new_product_name = null;
        }

        $.ajax({
            url: '/editpsidraft',
            type: 'POST',
            data: {
                _token: token,
                service: service,
                reference_number: reference_number,
                inspection_date: inspection_date,
                client: client,
                edit_inspection_id: edit_inspection_id,
                inspector: inspector,
                factory: factory,
                factory_contact_person: factory_contact_person,
                requirement: requirement,
                memo: memo,
                template: template,
                client_project_number: client_project_number,
                factory_contact_person2_psi: factory_contact_person2_psi,
                type_of_project: type_of_project,
                word_template: word_template,
                blank_report_type: blank_report_type,
                contact_person: contact_person,
                type_of_project: type_of_project,
                hidden_product_id: hidden_product_id,
                product_name: product_name,
                brand: brand,
                po_number: po_number,
                model_no: model_no,
                aql_qty: aql_qty,
                aql_normal_level: aql_normal_level,
                aql_special_level: aql_special_level,
                aql_major: aql_major,
                max_major: max_major,
                aql_minor: aql_minor,
                max_minor: max_minor,
                aql_normal_letter: aql_normal_letter,
                aql_normal_sampsize: aql_normal_sampsize,
                aql_special_letter: aql_special_letter,
                aql_special_sampsize: aql_special_sampsize,

                new_product_name: new_product_name,
                new_brand: new_brand,
                new_po_number: new_po_number,
                new_model_no: new_model_no,
                new_aql_qty: new_aql_qty,
                new_aql_normal_level: new_aql_normal_level,
                new_aql_special_level: new_aql_special_level,
                new_aql_major: new_aql_major,
                new_max_major: new_max_major,
                new_aql_minor: new_aql_minor,
                new_max_minor: new_max_minor,
                new_aql_normal_letter: new_aql_normal_letter,
                new_aql_normal_sampsize: new_aql_normal_sampsize,
                new_aql_special_letter: new_aql_special_letter,
                new_aql_special_sampsize: new_aql_special_sampsize,

            },
            beforeSend: function() {
                $('.send-loading ').show();
            },
            success: function(response) {
                $('.send-loading ').hide();
                alert("Draft successfully updated");
                location.reload();
                //document.location = '/panel/' + auth_id;

            },
            error: function(error) {
                console.log(error);
            }
        }); */
    });

    $('body').on('click', '#btn-cbpi-submit-draft', function() {

        /* var loading_service = $("#loading_service_inspection").val();
        var loading_reference_number = $("#loading_reference_number").val();
        var loading_inspection_date = $("#loading_inspection_date").val();
        var loading_client = $('#loading_client').val();
        var loading_inspector = $('#loading_inspector').val();
        var loading_factory = $('#loading_factory').val();
        var loading_factory_contact_person = $('#loading_factory_contact_person').val();
        var loading_client_name = $('#loading_client_name').val();
        var loading_supplier_name = $('#loading_supplier_name').val();
        var loading_requirements = $('#loading_requirements').val();
        var loading_template = $('#loading_template').val();
        var client_project_number_cbpi = $('#client_project_number_cbpi').val();
        var factory_contact_person2_cbpi = $('#factory_contact_person2_cbpi').val();
        if (loading_template == "") { loading_template = 0; }

        var type_of_project = $('input[name=project_type_cbpi]:checked').val();
        var blank_report_type = $('input[name=blank_report_type_cbpi]:checked').val();
        var word_template = $('#word_template_cbpi').val();
        if (type_of_project == "") { type_of_project = "N/A"; }
        if (blank_report_type == "") { blank_report_type = "N/A"; }
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


        $.ajax({
            url: '/savedraftinspectioncbpi',
            type: 'POST',
            data: {
                _token: token,
                service: loading_service,
                reference_number: loading_reference_number,
                inspection_date: loading_inspection_date,
                client: loading_client,
                inspector: loading_inspector,
                factory: loading_factory,
                factory_contact_person: loading_factory_contact_person,
                requirement: loading_requirements,
                template: loading_template,
                client_project_number: client_project_number_cbpi,
                factory_contact_person2_psi: factory_contact_person2_cbpi,
                type_of_project: type_of_project,
                word_template: word_template,
                blank_report_type: blank_report_type,
                contact_person: contact_person,
                supplier_name: loading_supplier_name

            },
            beforeSend: function() {
                $('.send-loading ').show();
            },
            success: function(response) {
                $('.send-loading ').hide();
                alert("Draft successfully saved");
                //window.location.href="/panel/1";
                document.location = './panel/' + auth_id;

            },
            error: function(error) {
                console.log(error);
            }
        }); */

    });

    /* $('body').on('click', '#btn-cbpi-edit-draft', function() {

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
            var client_project_number_cbpi = $('#client_project_number_cbpi').val();
            var factory_contact_person2_cbpi = $('#factory_contact_person2_cbpi').val();
            if (loading_template == "") { loading_template = 0; }

            var type_of_project = $('input[name=project_type_cbpi]:checked').val();
            var blank_report_type = $('input[name=blank_report_type_cbpi]:checked').val();
            var word_template = $('#word_template_cbpi').val();
            if (type_of_project == "") { type_of_project = "N/A"; }
            if (blank_report_type == "") { blank_report_type = "N/A"; }
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
                    loading_contact_person: loading_contact_person,
                    loading_inspector: loading_inspector,
                    loading_factory: loading_factory,
                    loading_factory_contact_person: loading_factory_contact_person,
                    loading_requirements: loading_requirements,
                    memo: memo,
                    loading_template: loading_template,
                    client_project_number_cbpi: client_project_number_cbpi,
                    factory_contact_person2_cbpi: factory_contact_person2_cbpi,
                    type_of_project: type_of_project,
                    word_template: word_template,
                    blank_report_type: blank_report_type,
                    contact_person: contact_person,
                    loading_supplier_name: loading_supplier_name

                },
                beforeSend: function() {
                    $('.send-loading ').show();
                },
                success: function(response) {
                    $('.send-loading ').hide();
                    alert("Draft successfully saved");
                    location.reload();

                },
                error: function(error) {
                    console.log(error);
                }
            });
        } else {
            alert("Please fill up the required fields");
        }


    }); */

    /* $('body').on('click', '.btn-cbpi-edit-submit', function() {
        alert("test");
        var cbpi_req = $('.cli_required');
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

        if (count_null == 0 && !$("input[name='project_type_cbpi']:checked").val()) {
            alert("Please choose type of project");
        } else if (count_null == 1 && !$("input[name='project_type_cbpi']:checked").val()) {
            alert("Please choose type of project");
        } else if (count_null > 0) {
            alert("Please fill up the required fields");
        } else {

        }
    }); */

    $('body').on('input', '#cbpi_cli_md_charge, #cbpi_ins_md_charge, #cbpi_ins_travel_cost, #cbpi_ins_hotel_cost, #cbpi_ins_ot_cost, #cbpi_cli_travel_cost, #cbpi_cli_hotel_cost, #cbpi_cli_ot_cost, #cli_md_charge, #ins_md_charge, #ins_travel_cost, #ins_hotel_cost, #ins_ot_cost, #cli_travel_cost, #cli_hotel_cost, #cli_ot_cost', function() {
        this.value = Math.abs(this.value);
    });

    $('body').on('input', '.ins_other_cost_value, .cli_other_cost_value, .cbpi_ins_other_cost_value, .cbpi_cli_other_cost_value', function() {
        this.value = Math.abs(this.value);
    });

});

var psi_template = ['Apparel', 'Automotive', 'Chemical', 'Electronics', 'Furniture', 'Garden', 'Gifts & Promotion', 'Healthcare & Beauty', 'Home Appliances', 'Homeware', 'Hotel Supplies', 'Kitchen Appliances', 'Machinery Parts & Products', 'Multimedia', 'Outdoor & Sports', 'Pet Produkts', 'Printing & Packaging', 'Stationery & Luggage', 'Toys & Recrational Items'];

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

    var psi_sub_servie = ['Garments', 'Foot wears', 'Decorations', 'Shoes', 'Bags and Pouches', 'Gift and Premiums', 'Wallets', 'Purses', 'Belts', 'Hats', 'Gloves', 'Scarves', 'Cosmetics, Fragrances, Personal Care', 'Pillows', 'Towels', 'Cushions', 'Domestics: Bedding, Linens, Table Cloths', 'Apparel', 'Backpacks & Luggage', 'Headwear', 'Jewelry', 'Outerwear', 'Furnitures', 'SDA and Household Appliances', 'Outdoor Products', 'Car Parts', 'Consumer Electronics and Multimedia', 'Sporting / Gym Equipements', 'Cookwares', 'Stools', 'Trolleys', 'Tables', 'Chairs', 'Sofas', 'Automotive', 'Costumes / Role Play', 'Food & Beverage', 'Office Supplies', 'Outdoor Gear', 'Pet Products', 'Toys & Games', 'Video Games'];

    if (type == 'word') {
        $('#template').removeClass("psi_required");
        $('#app_project').val('null');
        $('#word_project').val('word_project');
        $('#div_template').hide();
        var service = $('.service').val();

        if (service == 'psi') {
            $('#blank_report').show();
            $('.word_template').empty();
            $('.word_template').append('<option value="">Select word template</option>');
            psi_template.forEach(element => {
                $('.word_template').append('<option value="' + element + '">' + element + '</option>');
            });
        }

    } else if (type == 'app') {
        $('#template').addClass("psi_required");
        $('#div_template').show();
        $('#blank_report').hide();
        $('.sub_service option').remove();
        $('#app_project').val('app_project');
        $('#word_project').val('null');
    } else {
        $('#template').removeClass("psi_required");
        $('#div_template').hide();
        $('#blank_report').hide();
        $('#app_project').val('null');
        $('#word_project').val('null');
        $('#esprit_project').val('esprit');

    }
}

function changeProjectTypeCbpi(type) {


    if (type == 'word') {
        $('#loading_template').removeClass("cli_required");
        $('#app_project_cbpi').val('null');
        $('#word_project_cbpi').val('word_project');
        $('#project_type_cbpi').val('null');
        $('#div_template_cbpi').hide();

        $('#blank_report_cbpi').hide();
        $('.div_sub_service').hide();
        /* $('.word_template').empty();
        $('.word_template').append('<option value="">Select word template</option>');
        psi_template.forEach(element => {
            $('.word_template').append('<option value="' + element + '">' + element + '</option>');
        }); */
    } else {
        var service = $('.service').val();
        if (service == 'site_visit') {
            $('.div_sub_service').hide();
            $('#blank_report_cbpi').hide();
            $('#app_project_cbpi').val('app_project');
            $('#word_project_cbpi').val('null');
            $('#project_type_cbpi').val('app_project');
            $('#div_template_cbpi').hide();
            $('#loading_template').removeClass("cli_required");
        } else {
            $('#loading_template').addClass("cli_required");
            $('#app_project_cbpi').val('app_project');
            $('#word_project_cbpi').val('null');
            $('#project_type_cbpi').val('app_project');


            $('#div_template_cbpi').show();
            $('.div_sub_service').hide();
            $('#blank_report_cbpi').hide();
            $('.sub_service option').remove();
            $('.sub_service').append($("<option selected disabled>Select Sub-service</option>"));
        }
    }
}

function changeProjectTypeSite(type) {
    if (type == 'word') {
        $('#site_template').removeClass("site_required");
        $('#app_project_site').val('null');
        $('#word_project_site').val('word_project');
        $('#project_type_site').val('null');
        $('#div_template_site').hide();
    } else {
        $('#app_project_site').val('app_project');
        $('#word_project_site').val('null');
        $('#project_type_site').val('app_project');
        $('#div_template_site').hide();
        $('#site_template').removeClass("site_required");

    }
}

function chooseEngReport(type) {
    if (type == 'same_report') {
        $('#eng_rpt_temp').hide();
        $('#report_template').removeClass('psi_required');
        $('#same_report').val('same');
        $('#other_report').val('null');
    } else {
        $('#eng_rpt_temp').show();
        $('#report_template').addClass('psi_required');
        $('#same_report').val('null');
        $('#other_report').val('other');
    }
}