@extends('layouts.new')
@section('title','Calendar Inspections')
@section('page-title','Calendar Inspections')

@section('stylesheets')
{!! Html::style('/css/admin/dashboard.css') !!}
{!! Html::style('/css/admin/project.css') !!}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<style>
	.fa-loader {
		-webkit-animation: spin 2s linear infinite;
		-moz-animation: spin 2s linear infinite;
		animation: spin 2s linear infinite;
	}

	@-moz-keyframes spin {
		100% {
			-moz-transform: rotate(360deg);
		}
	}

	@-webkit-keyframes spin {
		100% {
			-webkit-transform: rotate(360deg);
		}
	}

	@keyframes spin {
		100% {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
		}
	}

	.content-header h1 {
		border-bottom: 3px solid orange;
		width: 20%;
		text-align: center;
		margin: 0 auto;
	}

</style>
@endsection

@section('content')
<!-- <div class="container"> -->
    <div class="row">
        <div class="col-md-12">
            <div class="response"></div>
            <div id='calendar' style="background-color:#FFFFFF !important;"></div>  
        </div>
    </div>
<!-- </div> -->

@include('partials.reports_reviewer.dashboard._viewprojectdetails')
@include('partials.reports_reviewer.dashboard._viewprojectdetails_cbpi')
<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js" integrity="sha256-4iQZ6BVL4qNKlQ27TExEhBN1HFPvAvAMbFavKKosSWQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script>
	$(window).on('load', function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});

    $(document).ready(function () {
         
         var SITEURL = "{{url('/')}}";
         $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
         });
  
         var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: SITEURL + "/booking-inspection-calendar",
            displayEventTime: true,
            editable: true,
            eventRender : function(event, element) {
                //element[0].title = event.title;
            },
            
            selectable: true,
            allDaySlot: true,
            selectHelper: true,
            select: function (start, end, allDay) {
                calendar.fullCalendar('unselect');
            },
             
            events: SITEURL+ '/load-booking-calendar-data',
            /* eventColor: '#3e9cbf', */
            eventTextColor: '#FFFFFF', 
 
            eventClick: function (event, jsEvent, view) {
               //$("#inspecID").val(event.id);
               //console.log('event id:'+event.id);
                var inspect_id=event.id;
                var service=event.service;
                if(service=='psi' || service=='iqi' || service=='dupro'  || service=='site_visit'){
                    viewPSI(inspect_id);
                }else{
                    viewCBPI(inspect_id);
                } 
            },
            eventMouseover: function (event, jsEvent, view) {  
                //console.log('event:'+event.start);
                //tooltip.hide();        
                tooltip = '<div class="tooltiptopicevent" style="width:auto;height:auto;background:#f7f5f5;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;  line-height: 200%;">' + 'Service : ' + event.service + '</br>' + 'Report # : '+ event.report_no + '</br>' + 'Client : '+ event.client + '</br>' + 'Booked : '+ event.book_mngr + '</br>' + 'Inspection date : '+ event.ins_date +  '</div>';

                $("body").append(tooltip);
                $(this).mouseover(function (e) {
                    $(this).css('z-index', 10000);
                    $('.tooltiptopicevent').fadeIn('500');
                    $('.tooltiptopicevent').fadeTo('10', 1.9);
                }).mousemove(function (e) {
                    $('.tooltiptopicevent').css('top', e.pageY + 10);
                    $('.tooltiptopicevent').css('left', e.pageX + 20);
                });

            },
            eventMouseout: function (data, event, view) {
                $(this).css('z-index', 8);
    
                $('.tooltiptopicevent').remove();
    
            },
            dayClick: function () {
                tooltip.hide()
            },
            eventResizeStart: function () {
                tooltip.hide()
            },
            eventDragStart: function () {
                tooltip.hide()
            },
            viewDisplay: function () {
                tooltip.hide()
            },
            loading: function (bool) {
                console.log('events are being rendered'); // Add your script to show loading
                $('.send-loading').show();
            },
            eventAfterAllRender: function (view) {
                console.log('all events are rendered'); // remove your loading 
                $('.send-loading').hide();
            }
  
         });
 
         /* $(".fc-title").each(function() {
             $(this).attr("title", $(this).text());
         }) */
         $(".fc-title").each(function() {
             $(this).removeAttr("title");
         })
   });

   function viewPSI(id) {
            $('.send-loading').show();
            var dis_id=id;
            $.ajax({
                url: '/project-details/' + dis_id,
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
                    
                    var btn_action='<div class="dropdown">'+
                        '<button class="btn btn-sm btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Select Action'+
                        '<span class="caret"></span></button>'+
                        '<ul class="dropdown-menu">'+
                            '<li><a href="/edit-project/'+dis_id+'" title="Edit Project Details">Edit</li>'+
                            '<li><a href="/track-inspections/'+dis_id+'"  title="Track Project">Track</a></li>'+
                        '</ul>'+
                        '</div>';
                    $('#div-action-psi').empty();
                    $('#div-action-psi').append(btn_action);

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
                    $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="tr_attachment" style="background-color:lightgrey"><th colspan="4"><h4>5. Attachments</h4></th></tr>');
                    if (response.attachments.length > 0) {                  
                        response.attachments.forEach(element => {
                            $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                                '<td colspan="4"><a target="_blank" href="http://ticapp.tk/' + element.path + '">' + element.file_name + '</a>' +
                                '</td>' +
                                '</tr>');

                        });                   
                    }
                    $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="tr_client_attachment" style="background-color:lightgrey"><th colspan="4"><h4>6. Add Attachments</h4></th></tr>');
                    if (response.client_attachments.length > 0) {                  
                        response.client_attachments.forEach(element => {
                            $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="file-attach-'+element.id+'">' +
                                '<td colspan="3"><a target="_blank" href="http://ticapp.tk/' + element.path + '">' + element.file_name + '</a>' +
                                '</td>' +
                                '<td><a  href="#" data-id="'+element.id+'" class="remove-adedd-file">Remove</a>' +
                                '</td>' +
                                '</tr>');

                        });                   
                    }
                    //var route_add='{{route("client-add-files","'+dis_id+'")}}';
                    $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                    '<td colspan="4"><a target="_blank" class="btn btn-primary" href="client-add-files/'+dis_id+'">Add attachment</a>' +
                    '</td>' +
                    '</tr>');
                    

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
        }

    function viewCBPI(id) {
        $('.send-loading').show();
        var dis_id=id;
        $.ajax({
            url: '/project-details-cbpi/' + dis_id,
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

                var btn_action='<div class="dropdown">'+
                        '<button class="btn btn-sm btn-warning dropdown-toggle" type="button" data-toggle="dropdown">Select Action'+
                        '<span class="caret"></span></button>'+
                        '<ul class="dropdown-menu">'+
                            '<li><a href="/edit-project-cbpi/'+dis_id+'" title="Edit Project Details">Edit</li>'+
                            '<li><a href="/track-inspections/'+dis_id+'"  title="Track Project">Track</a></li>'+
                        '</ul>'+
                        '</div>';
                $('#div-action-psi').empty();
                $('#div-action-psi').append(btn_action);

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
                $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="tr_attachment" style="background-color:lightgrey"><th colspan="4"><h4>4. Attachments</h4></th></tr>');
                if (response.attachments.length > 0) {                  
                    response.attachments.forEach(element => {
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<td colspan="4"><a target="_blank" href="http://ticapp.tk/' + element.path + '">' + element.file_name + '</a>' +
                            '</td>' +
                            '</tr>');

                    });           
                }
                $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="tr_client_attachment" style="background-color:lightgrey"><th colspan="4"><h4>6. Add Attachments</h4></th></tr>');
                    if (response.client_attachments.length > 0) {                  
                        response.client_attachments.forEach(element => {
                            $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row"  id="file-attach-'+element.id+'">' +
                                '<td colspan="3"><a target="_blank" href="http://ticapp.tk/' + element.path + '">' + element.file_name + '</a>' +
                                '</td>' +
                                '<td><a  href="#" data-id="'+element.id+'" class="remove-adedd-file">Remove</a>' +
                                '</td>' +
                                '</tr>');

                        });                   
                    }

                var route_add='{{route("client-add-files","'dis_id'")}}';
                $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                '<td colspan="4"><a target="_blank" class="btn btn-primary" href="client-add-files/'+dis_id+'">Add attachment</a>' +
                '</td>' +
                '</tr>');
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
    }

 
</script>
@endsection
