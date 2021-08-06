@extends('layouts.new')
@section('title','Dashboard')
@section('page-title','Dashboard ')

@section('stylesheets')

@endsection

@section('content')
<div class="row">
	@include('new-partials.dashboard._infobox')
</div>

<div class="row">
	@include('new-partials.dashboard._recap')
</div>

<div class="row">
	@include('new-partials.dashboard._widgets')
	@include('new-partials.dashboard._table')
</div>
@endsection

@section('scripts')
<script>
	var test = "test";

</script>
@endsection
