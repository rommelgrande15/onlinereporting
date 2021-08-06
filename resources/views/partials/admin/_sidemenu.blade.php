<div class="nav-side-menu">
	<div class="brand">
		<img alt="Brand" src="{{URL::asset('/images/tic_white.png')}}" width="150">
	</div>
	<div class="avatar">
		<img alt="Brand" src="{{$user_info->photo}}" class="img-circle" width="100" height="100">
		<p class="name-user">{{$user_info->name}}</p>
		<p class="designation">{{ucwords($user_info->designation)}}</p>
		<ul>
			<li><a href="#" title="Profile"><i class="fa fa-user"></i></a></li>
			<li><a href="#" title="Account Settings"><i class="fa fa-cog"></i></a></li>
			<li><a href="{{route('logout')}}" title="Logout"><i class="fa fa-power-off"></i></a></li>
		</ul>
	</div>
	<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

	<div class="menu-list">

		<ul id="menu-content" class="menu-content collapse out">
			<li>
				<a href="/panel/{{Auth::id()}}">
					<i class="fa fa-dashboard fa-lg"></i> Project Management
				</a>
			</li>

			<li>
				<a href="{{route('project')}}">
					<i class="fa fa-file-text fa-lg"></i> New Inspection Project
				</a>
			</li>

			<li>
				<a href="{{route('clients')}}">
					<i class="fa fa-users fa-lg"></i> Client Management
				</a>
			</li>

			<li>
				<a href="{{route('factorylist')}}">
					<i class="fa fa-industry fa-lg"></i> Factories List
				</a>
			</li>


			<li data-toggle="collapse" data-target="#users" class="collapsed">
				<a href="#"><i class="fa fa-users fa-lg"></i> User Management <span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="users">
				<li><a href="{{route('accounts')}}">Accounts</a></li>
				<li><a href="{{route('inspectors')}}">Inspectors</a></li>
				{{-- <li><a href="#">Booking Team</a></li>
                      <li><a href="#">Reports Team</a></li> --}}
			</ul>

			<li data-toggle="collapse" data-target="#admin" class="collapsed">
				<a href="#"><i class="fa fa-cogs fa-lg"></i> Administrator Settings <span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="admin">
				{{-- <li><a href="#">Email Change Requests</a></li> --}}
				<li><a href="{{route('permissions')}}">User Permissions</a></li>
			</ul>

			<li data-toggle="collapse" data-target="#cms" class="collapsed">
				<a href="#"><i class="fa fa-edit fa-lg"></i> Website Content Management <span class="arrow"></span></a>
			</li>
			<ul class="sub-menu collapse" id="cms">
				<li><a href="{{route('cms.languages')}}">Languages</a></li>
				<li><a href="{{route('cms.pages')}}">Pages</a></li>
				<li><a href="">All Contents</a></li>
				<li><a href="">Navigation (Menu)</a></li>
				<li><a href="">Widgets</a></li>
			</ul>
		</ul>
	</div>
</div>
