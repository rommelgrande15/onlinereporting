@extends('layouts.client._new')
@section('title','Dashboard Statistics')
@section('page-title','Dashboard Statistics')

@section('stylesheets')
{!! Html::style('/css/admin/dashboard.css') !!}
{!! Html::style('/css/admin/project.css') !!}
<!-- daterange picker -->
<link rel="stylesheet" href="css/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
<script src="https://code.iconify.design/1/1.0.5/iconify.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
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

    .margin-right-twenty {
        margin-right: 20px !important;
    }

    .info-box-dashboard {
        display: block;
        min-height: 30px;
        background: #fff;
        width: 100%;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        border-radius: 2px;
        margin-bottom: 15px;
    }

    .info-box-icon-dashboard {
        border-top-left-radius: 2px;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 2px;
        display: block;
        float: left;
        height: 32px;
        width: 32px;
        text-align: center;
        font-size: 20px;
        line-height: 35px;
        background: rgba(0, 0, 0, 0.2);
    }

    .info-box-content-dashboard {
        padding: 5px 10px;
        margin-left: 35px;
    }
</style>
@endsection

@section('content')

<!-- Info boxes -->

<div class="row">
    <div class="col-md-12">
        <form class="form-inline" action="" method="post">
            {!!csrf_field()!!}
            <div class="form-group margin-right-twenty">
                <label>Filter By Supplier:</label>
                <select class="form-control" name="select_supplier" id="select_supplier">
                    <option value="" selected>Select Supplier</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{$supplier->supplier_number}}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary margin-right-twenty" id="search-date-button" type="submit">Search</button>

            <button class="btn btn-primary margin-right-twenty" id="export_btn" type="button">Export to Excel</button>

            <div class="form-group margin-right-twenty">
                <label>Review Date:</label>
                <div class="input-group">
                    <button type="button" class="btn btn-default btn-block" id="daterange-btn">
                        <span>
                            <i class="fa fa-calendar"></i> Select Date
                        </span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <input type="hidden" id="start_date" name="start_date">
                    <input type="hidden" id="end_date" name="end_date">
                </div>
            </div>
        </form>
        <br>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-dashboard">
            <span class="info-box-icon-dashboard bg-aqua"><span class="iconify" data-icon="wpf:inspection" data-inline="false"></span></span>

            <div class="info-box-content-dashboard">
                <span class="info-box-text">TOTAL INSPECTION / THIS MONTH: &nbsp;<strong>{{ $inspection_count }}</strong></span>
                {{-- <span class="info-box-number" id="inspection_count"></span> --}}
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-dashboard">
            <span class="info-box-icon-dashboard bg-green"><span class="iconify" data-icon="wpf:inspection" data-inline="false"></span></span>

            <div class="info-box-content-dashboard">
                <span class="info-box-text">Total Shipment Accepted: &nbsp;<strong>{{ $inspection_accepted }}</strong></span>
                {{-- <span class="info-box-number" id="inspection_accepted">{{ $inspection_accepted }}</span> --}}
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-dashboard">
            <span class="info-box-icon-dashboard bg-red"><span class="iconify" data-icon="wpf:inspection" data-inline="false"></span></span>

            <div class="info-box-content-dashboard">
                <span class="info-box-text">Total Shipment Rejecte: &nbsp;<strong>{{ $inspection_rejected }}</strong></span>
                {{-- <span class="info-box-number" id="inspection_rejected">{{ $inspection_rejected }}</span> --}}
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-dashboard">
            <span class="info-box-icon-dashboard bg-yellow"><span class="iconify" data-icon="wpf:inspection" data-inline="false"></span></span>

            <div class="info-box-content-dashboard">
                <span class="info-box-text">Total Released: &nbsp;<strong>{{ $released }}</strong></span>
                {{-- <span class="info-box-number" id="released">{{ $released }}</span> --}}
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- fix for small devices only -->
    <div class="clearfix visible-sm-block"></div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-dashboard">
            <span class="info-box-icon-dashboard bg-yellow"><span class="iconify" data-icon="wpf:inspection" data-inline="false"></span></span>

            <div class="info-box-content-dashboard">
                <span class="info-box-text">Total Cancelled/Hold: &nbsp;<strong>{{ $cancelled }}</strong></span>
                {{-- <span class="info-box-number" id="cancelled">{{ $cancelled }}</span> --}}
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-dashboard">
            <span class="info-box-icon-dashboard bg-yellow"><span class="iconify" data-icon="wpf:inspection" data-inline="false"></span></span>

            <div class="info-box-content-dashboard">
                <span class="info-box-text">Total Pending: &nbsp;<strong>{{ $pending }}</strong></span>
                {{-- <span class="info-box-number" id="pending">{{ $pending }}</span> --}}
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-dashboard">
            <span class="info-box-icon-dashboard bg-green"><span class="iconify" data-icon="wpf:inspection" data-inline="false"></span></span>

            <div class="info-box-content-dashboard">
                <span class="info-box-text">Total Pass: &nbsp;<strong>{{ $inspection_client_pass }}</strong></span>
                {{-- <span class="info-box-number" id="pass">{{ $inspection_client_pass }}</span> --}}
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box-dashboard">
            <span class="info-box-icon-dashboard bg-red"><span class="iconify" data-icon="wpf:inspection" data-inline="true"></span></span>

            <div class="info-box-content-dashboard">
                <span class="info-box-text">Total Failed: &nbsp;<strong>{{ $inspection_client_failed }}</strong></span>
                {{-- <span class="info-box-number" id="failed">{{ $inspection_client_failed }}</span> --}}
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>






    <!-- /.col -->
