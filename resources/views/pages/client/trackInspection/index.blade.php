@extends('layouts.client._new')
@section('title','Track Inspection')
{{-- @section('page-title','Account Settings') --}}

@section('stylesheets')
  {{ Html::style('/css/admin/dashboard.css') }}
  {!! Html::style('/css/register/index.css') !!}
@endsection
<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.js'></script>
<link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' rel='stylesheet' />
<style>
body { margin:0; padding:0; }
#map {  width:100%; height:100%; }
</style>
 <body>
@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading orange-background"><h3>Inspection Tracking</h3></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-4">
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table id="factories_table" class="table table-condensed small dataTable no-footer">
										<thead>
										<tr>
										<th class="text-center">Section</th>

										<th class="text-center">Status</th>

										</tr>
										</thead>
										<tbody id="statusSection">
										</tbody>
										</table>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table id="factories_table" class="table table-condensed small dataTable no-footer">
											<tr>
												<td style="width: 25%">Inspection Started</td><td id="inspection-start">Pending..</td>
											</tr>
											<tr>
												<td>Inspection Ended</td><td id="inspection-end">Pending..</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div id='map'></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="se-pre-con"></div>
	<div class="send-loading"></div>
<script type="text/javascript" src="{{asset('cloudfare/jquery-3.3.1.min.js')}}"></script>
<script>
	$(window).on('load',function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
	});
</script>
<script>
mapboxgl.accessToken = 'pk.eyJ1Ijoicm9tbWVsLXRpYyIsImEiOiJjanBqYXM3YmwwNHQ4M3Bya2ozemdvazcxIn0.ybQdeyZUQQVoHD5iUVfFfA';
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v11'
});
 
map.on('load', function() {
map.addLayer({
'id': 'room-extrusion',
'type': 'fill-extrusion',
'source': {
// GeoJSON Data source used in vector tiles, documented at
// https://gist.github.com/ryanbaumann/a7d970386ce59d11c16278b90dde094d
'type': 'geojson',
'data': 'https://docs.mapbox.com/mapbox-gl-js/assets/indoor-3d-map.geojson'
},
'paint': {
// See the Mapbox Style Specification for details on data expressions.
// https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions
 
// Get the fill-extrusion-color from the source 'color' property.
'fill-extrusion-color': ['get', 'color'],
 
// Get fill-extrusion-height from the source 'height' property.
'fill-extrusion-height': ['get', 'height'],
 
// Get fill-extrusion-base from the source 'base_height' property.
'fill-extrusion-base': ['get', 'base_height'],
 
// Make extrusions slightly opaque for see through indoor walls.
'fill-extrusion-opacity': 0.5
}
});
});
marker = new mapboxgl.Marker({color: '#f39c12'});
setTimeout(function run() {
  ajaxRequest('geo-reporting?id={{ $id }}',processsGeoReporting);
  ajaxRequest('report-status?id={{ $id }}',processReportStatus);
  ajaxRequest('report-start-time?id={{ $id }}',getStartTime);
  ajaxRequest('report-end-time?id={{ $id }}',getEndTime);
  setTimeout(run, 10000);
}, 100);

function processsGeoReporting(data){
	data = JSON.parse(data);
	if(typeof data != "undefined" && !isEmpty(data)){
		marker.setLngLat([data.longitude, data.latitude])
		  .addTo(map);
		map.flyTo({
			center: [data.longitude, data.latitude],
			zoom: 10,
			bearing: 0,
			speed: 0.7,
			curve: 1, 
			easing: function (t) { return t; }
		});
	}
}

function processReportStatus(data){
	if(data){
		document.getElementById('statusSection').innerHTML = '';
		data = JSON.parse(data);
		data.forEach(displayStatus);
	}
}

function displayStatus(value) {
	document.getElementById('statusSection').insertAdjacentHTML( 'beforeend', value );
}

function setNewMarker(lng,){
	
}
function getRandomInRange(from, to, fixed) {
    return (Math.random() * (to - from) + from).toFixed(fixed) * 1;
}
function ajaxRequest(endpoint,cb){
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			cb.apply(this,[this.responseText]);
		}
	};
	xmlhttp.open("GET", '/api/' + endpoint, true);
	xmlhttp.send();
}
function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}
function getStartTime(data){
	if(data)
		document.getElementById('inspection-start').innerHTML = data;
}
function getEndTime(data){
	if(data)
		document.getElementById('inspection-end').innerHTML = data;
}
</script>
</body>
@endsection

@section('scripts')
	{!! Html::script('/js/client/panel-client.js') !!}
@endsection

