$(document).ready(function() {
    $('.products-list').find('.btn-remove').css('display', 'none');

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
                $.each(response.sub_categories, function(i, element) {
                    sub_cat_arr.push(element.sub_category);
                });
                if (response.orig_sub_categories.length > 0) {
                    $.each(response.orig_sub_categories, function(i, element) {
                        sub_cat_arr.push(element.name);
                    });
                }
                sub_cat_arr.sort();
                $.each(sub_cat_arr, function(i, element) {
                    $('.product_sub_category').append('<option value="' + element + '">' + element + '</option>');
                });
                $('.product_sub_category').append('<option value="Others">Others</option>');
            }
        });
        if (cat_val == 'Others' || cat_val == 'others') {
            $('#modalInputNewCat').modal();
        }
    });


    $('.product_sub_category').on('change', function() {
        var dis = this;
        var sub_cat_val = $(dis).val();
        /* if (sub_cat_val == 'Others' || sub_cat_val == 'others') {
            $('#modalInputNewSubCat').modal();
            console.log('sub_cat product others');
        } */
    });
    $('body').on('click', '.epc', function() {
        var dis = this;
        var sub_cat_class = $(dis).closest('.clone-inputs').find('.epsc');
        $(sub_cat_class).empty();
        $(sub_cat_class).append('<option value="">Select Sub-product Category</option>');
        var cat_val = $(dis).val();
        console.log(cat_val);
        getSubCategory(cat_val, dis);
        if (cat_val == 'Others' || cat_val == 'others') {
            /*  $(this).closest('.div_category').find('.modalCategory').modal('show'); */
        }

    });

    $('body').on('click', '.epsc', function() {
        var dis = this;
        var sub_cat_val = $(dis).val();
        if (sub_cat_val == 'Others' || sub_cat_val == 'others') {
            /* $(this).closest('.div_sub_category').find('.modalSubCategory').modal('show'); */
            console.log('sub_cat product others');
        }
    });


    $('body').on('click', '.btn-add-cat-modal', function() {
        $('#modalInputNewCat').modal();
    });

    $('body').on('click', '.btn-show-cat-modal', function() {
        $(this).closest('.div_category').find('.modalCategory').modal('show');
    });
    $('body').on('click', '.btn-add-sub-cat-modal', function() {
        var dis = this;
        var pval = $(dis).closest('.clone-inputs').find('.epc').val();
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

    $('body').on('click', '.btn-add-sub-cat-modal2', function() {
        var dis = this;
        var pval = $('.product_category').val();
        if (pval == '' || pval == null || pval == 'Others') {
            swal({
                title: "Warning!",
                text: "Please select product category first",
                type: "warning",
            });
        } else {
            $('#modalInputNewSubCat2').modal();
        }

    });

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

    $('#confirmAql').click(function() {
        if ($('#new_inspection_form').valid()) {
            $('#po_qty').val($('#qty').val());
            $('#aqlModal').modal('hide');
        } else {
            alert('Please fill in all fields');
        }
    })

    $('#btn_product').click(function() {

        var add = $('.input-new-prod');
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

            var pr_clone = $('.clone-inputs');
            var clone_count = pr_clone.length;
            console.log('clone_count: ' + clone_count);
            var new_id = 'pclick-' + clone_count;
            var content_clone = $('.clone-inputs:first').clone();
            content_clone.find(".product-click").attr('id', new_id);
            content_clone.find(".col-view-att").hide();
            //product id saved
            content_clone.find(".edit_pid").remove();
            content_clone.find(".epsc_value").remove();
            //product name
            content_clone.find(".product_name").removeClass('s_pname');
            content_clone.find(".product_name").addClass('n_pname');
            content_clone.find(".product_name").val('');
            //category
            content_clone.find(".epc").removeClass('s_pcat');
            content_clone.find(".epc").addClass('n_pcat');
            content_clone.find(".epc").val('');
            //sub category
            content_clone.find(".epsc").removeClass('s_scat');
            content_clone.find(".epsc").addClass('n_scat');
            content_clone.find(".epsc").empty();
            content_clone.find(".epsc").append('<option value="">Select Sub-product Category</option>');
            content_clone.find(".epsc").val('');
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

            content_clone.appendTo('.product-clone');
        }
    });
    ///04-27-2021
    $('#btn_product_new').click(function() {

        var add = $('.input-new-prod');
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

            var pr_clone = $('.clone-inputs');
            var clone_count = pr_clone.length;
            console.log('clone_count: ' + clone_count);
            var new_id = 'pclick-' + clone_count;
            var content_clone = $('.clone-inputs:first').clone();
            content_clone.find(".product-click").attr('id', new_id);
            content_clone.find(".col-view-att").hide();
            //product id saved
            content_clone.find(".edit_pid").remove();
            content_clone.find(".epsc_value").remove();
            //product name
            content_clone.find(".product_name_new").removeClass('s_pname');
            content_clone.find(".product_name_new").addClass('n_pname');
            content_clone.find(".product_name_new").val('');
            //category
            content_clone.find(".epc").removeClass('s_pcat');
            content_clone.find(".epc").addClass('n_pcat');
            content_clone.find(".epc").val('');
            //sub category
            content_clone.find(".epsc").removeClass('s_scat');
            content_clone.find(".epsc").addClass('n_scat');
            content_clone.find(".epsc").empty();
            content_clone.find(".epsc").append('<option value="">Select Sub-product Category</option>');
            content_clone.find(".epsc").val('');
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

            content_clone.appendTo('.product-clone');
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

    $('body').on('click', '.rm-att', function() {
        var id = $(this).data('id');
        var result = confirm("Delete this attachment?");
        if (result) {
            $('.a-' + id).remove();
        }
    });

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
                    dis.closest('.clone-inputs').find('.col-view-att').hide();
                } else {
                    dis.closest('.clone-inputs').find('.col-view-att').show();
                }
            }
        });

    }
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


        var id = $(this).closest('.clone-inputs').find('.product_name').val();
        $('#edit_product_id').val(id);
        $('#editProduct').modal();
    });
    //added 04-14-2021
    $('body').on('click', '.view_prod_attachment_new', function() {
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


        var id = $(this).closest('.clone-inputs').find('.product_name_new').val();
        $('#edit_product_id').val(id);
        $('#editProduct').modal();
    });

    $('body').on('click', '.product-click', function() {
        $('.send-loading').show();
        var dis = this;
        var pc_id = dis.id;
        var client_code = $('#hidden_client_code').val();
        $('.prod-added').remove();
        $.ajax({
            type: "GET",
            url: '/getproductbyclientcode/' + client_code,
            success: function(data) {
                //$('#table_select_product').DataTable();
                $('#table_select_product').DataTable().clear().destroy();

                console.table(data);
                $.each(data.products, function(i, element) {
                    $('#table_select_product > tbody:last-child').append(
                        '<tr class="prod-added">' +
                        '<td >' + element.product_name + '</td>' +
                        '<td >' + element.product_number + '</td>' +
                        '<td >' + element.model_no + '</td>' +
                        '<td>' +
                        '<button class="btn btn-success btn-xs choose-prod"  data-pid="' + element.id + '" data-btnid="' + pc_id + '" type="button"><i class="fa fa-check "></i> Select</button>' +
                        '</td>' +
                        '</tr>');
                });
                $('#modalSelectProduct').modal();
                setTimeout(function() {
                    $('#table_select_product').DataTable();
                    $('.send-loading').hide();
                }, 1000);


            }
        });

    })
    //get supplier product 04-13-2021
    $('body').on('click', '.product-click-new', function() {
        $('.send-loading').show();
        var dis = this;
        var pc_id = dis.id;
        var client_code = $('#hidden_client_code').val();
        $('.prod-added').remove();
        $.ajax({
            type: "GET",
            url: '/getsupplierproductbyclientcode/' + client_code,
            success: function(data) {
                //$('#table_select_product').DataTable();
                $('#table_select_product_new').DataTable().clear().destroy();

                console.table(data);
                $.each(data.products, function(i, element) {
                    $('#table_select_product_new > tbody:last-child').append(
                        '<tr class="prod-added">' +
                        '<td >' + element.product_name + '</td>' +
                        '<td >' + element.brand + '</td>' +
                        '<td >' + element.model_no + '</td>' +
                        '<td>' +
                        '<button class="btn btn-success btn-xs choose-prod-new"  data-pid="' + element.id + '" data-btnid="' + pc_id + '" type="button"><i class="fa fa-check "></i> Select</button>' +
                        '</td>' +
                        '</tr>');
                });
                $('#modalSelectProductNew').modal();
                setTimeout(function() {
                    $('#table_select_product_new').DataTable();
                    $('.send-loading').hide();
                }, 1000);


            }
        });

    })
    $('body').on('click', '.choose-prod', function() {
        var prod_id = $(this).data('pid');
        var btn_id = $(this).data('btnid');
        console.log('prod_id: ' + prod_id + 'btn_id: ' + btn_id);
        $('#' + btn_id).closest('.clone-inputs').find('.product_name').val(prod_id);
        var dis_new = $('#' + btn_id);
        $.ajax({
            url: getproduct,
            type: 'POST',
            data: {
                _token: token,
                product_id: prod_id
            },
            success: function(response) {
                $('#' + btn_id).closest('.clone-inputs').find('.p_unit').val(response.product.product_unit);
                $('#' + btn_id).closest('.clone-inputs').find('.epc').val(response.product.product_category);
                // dis.closest('.clone-inputs').find('.product_sub_category').val(response.product.product_sub_category);
                $('#' + btn_id).closest('.clone-inputs').find('.brand').val(response.product.brand);
                $('#' + btn_id).closest('.clone-inputs').find('.po_number').val('');
                $('#' + btn_id).closest('.clone-inputs').find('.model_no').val(response.product.model_no);
                $('#' + btn_id).closest('.clone-inputs').find('.prod_number').val(response.product.product_number);

                $('#' + btn_id).closest('.clone-inputs').find('.epsc').empty();
                $('#' + btn_id).closest('.clone-inputs').find('.epsc').append('<option value="">Select Sub-product Category</option>');
                var cat_val = $('#' + btn_id).closest('.clone-inputs').find('.epc').val();
                var dis_btn = $('#' + btn_id);
                getSubCategory(cat_val, dis_btn);
                setTimeout(function() {
                    $('#' + btn_id).closest('.clone-inputs').find('.epsc').val(response.product.product_sub_category);
                }, 1000);

                getCountAttachments(prod_id, dis_new);
                var add = $('.input-new-prod');
                for (var i = 0; i < add.length; i++) {
                    $(add[i]).removeAttr("style");
                }
            }

        });

        $('#modalSelectProduct').modal('toggle');
    })
    //select supplier product 04-13-2021
    $('body').on('click', '.choose-prod-new', function() {
        var prod_id = $(this).data('pid');
        var btn_id = $(this).data('btnid');
        console.log('prod_id: ' + prod_id + 'btn_id: ' + btn_id);
        $('#' + btn_id).closest('.clone-inputs').find('.product_name_new').val(prod_id);
        var dis_new = $('#' + btn_id);
        $.ajax({
            url: getproductnew,
            type: 'POST',
            data: {
                _token: token,
                product_id: prod_id
            },
            success: function(response) {
                $('#' + btn_id).closest('.clone-inputs').find('.p_unit').val(response.product.product_unit);
                $('#' + btn_id).closest('.clone-inputs').find('.epc').val(response.product.product_category);
                // dis.closest('.clone-inputs').find('.product_sub_category').val(response.product.product_sub_category);
                $('#' + btn_id).closest('.clone-inputs').find('.brand').val(response.product.brand);
                $('#' + btn_id).closest('.clone-inputs').find('.po_number').val('');
                $('#' + btn_id).closest('.clone-inputs').find('.model_no').val(response.product.model_no);
                $('#' + btn_id).closest('.clone-inputs').find('.prod_number').val(response.product.product_number);

                $('#' + btn_id).closest('.clone-inputs').find('.epsc').empty();
                $('#' + btn_id).closest('.clone-inputs').find('.epsc').append('<option value="">Select Sub-product Category</option>');
                var cat_val = $('#' + btn_id).closest('.clone-inputs').find('.epc').val();
                var dis_btn = $('#' + btn_id);
                getSubCategory(cat_val, dis_btn);
                setTimeout(function() {
                    $('#' + btn_id).closest('.clone-inputs').find('.epsc').val(response.product.product_sub_category);
                }, 1000);

                getCountAttachments(prod_id, dis_new);
                var add = $('.input-new-prod');
                for (var i = 0; i < add.length; i++) {
                    $(add[i]).removeAttr("style");
                }
            }

        });

        $('#modalSelectProductNew').modal('toggle');
    })

    $('body').on('click', '.view_prod_attachment_old', function() {
        var id = $(this).closest('.clone-inputs').find('.product_name').val();
        $('.att_added_row').remove();
        console.log(id);
        $.ajax({
            url: '/getProductPhoto',
            type: 'POST',
            data: {
                id: id,
                _token: token
            },
            success: function(response) {
                console.table(response.productphoto);
                var count_ps = 0,
                    count_td = 0,
                    count_aw = 0,
                    count_sm = 0,
                    count_pd = 0,
                    count_pp = 0;
                $.each(response.productphoto, function(i, element) {
                    var src_path = "http://ticapp.tk/js/dropzone/upload/" + element.photo_category + "/" + element.user_id + "/" + element.file_name;
                    var aid = element.id;
                    if (element.photo_category == 'PS') {
                        count_ps += 1;
                        $('#view_att_ps > tbody:last-child').append(
                            '<tr class="att_added_row a-' + aid + '">' +
                            '<td colspan="3"><a href="' + src_path + '">' + element.file_name + '</a></td>' +
                            '<td class="text-center"><a href="#" class="rm-att"  data-id="' + aid + '"><i class="fa fa-trash "></i></td>' +
                            '</tr>');
                    } else if (element.photo_category == 'TD') {
                        count_td += 1;
                        $('#view_att_td > tbody:last-child').append(
                            '<tr class="att_added_row a-' + aid + '">' +
                            '<td colspan="3"><a href="' + src_path + '">' + element.file_name + '</a></td>' +
                            '<td class="text-center"><a href="#" class="rm-att"  data-id="' + aid + '"><i class="fa fa-trash" ></i></td>' +
                            '</tr>');
                    } else if (element.photo_category == 'AW') {
                        count_aw += 1;
                        $('#view_att_aw > tbody:last-child').append(
                            '<tr class="att_added_row a-' + aid + '">' +
                            '<td colspan="3"><a href="' + src_path + '">' + element.file_name + '</a></td>' +
                            '<td class="text-center"><a href="#" class="rm-att"  data-id="' + aid + '"><i class="fa fa-trash"></i></td>' +
                            '</tr>');
                    } else if (element.photo_category == 'SM') {
                        count_sm += 1;
                        $('#view_att_sm > tbody:last-child').append(
                            '<tr class="att_added_row a-' + aid + '">' +
                            '<td colspan="3"><a href="' + src_path + '">' + element.file_name + '</a></td>' +
                            '<td><a href="#" class="rm-att"  data-id="' + aid + '"><i class="fa fa-trash" ></i></td>' +
                            '</tr>');
                    } else if (element.photo_category == 'PD') {
                        count_pd += 1;
                        $('#view_att_pd > tbody:last-child').append(
                            '<tr class="att_added_row a-' + aid + '">' +
                            '<td colspan="3"><a href="' + src_path + '">' + element.file_name + '</a></td>' +
                            '<td class="text-center"><a href="#" class="rm-att"  data-id="' + aid + '"><i class="fa fa-trash"></i></td>' +
                            '</tr>');
                    } else if (element.photo_category == 'PP') {
                        count_pp += 1;
                        $('#view_att_pp > tbody:last-child').append(
                            '<tr class="att_added_row a-' + aid + '">' +
                            '<td colspan="3"><a href="' + src_path + '">' + element.file_name + '</a></td>' +
                            '<td class="text-center"><a href="#" class="rm-att"  data-id="' + aid + '"><i class="fa fa-trash"></i></td>' +
                            '</tr>');
                    }
                });
                if (count_ps == 0) {
                    $('#view_att_ps > tbody:last-child').append(
                        '<tr class="att_added_row">' +
                        '<td colspan="4">N/A</td>' +
                        '</tr>');
                }
                if (count_td == 0) {
                    $('#view_att_td > tbody:last-child').append(
                        '<tr class="att_added_row">' +
                        '<td colspan="4">N/A</td>' +
                        '</tr>');
                }
                if (count_aw == 0) {
                    $('#view_att_aw > tbody:last-child').append(
                        '<tr class="att_added_row">' +
                        '<td colspan="4">N/A</td>' +
                        '</tr>');
                }
                if (count_sm == 0) {
                    $('#view_att_sm > tbody:last-child').append(
                        '<tr class="att_added_row">' +
                        '<td colspan="4">N/A</td>' +
                        '</tr>');
                }
                if (count_pd == 0) {
                    $('#view_att_pd > tbody:last-child').append(
                        '<tr class="att_added_row">' +
                        '<td colspan="4">N/A</td>' +
                        '</tr>');
                }
                if (count_pp == 0) {
                    $('#view_att_pp > tbody:last-child').append(
                        '<tr class="att_added_row">' +
                        '<td colspan="4">N/A</td>' +
                        '</tr>');
                }
                $('#modalViewAttachment').modal();
            }
        });

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

    $('body').on('click', '.btn-rm-perm', function() {
        var count_prod = $('.product-clone .clone-inputs').length;
        // var sure_delete = confirm("Are you sure you want to delete this product?");
        // var dis_btn = this;
        // if (sure_delete) {
        //     var id = $(this).data('id');
        //     if (id != null || id != 'undefined') {
        //         $.ajax({
        //             url: '/deletedraftproduct/' + id,
        //             type: 'GET',
        //             success: function() {
        //                 alert("Product successfully deleted.");
        //                 $(dis_btn).closest('.clone-inputs').remove();
        //             }
        //         });
        //     } else {
        //         if (count_prod > 1) {
        //             $(this).closest('.clone-inputs').remove();
        //         } else {

        //         }
        //     }


        // } else {

        // }
        var dis_btn = this;
        var id = $(this).data('id');
        //var sure_delete = confirm("Are you sure you want to delete this product?");
        if (count_prod == 1){
            swal("Oops!", "Product can't be empty!, Add new product first before removing old one", "error")
        }else if( confirm("Are you sure you want to delete this product?")){
            if(id != null || id != 'undefined'){
               
                $.ajax({
                    url: '/deletedraftproduct/' + id,
                    type: 'GET',
                    success: function() {
                        alert("Product successfully deleted.");
                        $(dis_btn).closest('.clone-inputs').remove();
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

    $('body').on('click', '.edit-btn-qty-modal', function() {
        $(this).closest('.qty-modal').find('.EditAQLModal').modal('show');

    });
    $('body').on('click', '.edit_qty', function() {
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

        if (service == 'cli' || service == 'cbpi' || service == 'cbpi_serial' || service == 'cbpi_isce' || service == 'physical' || service == 'detail' || service == 'social') {
            $("#mandaySection").removeClass("col-md-6");
            $("#mandaySection").addClass("col-md-4");
            $('.tic_form').hide();
            $('.loading_form').show();
            $('#fri-form').hide();
            $('#spk-form').hide();
            $('.site_form').hide();
            $('#loading_service').val(service);
        } else if (service == 'site_visit') {
            $("#mandaySection").removeClass("col-md-6");
            $("#mandaySection").addClass("col-md-4");
            $('.tic_form').hide();
            $('.loading_form').hide();
            $('#fri-form').hide();
            $('#spk-form').hide();
            $('.site_form').show();
            $('#site_service_inspection').val(service);
        } else if (service == 'SPK') {
            /*  $("#mandaySection").removeClass("col-md-4");
             $("#mandaySection").addClass("col-md-6"); */
            $('#spk-form').show();
            $('#fri-form').hide();
            $('.tic_form').show();
            $('.loading_form').hide();
            $('.site_form').hide();
            $('#service').val(service);


        } else if (service == 'FRI') {
            /*   $("#mandaySection").removeClass("col-md-4");
              $("#mandaySection").addClass("col-md-6"); */
            $('#spk-form').hide();
            $('#fri-form').show();
            $('.tic_form').show();
            $('.tic_form').show();
            $('.loading_form').hide();
            $('.FRI_form').hide();
            $('.site_form').hide();
            $('#service').val(service);


        } else {
            $("#mandaySection").removeClass("col-md-6");
            $("#mandaySection").addClass("col-md-4");
            $('.tic_form').show();
            $('.loading_form').hide();
            $('#fri-form').hide();
            $('#spk-form').hide();
            $('.site_form').hide();
            $('#service').val(service);
        }
    });

    $('body').on('click', '.confirm_aql', function() {
        var dis = $(this);
        dis.closest('.clone-inputs').find('.edit_qty').val(dis.closest('.clone-inputs').find('.edit_aql_qty').val());
        dis.closest('.clone-inputs').find('.EditAQLModal').modal('hide');
        dis.closest('.clone-inputs').find('.edit_qty').removeAttr("style");

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
    })


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
                $.each(response.contacts, function(i, element) {
                    dis.closest('.factory-select').find('.supplier_contact_person').append($("<option></option>").attr("value", element.id).text(element.supplier_contact_person));
                });

                dis.closest('.factory-select').find('.factory option').remove();
                dis.closest('.factory-select').find('.factory').append($("<option selected disabled>Select Factory</option>"));
                $.each(response.factories, function(i, element) {
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


    $('body').on('change', '#new_inspection_form .contact_persons', function() {
        $('#contact_number').removeAttr("style");
        $('#email_address').removeAttr("style");
    })

    $('body').on('change', '#new_inspection_form .factory', function() {
        $('#factory_address').removeAttr("style");
    })
    $('body').on('change', '#new_inspection_form .factory_contact_person', function() {
        $('#factory_contact_number').removeAttr("style");
        $('#factory_email').removeAttr("style");
    })

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
        console.log('choosing product...');
        $.ajax({
            url: getproduct,
            type: 'POST',
            data: {
                _token: token,
                product_id: id
            },
            success: function(response) {
                //dis.closest('.clone-inputs').find('.p_unit').val(response.product.product_unit);
                dis.closest('.clone-inputs').find('.epc').val(response.product.product_category);
                // dis.closest('.clone-inputs').find('.product_sub_category').val(response.product.product_sub_category);
                dis.closest('.clone-inputs').find('.brand').val(response.product.brand);
                dis.closest('.clone-inputs').find('.po_number').val('');
                dis.closest('.clone-inputs').find('.model_no').val(response.product.model_no);
                //dis.closest('.clone-inputs').find('.prod_number').val(response.product.product_number);

                dis.closest('.clone-inputs').find('.epsc').empty();
                dis.closest('.clone-inputs').find('.epsc').append('<option value="">Select Sub-product Category</option>');
                var cat_val = dis.closest('.clone-inputs').find('.epc').val();
                getSubCategory(cat_val, dis)
                setTimeout(function() {
                    dis.closest('.clone-inputs').find('.epsc').val(response.product.product_sub_category);
                }, 1000);
                var pid = $(dis).closest('.clone-inputs').find('.product_name').val();
                getCountAttachments(pid, dis);
                var add = $('.input-new-prod');
                for (var i = 0; i < add.length; i++) {
                    $(add[i]).removeAttr("style");
                }
            }

        });
    });
    //get supplier product name 04-13-2021
    $('body').on('change', '.product_name_new', function() {
        var dis = $(this);
        var id = $(this).val();
        console.log('choosing product...');
        $.ajax({
            url: getproductnew,
            type: 'POST',
            data: {
                _token: token,
                product_id: id
            },
            success: function(response) {
                //dis.closest('.clone-inputs').find('.p_unit').val(response.product.product_unit);
                dis.closest('.clone-inputs').find('.epc').val(response.product.product_category);
                // dis.closest('.clone-inputs').find('.product_sub_category').val(response.product.product_sub_category);
                dis.closest('.clone-inputs').find('.brand').val(response.product.brand);
                dis.closest('.clone-inputs').find('.po_number').val('');
                dis.closest('.clone-inputs').find('.model_no').val(response.product.model_no);
                //dis.closest('.clone-inputs').find('.prod_number').val(response.product.product_number);

                dis.closest('.clone-inputs').find('.epsc').empty();
                dis.closest('.clone-inputs').find('.epsc').append('<option value="">Select Sub-product Category</option>');
                var cat_val = dis.closest('.clone-inputs').find('.epc').val();
                getSubCategory(cat_val, dis)
                setTimeout(function() {
                    dis.closest('.clone-inputs').find('.epsc').val(response.product.product_sub_category);
                }, 1000);
                var pid = $(dis).closest('.clone-inputs').find('.product_name_new').val();
                getCountAttachments(pid, dis);
                var add = $('.input-new-prod');
                for (var i = 0; i < add.length; i++) {
                    $(add[i]).removeAttr("style");
                }
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
            '<input type="number" class="form-control ins_other_cost_value psi_required" name="ins_other_cost_value" onkeyup="Inspector_Total_Cost_New()" value="0">' +
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
            '<input type="number" class="form-control cli_other_cost_value cli_required" name="cli_other_cost_value" onkeyup="Inspector_Total_Cost_New2()" value="0">' +
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


    //site other cost
    $('body').on('click', '#site_add_insp_other_cost', function() {
        $('.site_ins_other_cost_container').append('<div class="site_ins_cost_div"><div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Other Cost Description</label>' +
            '<input type="text" class="form-control site_ins_other_cost_text site_required" placeholder="Enter description cost here">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Cost</label>' +
            '<div class="input-group">' +
            '<input type="number" class="form-control site_ins_other_cost_value site_required">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger site_del_added_insp_cost" type="button">' +
            '<i class="fa fa-times"></i> ' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    });

    $('body').on('click', '.site_del_added_insp_cost', function() {
        $(this).closest('.site_ins_cost_div').remove();

    });

    $('body').on('click', '#site_add_cli_other_cost', function() {
        $('.site_cli_other_cost_container').append('<div class="site_cli_cost_div"><div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Other Cost Description</label>' +
            '<input type="text" class="form-control site_cli_other_cost_text site_required" placeholder="Enter description cost here">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
            '<div class="form-group">' +
            '<label>Cost</label>' +
            '<div class="input-group">' +
            '<input type="number" class="form-control site_cli_other_cost_value site_required">' +
            '<div class="input-group-btn">' +
            '<button class="btn btn-danger site_del_added_cli_cost" type="button">' +
            '<i class="fa fa-times"></i> ' +
            '</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );
    });

    $('body').on('click', '.site_del_added_cli_cost', function() {
        $(this).closest('.site_cli_cost_div').remove();

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


    });

    $('body').on('click', '#site_add_inspector', function() {
        //$('.clone-inspector:first').clone().find("input:text").val("").end().appendTo('.clone-inspector-container');
        var content_clone = $('.clone-inspector-site:first').clone();
        content_clone.find("input:text").val("");
        //content_clone.find(".insp-addr").val();
        content_clone.find(".site-sel-inspector").val('');
        content_clone.find(".site-sel-inspector").removeClass("select_address");
        content_clone.find(".site-sel-inspector").removeAttr("id");
        content_clone.find(".site-sel-inspector").addClass("site-sel-added-inspector");
        content_clone.find(".site-insp-addr").removeAttr("id");
        content_clone.find(".site-insp-addr").removeClass("inspector_address");
        content_clone.find(".site-insp-addr").addClass("site-added-inspector-address");
        content_clone.appendTo('.clone-inspector-container-site');
        $('.clone-inspector-site:last').append('<div class="col-md-12"><button class="btn btn-danger btn-rm-inspector-site" type="button"><i class="fa fa-times"></i> Remove</button><br><br></div>');
        var md_val = $('#site_manday').val();
        var temp = parseInt(md_val) + 1;
        $('#site_manday').val(temp);
    });

    $('body').on('click', '.btn-rm-inspector-site', function() {
        $(this).closest('.clone-inspector-site').remove();
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
                dis.closest('.clone-inspector-site').find('.site-added-inspector-address').val(response.address[0]['address']);

            }
        });
        var id = $(this).val();
        var inspection_date = $('#site_inspection_date').val();


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


    });

    $('body').on('click', '#btn-psi-edit-draft', function() {

    });

    $('body').on('click', '#btn-cbpi-submit-draft', function() {


    });


    $('body').on('input', '#cbpi_cli_md_charge, #cbpi_ins_md_charge, #cbpi_ins_travel_cost, #cbpi_ins_hotel_cost, #cbpi_ins_ot_cost, #cbpi_cli_travel_cost, #cbpi_cli_hotel_cost, #cbpi_cli_ot_cost, #cli_md_charge, #ins_md_charge, #ins_travel_cost, #ins_hotel_cost, #ins_ot_cost, #cli_travel_cost, #cli_hotel_cost, #cli_ot_cost', function() {
        this.value = Math.abs(this.value);
    });

    $('body').on('input', '.ins_other_cost_value, .cli_other_cost_value, .cbpi_ins_other_cost_value, .cbpi_cli_other_cost_value', function() {
        this.value = Math.abs(this.value);
    });

    $('body').on('click', '.btn-contact-person', function() {
        var client_id = $('#hidden_client_code').val();
        $.ajax({
            url: '/getoneclientsbyclibook/' + client_id,
            type: 'GET',
            beforeSend: function() {
                $('.send-loading').show();
            },
            success: function(response) {
                console.log(response);
                $('#div_edit_more_fields_client').empty();
                $.each(response.client_contact_list, function(i, element) {
                    if (element.client_contact_status != 2 || element.client_contact_status != '2') {
                        $('#div_edit_more_fields_client').append('<div id="' + element.id + '"><div class="col-md-12">' +
                            '        <div class="form-group">' +
                            '          <hr/>' +
                            '      </div>' +
                            '    </div>' +
                            '<div class="col-md-4">' +
                            '<div class="form-group">' +
                            '     <label for="update_contact_person">Contact Person</label>' +
                            '    <input type="text" name="update_contact_person" value="' + element.contact_person + '"  id="update_contact_person' + element.id + '" class="form-control update_contact_person" required>' +
                            '    <input type="hidden" name="update_contact_id" value="' + element.id + '"  id="update_contact_id' + element.id + '" class="form-control update_contact_id" required>' +
                            '</div>' +
                            '</div>' +

                            '<div class="col-md-4">' +
                            '  <div class="form-group">' +
                            '      <label for="update_contact_person_email">Contact Person Email</label>' +
                            '      <input type="text" name="update_contact_person_email" value="' + element.email_address + '"  id="update_contact_person_email' + element.id + '" class="form-control update_contact_person_email" required>' +

                            '  </div>' +
                            '</div>' +

                            '<div class="col-md-4">' +
                            '  <div class="form-group">' +
                            '      <label for="update_contact_person_number">Contact Mobile Number</label>' +
                            '       <input type="text" name="update_contact_person_number" value="' + element.contact_number + '"  id="update_contact_person_number' + element.id + '" class="form-control update_contact_person_number" required>' +
                            '  </div>' +
                            '</div>' +

                            '<div class="col-md-4">' +
                            '  <div class="form-group">' +
                            '      <label for="update_contact_tel_number">Contact Telephone Number</label>' +
                            '       <input type="text" name="update_contact_tel_number" value="' + element.tel_number + '"  id="update_contact_tel_number' + element.id + '" class="form-control update_contact_tel_number" required>' +
                            '  </div>' +
                            '</div>' +


                            '   <div class="col-md-4">' +
                            '   <div class="form-group">' +

                            '      <label for="update_client_skype">Skype</label>' +
                            '       <input type="text" id="update_client_skype' + element.id + '" name="update_client_skype" value="' + element.client_skype + '" class="form-control update_client_skype" onkeyup="contacPersonValidator(\'update_client_skype\')">' +
                            '   </div>' +
                            ' </div>' +

                            ' <div class="col-md-4">' +
                            '     <div class="form-group">' +

                            '      <label for="update_client_wechat">We Chat</label>' +
                            '         <input type="text" id="update_client_wechat' + element.id + '" name="update_client_wechat"  value="' + element.client_wechat + '" class="form-control update_client_wechat" onkeyup="contacPersonValidator(\'update_client_wechat\')">' +
                            '     </div>' +
                            '   </div>' +

                            '   <div class="col-md-4">' +
                            '       <div class="form-group">' +

                            '      <label for="update_client_whatsapp">WhatsApp</label>' +
                            '           <input type="text" id="update_client_whatsapp' + element.id + '" name="update_client_whatsapp"  value="' + element.client_whatsapp + '" class="form-control update_client_whatsapp" onkeyup="contacPersonValidator(\'update_client_whatsapp\')">' +
                            '       </div>' +
                            '     </div>' +

                            '     <div class="col-md-4">' +
                            '         <div class="form-group">' +

                            '      <label for="update_client_qqmail">QQ Mail</label>' +
                            '             <input type="text" id="update_client_qqmail' + element.id + '" name="update_client_qqmail"  value="' + element.client_qqmail + '" class="form-control update_client_qqmail" onkeyup="contacPersonValidator(\'update_client_qqmail\')">' +
                            '         </div>' +
                            '       </div> ' +
                            '<div class="col-md-4">' +
                            '<div class="form-group"><br>' +
                            '<button onclick ="updateContactData(' + element.id + ')" type="button"  class="btn btn-primary btn-block btn-rm" style="margin-top:5px;"><i class="fa fa-pencil"></i> Update</button>' +
                            '</div>' +
                            '</div></div>');
                    }
                });
                //$('#updateClient').modal('show');
                $('#contact-person-modal').modal('show');
                $('.send-loading').hide();
            }

        });
    });
    $('body').on('click', '#add_more_contact_person', function() {
        $('#add_more_contact_person').show();
    });
    $('body').on('click', '.btn-cli-factory', function() {
        $('#newFactory').modal('show');
    });
    $('body').on('click', '.btn-supplier', function() {
        $('#newSupplier').modal('show');
    });
    $('body').on('click', '#btn-save-new-cat', function() {
        var add_cat = $('.create_new_cat');
        var count_null = 0;
        for (var i = 0; i < add_cat.length; i++) {
            var data = $(add_cat[i]).val();
            if (data == "") {
                $(add_cat[i]).css("border", "1px solid red");
                count_null += 1;
            } else {
                $(add_cat[i]).removeAttr("style");
            }
        }
        if (count_null == 0) {
            $('.send-loading ').show();
            var request = 'save_category';
            var new_cat_other = $('#new_cat_other').val();
            var new_sub_cat_other = $('#new_sub_cat_other').val();
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
                    swal({
                        title: "Success!",
                        text: "Category successfully added.",
                        type: "success",
                    }, function() {
                        $('#modalInputNewCat').modal('toggle');
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


    $('body').on('click', '#btn-save-new-scat2', function() {
        var add_cat = $('.create_new_scat2');
        var count_null = 0;
        for (var i = 0; i < add_cat.length; i++) {
            var data = $(add_cat[i]).val();
            if (data == "") {
                $(add_cat[i]).css("border", "1px solid red");
                count_null += 1;
            } else {
                $(add_cat[i]).removeAttr("style");
            }
        }
        if (count_null == 0) {
            $('.send-loading ').show();
            var request = 'save_sub_category';
            var category = $('#new_product_category').val();
            var new_sub_cat_other = $('#s_new_sub_cat_other2').val();
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
                    $('.product_sub_category').append('<option value="' + new_sub_cat_other + '">' + new_sub_cat_other + '</option>');
                    $('.product_sub_category').val(new_sub_cat_other);
                    swal({
                        title: "Success!",
                        text: "Category successfully added.",
                        type: "success",
                    }, function() {
                        $('.create_new_scat').each(function() {
                            $(this).val('');
                        });
                        $('#modalInputNewSubCat2').modal('toggle');
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
                    $(dis).closest('.clone-inputs').find('.epc').val(new_cat_other);
                    $(dis).closest('.clone-inputs').find('.epsc').empty();
                    $(dis).closest('.clone-inputs').find('.epsc').append('<option value="">Select Sub-product Category</option>');
                    $(dis).closest('.clone-inputs').find('.epsc').append('<option value="' + new_sub_cat_other + '">' + new_sub_cat_other + '</option>');
                    $(dis).closest('.clone-inputs').find('.epsc').append('<option value="Others">Others</option>');
                    $(dis).closest('.clone-inputs').find('.epsc').val(new_sub_cat_other);

                    swal({
                        title: "Success!",
                        text: "Category successfully added.",
                        type: "success",
                    }, function() {
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

    $('body').on('click', '.btn_save_sub_category', function() {
        var dis = this;
        var category = $(dis).closest('.clone-inputs').find('.epc').val();
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
                    $(dis).closest('.clone-inputs').find('.epsc').append('<option value="' + new_sub_cat_other + '">' + new_sub_cat_other + '</option>');
                    $(dis).closest('.clone-inputs').find('.epsc').val(new_sub_cat_other);
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
            $.each(psi_template, function(i, element) {
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

function chooseEngReportSite(type) {
    if (type == 'same_report') {
        $('#site_eng_rpt_temp').hide();
        $('#site_report_template').removeClass('site_required');
        $('#site_same_report').val('same');
        $('#site_other_report').val('null');
    } else {
        $('#site_eng_rpt_temp').show();
        $('#site_report_template').addClass('site_required');
        $('#site_same_report').val('null');
        $('#site_other_report').val('other');
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
            $.each(response.sub_categories, function(i, element) {
                sub_cat_arr.push(element.sub_category);
            });
            if (response.orig_sub_categories.length > 0) {
                $.each(response.orig_sub_categories, function(i, element) {
                    sub_cat_arr.push(element.name);
                });
            }
            sub_cat_arr.sort();
            $.each(sub_cat_arr, function(i, element) {
                $(dis).closest('.clone-inputs').find('.epsc').append('<option value="' + element + '">' + element + '</option>');
            });
            $(dis).closest('.clone-inputs').find('.epsc').append('<option value="Others">Others</option>');
        }
    });
}