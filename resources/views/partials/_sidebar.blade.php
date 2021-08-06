<h3 class="orange-text text-center">Control Panel</h3>
<div class="text-center company-avatar">
 {{--  <img src="{{$company->company_logo}}" width="200"><br><br> --}}
  <p>
    <a href="#" class="btn btn-success btn-xs"><i class="fa fa-picture-o"></i> Update Logo</a>
  </p>
</div>
<ul class="nav nav-pills nav-stacked">
  <li> <a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
  <li class="dropdown">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-file-text"></i> Book a Service
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <li><a href="/inspection"><i class="fa fa-search"></i> Inspection Service Booking</a></li>
{{--       <li><a href="/quick"><i class="fa fa-bolt"></i> Quick Booking</a></li> --}}
    </ul>
  </li>
  <li><a href="/bookings"><i class="fa fa-list-alt"></i> My Bookings</a></li>
   <li> <a href="/requirements"><i class="fa fa-list"></i> My Requirements</a></li>
  <li> <a href="/products"><i class="fa fa-cubes"></i> Products List</a></li>
  <li> <a href="/factories"><i class="fa fa-industry"></i> Factories</a></li>
</ul>
