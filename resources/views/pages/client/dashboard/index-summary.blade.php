@extends('layouts.client._new')
@section('title','Summary Report')
@section('page-title','Summary Report')

@section('stylesheets')
@if(strpos(Request::url(''), 'tic-sera') !== false)
{!! Html::style('/css/admin/dashboard-sera.css') !!}
@else
{!! Html::style('/css/admin/dashboard.css') !!}
@endif
<link rel="stylesheet" href="css/daterangepicker.css">

{{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css"> --}}


{{-- {!! Html::style('/css/admin/project.css') !!} --}}
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

    table.dataTable td:nth-child(3) {
        max-width: 100px;
    }

    table.dataTable td:nth-child(4) {
        max-width: 100px;
    }

    table.dataTable td:nth-child(5) {
        max-width: 100px;
    }

    table.dataTable td {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .dropdown {
        position: absolute;
    }

</style>
@endsection

@section('content')
<div class="row">

    <div class="col-md-12">
        <form class="form-inline" action="" method="post">
            {!!csrf_field()!!}
        


            <div class="form-group margin-right-twenty">
                <label>Summary Date:</label>
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

            <button class="btn btn-primary margin-right-twenty" id="search-date-button" type="Button">Search</button>
        </form>
        <br>
    </div>

    
  
    <div class="col-md-12">
        <div class="col-md-12 padding-b-25">
            <div class="table-responsive">
                {{-- <div class="pull-right">
					<b>Filtered by :</b>
					<select class="form-control pull-right" id="engines" style="margin-bottom:5px;">
						<option value="">All</option>
						<option value="Cancelled">Cancelled</option>
						<option value="Waiting for approval">Waiting for approval</option>
						<option value="On-going Inspection">On-going Inspection</option>
						<option value="Finished">Finished</option>
					</select>
					<br> <br>
				</div> --}}
                <br> <br>
                <form class="form-inline" action="" method="post">
                <table id="inspections_tbl" class="table table-condensed cell-border small dataTable no-footer display">
                    <thead>
                        <tr>
                            <th class="text-left">Project No.</th>
                            <th class="text-left">Result</th>
                            <th class="text-left">PO Number</th>
                            <th class="text-left">Item Number</th>
                            <th class="text-left">Supplier Code</th>
                            <th class="text-left">Supplier Name</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($SummaryData as $SummaryData)
                            <tr>
                                <td>{{$SummaryData->reference_no}}</td>
                                <td>{{$SummaryData->report_status}}</td>
                                <td>{{$SummaryData->po_no}}</td>
                                <td>{{$SummaryData->model_no}}</td>
                                <td>{{$SummaryData->supplier_code}}</td>
                                <td>{{$SummaryData->supplier_name}}</td>
                            </tr>
                        @endforeach

                    </tbody>

                    <tfoot>
                        <tr>
                            <th class="text-center">.</th>
                            <th class="text-center">.</th>
                            <th class="text-center">.</th>
                            <th class="text-center">.</th>
                            <th class="text-center">.</th>
                            <th class="text-center">.</th>
                            
                           
                        </tr>
                    </tfoot>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
{!! Html::script('/js/client/panel-client.js?v=4') !!}
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="js/daterangepicker.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>

<script>
    $(window).on('load', function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });




    $(document).ready(function() {

        $( "#search-date-button" ).click(function() {
            var dataTable2 = $('#inspections_tbl').DataTable();
            dataTable2.clear();
            
            fromDate =$('#start_date').val();
            toDate=$('#end_date').val();
            $.ajax({
            url: '/search-summary-panel-client',
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                fromDate:fromDate,
                toDate:toDate
            },
            success: function(response) {
                if(response.length==0){
                    dataTable2.row.add([
        '',
        '',
        '',
        '',
        '',
        ''
    ]).draw();  
                }
        response.forEach(element => {
        dataTable2.row.add([
        ''+element['reference_no']+'',
        ''+element['report_status']+'',
        ''+element['po_no']+'',
        ''+element['model_no']+'',
        ''+element['supplier_code']+'',
        ''+element['supplier_name']+''
    ]).draw();
                });
               console.log(response);
            },
            error: function(err) {
                console.log(err);
            }
        });
        });
        


       var table= $('#inspections_tbl').DataTable({
        rowCallback: function(row, data, index){
        if(data[1].toUpperCase() == 'PASSED'){
    	$(row).find('td:eq(1)').css('color', 'Green');
        }else if(data[1].toUpperCase() == 'PENDING'){
            $(row).find('td:eq(1)').css('color', 'Orange');
        }else{
            $(row).find('td:eq(1)').css('color', 'Red');
        }
  },
            dom: 'Bfrtip',
        buttons: [
            { 
            extend: 'print', className: 'btn btn-primary margin-right-twenty',
            customize: function(win) {
              $(win.document.body).find('tbody tr :nth-child(2):contains("Failed")').css('color', 'red');
              $(win.document.body).find('tbody tr :nth-child(2):contains("Passed")').css('color', 'green');
              $(win.document.body).find('tbody tr :nth-child(2):contains("Pending")').css('color', 'Orange');
              //console.log(win.document.body);
            }
            },
        ]
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
               'January': [moment(year + '-01').startOf('month'), moment(year + '-01').endOf('month')],
				'February': [moment(year + '-02').startOf('month'), moment(year + '-02').endOf('month')],
				'March': [moment(year + '-03').startOf('month'), moment(year + '-03').endOf('month')],
				'April': [moment(year + '-04').startOf('month'), moment(year + '-04').endOf('month')],
				'May': [moment(year + '-05').startOf('month'), moment(year + '-05').endOf('month')],
				'June': [moment(year + '-06').startOf('month'), moment(year + '-06').endOf('month')],
				'July': [moment(year + '-07').startOf('month'), moment(year + '-07').endOf('month')],
				'August': [moment(year + '-08').startOf('month'), moment(year + '-08').endOf('month')],
				'September': [moment(year + '-09').startOf('month'), moment(year + '-09').endOf('month')],
				'October': [moment(year + '-10').startOf('month'), moment(year + '-10').endOf('month')],
				'November': [moment(year + '-11').startOf('month'), moment(year + '-11').endOf('month')],
				'December': [moment(year + '-12').startOf('month'), moment(year + '-12').endOf('month')],
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
    
    });

    

</script>
@endsection
