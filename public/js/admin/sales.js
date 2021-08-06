$(document).ready(function() {
    $('#sales_table').DataTable({
        "order": [
            [3, "desc"]
        ],
    });
    showAllCountryUpdate();

    $('body')
        .on('click', '.btn-edit', function() {
            /* alert("alert"); */
            $.ajax({
                url: '/getonesales/' + $(this).data('id'),
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('#update_id').val(response.sales_id);
                    $('#update_username').val(response.username);
                    $('#update_email').val(response.sales_email);
                    $('#update_contact_number').val(response.contact_number);
                    $('#update_tel_number').val(response.tel_number);
                    $('#update_sales_name').val(response.sales_name);
                    $('#update_address').val(response.address);

                    $('#update_skype').val(response.user_skype);
                    $('#update_wechat').val(response.user_wechat);
                    $('#update_whatsapp').val(response.user_whatsapp);
                    $('#update_qqmail').val(response.user_qqmail);


                    $('#update_sales_country').val(response.user_country_id);
                    $('#update_sales_state').val(response.user_state_name);
                    $('#update_sales_city').val(response.user_city_name);
                    showStateByCountryUpdate(response.user_country_id, response.user_state_id);
                    showCityByCountryAndStateUpdate(response.user_country_id, response.user_state_id, response.user_city_id);

                    $('#update_sales_country_name').val(response.user_country_name);
                    $('#update_sales_state_id').val(response.user_state_id);
                    $('#update_sales_city_name').val(response.user_city_name);

                    $('#updateSalesModal').modal();
                }

            });
        })

    .on('click', '.btn-view', function() {
        $.ajax({
            url: '/getonesales/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                $('#view_sales_name').text(response.sales_name);
                $('#view_email').text(response.sales_email);
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

                $('#viewSalesDetails').modal();
            }

        });
    })

    .on('click', '.btn-delete', function() {
        $.ajax({
            url: '/getonesales/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                $('#del_sales_id').val(response.sales_id);
                $('#deleteSalesModal').modal();
            }

        });
    })

});


function showAllCountryUpdate() {
    $('#update_sales_country').empty();
    $('#update_sales_country').append('<option value="">Please Wait...</option>');
    $.ajax({
        url: '/get-all-country/1',
        type: 'GET',
        success: function(result) {
            //localStorage.setItem("result",result);

            $('#update_sales_country').empty();
            $('#update_sales_country').append('<option value="">Select Country</option>');
            var data_country = JSON.parse(result);
            //data_country = result;
            data_country.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    $('#update_sales_country').append('<option value="' + element.id + '">' + element.name + '</option>');
                }

            });
            //$('#update_factory_country').val();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#update_sales_country').empty();
            $('#update_sales_country').append('<option value="">Something went wrong. Please try again.</option>');

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
            $('#update_sales_state').empty();
            $('#update_sales_state').append('<option value="">Something went wrong. Please try again.</option>');
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
            $('#update_sales_city').empty();
            $('#update_sales_city').append('<option value="">Something went wrong. Please try again.</option>');
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