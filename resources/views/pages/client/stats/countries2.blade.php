@extends('layouts.client._new')
@section('title','Countries Statistics')
@section('page-title','Countries Statistics')

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


    #chartdiv {
        width: 100%;
        height: 500px;
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
                    <option value="">Select Month</option>
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

        <div id="chartdiv"></div>
    </div>

</div>
<!-- /.box -->
<div class="se-pre-con"></div>
<div class="send-loading"></div>
@endsection

@section('scripts')
<!-- bootstrap datepicker -->
<script src="https://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/worldHigh.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script>
    $(document).ready(function() {
        $(window).on('load', function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");
        });
        var json_url = "{{route('client.statsData')}}";
        var countries = [];
        var count = [];

        am4core.ready(function() {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            // Create map instance
            var chart = am4core.create("chartdiv", am4maps.MapChart);

            // Set map definition
            chart.geodata = am4geodata_worldHigh;

            // Set projection
            chart.projection = new am4maps.projections.Mercator();

            // Export
            chart.exporting.menu = new am4core.ExportMenu();

            // Zoom control
            chart.zoomControl = new am4maps.ZoomControl();

            var homeButton = new am4core.Button();
            homeButton.events.on("hit", function() {
                chart.goHome();
            });

            homeButton.icon = new am4core.Sprite();
            homeButton.padding(7, 5, 7, 5);
            homeButton.width = 30;
            homeButton.icon.path = "M16,8 L14,8 L14,16 L10,16 L10,10 L6,10 L6,16 L2,16 L2,8 L0,8 L8,0 L16,8 Z M16,8";
            homeButton.marginBottom = 10;
            homeButton.parent = chart.zoomControl;
            homeButton.insertBefore(chart.zoomControl.plusButton);

            // Center on the groups by default
            chart.homeZoomLevel = 3.5;
            chart.homeGeoPoint = {
                longitude: 10,
                latitude: 52
            };

            var groupData = [{
                    "name": "EU member before 2004",
                    "color": chart.colors.getIndex(0),
                    "data": [{
                        "title": "Austria",
                        "id": "AT", // With MapPolygonSeries.useGeodata = true, it will try and match this id, then apply the other properties as custom data
                        "customData": "1995"
                    }, {
                        "title": "Ireland",
                        "id": "IE",
                        "customData": "1973"
                    }, {
                        "title": "Denmark",
                        "id": "DK",
                        "customData": "1973"
                    }, {
                        "title": "Finland",
                        "id": "FI",
                        "customData": "1995"
                    }, {
                        "title": "Sweden",
                        "id": "SE",
                        "customData": "1995"
                    }, {
                        "title": "Great Britain",
                        "id": "GB",
                        "customData": "1973"
                    }, {
                        "title": "Italy",
                        "id": "IT",
                        "customData": "1957"
                    }, {
                        "title": "France",
                        "id": "FR",
                        "customData": "1957"
                    }, {
                        "title": "Spain",
                        "id": "ES",
                        "customData": "1986"
                    }, {
                        "title": "Greece",
                        "id": "GR",
                        "customData": "1981"
                    }, {
                        "title": "Germany",
                        "id": "DE",
                        "customData": "1957"
                    }, {
                        "title": "Belgium",
                        "id": "BE",
                        "customData": "1957"
                    }, {
                        "title": "Luxembourg",
                        "id": "LU",
                        "customData": "1957"
                    }, {
                        "title": "Netherlands",
                        "id": "NL",
                        "customData": "1957"
                    }, {
                        "title": "Portugal",
                        "id": "PT",
                        "customData": "1986"
                    }]
                },
                {
                    "name": "Joined at 2004",
                    "color": chart.colors.getIndex(1),
                    "data": [{
                        "title": "Lithuania",
                        "id": "LT",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }, {
                        "title": "Latvia",
                        "id": "LV",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }, {
                        "title": "Czech Republic ",
                        "id": "CZ",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }, {
                        "title": "Slovakia",
                        "id": "SK",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }, {
                        "title": "Slovenia",
                        "id": "SI",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }, {
                        "title": "Estonia",
                        "id": "EE",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }, {
                        "title": "Hungary",
                        "id": "HU",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }, {
                        "title": "Cyprus",
                        "id": "CY",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }, {
                        "title": "Malta",
                        "id": "MT",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }, {
                        "title": "Poland",
                        "id": "PL",
                        "color": chart.colors.getIndex(1),
                        "customData": "2004",
                        "groupId": "2004"
                    }]
                },
                {
                    "name": "Joined at 2007",
                    "color": chart.colors.getIndex(3),
                    "data": [{
                        "title": "Romania",
                        "id": "RO",
                        "customData": "2007"
                    }, {
                        "title": "Bulgaria",
                        "id": "BG",
                        "customData": "2007"
                    }]
                },
                {
                    "name": "Joined at 2013",
                    "color": chart.colors.getIndex(4),
                    "data": [{
                        "title": "Croatia",
                        "id": "HR",
                        "customData": "2013"
                    }]
                }
            ];

            // This array will be populated with country IDs to exclude from the world series
            var excludedCountries = ["AQ"];

            // Create a series for each group, and populate the above array
            groupData.forEach(function(group) {
                var series = chart.series.push(new am4maps.MapPolygonSeries());
                series.name = group.name;
                series.useGeodata = true;
                var includedCountries = [];
                group.data.forEach(function(country) {
                    includedCountries.push(country.id);
                    excludedCountries.push(country.id);
                });
                series.include = includedCountries;

                series.fill = am4core.color(group.color);

                // By creating a hover state and setting setStateOnChildren to true, when we
                // hover over the series itself, it will trigger the hover SpriteState of all
                // its countries (provided those countries have a hover SpriteState, too!).
                series.setStateOnChildren = true;
                series.calculateVisualCenter = true;

                // Country shape properties & behaviors
                var mapPolygonTemplate = series.mapPolygons.template;
                // Instead of our custom title, we could also use {name} which comes from geodata  
                mapPolygonTemplate.fill = am4core.color(group.color);
                mapPolygonTemplate.fillOpacity = 0.8;
                mapPolygonTemplate.nonScalingStroke = true;
                mapPolygonTemplate.tooltipPosition = "fixed"

                mapPolygonTemplate.events.on("over", function(event) {
                    series.mapPolygons.each(function(mapPolygon) {
                        mapPolygon.isHover = true;
                    })
                    event.target.isHover = false;
                    event.target.isHover = true;
                })

                mapPolygonTemplate.events.on("out", function(event) {
                    series.mapPolygons.each(function(mapPolygon) {
                        mapPolygon.isHover = false;
                    })
                })

                // States  
                var hoverState = mapPolygonTemplate.states.create("hover");
                hoverState.properties.fill = am4core.color("#CC0000");

                // Tooltip
                mapPolygonTemplate.tooltipText = "{title} joined EU at {customData}"; // enables tooltip
                // series.tooltip.getFillFromObject = false; // prevents default colorization, which would make all tooltips red on hover
                // series.tooltip.background.fill = am4core.color(group.color);

                // MapPolygonSeries will mutate the data assigned to it, 
                // we make and provide a copy of the original data array to leave it untouched.
                // (This method of copying works only for simple objects, e.g. it will not work
                //  as predictably for deep copying custom Classes.)
                series.data = JSON.parse(JSON.stringify(group.data));
            });

            // The rest of the world.
            var worldSeries = chart.series.push(new am4maps.MapPolygonSeries());
            var worldSeriesName = "world";
            worldSeries.name = worldSeriesName;
            worldSeries.useGeodata = true;
            worldSeries.exclude = excludedCountries;
            worldSeries.fillOpacity = 0.8;
            worldSeries.hiddenInLegend = true;
            worldSeries.mapPolygons.template.nonScalingStroke = true;

            // This auto-generates a legend according to each series' name and fill
            chart.legend = new am4maps.Legend();

            // Legend styles
            chart.legend.paddingLeft = 27;
            chart.legend.paddingRight = 27;
            chart.legend.marginBottom = 15;
            chart.legend.width = am4core.percent(90);
            chart.legend.valign = "bottom";
            chart.legend.contentAlign = "left";

            // Legend items
            chart.legend.itemContainers.template.interactionsEnabled = false;

        }); // end am4core.ready()
    });

</script>

@endsection
