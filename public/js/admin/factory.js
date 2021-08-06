$(document).ready(function() {

    $('#factories_table').DataTable(

        {

            "order": [
                [4, "desc"]
            ]
        }


    );
    $('#contacts_table').DataTable();
    $('body')
        .on('click', '.btn-edit', function() {
            $.ajax({
                url: '/getonefactory/' + $(this).data('id'),
                type: 'GET',
                success: function(response) {
                    console.log(response);

                    $('#div_edit_more_fields').empty();
                    response.contacts.forEach(element => {
                        if (element.factory_contact_status != 2 || element.factory_contact_status != '2') {
                            console.log(element.factory_contact_person);
                            $('#div_edit_more_fields').append('<div id="' + element.id + '"><div class="col-md-12">' +
                                '        <div class="form-group">' +
                                '          <hr/>' +
                                '      </div>' +
                                '    </div>' +
                                '    <div class="col-md-12">' +
                                '      <div class="form-group">    ' +
                                '        <h4 class="modal-title">Factory Contact Person</h4>' +
                                '      </div>' +
                                '    </div>' +

                                '    <div class="col-md-4">      ' +
                                '      <div class="form-group">' +
                                '          <label for="update_contact_person">Contact Person</label>' +
                                '          <input type="text" name="update_contact_person" value="' + element.factory_contact_person + '" onchange="test2()" id="update_contact_person' + element.id + '" class="form-control update_contact_person" required>' +

                                '      </div>' +
                                '    </div>' +
                                '    ' +
                                '    <div class="col-md-4">' +
                                '      <div class="form-group">' +
                                '          <label for="update_contact_person_email">Email Address</label>' +
                                '          <input type="email" name="update_contact_person_email" value="' + element.factory_email + '" onchange="test2()" id="update_contact_person_email' + element.id + '" class="form-control update_contact_person_email" required>' +

                                '      </div>' +
                                '    </div>' +

                                '    <div class="col-md-4">' +
                                '      <div class="form-group">' +
                                '          <label for="update_contact_person_number">Mobile Number</label>' +
                                '          <input type="text" name="update_contact_person_number" value="' + element.factory_contact_number + '" onchange="test2()" id="update_contact_person_number' + element.id + '" class="form-control numeric update_contact_person_number" required>' +

                                '      </div>' +
                                '    </div>' +

                                '    <div class="col-md-4">' +
                                '      <div class="form-group">' +
                                '          <label for="update_contact_tel_person_number">Telephone Number</label>' +
                                '          <input type="text" name="update_contact_tel_person_number" value="' + element.factory_tel_number + '" onchange="test2()" id="update_contact_tel_person_number' + element.id + '" class="form-control numeric update_contact_tel_person_number" required>' +

                                '      </div>' +
                                '    </div>' +


                                '    <div class="col-md-4">' +
                                '        <div class="form-group">' +
                                '            <label for="update_contact_skype">Skype</label>' +
                                '            <input type="text" name="update_contact_skype" value="' + element.factory_contact_skype + '"  id="update_contact_skype' + element.id + '" class="form-control update_contact_skype" required>' +

                                '        </div>' +
                                '      </div>' +

                                '      <div class="col-md-4">' +
                                '          <div class="form-group">' +
                                '              <label for="update_contact_wechat">We Chat</label>' +
                                '              <input type="text" name="update_contact_wechat"  value="' + element.factory_contact_wechat + '" id="update_contact_wechat' + element.id + '" class="form-control update_contact_wechat" required>' +

                                '          </div>' +
                                '        </div>' +
                                '    ' +
                                '        <div class="col-md-4">' +
                                '            <div class="form-group">' +
                                '                <label for="update_contact_whatsapp">WhatsApp</label>' +
                                '                <input type="text" name="update_contact_whatsapp" value="' + element.factory_contact_whatsapp + '" id="update_contact_whatsapp' + element.id + '" class="form-control update_contact_whatsapp" required>' +

                                '            </div>' +
                                '          </div>' +

                                '          <div class="col-md-4">' +
                                '              <div class="form-group">' +
                                '                  <label for="update_contact_qqmail">QQ Mail</label>' +
                                '                  <input type="text" name="update_contact_qqmail"  value="' + element.factory_contact_qq + '" id="update_contact_qqmail' + element.id + '" class="form-control update_contact_qqmail" required>' +

                                '              </div>' +
                                '            </div>' +
                                '          <div class="col-md-1">' +
                                '              <div class="form-group">' +
                                '          <input type="hidden" name="hidden_contact_id" id="IdcontactFactory" class="IdcontactFactory" value="' + element.id + '">' +


                                '              </div>' +
                                '            </div>' +
                                '<div class="col-md-1">' +
                                '<div class="form-group"><br>' +
                                '<button onclick ="update_Factory_data(' + element.id + ')" type="button"  class="btn btn-danger btn-rm update_Client_data" ><i class="fa fa-times"></i></button>' +
                                '</div>' +
                                '</div> </div>');

                        }

                    });


                    $('#update_factory_id').val(response.factory_id);
                    $('#update_client_code').val(response.client_code);
                    $('#update_factory_name').val(response.factory_name);
                    $('#update_factory_address').val(response.factory_address);
                    $('#update_factory_address_local').val(response.factory_address_local);
                    $('#update_factory_country').val(response.factory_country);
                    $('#update_factory_city').val(response.factory_city);

                    $('#update_country_id').val(response.factory_country);
                    $('#update_state_id').val(response.factory_state);
                    $('#update_city_id').val(response.factory_city);

                    $('#update_contact_person').val(response.factory_contact_person);
                    $('#update_contact_person_email').val(response.factory_email);
                    $('#update_contact_person_number').val(response.factory_contact_number);
                    $('#hidden_contact_id').val(response.factory_contact_id);

                    $('#update_contact_skype').val(response.factory_contact_skype);
                    $('#update_contact_wechat').val(response.factory_contact_wechat);
                    $('#update_contact_whatsapp').val(response.factory_contact_whatsapp);
                    $('#update_contact_qqmail').val(response.factory_contact_qq);

                    $('#updateFactory').modal('show');

                    showAllCountryUpdate(response.factory_country);
                    showStateByCountryUpdate(response.factory_country, response.factory_state_id);
                    showCityByCountryAndStateUpdate(response.factory_country, response.factory_state_id, response.factory_city_id);
                    //$('#update_factory_city').val(response.factory_state);
                    $('#update_factory_state').val(response.factory_state);
                    $('#update_factory_state_id').val(response.factory_state_id);

                    //$("#update_factory_country").attr("onchange", "showStateByCountryChange()");
                    //$("#update_factory_state").attr("onchange", "showCityByCountryAndStateChange()");

                }

            });
        })

    .on('click', '.btn-view', function() {
        //$('#btn_add_more_con_person').data('data-id', $(this).data('id')); //setter
        $('#btn_add_more_con_person').attr("data-id", $(this).data('id'));
        $.ajax({
            url: '/getonefactory/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('#view_fac_name').text(response.factory_name);
                $('#view_fac_addr_local').text(response.factory_address_local);
                var fac_addr = response.factory_city + ', ' + response.factory_state + ', ' + response.factory_country_name;
                $('#view_fac_addr').text(fac_addr);
                $('.factory_added_row').remove();
                $('#table_view_factory > tbody:last-child').append('<tr class="factory_added_row" style="background-color:lightgrey"><th colspan="4"><h4>2. Factory Contact Person</h4></th></tr>');
                var count_contact = 0;
                response.contacts.forEach(element => {
                    count_contact += 1;
                    $('#table_view_factory > tbody:last-child').append('<tr class="factory_added_row">' +
                        '<th>Contact Person ' + count_contact + ' :</th>' +
                        '<td colspan="3">' + element.factory_contact_person + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>Email :</th>' +
                        '<td>' + element.factory_email + '</td>' +
                        '<th>Mobile Number :</th>' +
                        '<td>' + element.factory_contact_number + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>Telephone Number :</th>' +
                        '<td>' + element.factory_tel_number + '</td>' +
                        '<th>Skype :</th>' +
                        '<td>' + element.factory_contact_skype + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>We Chat :</th>' +
                        '<td>' + element.factory_contact_wechat + '</td>' +
                        '<th>WhatsApp :</th>' +
                        '<td>' + element.factory_contact_whatsapp + '</td>' +
                        '</tr>' +

                        '<tr class="factory_added_row">' +
                        '<th>QQ Mail :</th>' +
                        '<td colspan="3">' + element.factory_contact_qq + '</td>' +
                        '</tr>' +
                        '<tr class="factory_added_row">' +
                        '<td colspan="4"></td>' +
                        '</tr>');
                });

                $('#viewFactoryDetails').modal();
            }
        })
    })

    .on('click', '.btn-add', function() {

        $.ajax({
            url: '/getonefactory/' + $(this).data('id'),
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
        $.ajax({
            url: '/getonefactory/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                $('#del_factory_name').val(response.factory_name);
                $('#del_factory_id').val(response.factory_id);
                $('#deleteFactory').modal();

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
        //url: 'http://world.t-i-c.asia/webapi_world_controller.php',
        url: '/get-all-country/1',
        type: 'GET',
        datatype: 'json',
        /*data: {
            show_all_country: 1
        },*/
        success: function(result) {
            //localStorage.setItem("result",result);

            $('#update_factory_country').empty();
            $('#update_factory_country').append('<option value="">Select Country</option>');
            var data_country = JSON.parse(result);
            //data_country = result;
            //data_country.forEach(element => {
            $.each(data_country, function(i, element) {
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
        //url: 'http://world.t-i-c.asia/webapi_state_controller.php?id=' + id,
        url: '/get-state/' + id,
        type: 'GET',
        /*datatype: 'json',
        data: {
            show_all_country: 1
        },*/
        success: function(result) {
            update_source_state.length = 0;
            //var data_country = result;
            //data_country.forEach(element => {
            var data_country = JSON.parse(result);
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
        //url: 'http://world.t-i-c.asia/webapi_city_controller.php?state_id=' + sid,
        url: '/get-city/' + sid,
        type: 'GET',
        /*datatype: 'json',
        data: {
            show_all_country: 1
        },*/
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