<h3 class="orange-text">Control Panel</h3>
<ul class="nav nav-pills nav-stacked text-left">
	<li><a href="/panel/{{Auth::id()}}"><i class="fa fa-dashboard"></i>Project Management</a></li>
	<li><a href="{{route('project')}}"><i class="fa fa-file-text"></i> New Inspection Project</a></li>
	<li><a href="{{route('clients')}}"><i class="fa fa-users"></i> Clients</a></li>
	<li><a href="{{route('inspectors')}}"><i class="fa fa-users"></i> Inspectors</a></li>
	<li><a href="{{route('factorylist')}}"><i class="fa fa-industry"></i> Factories</a></li>
	<li><a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> Logout</a></li>
</ul>
