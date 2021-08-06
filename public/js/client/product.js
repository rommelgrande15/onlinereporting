$(document).ready(function() {
    fillCategories();
    //fillProductCategories();

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

    function fillProductCategories() {
        //$('.product_category').find('optgroup').remove();
        $.getJSON("json/categories.json", function(json) {
            $.each(json, function(i, optgroups) {
                $.each(optgroups, function(groupName, options) {
                    var $optgroup = $("<option>", {
                        text: groupName,
                        value: groupName
                    });
                    $optgroup.appendTo('.product_category');
                });
            });
        });
        getSavedCategory();
    }

    function fillProductSubCategories2(cat_val, copy) {
        //dis.closest('.clone-inputs').find('.product_sub_category').val(response.product.product_sub_category);
        console.log('fill:' + cat_val);
        $('#edit_product_sub_category').empty();
        $('#edit_product_sub_category').append('<option value="">Select Sub-product Category</option>');
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
                //response.sub_categories.forEach(element => {
                //    sub_cat_arr.push(element.sub_category);
                //});
                $.each(response.sub_categories, function(i, item) {
                    sub_cat_arr.push(item.sub_category);
                });
                if (response.orig_sub_categories.length > 0) {
                    //response.orig_sub_categories.forEach(element => {
                    //    sub_cat_arr.push(element.name);
                    //});
                    $.each(response.orig_sub_categories, function(i, item) {
                        sub_cat_arr.push(item.name);
                    });
                }
                sub_cat_arr.sort();
                //sub_cat_arr.forEach(element => {
                //    $('#edit_product_sub_category').append('<option value="' + element + '">' + element + '</option>');
                //});
                $.each(sub_cat_arr, function(i, item) {
                    if (copy == 'copy') {
                        $('#copy_product_sub_category').append('<option value="' + item + '">' + item + '</option>');
                    } else {
                        $('#edit_product_sub_category').append('<option value="' + item + '">' + item + '</option>');
                    }


                });
                if (copy == 'copy') {
                    $('#copy_product_sub_category').append('<option value="Others">Others</option>');
                } else {
                    $('#edit_product_sub_category').append('<option value="Others">Others</option>');
                }

            }
        });
    }

    function getSavedCategory() {
        $.ajax({
            url: '/get-saved-category/' + auth_id,
            type: 'GET',
            success: function(response) {
                console.log(response);
                //response.categories.forEach(element => {
                //    $('.product_category').append('<option value="' + element.id + '">' + element.category + '</option>');
                //});
                $.each(response.categories, function(i, item) {
                    $('.product_category').append('<option value="' + item.id + '">' + item.category + '</option>');
                });
            }
        });
    }
    $('body').on('click', '.btn-add-cat-modal', function() {
        $('#modalInputNewCat').modal();
        //$(this).closest('.div-cat-modal').find('.modalSaveCategory').modal('show');
    });
    $('body').on('click', '.btn-add-sub-cat-modal', function() {
        var dis = this;
        var pval = $('#new_product_category').val();
        if (pval == '' || pval == null || pval == 'Others') {
            swal({
                title: "Warning!",
                text: "Please select product category first",
                type: "warning",
            });
        } else {
            $('#modalInputNewSubCat').modal();
        }

    });
    $('body').on('click', '.btn-add-sub-cat-modal-edit', function() {
        var dis = this;
        var pval = $('#edit_product_category').val();
        if (pval == '' || pval == null || pval == 'Others') {
            swal({
                title: "Warning!",
                text: "Please select product category first",
                type: "warning",
            });
        } else {
            $('#modalInputNewSubCatEdit').modal();
        }

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
                //response.sub_categories.forEach(element => {
                //    sub_cat_arr.push(element.sub_category);
                //});
                $.each(response.sub_categories, function(i, item) {
                    sub_cat_arr.push(item.sub_category);
                });
                if (response.orig_sub_categories.length > 0) {
                    //response.orig_sub_categories.forEach(element => {
                    //    sub_cat_arr.push(element.name);
                    //});
                    $.each(response.orig_sub_categories, function(i, item) {
                        sub_cat_arr.push(item.name);
                    });
                }
                sub_cat_arr.sort();
                //sub_cat_arr.forEach(element => {
                //    $('.product_sub_category').append('<option value="' + element + '">' + element + '</option>');
                //});
                $.each(sub_cat_arr, function(i, item) {
                    $('.product_sub_category').append('<option value="' + item + '">' + item + '</option>');
                });
                $('.product_sub_category').append('<option value="Others">Others</option>');
            }
        });

        if (cat_val == 'Others' || cat_val == 'others') {
            $('#modalInputNewCat').modal();
            console.log('product others');
        }
    });
    $('.product_sub_category').on('change', function() {
        var dis = this;
        var sub_cat_val = $(dis).val();
        if (sub_cat_val == 'Others' || sub_cat_val == 'others') {
            $('#modalInputNewSubCat').modal();
            console.log('sub_cat product others');
        }
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
                    $('.product_category').append('<option value="' + new_cat_other + '">' + new_cat_other + '</option>');
                    $('.product_category').val(new_cat_other);
                    $('.product_sub_category').empty();
                    $('.product_sub_category').append('<option value="">Select Sub-product Category</option>');
                    $('.product_sub_category').append('<option value="' + new_sub_cat_other + '">' + new_sub_cat_other + '</option>');
                    $('.product_sub_category').append('<option value="Others">Others</option>');
                    $('.product_sub_category').val(new_sub_cat_other);
                    swal({
                        title: "Success!",
                        text: "Category successfully added.",
                        type: "success",
                    }, function() {
                        $('.create_new_cat').each(function() {
                            $(this).val('');
                        });
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
    $('body').on('click', '#btn-save-new-scat', function() {
        var add_cat = $('.create_new_scat');
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
            var new_sub_cat_other = $('#s_new_sub_cat_other').val();
            var category = $('#new_product_category').val();
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
                    $('#new_product_sub_category').append('<option value="' + new_sub_cat_other + '">' + new_sub_cat_other + '</option>');
                    $('#new_product_sub_category').val(new_sub_cat_other);
                    swal({
                        title: "Success!",
                        text: "Category successfully added.",
                        type: "success",
                    }, function() {
                        $('.create_new_scat').each(function() {
                            $(this).val('');
                        });
                        $('#modalInputNewSubCat').modal('toggle');
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

    $('body').on('click', '#btn-save-new-scat-edit', function() {
        var new_sub_cat_other = $('#s_new_sub_cat_other_edit').val();
        if (new_sub_cat_other != "" || new_sub_cat_other != null) {
            $('.send-loading ').show();
            var request = 'save_sub_category';
            var category = $('#edit_product_category').val();
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
                    $('#edit_product_sub_category').append('<option value="' + new_sub_cat_other + '">' + new_sub_cat_other + '</option>');
                    swal({
                        title: "Success!",
                        text: "Category successfully added.",
                        type: "success",
                    }, function() {
                        $('.create_new_scat').each(function() {
                            $(this).val('');
                        });
                        $('#modalInputNewSubCatEdit').modal('toggle');
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


    /**
     * Apply the same filter to all DataTable instances on a particular page. The
     * function call exactly matches that used by `fnFilter()` so regular expression
     * and individual column sorting can be used.
     *
     * DataTables 1.10+ provides this ability through its new API, which is able to
     * to control multiple tables at a time.
     * `$('.dataTable').DataTable().search( ... )` for example will apply the same
     * filter to all tables on the page. The new API should be used in preference
     * to this older method if at all possible.
     *
     *  @name fnFilterAll
     *  @summary Apply a common filter to all DataTables on a page
     *  @author [Kristoffer Karlström](http://www.kmmtiming.se/)
     *  @deprecated
     *
     *  @param {string} sInput Filtering input
     *  @param {integer} [iColumn=null] Column to apply the filter to
     *  @param {boolean} [bRegex] Regular expression flag
     *  @param {boolean} [bSmart] Smart filtering flag
     *
     *  @example
     *    $(document).ready(function() {
     *      var table = $(".dataTable").dataTable();
     *       
     *      $("#search").keyup( function () {
     *        // Filter on the column (the index) of this element
     *        table.fnFilterAll(this.value);
     *      } );
     *    });
     */

    jQuery.fn.dataTableExt.oApi.fnFilterAll = function(oSettings, sInput, iColumn, bRegex, bSmart) {
        var settings = $.fn.dataTableSettings;

        for (var i = 0; i < settings.length; i++) {
            settings[i].oInstance.fnFilter(sInput, iColumn, bRegex, bSmart);
        }
    };
    /*  $('#inspections_table').DataTable({
         "order": [
             [6, "desc"]
         ],
         "pageLength": 30
     }); */


    var oTable = $('#inspections_table').dataTable({
        "oLanguage": {
            "sSearch": "Search all columns:"
        },
        "order": [
            [3, "desc"]
        ],
        "pageLength": 10
    });

    $('select#engines').change(function() {
        oTable.fnFilter($(this).val());

    });

    //var token = "{{csrf_token()}}";



    var services = {
        'iqi': 'Incoming Quality Inspection',
        'dupro': 'During Production Inspection',
        'psi': 'Pre Shipment Inspection',
        'cli': 'Container Loading Inspection',
    };
    $('body').on('click', '.Copy-client-picture', function() {
        $('#id_copy_prod_spec').val("N/A");
        $('#id_copy_tech_details').val("N/A");
        $('#id_copy_art_work').val("N/A");
        $('#id_copy_shipping_mark').val("N/A");
        $('#id_copy_packing').val("N/A");
        $('#id_copy_photo_files').val("N/A");
        $('#form_copy_prod_spec').hide();
        $('#form_copy_tech_details').hide();
        $('#form_copy_art_work').hide();
        $('#form_copy_shipping_mark').hide();
        $('#form_copy_packing').hide();
        $('#form_copy_photo_files').hide();

        var dis = this;
        $('.send-loading').show();
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: '/get-client-product/' + id,
            type: 'GET',
            beforeSend: function() {
                //$('.send-loading ').show();
            },
            success: function(response) {
                //getphotoData(response.product.id);
                console.log(response);

                /*  $('#copy_product_name').val(response.product.product_name); */
                $('#copy_client_code_product').val(response.product.client_code);
                $('#copy_product_nameHide').val(response.product.product_name);
                $('#copy_product_id').val(response.product.id);
                $('#copy_unit').val(response.product.product_unit);
                $('#copy_po_number').val(response.product.po_no);
                $('#copy_model_number').val(response.product.model_no);
                $('#copy_supplier_item_no').val(response.product.supplier_item_no);
                $('#copy_brand').val(response.product.brand);

                $('#copy_prod_length').val(response.product.product_length);
                $('#copy_prod_width').val(response.product.product_width);
                $('#copy_prod_height').val(response.product.product_height);
                $('#copy_prod_diameter').val(response.product.product_diameter);
                $('#copy_prod_weight').val(response.product.product_weight);
                $('#copy_retail_length').val(response.product.retail_length);
                $('#copy_retail_width').val(response.product.retail_width);
                $('#copy_retail_height').val(response.product.retail_height);
                $('#copy_retail_diameter').val(response.product.retail_diameter);
                $('#copy_retail_weight').val(response.product.retail_weight);
                $('#copy_retail_qty').val(response.product.retail_box_qty);
                $('#copy_inner_length').val(response.product.inner_length);
                $('#copy_inner_width').val(response.product.inner_width);
                $('#copy_inner_height').val(response.product.inner_height);
                $('#copy_inner_diameter').val(response.product.inner_diameter);
                $('#copy_inner_weight').val(response.product.inner_weight);
                $('#copy_inner_qty').val(response.product.inner_box_qty);
                $('#copy_export_length').val(response.product.export_length);
                $('#copy_export_width').val(response.product.export_width);
                $('#copy_export_height').val(response.product.export_height);
                $('#copy_export_diameter').val(response.product.export_diameter);
                $('#copy_export_weight').val(response.product.export_weight);
                $('#copy_export_qty').val(response.product.export_box_qty);
                $('#copy_export_max_weight').val(response.product.export_max_weight_carton);
                $('#copy_export_cbm').val(response.product.export_cbm);
                $('#copy_grd').val(response.product.grd);
                $('#copy_item_desc').val(response.product.item_description);


                $('#copy_additional_product_info').val(response.product.additional_product_info);
                $('#copy_product_category').removeAttr('selected');
                $("#copy_product_category option").filter(function() {
                    return $(this).text() == response.product.product_category;
                }).attr('selected', true);

                fillProductSubCategories2(response.product.product_category, 'copy');
                setTimeout(function() {
                    $('#copy_product_sub_category').val(response.product.product_sub_category);
                }, 1000);
                $('#copyProduct').modal('show');
                $('.send-loading').hide();

            },
            error: function() {
                swal({
                    title: "Error!",
                    text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                    type: "error",
                });
                $('.send-loading').hide();
            }
        });


    });

    $('body').on('click', '.edit-client-picture', function() {
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
        var dis = this;
        $('.send-loading').show();
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: '/get-client-product/' + id,
            type: 'GET',
            beforeSend: function() {
                //$('.send-loading ').show();
            },
            success: function(response) {
                //getphotoData(response.product.id);
                console.log(response);

                $('#edit_product_name').val(response.product.product_name);
                $('#edit_product_nameHide').val(response.product.product_name);
                $('#edit_product_id').val(response.product.id);
                $('#edit_unit').val(response.product.product_unit);
                $('#edit_po_number').val(response.product.po_no);
                $('#edit_model_number').val(response.product.model_no);
                $('#edit_supplier_item_no').val(response.product.supplier_item_no);

                /* $('#edit_length').val(response.product.length);
                $('#edit_width').val(response.product.width);
                $('#edit_height').val(response.product.height);
                $('#edit_diameter').val(response.product.diameter);
                $('#edit_weight').val(response.product.weight);
                $('#edit_max_weight').val(response.product.max_weight_carton);
                $('#edit_carton_length').val(response.product.carton_length);
                $('#edit_carton_width').val(response.product.carton_width);
                $('#edit_carton_height').val(response.product.carton_height);
                $('#edit_carton_cbm').val(response.product.carton_cbm);
                $('#edit_etd').val(response.product.etd);
                $('#edit_eta').val(response.product.eta);
                $('#edit_item_desc').val(response.product.item_description); */

                $('#edit_prod_length').val(response.product.product_length);
                $('#edit_prod_width').val(response.product.product_width);
                $('#edit_prod_height').val(response.product.product_height);
                $('#edit_prod_diameter').val(response.product.product_diameter);
                $('#edit_prod_weight').val(response.product.product_weight);

                $('#edit_retail_length').val(response.product.retail_length);
                $('#edit_retail_width').val(response.product.retail_width);
                $('#edit_retail_height').val(response.product.retail_height);
                $('#edit_retail_diameter').val(response.product.retail_diameter);
                $('#edit_retail_weight').val(response.product.retail_weight);
                $('#edit_retail_qty').val(response.product.retail_box_qty);

                $('#edit_inner_length').val(response.product.inner_length);
                $('#edit_inner_width').val(response.product.inner_width);
                $('#edit_inner_height').val(response.product.inner_height);
                $('#edit_inner_diameter').val(response.product.inner_diameter);
                $('#edit_inner_weight').val(response.product.inner_weight);
                $('#edit_inner_qty').val(response.product.inner_box_qty);

                $('#edit_export_length').val(response.product.export_length);
                $('#edit_export_width').val(response.product.export_width);
                $('#edit_export_height').val(response.product.export_height);
                $('#edit_export_diameter').val(response.product.export_diameter);
                $('#edit_export_weight').val(response.product.export_weight);
                $('#edit_export_qty').val(response.product.export_box_qty);
                $('#edit_export_max_weight').val(response.product.export_max_weight_carton);
                $('#edit_export_cbm').val(response.product.export_cbm);


                $('#edit_grd').val(response.product.grd);
                $('#edit_item_desc').val(response.product.item_description);

                /* $('#edit_product_number').val(response.product.product_number); */
                $('#edit_brand').val(response.product.brand);
                $('#edit_additional_product_info').val(response.product.additional_product_info);
                //$('#edit_product_category').val(response.product.product_category);
                //$('#edit_product_category:selected', this).removeAttr('selected');
                $('#edit_product_category').removeAttr('selected');
                //$("#edit_product_category option:contains(" + response.product.product_category + ")").val();
                $("#edit_product_category option").filter(function() {
                    return $(this).text() == response.product.product_category;
                }).attr('selected', true);

                fillProductSubCategories2(response.product.product_category);
                setTimeout(function() {
                    $('#edit_product_sub_category').val(response.product.product_sub_category);
                }, 1000);
                $('#editProduct').modal('show');
                $('.send-loading').hide();

            },
            error: function() {
                swal({
                    title: "Error!",
                    text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                    type: "error",
                });
                $('.send-loading').hide();
            }
        });

    })

    .on('click', '.delete-product', function() {
        var dis = this;
        $(dis).find('i').removeClass('fa fa-times');
        $(dis).find('i').addClass('fa fa-refresh');
        $(dis).find('i').addClass('fa-loader');
        var id = $(this).data('id');
        var name = $(this).data('name');
        $('#del_prod_id').val(id);
        $('#product_name').val(name);
        $('#deleteProduct').modal();
        $(dis).find('i').removeClass('fa fa-refresh');
        $(dis).find('i').removeClass('fa-loader');
        $(dis).find('i').addClass('fa fa-times');

    })

    .on('click', '.view-product', function() {
        var dis = this;
        $('.send-loading').show();
        var id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: '/get-client-product/' + id,
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('#view_prod_name').text(response.product.product_name);
                $('#view_prod_unit').text(response.product.product_unit);
                $('#view_prod_brand').text(response.product.brand);
                $('#view_model_number').text(response.product.model_no);
                $('#view_supplier_item_no').text(response.product.supplier_item_no);

                $('#view_prod_length').text(response.product.product_length);
                $('#view_prod_width').text(response.product.product_width);
                $('#view_prod_height').text(response.product.product_height);
                $('#view_prod_diameter').text(response.product.product_diameter);
                $('#view_prod_weight').text(response.product.product_weight);

                $('#view_retail_length').text(response.product.retail_length);
                $('#view_retail_width').text(response.product.retail_width);
                $('#view_retail_height').text(response.product.retail_height);
                $('#view_retail_diameter').text(response.product.retail_diameter);
                $('#view_retail_weight').text(response.product.retail_weight);
                $('#view_retail_qty').text(response.product.retail_box_qty);

                $('#view_inner_length').text(response.product.inner_length);
                $('#view_inner_width').text(response.product.inner_width);
                $('#view_inner_height').text(response.product.inner_height);
                $('#view_inner_diameter').text(response.product.inner_diameter);
                $('#view_inner_weight').text(response.product.inner_weight);
                $('#view_inner_qty').text(response.product.inner_box_qty);

                $('#view_export_length').text(response.product.export_length);
                $('#view_export_width').text(response.product.export_width);
                $('#view_export_height').text(response.product.export_height);
                $('#view_export_diameter').text(response.product.export_diameter);
                $('#view_export_weight').text(response.product.export_weight);
                $('#view_export_qty').text(response.product.export_box_qty);
                $('#view_export_max_weight').text(response.product.export_max_weight_carton);
                $('#view_export_cbm').text(response.product.export_cbm);


                $('#view_grd').text(response.product.grd);
                $('#view_item_desc').text(response.product.item_description);

                $('#view_add_info').text(response.product.additional_product_info);
                $('#view_cat').text(response.product.product_category);
                $('#view_sub_cat').text(response.product.product_sub_category);
                /* $('#view_product_number').text(response.product.product_number); */
                getProductPhotos(response.product.id);
                $('#viewProduct').modal('show');
                $('.send-loading').hide();

            },
            error: function() {
                swal({
                    title: "Error!",
                    text: "Error: Server encountered an error. Please try again later or contact our system administrator.",
                    type: "error",
                });
                $('.send-loading').hide();
            }
        });

        $('body').on('click', '#btn_view_log_prod', function() {
            if ($('#view_logistic_prod').hasClass('hidden')) {
                $('#view_logistic_prod').removeClass('hidden');
            } else {
                $('#view_logistic_prod').addClass('hidden');
            }
        })

        $('body').on('click', '#btn_view_log_retail', function() {
            if ($('#view_logistic_retail').hasClass('hidden')) {
                $('#view_logistic_retail').removeClass('hidden');
            } else {
                $('#view_logistic_retail').addClass('hidden');
            }
        })

        $('body').on('click', '#btn_view_log_inner', function() {
            if ($('#view_logistic_inner').hasClass('hidden')) {
                $('#view_logistic_inner').removeClass('hidden');
            } else {
                $('#view_logistic_inner').addClass('hidden');
            }
        })

        $('body').on('click', '#btn_view_log_export', function() {
            if ($('#view_logistic_export').hasClass('hidden')) {
                $('#view_logistic_export').removeClass('hidden');
            } else {
                $('#view_logistic_export').addClass('hidden');
            }
        })

    });






});

function getProductPhotos(pid) {
    var p_cat = {
        'PS': 'view_prod_photos',
        'TD': 'view_prod_spec',
        'AW': 'view_artwork',
        'SM': 'view_ship_mark',
        'PD': 'view_prod_details',
        'PP': 'view_other_photos'
    };
    for (var key in p_cat) {
        value = p_cat[key];
        $('#' + value).empty();
    }
    $.ajax({
        url: '/getProductPhoto',
        type: 'POST',
        data: {
            _token: token,
            id: pid
        },
        success: function(response) {
            console.log(response.productphoto);

            var count = response.productphoto.length;
            var count_ps = 0,
                count_td = 0,
                count_aw = 0,
                count_sm = 0,
                count_pd = 0,
                count_pp = 0;
            //response.productphoto.forEach(element => {
            $.each(response.productphoto, function(i, element) {

                var src_path_origin = "http://ticapp.tk/js/dropzone/upload/"
                var ext = element.file_name.split('.').pop();
                var src_path;
                if (ext == "pdf") {

                    src_path = pdf_icon;



                } else if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1) {

                    src_path = doc_icon;
                } else if (ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1) {

                    src_path = xls_icon;
                } else if (ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1) {

                    src_path = ppt_icon;
                } else if (ext.indexOf("pub") != -1) {

                    src_path = pub_icon;
                } else if (ext.indexOf("rar") != -1) {
                    src_path_origin = src_path_origin + "/" + element.file_name;
                    src_path = rar_icon;
                } else if (ext.indexOf("zip") != -1) {

                    src_path = rar_icon;
                } else {
                    src_path = "http://ticapp.tk/js/dropzone/upload/" + element.photo_category + "/" + element.user_id + "/" + element.file_name;
                }






                if (element.photo_category == 'PS') {
                    count_ps += 1;
                    $('#view_prod_photos').append('<img src="' + src_path + '" style="width:100px; height:100px;"></img></br>');

                    if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1 || ext.indexOf("pub") != -1 || ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1 || ext == "pdf") {

                        $('#view_prod_photos').append('<a target="_blank" href="' + src_path_origin + '/' + element.photo_category + '/' + element.user_id + '/' + element.file_name + '" >View</a></br>');
                    } else {
                        $('#view_prod_photos').append('<a target="_blank" href="' + src_path + '">View</a></br>');
                    }





                } else if (element.photo_category == 'TD') {
                    count_td += 1;
                    $('#view_prod_spec').append('<img src="' + src_path + '" style="width:100px; height:100px;"></img></br>');




                    if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1 || ext.indexOf("pub") != -1 || ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1 || ext == "pdf") {

                        $('#view_prod_spec').append('<a target="_blank" href="' + src_path_origin + '/' + element.photo_category + '/' + element.user_id + '/' + element.file_name + '" >View</a></br>');
                    } else {
                        $('#view_prod_spec').append('<a target="_blank" href="' + src_path + '">View</a></br>');
                    }


                } else if (element.photo_category == 'AW') {
                    count_aw += 1;
                    $('#view_artwork').append('<img src="' + src_path + '" style="width:100px; height:100px;"></img></br>');





                    if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1 || ext.indexOf("pub") != -1 || ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1 || ext == "pdf") {

                        $('#view_artwork').append('<a target="_blank" href="' + src_path_origin + '/' + element.photo_category + '/' + element.user_id + '/' + element.file_name + '" >View</a></br>');
                    } else {
                        $('#view_artwork').append('<a target="_blank" href="' + src_path + '">View</a></br>');
                    }

                } else if (element.photo_category == 'SM') {
                    count_sm += 1;
                    $('#view_ship_mark').append('<img src="' + src_path + '" style="width:100px; height:100px;"></img></br>');



                    if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1 || ext.indexOf("pub") != -1 || ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1 || ext == "pdf") {

                        $('#view_ship_mark').append('<a target="_blank" href="' + src_path_origin + '/' + element.photo_category + '/' + element.user_id + '/' + element.file_name + '" >View</a></br>');
                    } else {
                        $('#view_ship_mark').append('<a target="_blank" href="' + src_path + '">View</a></br>');
                    }

                } else if (element.photo_category == 'PD') {
                    count_pd += 1;
                    $('#view_prod_details').append('<img src="' + src_path + '" style="width:100px; height:100px;"></img></br>');





                    if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1 || ext.indexOf("pub") != -1 || ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1 || ext == "pdf") {

                        $('#view_prod_details').append('<a target="_blank" href="' + src_path_origin + '/' + element.photo_category + '/' + element.user_id + '/' + element.file_name + '" >View</a></br>');
                    } else {
                        $('#view_prod_details').append('<a target="_blank" href="' + src_path + '">View</a></br>');
                    }
                } else if (element.photo_category == 'PP') {
                    count_pp += 1;
                    $('#view_other_photos').append('<img src="' + src_path + '" style="width:100px; height:100px;"></img></br>');



                    if (ext.indexOf("docx") != -1 || ext.indexOf("doc") != -1 || ext.indexOf("xlsx") != -1 || ext.indexOf("xls") != -1 || ext.indexOf("pptx") != -1 || ext.indexOf("ppt") != -1 || ext.indexOf("pub") != -1 || ext.indexOf("rar") != -1 || ext.indexOf("zip") != -1 || ext == "pdf") {

                        $('#view_other_photos').append('<a target="_blank" href="' + src_path_origin + '/' + element.photo_category + '/' + element.user_id + '/' + element.file_name + '" >View</a></br>');
                    } else {
                        $('#view_other_photos').append('<a target="_blank" href="' + src_path + '">View</a></br>');
                    }
                }
            });
            if (count_ps == 0) {
                $('#view_prod_photos').append('<span>N/A</span></br>');
            }
            if (count_td == 0) {
                $('#view_prod_spec').append('<span>N/A</span></br>');
            }
            if (count_aw == 0) {
                $('#view_artwork').append('<span>N/A</span></br>');
            }
            if (count_sm == 0) {
                $('#view_ship_mark').append('<span>N/A</span></br>');
            }
            if (count_pd == 0) {
                $('#view_prod_details').append('<span>N/A</span></br>');
            }
            if (count_pp == 0) {
                $('#view_other_photos').append('<span>N/A</span></br>');
            }
        }
    });
}

function getphotoData(data) {
    console.log(data);
    $.ajax({
        url: '/getProductPhoto',
        type: 'POST',
        data: {
            _token: token,
            id: data
        },
        success: function(response) {
            console.log(response.productphoto);
            /* response.productphoto.forEach(element => {
                
            }); */

        }
    });
}