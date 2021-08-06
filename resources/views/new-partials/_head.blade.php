<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

@if(strpos(Request::url(''), 'tic-sera') !== false)
    <title>TIC-SERA | @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('ticsera_icon.ico')}}" />
@else
    <title>TIC | @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.ico')}}" />
@endif
<!-- Tell the browser to be responsive to screen width -->

<!-- Bootstrap 3.3.7 -->
@if(strpos(Request::url(''), 'tic-sera') !== false)
    <link rel="stylesheet" href="{{asset('css/app-sera.css')}}">
@else

    @if(\Request::route()->getName() == 'summary-panel-client')
        <link rel="stylesheet" href="{{asset('css/app-for-print.css')}}">    
        @else
        <link rel="stylesheet" href="{{asset('css/app.css')}}">    
    @endif
    
@endif

<link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">
<!-- jvectormap -->
<link rel="stylesheet" href="{{asset('css/jquery-jvectormap.css')}}">

<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
@if(strpos(Request::url(''), 'tic-sera') !== false)
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/admin-sera.css')}}">
    <link rel="stylesheet" href="{{asset('css/skins/skin-sera.min.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/admin/dashboard-sera.css')}}">
@else
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <link rel="stylesheet" href="{{asset('css/skins/skin-yellow.min.css')}}">
    <link media="all" type="text/css" rel="stylesheet" href="{{asset('css/admin/dashboard.css')}}">
@endif


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="{{asset('js/html5shiv.min.js')}}"></script>
<script src="{{asset('js/respond.min.js')}}"></script>
<![endif]-->
<!-- Google Font -->
<link rel="stylesheet" href="{{asset('cloudfare/google_fonts.css')}}">
<link rel="stylesheet" href="{{asset('css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('css/sweetalert.css')}}">