</div>
<!-- /.row -->

<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Latest Inspections</h3>

        <div class="box-tools pull-right">
            <!-- /.box-body -->

            <a href="panel-client/{{ Auth::id() }}" class="btn btn-sm btn-default btn-flat">View All Orders</a>
            <a href="project-client" class="btn btn-sm btn-info btn-flat">Place New Order</a>
            <!-- /.box-footer -->
            <!--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">
            <table id="inspections_tbl" class="table table-condensed cell-border small dataTable no-footer">
                <thead>
                    <tr>
                        <th class="text-left">Project No.</th>
                        <th class="text-left">Factory</th>
                        <th class="text-left">Product Name</th>
                        <th class="text-left">Model / Part No.</th>
                        <th class="text-left">Manday</th>
                        <th class="text-left">PO #</th>
                        <th class="text-left">Status</th>
                        <th class="text-left">Created</th>
                        <th class="text-center">View / Track</th>
                        <th class="text-center">Edit / Cancel</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                        <th class="text-center">.</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.table-responsive -->
    </div>

</div>
<!-- /.box -->

@include('partials.client.reportsPage.acceptReport')
@include('partials.client.reportsPage.rejectReport')
@include('partials.client.reportsPage._view_report')

@include('partials.client.reportsPage.confirm_remove_file')

