$(document).ready(function () {


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

    //jQuery.fn.dataTableExt.oApi.fnFilterAll = function(oSettings, sInput, iColumn, bRegex, bSmart) {
    //    var settings = $.fn.dataTableSettings;
    //
    //    for (var i = 0; i < settings.length; i++) {
    //        settings[i].oInstance.fnFilter(sInput, iColumn, bRegex, bSmart);
    //    }
    //};
    /*  $('#inspections_table').DataTable({
         "order": [
             [6, "desc"]
         ],
         "pageLength": 30
     }); */


    //var oTable = $('#inspections_table').dataTable({
    //    "oLanguage": {
    //        "sSearch": "Search all columns:"
    //    },
    //    "order": [
    //        [7, "desc"]
    //    ],
    //    "pageLength": 10
    //});

    $('#inspections_table').DataTable({
        "order": [
            [6, "desc"]
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/client-book-data-mrn",
            "dataType": "json",
            "type": "POST",
            "data": {
                _token: token
            }
        },
        "columns": [
            {
                "data": "client",
                "name": "client"
            },
            {
                "data": "created_by",
                "name": "created_by"
            },
            {
                "data": "client_project_number",
                "name": "client_project_number"
            },
            {
                "data": "p_name",
                "name": "p_name"
            },
            {
                "data": "po",
                "name": "po"
            },
            {
                "data": "inspection_date",
                "name": "inspection_date"
            },
            {
                "data": "created_at",
                "name": "created_at"
            },
            {
                "data": "status",
                "name": "status"
            },
            {
                "data": "action",
                "name": "action"
            }
        ]

    });

    $('select#engines').change(function () {
        oTable.fnFilter($(this).val());

    });

    var services = {
        'iqi': 'Incoming Quality Inspection',
        'dupro': 'During Production Inspection',
        'psi': 'Pre Shipment Inspection',
        'cli': 'Container Loading Inspection',
        'pls': 'Setting Up Production Lines',
        'cbpi': 'CBPI - No Serial',
        'cbpi_serial': 'CBPI - with Serial',
        'cbpi_isce': 'CBPI - ISCE',
        'site_visit': 'Site Visit',
        'SPK': 'SPK',
        'FRI': 'FRI',
        'physical': 'Factory Audit',
        'detail': 'Detail Audit',
        'social': 'Social Audit',
        'st': 'Sample Test'

    };


    $('body')
        .on('click', '.btn_view_project', function () {
            $('.send-loading').show();
            $.ajax({
                url: '/project-details/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    //console.log(response.reference[0].password);
                    $('#proj_report_number').text(response.reference[0].report_no);
                    $('#proj_report_password').text(response.reference[0].password);
                    $('#proj_service_type').text(services[response.inspection.service]);
                    $('#proj_ins_date').text(response.inspection.inspection_date);
                    $('#proj_cli_pro_num').text(response.inspection_new.client_project_number);

                    //06-28-2021
                    if(response.second_inspector.secondary_inspector_id == null || response.second_inspector.secondary_inspector_id == 'null'){
                        var inspectors = response.inspection.name;
                    }else{  
                        var inspectors = response.inspection.name + ', ' + response.second_inspector.name;
                    }

                    $('#proj_ass_ins').text(inspectors);



                    $('#proj_client_email').text(response.inspection.email_address);
                    $('#proj_client_num').text(response.inspection.contact_number);
                    /* var client_addr = response.clients.company_house_num + ', ' + response.clients.company_street_num + ', ' + response.clients.company_city_name + ', ' + response.clients.company_state_name + ', ' + response.clients.company_country_name; */
                    var client_addr = response.clients.company_house_num + ', ' + response.clients.company_street_num + ', ' + response.clients.company_city_name + ', ' + response.clients.company_country_name;

                    $('.proj_added_row').remove();


                    //client
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4>Client Details</h4></th>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Client Name :</th>' +
                        '<td id="proj_client_name">' + response.clients.client_name + '</td>' +
                        '<th>Client Code :</th>' +
                        '<td id="proj_client_code">' + response.clients.client_code + '</td>' +
                        '</tr>' +

                        '<tr class="proj_added_row">' +
                        '<th>Client Email :</th>' +
                        '<td id="proj_client_email">' + response.clients.Company_Email + '</td>' +
                        '<th>Client Telephone Number :</th>' +
                        '<td id="proj_client_num">' + response.clients.Phone_number + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Client Address :</th>' +
                        '<td id="proj_client_address" colspan="3">' + client_addr + '</td>' +
                        '</tr>');
                    var count_client = 0;
                    response.client_contact_list.forEach(element => {
                        count_client += 1;
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<th>Client Contact Person ' + count_client + ':</th>' +
                            '<td id="proj_cli_cont_per">' + element.contact_person + '</td>' +
                            '<th>Client Contact Email :</th>' +
                            '<td id="proj_client_con_email">' + element.email_address + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Client Telephone Number :</th>' +
                            '<td id="proj_cli_tel_num">' + element.tel_number + '</td>' +
                            ' <th>Client Mobile Number :</th>' +
                            '<td id="proj_cli_mob_num">' + element.contact_number + '</td>' +

                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Client Contact We Chat :</th>' +
                            '<td id="proj_cli_cont_wechat">' + element.client_wechat + '</td>' +
                            '<th>Client Contact WhatsApp :</th>' +
                            '<td id="proj_cli_cont_whatsapp">' + element.client_whatsapp + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Client Contact QQ Mail :</th>' +
                            '<td id="proj_cli_cont_qqmail">' + element.client_qqmail + '</td>' +
                            '<th>Client Contact Skype :</th>' +
                            '<td id="proj_cli_cont_skype">' + element.client_skype + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<td colspan="4"></td>' +
                            '</tr>');
                    });

                    if(response.supplier.length >= 1){
                    //supplier
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4>Supplier Details </h4></th > ' +
                        '</tr>' +
                        '<tr class="proj_added_row">   ' +
                        '<th>Supplier Name :</th>' +
                        '<td id="proj_supplier_name" colspan="3">' + response.supplier[0].supplier_name + '</td>' +
                        '</tr>'+
                        '<tr class="proj_added_row">' +
                        '<th>Supplier Code :</th>' +
                        '<td id="proj_supplier_code">' + response.supplier[0].supplier_code + '</td>' +
                        '<th>Supplier Number :</th>' +
                        '<td id="proj_supplier_number">' + response.supplier[0].supplier_number + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">   ' +
                        '<th>Supplier Address :</th>' +
                        '<td id="proj_supplier_addr" colspan="3">' + response.supplier[0].supplier_address + '</td>' +
                        '</tr>'+
                        '<tr class="proj_added_row">   ' +
                        '<th>Supplier Address Local :</th>' +
                        '<td id="proj_supplier_addr_loc" colspan="3">' + response.supplier[0].supplier_local_address + '</td>' +
                        '</tr>');
                        if(response.supplier_contacts.length >= 1){
                        //supplier contact
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<th>Supplier Contact Person :</th>' +
                            '<td >' + response.supplier_contacts[0].supplier_contact_person + '</td>' +
                            '<th>Supplier Contact Email :</th>' +
                            '<td >' + response.supplier_contacts[0].supplier_email + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Supplier Telephone Number :</th>' +
                            '<td >' + response.supplier_contacts[0].supplier_tel_number + '</td>' +
                            ' <th>Supplier Mobile Number :</th>' +
                            '<td >' + response.supplier_contacts[0].supplier_contact_number + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Supplier Contact We Chat :</th>' +
                            '<td >' + response.supplier_contacts[0].supplier_contact_wechat + '</td>' +
                            '<th>Supplier Contact WhatsApp :</th>' +
                            '<td >' + response.supplier_contacts[0].supplier_contact_whatsapp + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Supplier Contact QQ Mail :</th>' +
                            '<td >' + response.supplier_contacts[0].supplier_contact_qq + '</td>' +
                            '<th>Supplier Contact Skype :</th>' +
                            '<td >' + response.supplier_contacts[0].supplier_contact_skype + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<td colspan="4"></td>' +
                            '</tr>');
                        }
                    }

                    //factory
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4>Factory Details </h4></th > ' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Factory Name :</th>' +
                        '<td id="proj_fac_name">' + response.factory.factory_name + '</td>' +
                        '<th>Factory Address :</th>' +
                        '<td id="proj_fac_addr">' + response.factory.factory_address + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">   ' +
                        '<th>Factory Address Local :</th>' +
                        '<td id="proj_fac_addr_loc" colspan="3">' + response.factory.factory_address_local + '</td>' +
                        '</tr>');

                    var count_factory = 1;

                    $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                        '<th>Factory Contact Person ' + count_factory + ':</th>' +
                        '<td >' + response.factory_contact1.factory_contact_person + '</td>' +
                        '<th>Factory Contact Email :</th>' +
                        '<td >' + response.factory_contact1.factory_email + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Factory Telephone Number :</th>' +
                        '<td >' + response.factory_contact1.factory_tel_number + '</td>' +
                        ' <th>Factory Mobile Number :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_number + '</td>' +

                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Factory Contact We Chat :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_wechat + '</td>' +
                        '<th>Factory Contact WhatsApp :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_whatsapp + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Factory Contact QQ Mail :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_qq + '</td>' +
                        '<th>Factory Contact Skype :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_skype + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<td colspan="4"></td>' +
                        '</tr>');

                    if (response.factory_contact_list[0] == null|| response.factory_contact_list[0] == 'null') {
                        console.log("this is null");
                    } else {
                        response.factory_contact_list.forEach(element => {
                            count_factory += 1;
                            $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                                '<th>Factory Contact Person ' + count_factory + ':</th>' +
                                '<td >' + element.factory_contact_person + '</td>' +
                                '<th>Factory Contact Email :</th>' +
                                '<td >' + element.factory_email + '</td>' +
                                '</tr>' +
                                '<tr class="proj_added_row">' +
                                '<th>Factory Telephone Number :</th>' +
                                '<td >' + element.factory_tel_number + '</td>' +
                                ' <th>Factory Mobile Number :</th>' +
                                '<td >' + element.factory_contact_number + '</td>' +

                                '</tr>' +
                                '<tr class="proj_added_row">' +
                                '<th>Factory Contact We Chat :</th>' +
                                '<td >' + element.factory_contact_wechat + '</td>' +
                                '<th>Factory Contact WhatsApp :</th>' +
                                '<td >' + element.factory_contact_whatsapp + '</td>' +
                                '</tr>' +
                                '<tr class="proj_added_row">' +
                                '<th>Factory Contact QQ Mail :</th>' +
                                '<td >' + element.factory_contact_qq + '</td>' +
                                '<th>Factory Contact Skype :</th>' +
                                '<td >' + element.factory_contact_skype + '</td>' +
                                '</tr>' +
                                '<tr class="proj_added_row">' +
                                '<td colspan="4"></td>' +
                                '</tr>');
                        });
                    }

                    //product
                    $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" style="background-color:lightgrey"><th colspan="4"><h4>Product Details</h4></th></tr>');
                    var count_product = 0;
                    var pname;
                    var pcategory;
                    response.psi_product.forEach(element => {

                        /* response.products.forEach(p_element => {
                            console.log(p_element.product_name);
                            if (p_element.id == element.product_name) {
                                pname = p_element.product_name;
                                pcategory = p_element.product_category;
                            }
                        }); */
                        count_product += 1;


                        var product_length1="";
                        var product_width1="";
                        var product_height1="";
                        var product_diameter1="";
                        var product_weight1="";
                        var retail_length1="";
                        var retail_width1="";
                        var retail_height1="";
                        var retail_diameter1="";
                        var retail_weight1="";
                        var retail_box_qty1="";
                        var inner_length1="";
                        var inner_width1="";
                        var inner_height1="";
                        var inner_diameter1="";
                        var inner_weight1="";
                        var inner_box_qty1="";
                        var export_length1="";
                        var export_width1="";
                        var export_height1="";
                        var export_diameter1="";
                        var export_weight1="";
                        var export_max_weight_carton1="";
                        var export_box_qty1="";
                        var grd1="";
                        var item_description1="";
                        
                        if(element.product_length != null && element.product_length != "null" && element.product_length != "" && element.product_length != ''){
                            product_length1=element.product_length;
                        }
                        if(element.product_width != null && element.product_width != "null" && element.product_width != "" && element.product_width != ''){
                            product_width1=element.product_width;
                        }
                        if(element.product_height != null && element.product_height != "null" && element.product_height != "" && element.product_height != ''){
                            product_height1=element.product_height;
                        }
                        if(element.product_diameter != null && element.product_diameter != "null" && element.product_diameter != "" && element.product_diameter != ''){
                            product_diameter1=element.product_diameter;
                        }
                        if(element.product_weight != null && element.product_weight != "null" && element.product_weight != "" && element.product_weight != ''){
                            product_weight1=element.product_weight;
                        }
                        if(element.retail_length != null && element.retail_length != "null" && element.retail_length != "" && element.retail_length != ''){
                            retail_length1=element.retail_length;
                        }
                        if(element.retail_width != null && element.retail_width != "null" && element.retail_width != "" && element.retail_width != ''){
                            retail_width1=element.retail_width;
                        }
                        if(element.retail_height != null && element.retail_height != "null" && element.retail_height != "" && element.retail_height != ''){
                            retail_height1=element.retail_height;
                        }
                        if(element.retail_diameter != null && element.retail_diameter != "null" && element.retail_diameter != "" && element.retail_diameter != ''){
                            retail_diameter1=element.retail_diameter;
                        }
                        if(element.retail_weight != null && element.retail_weight != "null" && element.retail_weight != "" && element.retail_weight != ''){
                            retail_weight1=element.retail_weight;
                        }
                        if(element.retail_box_qty != null && element.retail_box_qty != "null" && element.retail_box_qty != "" && element.retail_box_qty != ''){
                            retail_box_qty1=element.retail_box_qty;
                        }
                        if(element.inner_length != null && element.inner_length != "null" && element.inner_length != "" && element.inner_length != ''){
                            inner_length1=element.inner_length;
                        }
                        if(element.inner_width != null && element.inner_width != "null" && element.inner_width != "" && element.inner_width != ''){
                            inner_width1=element.inner_width;
                        }
                        if(element.inner_height != null && element.inner_height != "null" && element.inner_height != "" && element.inner_height != ''){
                            inner_height1=element.inner_height;
                        }
                        if(element.inner_diameter != null && element.inner_diameter != "null" && element.inner_diameter != "" && element.inner_diameter != ''){
                            inner_diameter1=element.inner_diameter;
                        }
                        if(element.inner_weight != null && element.inner_weight != "null" && element.inner_weight != "" && element.inner_weight != ''){
                            inner_weight1=element.inner_weight;
                        }
                        if(element.inner_box_qty != null && element.inner_box_qty != "null" && element.inner_box_qty != "" && element.inner_box_qty != ''){
                            inner_box_qty1=element.inner_box_qty;
                        }
                        if(element.export_length != null && element.export_length != "null" && element.export_length != "" && element.export_length != ''){
                            export_length1=element.export_length;
                        }
                        if(element.export_width != null && element.export_width != "null" && element.export_width != "" && element.export_width != ''){
                            export_width1=element.export_width;
                        }
                        if(element.export_height != null && element.export_height != "null" && element.export_height != "" && element.export_height != ''){
                            export_height1=element.export_height;
                        }
                        if(element.export_diameter != null && element.export_diameter != "null" && element.export_diameter != "" && element.export_diameter != ''){
                            export_diameter1=element.export_diameter;
                        }
                        if(element.export_weight != null && element.export_weight != "null" && element.export_weight != "" && element.export_weight != ''){
                            export_weight1=element.export_weight;
                        }
                        if(element.export_max_weight_carton != null && element.export_max_weight_carton != "null" && element.export_max_weight_carton != "" && element.export_max_weight_carton != ''){
                            export_max_weight_carton1=element.export_max_weight_carton;
                        }
                        if(element.export_box_qty != null && element.export_box_qty != "null" && element.export_box_qty != "" && element.export_box_qty != ''){
                            export_box_qty1=element.export_box_qty;
                        }
                        if(element.grd != null && element.grd != "null" && element.grd != "" && element.grd != ''){
                            grd1=element.grd;
                        }
                        if(element.item_description != null && element.item_description != "null" && element.item_description != "" && element.item_description != ''){
                            item_description1=element.item_description;
                        }

                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<th>Product ' + count_product + '  :</th>' +
                            '<td>' + element.product_name + '</th>' +
                            '<th>Product Category :</th>' +
                            '<td>' + element.product_category + '</th>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Product Quantity :</th>' +
                            '<td>' + element.aql_qty + '</th>' +
                            '<th > Brand</td>' +
                            '<td >' + element.brand + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>PO No :</th>' +
                            '<td>' + element.po_no + '</th>' +
                            '<th> Model No :</td>' +
                            '<td >' + element.model_no + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Sample level :</th>' +
                            '<td>' + element.aql_normal_level + '/' + element.aql_special_level + '</th>' +
                            '<th>Sampling Size :</td>' +
                            '<td >' + element.aql_normal_sampsize + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>AQL Major :</th>' +
                            '<td>' + element.aql_major + '</th>' +
                            '<th>Max allowed major :</td>' +
                            '<td >' + element.max_allowed_major + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>AQL Minor :</th>' +
                            '<td>' + element.aql_minor + '</th>' +
                            '<th>Max allowed minor :</td>' +
                            '<td >' + element.max_allowed_minor + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Additional Product Info :</th>' +
                            '<td colspan="3">' + element.additional_product_info + '</th>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Product :</th>' +
                            '<td colspan="3"> <button class="btn btn-primary btn-sm btn_view_log_prod" id="btn_view_log_prod">View <i class="fa fa-arrow-right"></i></button>' +
                            '<p id="view_logistic_prod" class="hidden view_logistic_prod">' +
                            'Length (cm): <span id="view_prod_length">' + product_length1 + '</span><br/>' +
                            'Width (cm): <span id="view_prod_width">' + product_width1 + '</span><br/>' +
                            'Height (cm): <span id="view_prod_height">' + product_height1 + '</span><br/>' +
                            'Diameter (cm): <span id="view_prod_diameter">' + product_diameter1 + '</span><br/>' +
                            'Weight (kg): <span id="view_prod_weight">' + product_weight1 + '</span><br/>' +
                            '</p>' +
                            '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Retail Pack :</th>' +
                            '<td colspan="3"> <button class="btn btn-primary btn-sm btn_view_log_retail" id="btn_view_log_retail">View <i class="fa fa-arrow-right"></i></button>' +
                            '<p id="view_logistic_retail" class="hidden view_logistic_retail">' +
                            'Length (cm): <span id="view_retail_length">' + retail_length1 + '</span><br/>' +
                            'Width (cm): <span id="view_retail_width">' + retail_width1 + '</span><br/>' +
                            'Height (cm): <span id="view_retail_height">' + retail_height1 + '</span><br/>' +
                            'Diameter (cm): <span id="view_retail_diameter">' + retail_diameter1 + '</span><br/>' +
                            'Weight (kg): <span id="view_retail_weight">' + retail_weight1 + '</span><br/>' +
                            'Retail Box Quantity: <span id="view_retail_box_qty">' + retail_box_qty1 + '</span><br/>' +
                            '</p>' +
                            '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Inner Carton :</th>' +
                            '<td colspan="3"> <button class="btn btn-primary btn-sm btn_view_log_inner" id="btn_view_log_inner">View <i class="fa fa-arrow-right"></i></button>' +
                            '<p id="view_logistic_inner" class="hidden view_logistic_inner">' +
                            'Length (cm): <span id="view_inner_length">' + inner_length1 + '</span><br/>' +
                            'Width (cm): <span id="view_inner_width">' + inner_width1 + '</span><br/>' +
                            'Height (cm): <span id="view_inner_height">' + inner_height1 + '</span><br/>' +
                            'Diameter (cm): <span id="view_inner_diameter">' +inner_diameter1 + '</span><br/>' +
                            'Weight (kg): <span id="view_inner_weight">' + inner_weight1 + '</span><br/>' +
                            'Inner Box Quantity: <span id="view_inner_box_qty">' + inner_box_qty1 + '</span><br/>' +
                            '</p>' +
                            '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Export Carton :</th>' +
                            '<td colspan="3"> <button class="btn btn-primary btn-sm btn_view_log_export" id="btn_view_log_export">View <i class="fa fa-arrow-right"></i></button>' +
                            '<p id="view_logistic_export" class="hidden view_logistic_export">' +
                            'Length (cm): <span id="view_export_length">' + export_length1 + '</span><br/>' +
                            'Width (cm): <span id="view_export_width">' + export_width1 + '</span><br/>' +
                            'Height (cm): <span id="view_export_height">' + export_height1 + '</span><br/>' +
                            'Diameter (cm): <span id="view_export_diameter">' + export_diameter1 + '</span><br/>' +
                            'Weight (kg): <span id="view_export_weight">' + export_weight1 + '</span><br/>' +
                            'Max. weight of export carton (kg): <span id="view_export_max_weight">' + export_max_weight_carton1 + '</span><br/>' +
                            'Export Box Quantity: <span id="view_export_box_qty">' + export_box_qty1 + '</span><br/>' +
                            '</p>' +
                            '</td>' +
                            '</tr>' +
                            // '<tr class="proj_added_row">' +
                            // '<th>GRD:</th>' +
                            // '<td colspan="3">' + grd1 + '</th>' +
                            // '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Item Description :</th>' +
                            '<td colspan="3">' + item_description1 + '</th>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<td colspan="4"></td>' +
                            '</tr>');




                        //product attachment
                        response.product_photos.forEach(element_pp => {
                            if (element.product_id == element_pp.product_id) {
                                var att_link = "js/dropzone/upload/" + element_pp.photo_category + "/" + element_pp.user_id + "/" + element_pp.file_name;
                                $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                                    '<td colspan="4"><a href="' + att_link + '" download>' +    element_pp.file_name + '</a></td>' +
                                    '</tr>');
                            }
                        });
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<td colspan="4"></td>' +
                            '</tr>');



                    });


                    //attachment
                    if (response.attachments.length > 0) {
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="tr_attachment" style="background-color:lightgrey"><th colspan="4"><h4> Attachments</h4></th></tr>');

                        response.attachments.forEach(element => {
                            $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                                '<td colspan="4"><a target="_blank" href="https://tic-service.company/' + element.path + '">' + element.file_name + '</a>' +
                                '</td>' +
                                '</tr>');

                        });
                    }

                    //requirements and memos
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4> Other Details </h4></th > ' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Requirements :</th>' +
                        '<td colspan="3">' + response.inspection_new.requirement + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Memo :</th>' +
                        '<td colspan="3">' + response.inspection_new.memo + '</td>' +
                        '</tr>');
                    $('#viewProjectDetails').modal();
                    $('.send-loading').hide();
                },
                error: function (err) {
                    console.log(err);
                    $('.send-loading').hide();
                }

            });
        })

        .on('click', '.btn_view_project_cbpi', function () {
            $.ajax({
                url: '/project-details-cbpi/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    //console.log(response.reference[0].report_no);
                    $('#proj_report_number').text(response.reference[0].report_no);
                    $('#proj_service_type').text(services[response.inspection_new.service]);
                    $('#proj_ins_date').text(response.inspection_new.inspection_date);

                     //06-29-2021
                     if(response.second_inspector.secondary_inspector_id == null || response.second_inspector.secondary_inspector_id == 'null'){
                        var inspectors = response.inspection.name;
                    }else{  
                        var inspectors = response.inspection.name + ', ' + response.second_inspector.name;
                    }

                    $('#proj_ass_ins').text(inspectors);

                    // $('#proj_ass_ins').text(response.inspection.name);

                    $('#proj_report_password').text(response.reference[0].password);
                    $('#proj_cli_pro_num').text(response.inspection_new.client_project_number);

                    $('.proj_added_row').remove();

                    var client_addr = response.clients.company_house_num + ', ' + response.clients.company_street_num + ', ' + response.clients.company_city_name + ', ' + response.clients.company_state_name + ', ' + response.clients.company_country_name;

                    //client
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4>2. Client Details</h4></th>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Client Name :</th>' +
                        '<td id="proj_client_name">' + response.clients.client_name + '</td>' +
                        '<th>Client Code :</th>' +
                        '<td id="proj_client_code">' + response.clients.client_code + '</td>' +
                        '</tr>' +

                        '<tr class="proj_added_row">' +
                        '<th>Client Email :</th>' +
                        '<td id="proj_client_email">' + response.clients.Company_Email + '</td>' +
                        '<th>Client Telephone Number :</th>' +
                        '<td id="proj_client_num">' + response.clients.Phone_number + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Client Address :</th>' +
                        '<td id="proj_client_address" colspan="3">' + client_addr + '</td>' +
                        '</tr>');
                    var count_client = 0;
                    response.client_contact_list.forEach(element => {
                        count_client += 1;
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<th>Client Contact Person ' + count_client + ':</th>' +
                            '<td id="proj_cli_cont_per">' + element.contact_person + '</td>' +
                            '<th>Client Contact Email :</th>' +
                            '<td id="proj_client_con_email">' + element.email_address + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Client Telephone Number :</th>' +
                            '<td id="proj_cli_tel_num">' + element.tel_number + '</td>' +
                            ' <th>Client Mobile Number :</th>' +
                            '<td id="proj_cli_mob_num">' + element.contact_number + '</td>' +

                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Client Contact We Chat :</th>' +
                            '<td id="proj_cli_cont_wechat">' + element.client_wechat + '</td>' +
                            '<th>Client Contact WhatsApp :</th>' +
                            '<td id="proj_cli_cont_whatsapp">' + element.client_whatsapp + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Client Contact QQ Mail :</th>' +
                            '<td id="proj_cli_cont_qqmail">' + element.client_qqmail + '</td>' +
                            '<th>Client Contact Skype :</th>' +
                            '<td id="proj_cli_cont_skype">' + element.client_skype + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<td colspan="4"></td>' +
                            '</tr>');
                    });

                    //factory
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4> 3. Factory Details </h4></th > ' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Factory Name :</th>' +
                        '<td id="proj_fac_name">' + response.factory.factory_name + '</td>' +
                        '<th>Factory Address :</th>' +
                        '<td id="proj_fac_addr">' + response.factory.factory_address + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">   ' +
                        '<th>Factory Address Local :</th>' +
                        '<td id="proj_fac_addr_loc" colspan="3">' + response.factory.factory_address_local + '</td>' +
                        '</tr>');

                    var count_factory = 1;

                    $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                        '<th>Factory Contact Person ' + count_factory + ':</th>' +
                        '<td >' + response.factory_contact1.factory_contact_person + '</td>' +
                        '<th>Factory Contact Email :</th>' +
                        '<td >' + response.factory_contact1.factory_email + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Factory Telephone Number :</th>' +
                        '<td >' + response.factory_contact1.factory_tel_number + '</td>' +
                        ' <th>Factory Mobile Number :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_number + '</td>' +

                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Factory Contact We Chat :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_wechat + '</td>' +
                        '<th>Factory Contact WhatsApp :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_whatsapp + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Factory Contact QQ Mail :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_qq + '</td>' +
                        '<th>Factory Contact Skype :</th>' +
                        '<td >' + response.factory_contact1.factory_contact_skype + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<td colspan="4"></td>' +
                        '</tr>');



                    console.log(response.factory_contact_list[0]);
                    if (response.factory_contact_list[0] == null|| response.factory_contact_list[0] == 'null') {
                        console.log("this is null");
                    } else {
                        console.log("this is not null");
                        //factory contacts
                        response.factory_contact_list.forEach(element => {
                            count_factory += 1;
                            $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                                '<th>Factory Contact Person ' + count_factory + ':</th>' +
                                '<td >' + element.factory_contact_person + '</td>' +
                                '<th>Factory Contact Email :</th>' +
                                '<td >' + element.factory_email + '</td>' +
                                '</tr>' +
                                '<tr class="proj_added_row">' +
                                '<th>Factory Telephone Number :</th>' +
                                '<td >' + element.factory_tel_number + '</td>' +
                                ' <th>Factory Mobile Number :</th>' +
                                '<td >' + element.factory_contact_number + '</td>' +

                                '</tr>' +
                                '<tr class="proj_added_row">' +
                                '<th>Factory Contact We Chat :</th>' +
                                '<td >' + element.factory_contact_wechat + '</td>' +
                                '<th>Factory Contact WhatsApp :</th>' +
                                '<td >' + element.factory_contact_whatsapp + '</td>' +
                                '</tr>' +
                                '<tr class="proj_added_row">' +
                                '<th>Factory Contact QQ Mail :</th>' +
                                '<td >' + element.factory_contact_qq + '</td>' +
                                '<th>Factory Contact Skype :</th>' +
                                '<td >' + element.factory_contact_skype + '</td>' +
                                '</tr>' +
                                '<tr class="proj_added_row">' +
                                '<td colspan="4"></td>' +
                                '</tr>');
                        });
                    }

                    //attachment
                    if (response.attachments.length > 0) {
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="tr_attachment" style="background-color:lightgrey"><th colspan="4"><h4>4. Attachments</h4></th></tr>');

                        response.attachments.forEach(element => {
                            $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                                '<td colspan="4"><a target="_blank" href="https://tic-service.company/' + element.path + '">' + element.file_name + '</a>' +
                                '</td>' +
                                '</tr>');

                        });
                    }

                    //requirements and memos
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4> Other Details </h4></th > ' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Requirements :</th>' +
                        '<td colspan="3">' + response.inspection_new.requirement + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Memo :</th>' +
                        '<td colspan="3">' + response.inspection_new.memo + '</td>' +
                        '</tr>');

                    $('#viewProjectDetails').modal();

                }

            });
        })

        .on('click', '.btn_view_project_site', function () {
            $.ajax({
                url: '/project-details-cbpi/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    //console.log(response.reference[0].report_no);
                    $('#proj_report_number').text(response.reference[0].report_no);
                    $('#proj_service_type').text(response.inspection_new.service);
                    $('#proj_ins_date').text(response.inspection_new.inspection_date);
                    $('#proj_ass_ins').text(response.inspection_new.name);
                    $('#proj_report_password').text(response.reference[0].password);
                    $('#proj_cli_pro_num').text(response.inspection_new.client_project_number);

                    $('.proj_added_row').remove();

                    var client_addr = response.clients.company_house_num + ', ' + response.clients.company_street_num + ', ' + response.clients.company_city_name + ', ' + response.clients.company_state_name + ', ' + response.clients.company_country_name;

                    //company details
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4>2. Company Details</h4></th>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Company Name :</th>' +
                        '<td >' + response.inspection_new.com_name + '</td>' +
                        '<th>Company Address :</th>' +
                        '<td >' + response.inspection_new.comp_addr + '</td>' +
                        '</tr>' +

                        '<th>Company Additional Info :</th>' +
                        '<td colspan="3">' + response.inspection_new.comp_other_info + '</td>' +
                        '</tr>');

                    //client
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4>3. Client Details</h4></th>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Client Name :</th>' +
                        '<td id="proj_client_name">' + response.clients.client_name + '</td>' +
                        '<th>Client Code :</th>' +
                        '<td id="proj_client_code">' + response.clients.client_code + '</td>' +
                        '</tr>' +

                        '<tr class="proj_added_row">' +
                        '<th>Client Email :</th>' +
                        '<td id="proj_client_email">' + response.clients.Company_Email + '</td>' +
                        '<th>Client Telephone Number :</th>' +
                        '<td id="proj_client_num">' + response.clients.Phone_number + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Client Address :</th>' +
                        '<td id="proj_client_address" colspan="3">' + client_addr + '</td>' +
                        '</tr>');
                    var count_client = 0;
                    response.client_contact_list.forEach(element => {
                        count_client += 1;
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<th>Client Contact Person ' + count_client + ':</th>' +
                            '<td id="proj_cli_cont_per">' + element.contact_person + '</td>' +
                            '<th>Client Contact Email :</th>' +
                            '<td id="proj_client_con_email">' + element.email_address + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Client Telephone Number :</th>' +
                            '<td id="proj_cli_tel_num">' + element.tel_number + '</td>' +
                            ' <th>Client Mobile Number :</th>' +
                            '<td id="proj_cli_mob_num">' + element.contact_number + '</td>' +

                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Client Contact We Chat :</th>' +
                            '<td id="proj_cli_cont_wechat">' + element.client_wechat + '</td>' +
                            '<th>Client Contact WhatsApp :</th>' +
                            '<td id="proj_cli_cont_whatsapp">' + element.client_whatsapp + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<th>Client Contact QQ Mail :</th>' +
                            '<td id="proj_cli_cont_qqmail">' + element.client_qqmail + '</td>' +
                            '<th>Client Contact Skype :</th>' +
                            '<td id="proj_cli_cont_skype">' + element.client_skype + '</td>' +
                            '</tr>' +
                            '<tr class="proj_added_row">' +
                            '<td colspan="4"></td>' +
                            '</tr>');
                    });

                    //attachment
                    if (response.attachments.length > 0) {
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="tr_attachment" style="background-color:lightgrey"><th colspan="4"><h4>4. Attachments</h4></th></tr>');

                        response.attachments.forEach(element => {
                            $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                                '<td colspan="4"><a target="_blank" href="https://tic-service.company/' + element.path + '">' + element.file_name + '</a>' +
                                '</td>' +
                                '</tr>');

                        });
                    }

                    //requirements and memos
                    $('#table_view_project > tbody:last-child').append('<tr style="background-color:lightgrey" class="proj_added_row">' +
                        '<th colspan="4"><h4> Other Details </h4></th > ' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Requirements :</th>' +
                        '<td colspan="3">' + response.inspection_new.requirement + '</td>' +
                        '</tr>' +
                        '<tr class="proj_added_row">' +
                        '<th>Memo :</th>' +
                        '<td colspan="3">' + response.inspection_new.memo + '</td>' +
                        '</tr>');

                    $('#viewProjectDetails').modal();

                }

            });
        })

        .on('click', '.delete-inspection', function () {
            var insp_id = $(this).data('id');
            console.log(insp_id);
            //console.log($(this).parents('tr'));
            $('.send-loading').show();
            $.ajax({
                url: '/get-one-inspect/' + insp_id,
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    var c_service = response.inspection.service;
                    var c_service_up = c_service.toUpperCase();
                    $('#delete_client').val(response.client.Company_Name);
                    $('#delete_service').val(c_service_up);
                    $('#delete_rn').val(response.inspection.reference_number);
                    $('#delete_ins_id').val(insp_id);
                    $('.send-loading').hide();
                    $('#deleteInspect').modal();
                },
                error: function (err) {
                    console.log(err);
                    $('.send-loading').hide();
                    //$('#cancelInspect').modal();
                }
            });
        })

        .on('click', '#btn_del_inspect', function () {
            var insp_id = $('#delete_ins_id').val();
            console.log(insp_id);
            //console.log($(this).parents('tr'));
            $('.send-loading').show();
            $.ajax({
                url: '/del-client-inspection/' + insp_id,
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('.send-loading').hide();
                    swal({
                        title: "Success!",
                        text: "Client inspection has been deleted",
                        type: "success",
                    }, function () {
                        window.location.href = '/client-booking';
                    });
                },
                error: function (err) {
                    console.log(err);
                    $('.send-loading').hide();
                    swal({
                        title: "Error!",
                        text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                        type: "error",
                    });
                }
            });
        })

        .on('click', '.btn-publish', function () {
            var insp_id = $(this).data('id');
            $.ajax({
                url: '/short-publish/' + $(this).data('id'),
                type: 'GET',
                success: function (response) {
                    console.log(response);
                    $('#title_publish').text('Inspection for ' + response.inspection_new.client_project_number + ' at ' + response.factory.factory_name + ' in ' + response.factory.factory_address + '  (' + response.inspection_new.inspection_date + ')');

                    $('#pub_sel_ins').empty();
                    $('#pub_sel_ins').append('<option value="">Select Inspector</option>');
                    response.inspectors.forEach(element => {
                        $('#pub_sel_ins').append('<option value="' + element.user_id + '">' + element.name + '</option>');
                    });
                    $('#pub_sel_ins').val(response.inspection_new.inspector_id);

                    $('#template_pub').empty();
                    $('#template_pub').append('<option value="">Select Template</option>');
                    response.templates.forEach(element => {
                        $('#template_pub').append('<option value="' + element.id + '">' + element.name + '</option>');
                    });

                    if (response.inspection_new.project_type == 'app_project') {
                        $('#app_project').prop("checked", true);
                        $('#word_project').prop("checked", false);
                        $('#div_template_pub').show();
                        $('#template_pub').val(response.inspection_new.template_id);
                    } else if (response.inspection_new.project_type == 'word_project') {
                        $('#app_project').prop("checked", false);
                        $('#word_project').prop("checked", true);
                        $('#div_template_pub').hide();
                        $('#template_pub').val('');
                    } else {
                        $('#app_project').prop("checked", false);
                        $('#word_project').prop("checked", false);
                        $('#div_template_pub').hide();
                        $('#template_pub').val('');
                    }
                    console.log(response.inspection_new.project_type);
                    console.log(response.attachment.length);
                    $('#pub_insp_id').val(insp_id);
                    $('#attachment_len').val(response.attachment.length);
                    $('#pub_service').val(response.inspection_new.service);
                    $('#publishDraftInspection').modal();
                }
            });
        })

        .on('click', '.btn_view_log_prod', function () {
            var get_element = $(this).closest('tr').find('.view_logistic_prod'); //proj_added_row
            if (get_element.hasClass('hidden')) {
                get_element.removeClass('hidden');
            } else {
                get_element.addClass('hidden');
            }
        })

        .on('click', '.btn_view_log_retail', function () {
            var get_element = $(this).closest('tr').find('.view_logistic_retail');
            if (get_element.hasClass('hidden')) {
                get_element.removeClass('hidden');
            } else {
                get_element.addClass('hidden');
            }
        })

        .on('click', '.btn_view_log_inner', function () {
            var get_element = $(this).closest('tr').find('.view_logistic_inner');
            if (get_element.hasClass('hidden')) {
                get_element.removeClass('hidden');
            } else {
                get_element.addClass('hidden');
            }
        })

        .on('click', '.btn_view_log_export', function () {
            var get_element = $(this).closest('tr').find('.view_logistic_export');
            if (get_element.hasClass('hidden')) {
                get_element.removeClass('hidden');
            } else {
                get_element.addClass('hidden');
            }
        })



    /*$("#btn_view_log_prod" + count_product).click(function () {
        if ($('#view_logistic_prod' + count_product).hasClass('hidden')) {
            $('#view_logistic_prod' + count_product).removeClass('hidden');
        } else {
            $('#view_logistic_prod' + count_product).addClass('hidden');
        }
    });


    $("#btn_view_log_retail" + count_product).click(function () {
        if ($('#view_logistic_retail' + count_product).hasClass('hidden')) {
            $('#view_logistic_retail' + count_product).removeClass('hidden');
        } else {
            $('#view_logistic_retail' + count_product).addClass('hidden');
        }
    });*/


    /* $("#btn_view_log_inner" + count_product).click(function () {
         if ($('#view_logistic_inner' + count_product).hasClass('hidden')) {
             $('#view_logistic_inner' + count_product).removeClass('hidden');
         } else {
             $('#view_logistic_inner' + count_product).addClass('hidden');
         }
     });*/

    /*$("#btn_view_log_export" + count_product).click(function () {
        if ($('#view_logistic_export' + count_product).hasClass('hidden')) {
            $('#view_logistic_export' + count_product).removeClass('hidden');
        } else {
            $('#view_logistic_export' + count_product).addClass('hidden');
        }
    });*/

    /* .on('click', '#btn_view_log_prod', function () {
         if ($('#view_logistic_prod').hasClass('hidden')) {
             $('#view_logistic_prod').removeClass('hidden');
         } else {
             $('#view_logistic_prod').addClass('hidden');
         }
     })

     .on('click', '#btn_view_log_retail', function () {
         if ($('#view_logistic_retail').hasClass('hidden')) {
             $('#view_logistic_retail').removeClass('hidden');
         } else {
             $('#view_logistic_retail').addClass('hidden');
         }
     })

     .on('click', '#btn_view_log_inner', function () {
         if ($('#view_logistic_inner').hasClass('hidden')) {
             $('#view_logistic_inner').removeClass('hidden');
         } else {
             $('#view_logistic_inner').addClass('hidden');
         }
     })

     .on('click', '#btn_view_log_export', function () {
         if ($('#view_logistic_export').hasClass('hidden')) {
             $('#view_logistic_export').removeClass('hidden');
         } else {
             $('#view_logistic_export').addClass('hidden');
         }
     })*/
});
