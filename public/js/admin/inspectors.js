$(document).ready(function() {
    $('#inspectors_table').DataTable({
        "order": [
            [5, "desc"]
        ],
    });
    showAllCountryUpdate();

    $('body')
        .on('click', '.btn-edit', function() {
            /* alert("alert"); */
            $.ajax({
                url: '/getoneinspector/' + $(this).data('id'),
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#update_id').val(response.inspector_id);
                    $('#update_username').val(response.username);
                    $('#update_email').val(response.inspector_email);
                    $('#update_contact_number').val(response.contact_number);
                    $('#update_tel_number').val(response.tel_number);
                    $('#update_inspector_name').val(response.inspector_name);
                    $('#update_address').val(response.address);

                    $('#update_skype').val(response.user_skype);
                    $('#update_wechat').val(response.user_wechat);
                    $('#update_whatsapp').val(response.user_whatsapp);
                    $('#update_qqmail').val(response.user_qqmail);


                    $('#update_inspector_country').val(response.user_country_id);
                    $('#update_inspector_state').val(response.user_state_name);
                    $('#update_inspector_city').val(response.user_city_name);
                    showStateByCountryUpdate(response.user_country_id, response.user_state_id);
                    showCityByCountryAndStateUpdate(response.user_country_id, response.user_state_id, response.user_city_id);

                    $('#update_inspector_country_name').val(response.user_country_name);
                    $('#update_inspector_state_id').val(response.user_state_id);
                    $('#update_inspector_city_name').val(response.user_city_name);

                    $('#updateInspectorModal').modal();
                }

            });
        })

    .on('click', '.btn-view', function() {
        $.ajax({
            url: '/getoneinspector/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                $('#view_insp_name').text(response.inspector_name);
                $('#view_email').text(response.inspector_email);
                $('#view_un').text(response.username);
                $('#view_mobile').text(response.contact_number);
                $('#view_tel').text(response.tel_number);
                $('#view_skype').text(response.user_skype);
                $('#view_wechat').text(response.user_wechat);
                $('#view_whatsapp').text(response.user_whatsapp);
                $('#view_qqmail').text(response.user_qqmail);
                $('#view_country').text(response.user_country_name);
                $('#view_state').text(response.user_state_name);
                $('#view_city').text(response.user_city_name);

                $('#viewInspectorDetails').modal();
            }

        });
    })

    .on('click', '.btn-delete', function() {
        $.ajax({
            url: '/getoneinspector/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                $('#del_inspector_id').val(response.inspector_id);
                $('#deleteInspectorModal').modal();
            }

        });
    })

});


function showAllCountryUpdate() {
    $('#update_inspector_country').empty();
    $('#update_inspector_country').append('<option value="">Please Wait...</option>');
    $.ajax({
        url: '/get-all-country/1',
        type: 'GET',
        success: function(result) {
            //localStorage.setItem("result",result);

            $('#update_inspector_country').empty();
            $('#update_inspector_country').append('<option value="">Select Country</option>');
            var data_country = JSON.parse(result);
            //data_country = result;
            data_country.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    $('#update_inspector_country').append('<option value="' + element.id + '">' + element.name + '</option>');
                }

            });
            //$('#update_factory_country').val();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_inspector_country').empty();
            $('#update_inspector_country').append('<option value="">Something went wrong. Please try again.</option>');

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
            //var data_country = result;
            var data_country = JSON.parse(result);
            data_country.forEach(element => {
                if (element.name == "" || element.name == null) {} else {
                    update_source_state.push({ value: element.id, label: element.name });
                }
            });

        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_inspector_state').empty();
            $('#update_inspector_state').append('<option value="">Something went wrong. Please try again.</option>');
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
    $.ajax({
        url: '/get-city/' + sid,
        type: 'GET',
        success: function(result) {
            //var data_city = result;
            var data_city = JSON.parse(result);
            update_source_city.length = 0;
            data_city.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    update_source_city.push(element.name);
                }
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_inspector_city').empty();
            $('#update_inspector_city').append('<option value="">Something went wrong. Please try again.</option>');
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