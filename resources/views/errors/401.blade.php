@extends('layouts.error')
@section('title','Error 401')
@section('stylesheets')
{{Html::style('/css/error.css')}}
@endsection

@section('content')
    <div class="col-md-12 text-center logo-container">
      <img src="{{URL::asset('/images/tic.png')}}">
    </div>
    <div class="col-md-12 text-center">
        <div class="text error-code">401</div>
    </div>
@endsection
