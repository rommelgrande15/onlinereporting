$(document).ready(function () {
    showAllCountryUpdate('update_company_country');
    showAllCountryUpdate('u_company_invoice_country');
    $('#new_clients_table').DataTable({
        "order": [
            [4, "desc"]
        ]
    });
    $('#clients_table').DataTable({
        "order": [
            [5, "desc"]
        ]
    });
    $('body')
        .on('click', '.btn-delete', function () {
            $.ajax({
                url: '/getoneclients/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    $('#del_client_name').val(response.client_name);
                    $('#del_client_id').val(response.client_id);
                    $('#deleteClient').modal();
                }

            });
        })

        .on('click', '.btn-edit', function () {
            var dis_val = $(this).data('id');
            console.log(dis_val);
            $('#new-add-btn-cperson').attr('data-id', dis_val); //setter
            $('#online_client').prop('selectedIndex', -1);
            $.ajax({
                url: '/getoneclients/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#div_edit_more_fields_client').empty();
                    $("#update_sales_manager").empty();
                    console.log(response.client_contact_list);
                    if (response.client_contact_list != undefined) {
                        response.client_contact_list.forEach(element => {
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
                                    '       <input type="text" id="update_client_skype" name="update_client_skype" value="' + element.client_skype + '" class="form-control update_client_skype" onkeyup="contacPersonValidator(\'update_client_skype\')">' +
                                    '   </div>' +
                                    ' </div>' +

                                    ' <div class="col-md-4">' +
                                    '     <div class="form-group">' +

                                    '      <label for="update_client_wechat">We Chat</label>' +
                                    '         <input type="text" id="update_client_wechat" name="update_client_wechat"  value="' + element.client_wechat + '" class="form-control update_client_wechat" onkeyup="contacPersonValidator(\'update_client_wechat\')">' +
                                    '     </div>' +
                                    '   </div>' +

                                    '   <div class="col-md-4">' +
                                    '       <div class="form-group">' +

                                    '      <label for="update_client_whatsapp">WhatsApp</label>' +
                                    '           <input type="text" id="update_client_whatsapp" name="update_client_whatsapp"  value="' + element.client_whatsapp + '" class="form-control update_client_whatsapp" onkeyup="contacPersonValidator(\'update_client_whatsapp\')">' +
                                    '       </div>' +
                                    '     </div>' +

                                    '     <div class="col-md-4">' +
                                    '         <div class="form-group">' +

                                    '      <label for="update_client_qqmail">QQ Mail</label>' +
                                    '             <input type="text" id="update_client_qqmail" name="update_client_qqmail"  value="' + element.client_qqmail + '" class="form-control update_client_qqmail" onkeyup="contacPersonValidator(\'update_client_qqmail\')">' +
                                    '         </div>' +
                                    '       </div> ' +
                                    '<div class="col-md-1">' +
                                    '<div class="form-group"><br>' +
                                    '<button onclick ="update_Client_data(' + element.id + ')" type="button"  class="btn btn-danger btn-rm update_Client_data" ><i class="fa fa-times"></i></button>' +
                                    '</div>' +
                                    '</div></div>');
                            }
                        });
                    }
                    $('.update_client_name').val(response.client_name);
                    //$('#online_client option:selected').val(response.is_online);
                    $('#online_client option[value=' + response.is_online + ']').prop('selected', true);
                    console.log('Online: ' + response.is_online);
                    $('.update_client_user_name').val(response.client_username);
                    $('.update_client_password').val(response.client_password);
                    $('#update_confirm_password').val(response.client_password);
                    $('.update_client_email_add').val(response.client_email);

                    $('.update_client_code').val(response.client_code);

                    $('.update_Company_Name').val(response.Company_Name);
                    $('.update_Company_Website').val(response.Company_Website);
                    $('.update_Company_Email').val(response.Company_Email);
                    $('.update_Company_Address').val(response.Company_Address);
                    $('.update_Invoice_Address').val(response.Invoice_Address);
                    $('.update_Phone_number').val(response.Phone_number);
                    $('#update_payment_terms').val(response.payment_term);
                    $('#update_sales_manager').val(response.sales_manager); //06-11-2021
                    $('#update_related_by').val(response.related_by);
                    $('#sales_id').val(response.sales_id);
                    
                    var sales_id = response.sales_id;
                    //sales manager
                    var len = 0;
                    if (response.sales != null) {
                        len = response.sales.length;
                    }
                    if (len>0) {
                        var option = '<option>--Select Sales Manager--</option>';
                        for (i = 0; i < len; i++) {
                            if(sales_id == response.sales[i].id){
                                option += '<option value="' + response.sales[i].id + '" selected>' + response.sales[i].name + '</option>';
                            }else{
                                option += '<option value="' + response.sales[i].id + '">' + response.sales[i].name + '</option>';
                            }
                        
                        }
                        $('#update_sales_manager').append(option);
                    }    
                    //end here
                  
                    $('#update_street_number').val(response.street_number);
                    $('#update_house_number').val(response.house_number);
                    $('#update_zip_code').val(response.zip_code);

                    $('#update_inv_street_number').val(response.company_inv_street_num);
                    $('#update_inv_house_number').val(response.company_inv_house_num);
                    $('#update_inv_zip_code').val(response.company_inv_zip_code);

                    $('#update_bldg_number').val(response.company_bldg_num);
                    $('#update_inv_bldg_number').val(response.company_inv_bldg_num);

                    if (response.company_country_id == response.company_invoice_country_id && response.company_state_id == response.company_invoice_state_id && response.company_city_id == response.company_invoice_city_id && response.street_number == response.company_inv_street_num && response.house_number == response.company_inv_house_num && response.zip_code == response.company_inv_zip_code) {
                        $('.update_invoice_class').hide();
                        $('#update_check_invoice').prop('checked', true);
                        $('#label_check_invoice').text('Invoice address same as address. Uncheck if you want to change your invoice address.');
                    } else {
                        $('.update_invoice_class').show();
                        $('#update_check_invoice').prop('checked', false);
                        $('#label_check_invoice').text('Invoice address did not same as address. Check if same as your address.');
                    }

                    if (response.payment_term == 'special_terms') {
                        $('#update_special_terms').val(response.special_term);
                        $('#update_div_special_terms').css("display", "block");
                    }

                    if (response.related_by == 'others') {
                        $('#update_others').val(response.others);
                        $('#update_div_related_others').css("display", "block");
                    }

                    /* $('.update_contact_person').val(response.contact_person);
                    $('.update_contact_person_email').val(response.email_address);
                    $('.update_contact_person_number').val(response.contact_number); */


                    $('#update_client_id').val(response.client_id);
                    $('#update_contact_client_id').val(response.contact_client_id);

                    $('#update_company_country').val(response.company_country_id);
                    $('#u_company_invoice_country').val(response.company_invoice_country_id);
                    showStateByCountryUpdate(response.company_country_id, response.company_state_id, 'update_company_state', 'comp');
                    // showCityByCountryAndStateUpdate(response.company_country_id, response.company_state_id, response.company_city_id, 'update_company_city', 'comp');

                    showStateByCountryUpdate(response.company_invoice_country_id, response.company_invoice_state_id, 'u_company_invoice_state', 'inv');
                    // showCityByCountryAndStateUpdate(response.company_invoice_country_id, response.company_invoice_state_id, response.company_invoice_city_id, 'u_company_invoice_city', 'inv');

                    if(response.company_state_name == null || response.company_state_name == 'null'){
                        $('#update_company_state').val('N/A');
                    }else{
                        $('#update_company_state').val(response.company_state_name);
                    }
                    
                    $('#update_company_city').val(response.company_city_name);

                    if(response.company_invoice_state_name == null || response.company_invoice_state_name == 'null'){
                        $('#u_company_invoice_state').val('N/A');
                    }else{
                        $('#u_company_invoice_state').val(response.company_invoice_state_name);
                    }
                    

                    $('#u_company_invoice_city').val(response.company_invoice_city_name);

                    $('#update_company_state_id').val(response.company_state_id);
                    $('#u_company_invoice_state_id').val(response.company_invoice_state_id);

                    //new client
                    $('#update_company_country2').val(response.company_country_name);
                    //$("#update_company_country").attr("onchange", "showStateByCountryChange('update_company_country','update_company_state','update_company_city')");
                    //$("#update_company_state").attr("onchange", "showCityByCountryAndStateChange('update_company_country','update_company_state','update_company_city')");

                    //$("#u_company_invoice_country").attr("onchange", "showStateByCountryChange('u_company_invoice_country','u_company_invoice_state','u_company_invoice_city')");
                    //$("#u_company_invoice_state").attr("onchange", "showCityByCountryAndStateChange('u_company_invoice_country','u_company_invoice_state','u_company_invoice_city')");

                    $('#updateClient').modal('show');
                }

            });
        })



        .on('click', '.btn-view', function () {

            $('#dataID').val($(this).data('id'));

            $('#btn_add_more_contact_client').attr('data-id', $(this).data('id')); // sets 
            $.ajax({
                url: '/getoneclients/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('.client_added_row').remove();
                    $('#tr_street_num').remove();

                    $('#view_comp_name').text(response.Company_Name);
                    $('#view_comp_code').text(response.client_code);
                    $('#view_comp_email').text(response.Company_Email);
                    $('#view_comp_phone').text(response.Phone_number);

                    $('#view_comp_country').text(response.company_country_name);

                    if(response.company_state_name == null || response.company_state_name == 'null'){
                        $('#view_comp_state').text('N/A');
                    }else{
                        $('#view_comp_state').text(response.company_state_name);
                    }

                    $('#view_comp_city').text(response.company_city_name);
                    $('#view_comp_zip_code').text(response.zip_code);
                    $('#view_comp_bldg').text(response.company_bldg_num);
                    $('#view_comp_house_num').text(response.house_number);
                    $('#view_comp_street_num').text(response.street_number);

                    $('#view_inv_comp_country').text(response.company_invoice_country_name);

                    if(response.company_invoice_state_name == null || response.company_invoice_state_name == 'null'){
                        $('#view_inv_comp_state').text('N/A');
                    }else{
                        $('#view_inv_comp_state').text(response.company_invoice_state_name);
                    }

                    $('#view_inv_comp_city').text(response.company_invoice_city_name);
                    $('#view_inv_comp_zip_code').text(response.company_inv_zip_code);
                    $('#view_inv_comp_bldg').text(response.company_inv_bldg_num);
                    $('#view_inv_comp_house_num').text(response.company_inv_house_num);
                    $('#view_inv_comp_street_num').text(response.company_inv_street_num);
                    if (response.sales_id == 0 || response.sales_id == null || response.sales_id == 'null'){
                        $('#view_sales_manager').text('no data'); //06-11-2021
                    }else{
                        $('#view_sales_manager').text(response.sales_name); //06-11-2021
                    }
                    


                    if (response.company_country_name == response.company_invoice_country_name && response.company_state_name == response.company_invoice_state_name && response.company_city_name == response.company_invoice_city_name && response.zip_code == response.company_inv_zip_code && response.company_bldg_num == response.company_inv_bldg_num && response.house_number == response.company_inv_house_num && response.street_number == response.company_inv_street_num) {
                        $('#same_as_address').show();
                        $('.not_same_as_address').hide();
                    } else {
                        $('#same_as_address').hide();
                        $('.not_same_as_address').show();
                    }

                    //var comp_addr = response.house_number + ', ' + response.street_number + ', ' + response.company_city_name + ', ' + response.company_state_name + ', ' + response.company_country_name;

                    //var comp_inv_addr = response.company_inv_house_num + ', ' + response.company_inv_street_num + ', ' + response.company_invoice_city_name + ', ' + response.company_invoice_state_name + ', ' + response.company_invoice_country_name;
                    //$('#view_comp_address').text(comp_addr);
                    //$('#view_comp_inv_address').text(comp_inv_addr);
                    var pay_terms = 'Special Terms: ' + response.special_term;
                    if (response.payment_term == 'special_terms') {

                        $('#view_comp_payment_terms').text(pay_terms);
                    } else {
                        $('#view_comp_payment_terms').text(response.payment_term);
                    }

                    console.log(response.client_contact_list);
                    if (response.client_contact_list != undefined) {
                        $('#table_view_client > tbody:last-child').append('<tr class="client_added_row" style="background-color:lightgrey"><th colspan="4"><h4>2. Client Contact Person</h4></th></tr>');
                        var count_contact = 0;
                        response.client_contact_list.forEach(element => {
                            count_contact += 1;
                            $('#table_view_client > tbody:last-child').append('<tr class="client_added_row">' +
                                '<th>Contact Person ' + count_contact + ' :</th>' +
                                '<td colspan="3">' + element.contact_person + '</td>' +
                                '</tr>' +

                                '<tr class="client_added_row">' +
                                '<th>Contact Person Email :</th>' +
                                '<td>' + element.email_address + '</td>' +
                                '<th>Mobile Number :</th>' +
                                '<td>' + element.contact_number + '</td>' +
                                '</tr>' +

                                '<tr class="client_added_row">' +
                                '<th>Telephone Number :</th>' +
                                '<td>' + element.tel_number + '</td>' +
                                '<th>Skype :</th>' +
                                '<td>' + element.client_skype + '</td>' +
                                '</tr>' +

                                '<tr class="client_added_row">' +
                                '<th>We Chat :</th>' +
                                '<td>' + element.client_wechat + '</td>' +
                                '<th>WhatsApp :</th>' +
                                '<td>' + element.client_whatsapp + '</td>' +
                                '</tr>' +

                                '<tr class="client_added_row">' +
                                '<th>QQ Mail :</th>' +
                                '<td colspan="3">' + element.client_qqmail + '</td>' +
                                '</tr>' +
                                '<tr class="client_added_row">' +
                                '<td colspan="4"></td>' +
                                '</tr>');
                        });
                    }

                    $('#viewClientDetails').modal();
                }

            });
        })

        .on('click', '.btn-add', function () {

            $.ajax({
                url: '/getoneclients/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#add_contact_for').text(response.Company_Name);
                    $('#hidden_client_code').val(response.client_code);
                    $('#viewClientDetails').modal('toggle');
                    $('#addClientContactPerson').modal('show');
                }

            });
        })

        .on('click', '.btn-add-new', function () {

            $.ajax({
                url: '/getoneclients/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#add_contact_for').text(response.Company_Name);
                    $('#hidden_client_code').val(response.client_code);
                    $('#updateClient').modal('toggle');
                    $('#addClientContactPerson').modal('show');
                }

            });
        })

        .on('click', '.btn-edit-contact', function () {
            $.ajax({
                url: '/getonecontact/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    $('#update_contact_id').val(response.id);
                    $('#update_contact_name').val(response.client_code);

                    $('#update_contact_person').val(response.contact_person);
                    $('#update_contact_person_email').val(response.email_address);
                    $('#update_contact_person_number').val(response.contact_number);
                    $('#updateContact').modal('show');
                }

            });
        })

        .on('click', '.btn-delete-contact', function () {
            $.ajax({
                url: '/getonecontact/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    $('#del_contact_name').val(response.contact_person);
                    $('#del_contact_id').val(response.id);
                    $('#deleteContact').modal();
                }

            });
        })



    $('#updateClient').on('hidden.bs.modal', function () {
        $('#update_client_name').val('');
        $('#update_client_code').val('');
        $('#update_client_id').val('');
    })

    $('#new_client_name').on('change', function () {
        $('#new_client_code').val($(this).val());
    })



});


