@extends('layouts.new')
@section('title','Booking Team Statistics')
@section('page-title','Booking Team Statistics')

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
        <div id="alert" class="alert alert-warning text-center" style="display: none;">
            No Data Found
        </div>
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

    var myChart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'pie',
        // The data for our dataset
        data: {
            labels: [],
            datasets: [{
                label: 'Booking',
                backgroundColor: [],
                data: []
            }]
        },
        // Configuration options go here
        options: {
            title: {
                display: true,
                text: []
            },
            tooltips: {
                mode: 'index',
                intersect: false
            },
            legend: {
                display: true,
                position: 'left',
            },
            maintainAspectRatio: false,
            responsive: true,
            /*			scales: {
            				xAxes: [{
            					stacked: true,
            				}],
            				yAxes: [{
            					stacked: true
            				}]
            			}*/
        }
    });

    var dynamicColors = function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    }

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

        var name = [];
        var counts = [];
        var bg_color = [];

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
                var total_counts = 0;
                $('.send-loading').hide();
                datas = response.data;

                console.log(chart);
                if (response.total_counts) {
                    $('#alert').hide();
                    $('#myChart').show();
                    var total_counts = response.total_counts;
                    $.each(datas, function(key, value) {

                        var percentage = (value.counts * 100 / total_counts).toFixed(2) + "%";
                        name.push(value.name.toUpperCase() + ' ' + percentage);
                        counts.push(value.counts);
                        bg_color.push(dynamicColors());
                        chart.data.labels = name;

                        chart.data.datasets[0].backgroundColor = bg_color;
                        chart.data.datasets[0].data = counts;
                    });

                } else {
                    $('#alert').show();
                    $('#myChart').hide();
                }
                chart.options.title.text = 'Booking Team Statistics ' + response.month + ' 2021';
                chart.update();
            }
        })
    }

</script>

@endsection
