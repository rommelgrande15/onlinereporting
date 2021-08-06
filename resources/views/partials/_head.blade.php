<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
@if(strpos(Request::url(''), 'tic-sera') !== false)
    <title>TIC-SERA | @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('ticsera_icon.ico')}}" />
@else
    <title>The Inspection Company Ltd. | @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />
@endif

<!-- CHANGE THIS TITLE FOR EACH PAGE -->

{!! Html::style('/css/app.css') !!}
{!! Html::style('/css/jquery-ui.min.css') !!}
{!! Html::style('/css/jquery.dataTables.css') !!}
{!! Html::style('/css/font-awesome.min.css') !!}
{!! Html::style('/css/parsley.css') !!}
{!! Html::style('/css/sweetalert.css') !!}
{!! Html::style('/css/global.css') !!}

@yield('stylesheets')
