$(document).ready(function() {






    $('#factories_table').DataTable(

        {
            "oLanguage": {
                "sSearch": "Search all columns:"
            },
            "order": [
                [3, "desc"]
            ]
        }


    );
    $('#contacts_table').DataTable();
    $('body')
        .on('click', '.btn-edit', function() {
            var dis = this;
            $(dis).find('i').removeClass('fa fa-pencil');
            $(dis).find('i').addClass('fa fa-refresh');
            $(dis).find('i').addClass('fa-loader');
            $.ajax({
                url: '/getonesupplierwithaccount/' + $(this).data('id'),
                type: 'GET',
                success: function(response) {
                    console.log(response);

                    $('#div_edit_more_fields').empty();
                    //response.contacts.forEach(element => {
                    $.each(response.contacts, function(i, element) {
                        if (element.supplier_contact_status != 2 || element.supplier_contact_status != '2') {
                            console.log(element.supplier_contact_person);
                            $('#div_edit_more_fields').append('<div id="' + element.id + '"><div class="col-md-12">' +
                                '        <div class="form-group">' +
                                '          <hr/>' +
                                '      </div>' +
                                '    </div>' +
                                '    <div class="col-md-12">' +
                                '      <div class="form-group">    ' +
                                '        <h4 class="modal-title">Supplier Contact Person</h4>' +
                                '      </div>' +
                                '    </div>' +

                                '    <div class="col-md-4">      ' +
                                '      <div class="form-group">' +
                                '          <label for="update_contact_person">Contact Person</label>' +
                                '          <input type="text" name="update_contact_person" value="' + element.supplier_contact_person + '" onchange="test2()" id="update_contact_person' + element.id + '" class="form-control update_contact_person validate_input" required>' +

                                '      </div>' +
                                '    </div>' +
                                '    ' +
                                '    <div class="col-md-4">' +
                                '      <div class="form-group">' +
                                '          <label for="update_contact_person_email">Email Address</label>' +
                                '          <input type="email" name="update_contact_person_email" value="' + element.supplier_email + '" onchange="test2()" id="update_contact_person_email' + element.id + '" class="form-control update_contact_person_email validate_input_email" required>' +

                                '      </div>' +
                                '    </div>' +

                                '    <div class="col-md-4">' +
                                '      <div class="form-group">' +
                                '          <label for="update_contact_person_number">Mobile Number</label>' +
                                '          <input type="text" name="update_contact_person_number" value="' + element.supplier_contact_number + '" onchange="test2()" id="update_contact_person_number' + element.id + '" class="form-control numeric update_contact_person_number validate_input" required>' +

                                '      </div>' +
                                '    </div>' +

                                '    <div class="col-md-4">' +
                                '      <div class="form-group">' +
                                '          <label for="update_contact_tel_person_number">Telephone Number</label>' +
                                '          <input type="text" name="update_contact_tel_person_number" value="' + element.supplier_tel_number + '" onchange="test2()" id="update_contact_tel_person_number' + element.id + '" class="form-control numeric update_contact_tel_person_number validate_input" required>' +

                                '      </div>' +
                                '    </div>' +


                                '    <div class="col-md-4">' +
                                '        <div class="form-group">' +
                                '            <label for="update_contact_skype">Skype</label>' +
                                '            <input type="text" name="update_contact_skype" value="' + element.supplier_contact_skype + '"  id="update_contact_skype' + element.id + '" class="form-control update_contact_skype" required>' +

                                '        </div>' +
                                '      </div>' +

                                '      <div class="col-md-4">' +
                                '          <div class="form-group">' +
                                '              <label for="update_contact_wechat">We Chat</label>' +
                                '              <input type="text" name="update_contact_wechat"  value="' + element.supplier_contact_wechat + '" id="update_contact_wechat' + element.id + '" class="form-control update_contact_wechat" required>' +

                                '          </div>' +
                                '        </div>' +
                                '    ' +
                                '        <div class="col-md-4">' +
                                '            <div class="form-group">' +
                                '                <label for="update_contact_whatsapp">WhatsApp</label>' +
                                '                <input type="text" name="update_contact_whatsapp" value="' + element.supplier_contact_whatsapp + '" id="update_contact_whatsapp' + element.id + '" class="form-control update_contact_whatsapp" required>' +

                                '            </div>' +
                                '          </div>' +

                                '          <div class="col-md-4">' +
                                '              <div class="form-group">' +
                                '                  <label for="update_contact_qqmail">QQ Mail</label>' +
                                '                  <input type="text" name="update_contact_qqmail"  value="' + element.supplier_contact_qq + '" id="update_contact_qqmail' + element.id + '" class="form-control update_contact_qqmail" required>' +

                                '              </div>' +
                                '            </div>' +
                                '          <div class="col-md-1">' +
                                '              <div class="form-group">' +
                                '          <input type="hidden" name="hidden_contact_id" id="IdcontactFactory" class="IdcontactFactory" value="' + element.id + '">' +


                                '              </div>' +
                                '            </div>' +
                                '<div class="col-md-4">' +
                                '<div class="form-group"><br>' +
                                '<button onclick ="deleteFactoryCP(' + element.id + ')" type="button"  class="btn btn-danger btn-rm update_Client_data btn-block" style="margin-top:-10px;"><i class="fa fa-times"></i> Delete</button>' +
                                '</div>' +
                                '</div> </div>');

                        }

                    });


                    $('#update_factory_id').val(response.supplier.id);
                    $('#update_client_code').val(response.supplier.client_code);
                    $('#update_factory_name').val(response.supplier.supplier_name);
                    $('#update_factory_code').val(response.supplier.supplier_code);
                    $('#update_factory_number').val(response.supplier.supplier_number);
                    $('#update_factory_address').val(response.supplier.supplier_address);
                    $('#update_factory_address_local').val(response.supplier.supplier_address_local);
                    $('#update_factory_country').val(response.supplier.supplier_country);
                    $('#update_factory_city').val(response.supplier.supplier_city);

                    $('#update_factory_city_local').val(response.supplier.supplier_local_city);

                    $('#update_factory_address_local').val(response.supplier.supplier_local_address);

                    $('#update_country_id').val(response.supplier.supplier_country);
                    $('#update_state_id').val(response.supplier.supplier_state);
                    $('#update_city_id').val(response.supplier.supplier_city);

                    if (response.withAccount == "true") {
                        $('#update_id').val(response.account.id);
                        $('#update_username').val(response.user.username);
                        $('#update_email').val(response.user.email);
                        $('#update_contact_number').val(response.account.contact_number);
                        $('#update_account_name').val(response.account.name);
                        //$('#loading_contact_supplier option[value=' + response.supplierContactData.id + ']').attr('selected', 'selected');
                        $('#loading_contact_supplier option').remove();
                        $('#loading_contact_supplier').append($('<option value="">Select Contact Person</option>'));
                        var count = response.supplierContactData.length;
                        for (var i = 0; i <= count - 1; i++) {
                            $('#loading_contact_supplier').append('<option value="' + response.supplierContactData[i].id + '" selected>' + response.supplierContactData[i].supplier_contact_person + '</option>');
                        }
                        $('#loading_contact_client option[value=' + response.clientContacts.id + ']').attr('selected', 'selected');
                        $("#SupplierAccountViewBtnEdit").prop("checked", false);
                        document.getElementById("SupplierAccountViewBtnEdit").removeAttribute("disabled");
                        $('#AccountSupplierViewPanelEdit').hide();
                    } else if (response.withAccount == "false") {
                        $('#update_id').removeClass("validate_input");
                        $('#update_username').removeClass("validate_input");
                        $('#update_email').removeClass("validate_input");
                        $('#update_contact_number').removeClass("validate_input");
                        $('#update_account_name').removeClass("validate_input");
                        $('#loading_contact_supplier').removeClass("validate_input");
                        $('#loading_contact_client').removeClass("validate_input");
                        $("#SupplierAccountViewBtnEdit").prop("checked", false);
                        document.getElementById("SupplierAccountViewBtnEdit").setAttribute("disabled", "disabled");
                        $('#edit_supplier_account').hide();
                        $('#AccountSupplierViewPanelEdit').hide();
                    }



                    //$('#update_contact_person').val(response.supplier.factory_contact_person);
                    //$('#update_contact_person_email').val(response.supplier.factory_email);
                    //$('#update_contact_person_number').val(response.supplier.factory_contact_number);
                    //$('#hidden_contact_id').val(response.supplier.factory_contact_id);

                    //$('#update_contact_skype').val(response.supplier.factory_contact_skype);
                    //$('#update_contact_wechat').val(response.supplier.factory_contact_wechat);
                    //$('#update_contact_whatsapp').val(response.supplier.factory_contact_whatsapp);
                    //$('#update_contact_qqmail').val(response.supplier.factory_contact_qq);

                    $('#updateSupplier').modal('show');

                    showAllCountryUpdate(response.supplier.supplier_country);
                    showStateByCountryUpdate(response.supplier.supplier_country, response.supplier.supplier_state_id);
                    showCityByCountryAndStateUpdate(response.supplier.supplier_country, response.supplier.supplier_state_id, response.supplier.supplier_city_id);
                    //$('#update_factory_city').val(response.factory_state);
                    $('#update_factory_state').val(response.supplier.supplier_state);
                    $('#update_factory_state_id').val(response.supplier.supplier_state_id);

                    //$("#update_factory_country").attr("onchange", "showStateByCountryChange()");
                    //$("#update_factory_state").attr("onchange", "showCityByCountryAndStateChange()");
                    $(dis).find('i').removeClass('fa fa-refresh');
                    $(dis).find('i').removeClass('fa-loader');
                    $(dis).find('i').addClass('fa fa-pencil');
                }

            });
        })

    .on('click', '.btn-view', function() {
        var dis = this;
        $(dis).find('i').removeClass('fa fa-eye');
        $(dis).find('i').addClass('fa fa-refresh');
        $(dis).find('i').addClass('fa-loader');
        $.ajax({
            url: '/getonesupplier/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);

                $('#view_fac_addr_eng').text(response.supplier.supplier_address);
                $('#view_fac_addr_locall').text(response.supplier.supplier_local_city);
                $('#view_fac_addr_llcaol').text(response.supplier.supplier_local_address);


                $('#view_fac_name').text(response.supplier.supplier_name);
                $('#view_fac_code').text(response.supplier.supplier_code);
                $('#view_fac_number').text(response.supplier.supplier_number);
                $('#view_fac_addr_local').text(response.supplier.supplier_country_name);
                //var fac_addr = response.supplier.supplier_city + ', ' + response.supplier.supplier_state + ', ' + response.supplier.supplier_country_name;
                $('#view_fac_addr').text(response.supplier.supplier_city);
                $('.factory_added_row').remove();
                $('#table_view_factory > tbody:last-child').append('<tr class="factory_added_row" style="background-color:lightgrey"><th colspan="4"><h4>2. Supplier Contact Person</h4></th></tr>');
                var count_contact = 0;
                //response.contacts.forEach(element => {
                $.each(response.contacts, function(i, element) {
                    count_contact += 1;
                    $('#table_view_factory > tbody:last-child').append('<tr class="factory_added_row">' +
                        '<th>Contact Person ' + count_contact + ' :</th>' +
                        '<td colspan="3">' + element.supplier_contact_person + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>Email :</th>' +
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

                $('#viewSupplierDetails').modal();
                $(dis).find('i').removeClass('fa fa-refresh');
                $(dis).find('i').removeClass('fa-loader');
                $(dis).find('i').addClass('fa fa-eye');
            }
        })
    })

    .on('click', '.btn-add-factory', function() {
        var dis = this;
        $(dis).find('i').addClass('fa fa-refresh');
        $(dis).find('i').addClass('fa-loader');
        $.ajax({
            url: '/getonesupplierforfactory/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);

                $('#supplier').val(response.supplier.id);
                $('#factory_count').val(response.factoryValue);
                var fc = response.factoryValue;
                if (fc == 0) {
                    // $('#chckBox').show();
                    $("#check_supplier").prop('checked', false);
                    $("#check_supplier").attr('disabled', false);
                } else if (fc > 0) {
                    // $('#chckBox').hide();
                    $("#check_supplier").prop('checked', false);
                    $("#check_supplier").attr('disabled', 'disabled');
                }
                $('#newFactory').modal();
            }
        })
    })



    .on('click', '.btn-add', function() {
        $.ajax({
            url: '/getonesupplier/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('#add_contact_for').text(response.factory_name);
                $('#hidden_client_code').val(response.client_code);
                $('#hidden_factory_id').val(response.factory_id);
                $('#viewFactoryDetails').modal('toggle');
                $('#addFactoryContactPerson').modal();
            }
        });
    })

    .on('click', '.btn-delete', function() {
        var dis = this;
        $(dis).find('i').removeClass('fa fa-times');
        $(dis).find('i').addClass('fa fa-refresh');
        $(dis).find('i').addClass('fa-loader');
        $.ajax({
            url: '/getonesupplier/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                $('#del_factory_name').val(response.supplier.supplier_name);
                $('#del_factory_id').val(response.supplier.id);
                $('#deleteSupplier').modal();
                $(dis).find('i').removeClass('fa fa-refresh');
                $(dis).find('i').removeClass('fa-loader');
                $(dis).find('i').addClass('fa fa-times');
            }

        });
    })

    .on('click', '.btn-update-contact', function() {
        $.ajax({
            url: '/factorycontact/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                $('#update_contact_id').val(response.contact.id);
                $('#update_factory_name').val(response.contact.factory_name)
                $('#update_contact_person').val(response.contact.factory_contact_person);
                $('#update_contact_person_number').val(response.contact.factory_contact_number);
                $('#update_contact_person_email').val(response.contact.factory_email);
                $('#updateContact').modal('show');
            }
        })
    })

    .on('click', '.btn-delete-contact', function() {
        $.ajax({
            url: '/factorycontact/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                $('#del_contact_id').val(response.contact.id);
                $('#del_contact_name').val(response.contact.factory_contact_person);
                $('#deleteContact').modal('show');
            }
        })
    })

    $('#new_client_code').on('change', function() {
        $('.factories').remove();
        $.ajax({
            url: '/getclientfactory/' + $(this).val(),
            type: 'GET',
            success: function(response) {
                var cnt = response.factories.length;
                for (var i = 0; i <= cnt - 1; i++) {
                    $('#factory_id').append('<option class="factories" value="' + response.factories[i].id + '">' +
                        response.factories[i].factory_name +
                        '</option>')
                }
            }
        })
    })
})