function showAllCountryUpdate(id) {
    $('#' + id).empty();
    $('#' + id).append('<option value="">Please Wait...</option>');
    $.ajax({
        url: '/get-all-country/1',
        type: 'GET',
        success: function (result) {
            //localStorage.setItem("result",result);

            $('#' + id).empty();
            $('#' + id).append('<option value="">Select Country</option>');
            var data_country = JSON.parse(result);
            //data_country = result;
            data_country.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    $('#' + id).append('<option value="' + element.id + '">' + element.name + '</option>');
                }

            });
            //$('#update_company_country').val();

        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#' + id).empty();
            $('#' + id).append('<option value="">Something went wrong. Please try again.</option>');

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

var update_comp_source_state = [];
var update_inv_source_state = [];

function showStateByCountryUpdate(id, state_id, select_id, src) {
    /*  var id = $('#factory_country').val(); */
    //var country_name = $('#factory_country option:selected').text();
    //$('#hcountry_name').val(country_name);
    //$('#' + select_id).empty();
    //$('#' + select_id).append('<option value="">Please Wait...</option>');
    //$('#' + select_id).val('Please wait...');
    $.ajax({
        url: '/get-state/' + id,
        type: 'GET',
        success: function (result) {
            //console.log(result);
            //$('#' + select_id).empty();
            // $('#' + select_id).append('<option value="">Select State</option>');
            /* var data_country=  JSON.parse(result); */
            //$('#' + select_id).val('');
            //var data_country = result;
            var data_country = JSON.parse(result);
            if (src == 'comp') {
                update_comp_source_state.length = 0;
            } else {
                update_inv_source_state.length = 0;
            }
            data_country.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    //$('#' + select_id).append('<option value="' + element.id + '">' + element.name + '</option>');
                    if (src == 'comp') {
                        update_comp_source_state.push({
                            value: element.id,
                            label: element.name
                        });
                    } else {
                        update_inv_source_state.push({
                            value: element.id,
                            label: element.name
                        });
                    }
                }
            });

            //$('#' + select_id).val(state_id);

        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#' + select_id).empty();
            $('#' + select_id).append('<option value="">Something went wrong. Please try again.</option>');
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

var update_comp_source_city = [];
var update_inv_source_city = [];

function showCityByCountryAndStateUpdate(cid, sid, city_id, select_id, source) {
    /*  var cid = $('#factory_country').val();
     var sid = $('#factory_state').val(); */
    //console.log(cid);
    //$('#' + select_id).empty();
    //$('#' + select_id).append('<option value="">Please Wait...</option>');
    $.ajax({
        url: '/get-city/' + sid,
        type: 'GET',
        success: function (result) {
            //console.log(result);
            //$('#' + select_id).empty();
            //$('#' + select_id).append('<option value="">Select City</option>');
            var data_city = JSON.parse(result);
            //var data_city = result;

            data_city.forEach(element => {
                if (element.name == "" || element.name == null) {

                } else {
                    //$('#' + select_id).append('<option value="' + element.id + '">' + element.name + '</option>');
                    if (source == 'comp') {
                        update_comp_source_city.push(element.name);
                    } else {
                        update_inv_source_city.push(element.name);
                    }
                }
            });
            $('#' + select_id).val(city_id);


        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('#' + select_id).empty();
            $('#' + select_id).append('<option value="">Something went wrong. Please try again.</option>');
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
