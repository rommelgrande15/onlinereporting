$(document).ready(function() {

    $('#accounts_table').DataTable({
        "order": [
            [5, "desc"]
        ],
    });

    $('body')
        .on('click', '.btn-edit', function() {
            $.ajax({
                url: '/getoneaccount/' + $(this).data('id'),
                type: 'GET',
                beforeSend: function() {
                    $('.send-loading ').show();
                },
                success: function(response) {
                    $('.send-loading ').hide();
                    $('#update_id').val(response.account.id);
                    $('#update_username').val(response.user.username);
                    $('#update_email').val(response.user.email);
                    $('#update_contact_number').val(response.account.contact_number);
                    $('#update_inspector_name').val(response.account.name);

                    $('#loading_contact_supplier option').remove();
                    $('#loading_contact_supplier').append($('<option value="">Select Contact Person</option>'));
                    var count = response.supplierContactData.length;
                    for (var i = 0; i <= count - 1; i++) {
                        $('#loading_contact_supplier').append('<option value="' + response.supplierContactData[i].id + '" selected>' + response.supplierContactData[i].supplier_contact_person + '</option>');
                    }
                    $('#loading_contact_supplier option[value=' + response.clientContacts.id + ']').attr('selected', 'selected');
                    $('#loading_contact_client option[value=' + response.clientContacts.id + ']').attr('selected', 'selected');
                    $('#update_designation').val(response.account.designation)
                    $('#updateAccountModal').modal();
                },
                error: function(error) {
                    console.log(error);
                    $('.send-loading ').hide();
                    swal({
                        title: "Error!",
                        text: "Someting went wrong. Please try again later",
                        type: "error",
                    });
                }

            });
        })

    .on('click', '.btn-view', function() {
        var dis = this;
        $(dis).find('i').removeClass('fa fa-eye');
        $(dis).find('i').addClass('fa fa-refresh');
        $(dis).find('i').addClass('fa-loader');
        $.ajax({
            url: '/getoneaccountdetail/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);

                $('#view_supp_name').text(response.supplier.supplier_name);
                $('#view_supp_code').text(response.supplier.supplier_code);
                $('#view_supp_address').text(response.supplier.supplier_address);
                $('#view_supp_country').text(response.supplier.supplier_country_name);
                $('#view_supp_city').text(response.supplier.supplier_city);
                $('#view_supp_city_local').text(response.supplier.supplier_local_city);
                $('#view_supp_address_local').text(response.supplier.supplier_address_local);

                $('.factory_added_row').remove();

                $('#table_view_account > tbody:last-child').append('<tr class="factory_added_row" style="background-color:lightgrey"><th colspan="4"><h4>2. Supplier Contact Person</h4></th></tr>');
                var count_suppliercontact = 0;
                //response.contacts.forEach(element => {
                $.each(response.supplierContact, function(i, element) {
                    count_suppliercontact += 1;
                    $('#table_view_account > tbody:last-child').append('<tr class="factory_added_row">' +
                        '<th>Supplier Contact Person ' + count_suppliercontact + ' :</th>' +
                        '<td colspan="3">' + element.supplier_contact_person + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>Supplier Email :</th>' +
                        '<td>' + element.supplier_email + '</td>' +
                        '<th>Mobile Number :</th>' +
                        '<td>' + element.supplier_contact_number + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>Telephone Number :</th>' +
                        '<td>' + element.supplier_tel_number + '</td>' +
                        '<th>Skype :</th>' +
                        '<td>' + element.supplier_contact_skype + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>We Chat :</th>' +
                        '<td>' + element.supplier_contact_wechat + '</td>' +
                        '<th>WhatsApp :</th>' +
                        '<td>' + element.supplier_contact_whatsapp + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>QQ Mail :</th>' +
                        '<td colspan="3">' + element.supplier_contact_qq + '</td>' +
                        '</tr>' +
                        '<tr class="factory_added_row">' +
                        '<td colspan="4"></td>' +
                        '</tr>');
                });
                $('#table_view_account > tbody:last-child').append('<tr class="factory_added_row" style="background-color:lightgrey"><th colspan="4"><h4>3. Client Contact Person</h4></th></tr>');
                var count_contact = 0;
                //response.contacts.forEach(element => {
                $.each(response.supplierClientContact, function(i, element) {
                    count_contact += 1;
                    $('#table_view_account > tbody:last-child').append('<tr class="factory_added_row">' +
                        '<th>Contact Person ' + count_contact + ' :</th>' +
                        '<td colspan="3">' + element.contact_person + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>Email :</th>' +
                        '<td>' + element.email_address + '</td>' +
                        '<th>Mobile Number :</th>' +
                        '<td>' + element.contact_number + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>Telephone Number :</th>' +
                        '<td>' + element.tel_number + '</td>' +
                        '<th>Skype :</th>' +
                        '<td>' + element.client_skype + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>We Chat :</th>' +
                        '<td>' + element.client_wechat + '</td>' +
                        '<th>WhatsApp :</th>' +
                        '<td>' + element.client_whatsapp + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>QQ Mail :</th>' +
                        '<td colspan="3">' + element.client_qqmail + '</td>' +
                        '</tr>' +
                        '<tr class="factory_added_row">' +
                        '<td colspan="4"></td>' +
                        '</tr>');
                });



                $('#viewAccountDetails').modal();
                $(dis).find('i').removeClass('fa fa-refresh');
                $(dis).find('i').removeClass('fa-loader');
                $(dis).find('i').addClass('fa fa-eye');
            }
        })
    })

    .on('click', '.btn-delete', function() {
        $.ajax({
            url: '/getoneaccount/' + $(this).data('id'),
            type: 'GET',
            beforeSend: function() {
                $('.send-loading ').show();
            },
            success: function(response) {
                $('.send-loading ').hide();
                $('#del_account_id').val(response.account.id);
                $('#deleteAccountModal').modal();

            },
            error: function(error) {
                console.log(error);
                $('.send-loading ').hide();
                swal({
                    title: "Error!",
                    text: "Someting went wrong. Please try again later",
                    type: "error",
                });
            }

        });
    })

    .on('click', '.btn-privelege', function() {
        var user_id = $(this).data('id');
        $.ajax({
            url: '/client-getprivelge/' + user_id,
            type: 'GET',
            beforeSend: function() {
                $('.send-loading ').show();
            },
            success: function(response) {
                console.log(response);
                $('#user_id_priv').val(user_id);
                if (!$.trim(response.privelege)) {
                    console.log('empty');
                    $('#priv_create_order').prop('checked', false);
                    $('#priv_edit_order').prop('checked', false);
                    $('#priv_copy_order').prop('checked', false);
                    $('#priv_cancel_order').prop('checked', false);
                    $('#priv_del_order').prop('checked', false);
                    $('#priv_create_suppl').prop('checked', false);
                    $('#priv_update_suppl').prop('checked', false);
                    $('#priv_del_suppl').prop('checked', false);
                    $('#priv_create_fact').prop('checked', false);
                    $('#priv_update_fact').prop('checked', false);
                    $('#priv_del_fact').prop('checked', false);
                    $('#priv_create_prod').prop('checked', false);
                    $('#priv_update_prod').prop('checked', false);
                    $('#priv_del_prod').prop('checked', false);

                    $('#priv_create_order').val('no');
                    $('#priv_edit_order').val('no');
                    $('#priv_copy_order').val('no');
                    $('#priv_cancel_order').val('no');
                    $('#priv_del_order').val('no');
                    $('#priv_create_suppl').val('no');
                    $('#priv_update_suppl').val('no');
                    $('#priv_del_suppl').val('no');
                    $('#priv_create_fact').val('no');
                    $('#priv_update_fact').val('no');
                    $('#priv_del_fact').val('no');
                    $('#priv_create_prod').val('no');
                    $('#priv_update_prod').val('no');
                    $('#priv_del_prod').val('no');

                } else {
                    $('#priv_create_order').val(response.privelege.create_order);
                    $('#priv_edit_order').val(response.privelege.edit_order);
                    $('#priv_copy_order').val(response.privelege.copy_order);
                    $('#priv_cancel_order').val(response.privelege.cancel_order);
                    $('#priv_del_order').val(response.privelege.delete_order);
                    //create
                    if (response.privelege.create_order == "yes") {
                        $('#priv_create_order').prop('checked', true);
                        $('#priv_create_order').val('yes');
                    } else {
                        $('#priv_create_order').prop('checked', false);
                        $('#priv_create_order').val('no');
                    }
                    //edit
                    if (response.privelege.edit_order == 'yes') {
                        $('#priv_edit_order').prop('checked', true);
                        $('#priv_edit_order').val('yes');
                    } else {
                        $('#priv_edit_order').prop('checked', false);
                        $('#priv_edit_order').val('no');
                    }
                    //copy
                    if (response.privelege.copy_order == 'yes') {
                        $('#priv_copy_order').prop('checked', true);
                        $('#priv_copy_order').val('yes');
                    } else {
                        $('#priv_copy_order').prop('checked', false);
                        $('#priv_copy_order').val('no');
                    }
                    //cancel
                    if (response.privelege.cancel_order == 'yes') {
                        $('#priv_cancel_order').prop('checked', true);
                        $('#priv_cancel_order').val('yes');
                    } else {
                        $('#priv_cancel_order').prop('checked', false);
                        $('#priv_cancel_order').val('no');
                    }
                    //delete
                    if (response.privelege.delete_order == 'yes') {
                        $('#priv_del_order').prop('checked', true);
                        $('#priv_del_order').val('yes');
                    } else {
                        $('#priv_del_order').prop('checked', false);
                        $('#priv_del_order').val('no');
                    }

                    $('#priv_create_suppl').val(response.privelege.create_supplier);
                    $('#priv_update_suppl').val(response.privelege.update_supplier);
                    $('#priv_del_suppl').val(response.privelege.delete_supplier);
                    $('#priv_create_fact').val(response.privelege.create_factory);
                    $('#priv_update_fact').val(response.privelege.update_factory);
                    $('#priv_del_fact').val(response.privelege.delete_factory);
                    //create supplier
                    if (response.privelege.create_supplier == 'yes') {
                        $('#priv_create_suppl').prop('checked', true);
                        $('#priv_create_suppl').val('yes');
                    } else {
                        $('#priv_create_suppl').prop('checked', false);
                        $('#priv_create_suppl').val('no');
                    }
                    //edit supplier
                    if (response.privelege.update_supplier == 'yes') {
                        $('#priv_update_suppl').prop('checked', true);
                        $('#priv_update_suppl').val('yes');
                    } else {
                        $('#priv_update_suppl').prop('checked', false);
                        $('#priv_update_suppl').val('no');
                    }
                    //delete supplier
                    if (response.privelege.delete_supplier == 'yes') {
                        $('#priv_del_suppl').prop('checked', true);
                        $('#priv_del_suppl').val('yes');
                    } else {
                        $('#priv_del_suppl').prop('checked', false);
                        $('#priv_del_suppl').val('no');
                    }
                    //create factory
                    if (response.privelege.create_factory == 'yes') {
                        $('#priv_create_fact').prop('checked', true);
                        $('#priv_create_fact').val('yes');
                    } else {
                        $('#priv_create_fact').prop('checked', false);
                        $('#priv_create_fact').val('no');
                    }
                    //update factory
                    if (response.privelege.update_factory == 'yes') {
                        $('#priv_update_fact').prop('checked', true);
                        $('#priv_update_fact').val('yes');
                    } else {
                        $('#priv_update_fact').prop('checked', false);
                        $('#priv_update_fact').val('no');
                    }
                    //delete factory
                    if (response.privelege.delete_factory == 'yes') {
                        $('#priv_del_fact').prop('checked', true);
                        $('#priv_del_fact').val('yes');
                    } else {
                        $('#priv_del_fact').prop('checked', false);
                        $('#priv_del_fact').val('no');
                    }

                    $('#priv_create_prod').val(response.privelege.create_product);
                    $('#priv_update_prod').val(response.privelege.update_product);
                    $('#priv_del_prod').val(response.privelege.delete_product);
                    //create product
                    if (response.privelege.create_product == 'yes') {
                        $('#priv_create_prod').prop('checked', true);
                        $('#priv_create_prod').val('yes');
                    } else {
                        $('#priv_create_prod').prop('checked', false);
                        $('#priv_create_prod').val('no');
                    }
                    //edit product
                    if (response.privelege.update_product == 'yes') {
                        $('#priv_update_prod').prop('checked', true);
                        $('#priv_update_prod').val('yes');
                    } else {
                        $('#priv_update_prod').prop('checked', false);
                        $('#priv_update_prod').val('no');
                    }
                    //delete product
                    if (response.privelege.delete_product == 'yes') {
                        $('#priv_del_prod').prop('checked', true);
                        $('#priv_del_prod').val('yes');
                    } else {
                        $('#priv_del_prod').prop('checked', false);
                        $('#priv_del_prod').val('no');
                    }
                }

                $('.send-loading ').hide();
                $('#privelegeModal').modal();

            },
            error: function(error) {
                console.log(error);
                $('.send-loading ').hide();
                swal({
                    title: "Error!",
                    text: "Someting went wrong. Please try again later",
                    type: "error",
                });
            }

        });
    })

    //ADDED BY ROMMEL 04/16/2021 FOR UPDATE EMAIL NOTIFICATIONS AND REPORT ACCESS ONLINE //
    .on('click', '.btn-email-notify', function() {
        $.ajax({
            url: '/getoneaccountemail/' + $(this).data('id'),
            type: 'GET',
            beforeSend: function() {
                $('.send-loading ').show();
            },

            success: function(response) {
                $('.send-loading ').hide();
                $('#update_id_email').val(response.supplierInfo.id);
                $('#update_username_email').val(response.user.username);
                $('#update_supplierName_email').val(response.supplierData.supplier_name);
                $('#update_usernameSupplier_email').val(response.user.email);
                $('#update_email_reciever').val(response.supplierInfo.email_reciever);
                if (response.supplierInfo.email_reciever === 1) {
                    document.getElementById("update_email_reciever1").checked = true;
                    $('#update_email_value').val('Enabled');
                } else {
                    document.getElementById("update_email_reciever2").checked = true;
                    $('#update_email_value').val('Disabled');
                }
                $('#updateEmailNotifications').modal();
            },
            error: function(error) {
                console.log(error);
                $('.send-loading ').hide();
                swal({
                    title: "Error!",
                    text: "Someting went wrong. Please try again later",
                    type: "error",
                });
            }

        });
    })

    .on('click', '.btn-report-access', function() {
        $.ajax({
            url: '/getoneaccountemail/' + $(this).data('id'),
            type: 'GET',
            beforeSend: function() {
                $('.send-loading ').show();
            },

            success: function(response) {
                $('.send-loading ').hide();
                $('#update_id_access').val(response.supplierInfo.id);
                $('#update_username_access').val(response.user.username);
                $('#update_supplierName_access').val(response.supplierData.supplier_name);
                $('#update_report_access').val(response.supplierInfo.report_access);
                if (response.supplierInfo.report_access === 1) {
                    document.getElementById("update_report_access1").checked = true;
                    $('#update_access_value').val('Enabled');
                } else {
                    document.getElementById("update_report_access2").checked = true;
                    $('#update_access_value').val('Disabled');
                }
                $('#updateReportAccess').modal();
            },
            error: function(error) {
                console.log(error);
                $('.send-loading ').hide();
                swal({
                    title: "Error!",
                    text: "Someting went wrong. Please try again later",
                    type: "error",
                });
            }

        });
    })

    .on('click', '.btn-no-email', function() {
        $.ajax({
            url: '/getoneaccountemail/' + $(this).data('id'),
            type: 'GET',
            beforeSend: function() {
                $('.send-loading ').show();
            },

            success: function(response) {
                $('.send-loading ').hide();
                $('#update_id_noemail').val(response.supplierInfo.id);
                $('#update_username_noemail').val(response.user.username);
                $('#update_usernameSupplier_noemail').val(response.supplierData.supplier_name);
                $('#update_email_noemail').val(response.user.email);
                $('#update_report_noemail').val(response.supplierInfo.no_email);
                if (response.supplierInfo.no_email === 1) {
                    document.getElementById("update_no_email1").checked = true;
                    $('#update_noemail_value').val('Enabled');
                } else {
                    document.getElementById("update_no_email2").checked = true;
                    $('#update_noemail_value').val('Disabled');
                }
                $('#updateNoEmail').modal();
            },
            error: function(error) {
                console.log(error);
                $('.send-loading ').hide();
                swal({
                    title: "Error!",
                    text: "Someting went wrong. Please try again later",
                    type: "error",
                });
            }

        });
    })

});