function showAllCountryUpdate(value) {
    $('#update_factory_country').empty();
    $('#update_factory_country').append('<option value="">Please Wait...</option>');
    $.ajax({
        url: '/get-all-country/1',
        type: 'GET',
        success: function(result) {
            //localStorage.setItem("result",result);

            $('#update_factory_country').empty();
            $('#update_factory_country').append('<option value="">Select Country</option>');
            var data_country = JSON.parse(result);
            //data_country = result;
            //data_country.forEach(element => {
            $.each(data_country, function(i, element) {
                //response.contacts
                if (element.name == "" || element.name == null) {

                } else {
                    $('#update_factory_country').append('<option value="' + element.id + '">' + element.name + '</option>');
                }

            });
            $('#update_factory_country').val(value);

        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#factory_country').empty();
            $('#factory_country').append('<option value="">Something went wrong. Please try again.</option>');

            $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
        }
    });
}

var update_source_state = [];

function showStateByCountryUpdate(id, state_id) {
    $.ajax({
        url: '/get-state/' + id,
        type: 'GET',
        success: function(result) {
            update_source_state.length = 0;
            //var data_country = result;
            var data_country = JSON.parse(result);

            //data_country.forEach(element => {
            $.each(data_country, function(i, element) {
                if (element.name == "" || element.name == null) {

                } else {
                    update_source_state.push({ value: element.id, label: element.name });
                }
            });

        },
        error: function(jqXHR, textStatus, errorThrown) {
            //$('#update_factory_state').empty();
            //$('#update_factory_state').append('<option value="">Something went wrong. Please try again.</option>');
            $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
        }
    });
}

