@extends('layouts.reports_reviewer_template')

@section('title', 'Inspection List | Reports Reviewer')
@section('stylesheets')
{!! Html::style('/css/dropzone.css') !!}
@endsection


@section('topbar')

@endsection
@section('sidebar')

@endsection

@section('content')
<div class="row">
	<div class="col-md-12 padding-b-25">
		<h3>Inspections</h3>
		<div class="table-responsive">
			<table id="inspections_table" class="table table-condensed cell-bor small dataTable no-footer">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Client Type</th>
                        <th>Service</th>
                        <th>Report #</th>
                        <th>Inspector</th>                        
                        <th>Account Manager</th>                 
                        <th>Inspection Date</th>
                        <th>Status</th>
                        <th>Action</th>                    
                    </tr>
                </thead>
            </table>
		</div>
	</div>
</div>
<div class="send-loading"></div>
@include('partials.reports_reviewer.dashboard._viewprojectdetails')
@include('partials.reports_reviewer.dashboard._viewprojectdetails_cbpi')

@endsection
@section('scripts')

<script>
	$(document).ready(function() {
		var token = "{{csrf_token()}}";
		$('#inspections_table').DataTable({
        "order": [
            [6, "desc"]
        ],
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "/get-rpt-inspectionlist",
            "dataType": "json",
            "type": "POST",
            "data": {
                _token: token
            }
        },
        "columns": [{
                "data": "client"
            },
            {
                "data": "inspection_type"
            },
            {
                "data": "service"
            },
            {
                "data": "reference_number"
            },
            {
                "data": "inspector_name"
            },
            {
                "data": "created_by"
            },
            {
                "data": "inspection_date"
            },
            {
                "data": "status"
            },
            {
                "data": "action",
                "searchable": false,
                "orderable": false
            }
        ]

	});
	

	$('body')
        .on('click', '.btn_view_project', function() {
            $('.send-loading').show();
            $.ajax({
                url: '/project-details/' + $(this).data('id'),
                type: 'GET',
                success: function(response) {
                    console.log(response);
                    $('.send-loading').hide();
                    //console.log(response.reference[0].password);
                    $('#proj_report_number').text(response.reference[0].report_no);
                    $('#proj_report_password').text(response.reference[0].password);
                    $('#proj_service_type').text(response.inspection.service);
                    var ins_date = response.inspection_new.inspection_date;
                    var ins_date_to = response.inspection_new.inspection_date_to;
                    if (ins_date == ins_date_to) {

                    } else {
                        ins_date = ins_date + ' to ' + ins_date_to;
                    }


                    $('#proj_ins_date').text(ins_date);
                    $('#proj_cli_pro_num').text(response.inspection_new.client_project_number);

                    $('#proj_ass_ins').text(response.inspection.name);


                    $('#proj_client_email').text(response.inspection.email_address);
                    $('#proj_client_num').text(response.inspection.contact_number);
                    var client_addr = response.clients.company_house_num + ', ' + response.clients.company_street_num + ', ' + response.clients.company_city_name + ', ' + response.clients.company_state_name + ', ' + response.clients.company_country_name;

                    $('.proj_added_row').remove();


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

                    if (response.factory_contact_list[0] == null || response.factory_contact_list[0] == 'null') {
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
                    $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" style="background-color:lightgrey"><th colspan="4"><h4>4. Product Details</h4></th></tr>');
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
                            '<td colspan="4"></td>' +
                            '</tr>');
                    });

                    //attachment
                    if (response.attachments.length > 0) {
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="tr_attachment" style="background-color:lightgrey"><th colspan="4"><h4>5. Attachments</h4></th></tr>');

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

                },
                error: function(err) {
                    console.log(err);
                    $('.send-loading').hide();
                }

            });
        })

    .on('click', '.btn_view_project_cbpi', function() {
        $('.send-loading').show();
        $.ajax({
            url: '/project-details-cbpi/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);
                //console.log(response.reference[0].report_no);
                $('#proj_report_number').text(response.reference[0].report_no);
                $('#proj_service_type').text(response.inspection_new.service);
                var ins_date = response.inspection_new.inspection_date;
                var ins_date_to = response.inspection_new.inspection_date_to;
                if (ins_date == ins_date_to) {} else {
                    ins_date = ins_date + ' to ' + ins_date_to;
                }

                $('#proj_ins_date').text(ins_date);
                $('#proj_ass_ins').text(response.inspection_new.name);
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
                if (response.factory_contact_list[0] == null || response.factory_contact_list[0] == 'null') {
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
                $('.send-loading').hide();
            },
            error: function(err) {
                console.log(err);
                $('.send-loading').hide();
            }

        });
    })

    .on('click', '.btn_view_project_site', function() {
        $('.send-loading').show();
        $.ajax({
            url: '/project-details-cbpi/' + $(this).data('id'),
            type: 'GET',
            success: function(response) {
                console.log(response);
                //console.log(response.reference[0].report_no);
                $('#proj_report_number').text(response.reference[0].report_no);
                $('#proj_service_type').text(response.inspection_new.service);
                var ins_date = response.inspection_new.inspection_date;
                var ins_date_to = response.inspection_new.inspection_date_to;
                if (ins_date == ins_date_to) {} else {
                    ins_date = ins_date + ' to ' + ins_date_to;
                }

                $('#proj_ins_date').text(ins_date);
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
                $('.send-loading').hide();
            }

        });
    })



	});

</script>

@endsection
