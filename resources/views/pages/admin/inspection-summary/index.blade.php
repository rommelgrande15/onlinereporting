@extends('layouts.new')
@section('title','Inspection Summary')
@section('page-title','Inspection Summary')
@section('stylesheets')
{!! Html::style('/css/admin/clients.css') !!}
<!-- daterange picker -->
<link rel="stylesheet" href="css/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
<script src="https://code.iconify.design/1/1.0.5/iconify.min.js"></script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 padding-b-25">
        <form class="form-inline" action="" method="post">
            {!!csrf_field()!!}
            <!--<div class="form-group margin-right-twenty">
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
            </div>-->
            <button class="btn btn-primary margin-right-twenty" id="search-date-button" type="submit">Today</button>
        </form>
        <br>

        <div class="table-responsive">
            <table id="inspections_table" class="table table-condensed small dataTable no-footer">
                <thead>
                    <tr>
                        <th class="text-center">Service</th>
                        <th class="text-center">Country</th>
                        <th class="text-center">Account Manager</th>
                        <th class="text-center">Count/s</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $total = 0;
                    @endphp
                    @foreach($inspections as $inspection)
                    <input type="hidden" value="{{ $inspection->user_created_by }}">
                    <tr class="text-center">
                        <td>{{ $inspection->service }}</td>
                        <td>{{ $inspection->factory_country_name }}</td>
                        <td>{{ $inspection->user_created_by }}</td>
                        <td>{{ $inspection->total }}</td>
                    </tr>
                    @php
                    $total = $total + $inspection->total;
                    @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="text-center">
                        <th class="text-center" colspan="3">TOTAL</th>
                        <th class="text-center">{{ $total }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form class="form_inline" method="POST" action="">
            {!!csrf_field()!!}

            <div class="form-group">
                <label for="">Send Inspection Summary</label><br>
                <button class="btn btn primary" id="btn_daily"><i class="fa fa-send"></i> Daily</button> &nbsp;
                <button class="btn btn primary" id="btn_Weekly"><i class="fa fa-send"></i> Weekly</button>
               {{-- <button class="btn btn primary" id="btn_yearly"><i class="fa fa-send"></i> Yearly</button>--}}
            </div>
        </form>
    </div>
</div>

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
    $('#inspections_table').dataTable();

    $('#btn_daily').click(function(e) {
        e.preventDefault();
        var token = $("input[name=_token]").val();
        $.ajax({
            type: 'POST',
            url: "{{ route('inspection-summary-send') }}",
            data: {
                _token: token,
                interval: 'daily'
            },
            success: function(data) {
                $('.send-loading ').hide();
                swal({
                    title: "Success",
                    text: "Daily Inspection Summary successfully sent",
                    type: "success",
                }, function() {
                    //location.reload();
                });
            },
            error: function() {
                swal({
                    title: "Error",
                    text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                    type: "error",
                });
                $('.send-loading ').hide();
            }
        });
    });

    $('#btn_Weekly').click(function(e) {
        e.preventDefault();
        var token = $("input[name=_token]").val();
        $.ajax({
            type: 'POST',
            url: "{{ route('inspection-summary-send') }}",
            data: {
                _token: token,
                interval: 'weekly'
            },
            success: function(data) {
                $('.send-loading ').hide();
                swal({
                    title: "Success",
                    text: "Weekly Inspection Summary successfully sent",
                    type: "success",
                }, function() {
                    //location.reload();
                });
            },
            error: function() {
                swal({
                    title: "Error",
                    text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                    type: "error",
                });
                $('.send-loading ').hide();
            }
        });
    });
    
    $('#btn_yearly').click(function(e) {
        e.preventDefault();
        var token = $("input[name=_token]").val();
        $.ajax({
            type: 'POST',
            url: "{{ route('inspection-summary-send') }}",
            data: {
                _token: token,
                interval: 'yearly'
            },
            success: function(data) {
                $('.send-loading ').hide();
                swal({
                    title: "Success",
                    text: "Yearly Inspection Summary successfully sent",
                    type: "success",
                }, function() {
                    //location.reload();
                });
            },
            error: function() {
                swal({
                    title: "Error",
                    text: "Error: Server encountered an error. Please try again or contact your system administrator.",
                    type: "error",
                });
                $('.send-loading ').hide();
            }
        });
    });

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
            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            $('#start_date').val(start.format('YYYY-MM-DD'))
            $('#end_date').val(end.format('YYYY-MM-DD'))
        }
    )

</script>
@endsection
