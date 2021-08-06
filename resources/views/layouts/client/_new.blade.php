<!DOCTYPE html>
<html>
<head>
  @include('new-partials._head')
  @yield('stylesheets')
</head>
<body class="hold-transition skin-blue sidebar-mini fixed skin-yellow">
<div class="wrapper">

  @include('new-partials._topbar')

  @include('new-partials.client._leftbar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>@yield('page-title')</h1>
    </section>

    <!-- Main content -->
    <section class="content">

      @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  @include('new-partials._footer')
  @include('new-partials._rightbar')
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


@include('new-partials._js')
@yield('scripts')
</body>
</html>