@include('partials.client.dashboard._viewprojectdetails')
@include('partials.client.dashboard._cancelinspection')
@include('partials.client.dashboard._deleteinspection')
@include('partials.reports_reviewer.dashboard._viewprojectdetails_cbpi')
<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="js/daterangepicker.js"></script>
<script type="text/javascript" src="https://unpkg.com/xlsx@0.11.18/dist/xlsx.full.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/file-saver@1.3.3/FileSaver.js"></script>
<!-- bootstrap datepicker -->
<script src="js/bootstrap-datepicker.min.js"></script>
<script>
    $(window).on('load', function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
    $(document).ready(function() {

        $('#select_supplier').select2();

        $('#inspections_tbl').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ route('panel-client-get') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{csrf_token()}}",
                    client_book: 'true'
                }
            },
            "lengthChange": false,
            "order": [
                [7, "desc"]
            ],
            "columns": [
                {
                    "data": "client_project_number"
                },
                {
                    "data": "factory_name"
                },
                {
                    "data": "product_names"
                },
                {
                    "data": "model_no"
                },
                {
                    "data": "manday"
                },
                {
                    "data": "po_no"
                },
                {
                    "data": "inspection_status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "view_edit",
                    "orderable": false,
                    "searcheable": false
                },
                {
                    "data": "edit_cancel",
                    "orderable": false,
                    "searcheable": false
                }
            ]

        });


        $('#inspections_table').dataTable({
            "order": [
                [6, "desc"]
            ],
            "columns": [
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                {
                    "orderable": false,
                    "searchable": false
                },
                {
                    "orderable": false,
                    "searchable": false
                }
            ]
        });

        $('#reports_table').dataTable({
            "order": [
                [2, "desc"]
            ],
            "columns": [
                null,
                null,
                null,
                null,
                {
                    "orderable": false,
                    "searchable": false
                }
            ]
        });

        /*$.ajaxSetup({
        	headers: {
        		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        	}
        });*/
        //$('.btn_view').click(function() {

        $('body').on('click', '#export_btn', function() {

            var token = $("input[name='_token']").val();
            var supplier = $('#select_supplier').val();
            $.ajax({
                //url: '/project-details-cbpi/' + dis_id,
                url: "{{ route('client-supplier') }}",
                type: 'POST',
                data: {
                    supplier: supplier,
                    _token: token
                },
                success: function(response) {
                    console.log(response);
                    //console.log(response[0].id);

                    var start_date = $('#start_date').val();
                    var end_date = $('#end_date').val();
                    var supplier = $('#select_supplier option:selected').text();

                    var inspection_count = $('#inspection_count').text();
                    var inspection_accepted = $('#inspection_accepted').text();
                    var inspection_rejected = $('#inspection_rejected').text();
                    var released = $('#released').text();
                    var cancelled = $('#cancelled').text();
                    var pending = $('#pending').text();
                    var pass = $('#pass').text();
                    var failed = $('#failed').text();

                    /* original data */
                    var data = [
                        ["Review Date ", start_date + " to " + end_date],
                        ["Supplier Name: ", response[0].supplier_name],
                        ["Supplier Code: ", response[0].supplier_number],
                        ["Country: ", response[0].name],
                        ["Supplier City (English): ", response[0].supplier_city],
                        ["Supplier Address (English): ", response[0].supplier_address],
                        ["Contact Person: ", response[0].supplier_contact_person],
                        ["Email: ", response[0].supplier_email],
                        ["Mobile Number: ", response[0].supplier_contact_number],
                        ["Telephone Number: ", response[0].supplier_tel_number],
                        ["", ""],
                        ["", ""],
                        ["TOTAL INSPECTION / JOBS", parseInt(inspection_count)],
                        ["TOTAL SHIPMENT ACCEPTED", parseInt(inspection_accepted)],
                        ["TOTAL SHIPMENT REJECTED", parseInt(inspection_rejected)],
                        ["TOTAL RELEASED", parseInt(released)],
                        ["TOTAL CANCELLED/HOLD", parseInt(cancelled)],
                        ["TOTAL PENDING", parseInt(pending)],
                        ["TOTAL PASS", parseInt(pass)],
                        ["TOTAL FAILED", parseInt(failed)],

                    ];
                    /* merge cells A1:B1 */
                    var merge = {
                        s: {
                            r: 0,
                            c: 0
                        },
                        e: {
                            r: 0,
                            c: 0
                        },
                        s: {
                            r: 0,
                            c: 0
                        },
                        e: {
                            r: 0,
                            c: 0
                        }
                    };
                    var wscols = [{
                            wch: 30
                        },

                    ];

                    //var merge = XLSX.utils.decode_range("A1:B1"); // this is equivalent

                    /* generate worksheet */
                    var ws = XLSX.utils.aoa_to_sheet(data);

                    /* add merges */
                    if (!ws['!merges']) ws['!merges'] = [];
                    ws['!merges'].push(merge);
                    ws['!cols'] = wscols;



                    /* generate workbook */
                    var wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, "sheet1");

                    /* generate file and download */
                    const wbout = XLSX.write(wb, {
                        type: "array",
                        bookType: "xlsx"
                    });
                    saveAs(new Blob([wbout], {
                        type: "application/octet-stream"
                    }), "inspections.xlsx");
                }

            });

        });

        $('body')
            .on('click', '.btn_view_project', function() {
                $('.send-loading').show();
                var dis_id = $(this).data('id');
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
                                $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row" id="file-attach-' + element.id + '">' +
                                    '<td colspan="3"><a target="_blank" href="http://ticapp.tk/' + element.path + '">' + element.file_name + '</a>' +
                                    '</td>' +
                                    '<td><a  href="#" data-id="' + element.id + '" class="remove-adedd-file">Remove</a>' +
                                    '</td>' +
                                    '</tr>');

                            });
                        }
                        //var route_add='{{route("client-add-files","'+dis_id+'")}}';
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<td colspan="4"><a target="_blank" class="btn btn-primary" href="client-add-files/' + dis_id + '">Add attachment</a>' +
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
            })

            .on('click', '.btn_view_project_cbpi', function() {
                $('.send-loading').show();
                var dis_id = $(this).data('id');
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
                                $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row"  id="file-attach-' + element.id + '">' +
                                    '<td colspan="3"><a target="_blank" href="http://ticapp.tk/' + element.path + '">' + element.file_name + '</a>' +
                                    '</td>' +
                                    '<td><a  href="#" data-id="' + element.id + '" class="remove-adedd-file">Remove</a>' +
                                    '</td>' +
                                    '</tr>');

                            });
                        }

                        var route_add = '{{route("client-add-files","'
                        dis_id '")}}';
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<td colspan="4"><a target="_blank" class="btn btn-primary" href="client-add-files/' + dis_id + '">Add attachment</a>' +
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
            })

            .on('click', '.btn_view_project_site', function() {
                $('.send-loading').show();
                var dis_id = $(this).data('id');
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
                                $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row"  id="file-attach-' + element.id + '">' +
                                    '<td colspan="3"><a target="_blank" href="http://ticapp.tk/' + element.path + '">' + element.file_name + '</a>' +
                                    '</td>' +
                                    '<td><a  href="#" data-id="' + element.id + '" class="remove-adedd-file">Remove</a>' +
                                    '</td>' +
                                    '</tr>');

                            });
                        }

                        var route_add = '{{route("client-add-files",'
                        dis_id ')}}';
                        $('#table_view_project > tbody:last-child').append('<tr class="proj_added_row">' +
                            '<td colspan="4"><a target="_blank" class="btn btn-primary" href="client-add-files/' + dis_id + '">Add attachment</a>' +
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
                    }

                });
            })
            .on('click', '.remove-adedd-file', function() {
                var id = $(this).data('id');
                swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }, function() {
                    /* if (result.value) {
                        deleteFile(id);
                    } */
                    deleteFile(id);
                })
            })

            .on('click', '#search-date-button', function(event) {
                event.preventDefault();
                $('#inspection_count').text(0);
                $('#inspection_accepted').text(0);
                $('#inspection_rejected').text(0);
                $('#released').text(0);
                $('#cancelled').text(0);
                $('#pending').text(0);
                $('#pass').text(0);
                $('#failed').text(0);

                $('.send-loading').show();
                var date = $('#daterange-btn span').text();
                var start_date = $('#start_date').val();
                var end_date = $('#end_date').val();
                var supplier = $('#select_supplier').val();
                //var factory = $('#select_supplier option:selected').val();
                var token = $("input[name='_token']").val();
                console.log(start_date + " " + supplier)
                if (start_date == '' && $("#select_supplier")[0].selectedIndex <= 0) {
                    $('.send-loading').hide();
                    swal({
                        title: 'Error',
                        text: "Please Select a date or a Supplier",
                        icon: 'error'
                    })
                } else {
                    /* swal({
                         title: 'Searched Date',
                         text: "Date: " + start_date + " To " + end_date, 
                         icon: 'success'
                     })*/
                    $.ajax({
                        //url: '/project-details-cbpi/' + dis_id,
                        url: "{{ route('client.stats.dashboard.search') }}",
                        type: 'POST',
                        data: {
                            start_date: start_date,
                            end_date: end_date,
                            supplier: supplier,
                            _token: token
                        },
                        success: function(response) {
                            $('.send-loading').hide();
                            $('#inspection_count').text(response.inspection_count);
                            $('#inspection_accepted').text(response.inspection_accepted);
                            $('#inspection_rejected').text(response.inspection_rejected);
                            $('#released').text(response.released);
                            $('#cancelled').text(response.cancelled);
                            $('#pending').text(response.pending);
                            $('#pass').text(response.pass);
                            $('#failed').text(response.failed);
                            /*swal({
                                title: 'Searched Date',
                                text: "Date: " + start_date + " To " + end_date,
                                icon: 'success'
                            })*/
                        },
                        error: function(err) {
                            console.log(err);
                            $('.send-loading').hide();
                        }

                    });
                }

            })



    });

    function deleteFile(id) {
        $.ajax({
            url: '/client-remove-file/' + id,
            type: 'GET',
            beforeSend: function() {
                $('.send-loading').show();
            },
            success: function(response) {
                $('.send-loading').hide();
                $('#file-attach-' + id).remove();
                swal(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                );
            },
            error: function(err) {
                console.log(err);
                $('.send-loading').hide();
                swal(
                    'Error',
                    'Something went wrong. Please try again later',
                    'error'
                );
            }
        });
    }

    function search() {
		
		var supplier = null;
		var start_date = null;
		var end_date = null;

		$('.send-loading').show();
		var date = $('#daterange-btn span').text();
		start_date = $('#start_date').val();
		end_date = $('#end_date').val();
		supplier = $('#select_supplier').val();
		var token = $("input[name='_token']").val();
		console.log(start_date + " " + supplier)
		
		/* $.ajax({
			url: "{{ route('client.stats.dashboard.search') }}",
			type: 'POST',
			data: {
				start_date: start_date,
				end_date: end_date,
				supplier: supplier,
				_token: token
			},
			success: function(response) {
				$('.send-loading').hide();
				$('#inspection_count').text(response.inspection_count);
				$('#inspection_uploaded').text(response.inspection_uploaded);
				$('#inspection_accepted').text(response.inspection_accepted);
				$('#inspection_rejected').text(response.inspection_rejected);
				$('#released').text(response.released);
				$('#cancelled').text(response.cancelled);
				$('#pending').text(response.pending);
				$('#pass').text(response.pass);
				$('#failed').text(response.failed);
				
			},
			error: function(err) {
				console.log(err);
				$('.send-loading').hide();
			}

		}); */
		//}
	}
    var year = new Date().getFullYear();
    //Select Date
    $('#daterange-btn').daterangepicker({
            /*ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            },*/
            ranges: {
                'January': [moment('01-01-' + year).startOf('month'), moment('01-31-' + year).endOf('month')],
                'February': [moment('02-01-' + year).startOf('month'), moment('02-29-' + year).endOf('month')],
                'March': [moment('03-01-' + year).startOf('month'), moment('03-31-' + year).endOf('month')],
                'April': [moment('04-01-' + year).startOf('month'), moment('04-31-' + year).endOf('month')],
                'May': [moment('05-01-' + year).startOf('month'), moment('05-31-' + year).endOf('month')],
                'June': [moment('06-01-' + year).startOf('month'), moment('06-30-' + year).endOf('month')],
                'July': [moment('07-01-' + year).startOf('month'), moment('07-31-' + year).endOf('month')],
                'August': [moment('08-01-' + year).startOf('month'), moment('08-31-' + year).endOf('month')],
                'September': [moment('09-01-' + year).startOf('month'), moment('09-31-' + year).endOf('month')],
                'October': [moment('10-01-' + year).startOf('month'), moment('10-31-' + year).endOf('month')],
                'November': [moment('11-01-' + year).startOf('month'), moment('11-30-' + year).endOf('month')],
                'December': [moment('12-01-' + year).startOf('month'), moment('12-31-' + year).endOf('month')],
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        },
        function(start, end) {
            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
            search();
        }
    )

</script>
@endsection
