@extends('layouts.new')
@section('title','Inspection Jobs Statistics')
@section('page-title','Inspection Jobs Statistics')

@section('stylesheets')
{!! Html::style('/css/admin/dashboard.css') !!}
{!! Html::style('/css/admin/project.css') !!}
<!-- daterange picker -->
<!-- daterange picker -->
<!--<link rel="stylesheet" href="css/daterangepicker.css">-->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://raw.githubusercontent.com/t0m/select2-bootstrap-css/bootstrap3/select2-bootstrap.css">
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

    .select2-selection {
        height: 37px !important;
    }

</style>
@endsection

@section('content')

<!-- Info boxes -->

<!-- /.row -->

<!-- TABLE: LATEST ORDERS -->
<div class="box box-info">
    <div class="box-header with-border">
        <form action="" method="post">
            <div class="col-md-3">
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
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <select name="client" id="client" class="form-control"></select>
                    <div class="input-group-btn">
                        <button id="clear" class="btn btn-warning" type="button">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>

            </div>
        </form>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    $('#clear').click(function() {
        $('#client').val(null).trigger('change');
    });


    $("#client").select2({
        ajax: {
            url: "{{route('admin.clientSelection')}}",
            type: "post",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    _token: "{{ csrf_token() }}",
                    search: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });

    /*$('#client').select2({
        ajax: {
            url: "{{route('admin.clientSelection')}}",
            type: "post",
            data: function(params) {
                var query = {
                    _token: "{{ csrf_token() }}",
                    search: params.term,
                }
                // Query parameters will be ?search=[term]&type=public
                return query;
            }
        }
    });*/

    var ctx = document.getElementById('myChart').getContext('2d');
    var json_url = "{{route('admin.statsData')}}";

    var myChart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
        // The data for our dataset
        data: {
            labels: [],
            datasets: [{
                    label: 'Jobs',
                    backgroundColor: '#f39c12',
                    data: []
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
                intersect: false
            },
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                xAxes: [{
                    stacked: true,
                }],
                yAxes: [{
                    stacked: true
                }]
            }
        }
    });

    search(myChart, json_url);

    $('#month').change(function() {
        var month = $(this).val();
        search(myChart, json_url);
    });

    $('#client').change(function() {
        var client = $(this).val();
        search(myChart, json_url);
    });

    function search(chart, url) {
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
        client = $("#client option:selected").val();;
        var token = $("input[name='_token']").val();

        var ranges = [];

        var count = [];
        var count = [];
        var total_jobs = 0;


        $.ajax({
            url: url,
            //url: "{{route('client.statsData')}}",
            method: "POST",
            data: {
                type: "{{$type}}",
                start_date: start_date,
                end_date: end_date,
                month: month,
                client: client,
                _token: token
            },
            dataType: "json",
            beforeSend: function() {
                let datas = '';
            },
            success: function(response) {
                $('.send-loading').hide();
                datas = response.data;

                $("#month option[value=" + response.month_no + "]").prop('selected', true);
                if (datas) {
                    $.each(datas, function(key, value) {
                        ranges.push(value.ranges);

                        count.push(value.count);
                        chart.data.labels = ranges;
                        chart.data.datasets[0].data = count;

                        total_jobs = parseInt(total_jobs + value.count);

                    });

                    chart.options.title.text = total_jobs + ' Inspection Jobs Statistics - ' + response.month + ' 2021';
                    chart.update();

                } else {
                    console.log('No data');
                }
            }
        })
    }

</script>

@endsection