var update_source_city = [];

function showCityByCountryAndStateUpdate(cid, sid, city_id) {
    /*  var cid = $('#factory_country').val();
     var sid = $('#factory_state').val(); */
    //console.log(cid);
    //$('#update_factory_city').empty();
    //$('#update_factory_city').append('<option value="">Please Wait...</option>');
    $.ajax({
        url: '/get-city/' + sid,
        type: 'GET',
        success: function(result) {
            //console.log(result);
            //$('#update_factory_city').empty();
            //$('#update_factory_city').append('<option value="">Select City</option>');
            var data_city = JSON.parse(result);
            //var data_city = result;

            //data_city.forEach(element => {
            $.each(data_city, function(i, element) {
                if (element.name == "" || element.name == null) {

                } else {
                    //$('#update_factory_city').append('<option value="' + element.id + '">' + element.name + '</option>');
                    update_source_city.push(element.name);
                }
            });
            // $('#update_factory_city').val(city_id);


        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_factory_city').empty();
            $('#update_factory_city').append('<option value="">Something went wrong. Please try again.</option>');
            $('#result').html('<p>status code: ' + jqXHR.status + '</p><p>errorThrown: ' + errorThrown + '</p><p>jqXHR.responseText:</p><div>' + jqXHR.responseText + '</div>');
            console.log('jqXHR:');
            console.log(jqXHR);
            console.log('textStatus:');
            console.log(textStatus);
            console.log('errorThrown:');
            console.log(errorThrown);
        }
    });
}