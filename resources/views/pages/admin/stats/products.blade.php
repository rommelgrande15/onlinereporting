@extends('layouts.new'))
@section('title','Products Statistics')
@section('page-title','Products Statistics')

@section('stylesheets')
{!! Html::style('/css/admin/dashboard.css') !!}
{!! Html::style('/css/admin/project.css') !!}
<!-- daterange picker -->
<!-- daterange picker -->
<!--<link rel="stylesheet" href="css/daterangepicker.css">-->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
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

    #myChart {
        height: 70vh !important;
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

    .show-calendar,
    .drp-calendar,
        {
        display: none !mportant;
    }

</style>
@endsection

@section('content')

<!-- Info boxes -->

<!-- /.row -->

<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
    <div class="box-header with-border">
        <div class="col-md-2">
            <form action="" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <select name="month" id="month" class="form-control">
                    <option value="" disabled selected>Select Month</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </form>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">

        <canvas id="myChart"></canvas>
    </div>
</div>
<!-- /.box -->
<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
<!-- bootstrap datepicker -->
<script src="https://www.chartjs.org/dist/2.9.4/Chart.min.js"></script>
<script src="https://momentjs.com/downloads/moment.js"></script>
<!--<script src="js/daterangepicker.js"></script>-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!-- bootstrap datepicker -->
<script src="js/bootstrap-datepicker.min.js"></script>

<script>
    $(window).on('load', function() {
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
    var ctx = document.getElementById('myChart').getContext('2d');
    var json_url = "{{route('admin.statsData')}}";

    $(document).ready(function() {
        var year = new Date().getFullYear();

        function cb(start, end) {

            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $('#start_date').val(start.format('YYYY-MM-DD'));
            $('#end_date').val(end.format('YYYY-MM-DD'));
            search(myChart, json_url);
        }
        $('#daterange-btn').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment(),
            showCustomRangeLabel: false,
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
                'December': [moment(year + '-12').startOf('month'), moment(year + '-12').endOf('month')]
            }
        }, cb);
        cb(start, end);
    });

    var myChart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
        // The data for our dataset
        data: {
            labels: [],
            datasets: [/*{
                    type: 'line',
                    label: 'Pcs',
                    borderColor: '#3498db',
                    data: [],
                    fill: false,
                    yAxisID: "y-axis-1",
                },
                {
                    type: 'line',
                    label: [],
                    borderColor: '#2ecc71',
                    data: [],
                    fill: false,
                    yAxisID: "y-axis-3",
                },*/
                {
                    label: 'Cost/Pcs',
                    backgroundColor: '#f39c12',
                    data: [],
                    yAxisID: "y-axis-2"
                }

            ]
        },
        // Configuration options go here
        options: {
            title: {
                display: true,
                text: []
            },
            tooltips: {
                mode: 'index',
                intersect: true
            },
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [/*{
                    stacked: true,
                    position: "left",
                    id: "y-axis-1",
                }, {
                    stacked: true,
                    position: "left",
                    id: "y-axis-3",
                }, */{
                    stacked: false,
                    position: "right",
                    id: "y-axis-2",
                }]
            }
        }
    });

    search(myChart, json_url);

    $('#month').change(function() {
        var month = $(this).val();

        console.log(month);
        search(myChart, json_url, month);
    });

    function search(chart, url, data) {
        var start_date = null;
        var end_date = null;
        var month = null;
        //var data = data || {};
        chart.clear();

        $('.send-loading').show();
        var date = $('#daterange-btn span').text();
        start_date = $('#start_date').val();
        end_date = $('#end_date').val();
        month = $('#month').val();
        var token = $("input[name='_token']").val();

        var ranges = [];
        var cost = [];
        var counts = [];
        var manday = [];
        var currency = [];

        $.ajax({
            url: url,
            method: "POST",
            data: {
                type: "{{$type}}",
                start_date: start_date,
                end_date: end_date,
                month: month,
                _token: token
            },
            dataType: "json",
            beforeSend: function() {
                let datas = '';
            },
            success: function(response) {
                $('.send-loading').hide();
                datas = response.data;

                console.log(chart);
                if (datas) {
                    var total_cost = [];
                    $.each(datas, function(key, value) {

                        ranges.push(value.ranges);

                        cost.push(value.cost);
                        //manday.push(value.manday);
                        counts.push(value.counts); //Product Counts
                        currency.push(value.currency);
                        total_cost.push((parseFloat(value.cost) / parseInt(value.counts)).toFixed(4));
                        if (value.cost >= 1) {
                            chart.data.labels = ranges;

                            //chart.data.datasets[0].data = counts;
                            //chart.data.datasets[1].data = cost * manday;
                            //chart.data.datasets[1].data = cost;
                           
                            
                            chart.data.datasets[0].data = total_cost;
                        }


                    });
                     chart.data.datasets[0].label = response.currency + ' Cost/Pcs';
                    chart.options.title.text = 'Products Statistics ' + response.month + ' 2021';
                    chart.update();

                } else {
                    console.log('No data');
                }
            }
        })
    }

</script>

@endsection
