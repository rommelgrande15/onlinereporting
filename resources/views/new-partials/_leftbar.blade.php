<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset($user_info->photo)}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{$user_info->name}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        {{-- <h1>{{$user_info->designation}}</h1> --}}
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            {{--<li>
				<a href="{{route('panel',Auth::id())}}">
            <i class="fa fa-cubes"></i> <span>Project Management</span>
            </a>
            </li>
            --}}
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-cubes"></i>
                    <span>Project Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{route('inspection-summary')}}">
                            <i class="fa fa-calendar"></i> <span>Inspection Summary</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('panel',Auth::id())}}">
                            <i class="fa fa-list"></i> <span>Inspection Lists</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('booking-inspection-calendar')}}">
                            <i class="fa fa-calendar"></i> <span>Inpsection Calendar</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ request()->is('admin-statistics*') ? 'active' : '' }}">
            <a href="#">
                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                <span>KPI</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                {{--<li class="{{ request()->is('admin-statistics/kpi') ? 'active' : '' }}"><a href="{{ request()->is('admin-statistics/kpi') ? '#' : route('admin.stats','kpi') }}"><i class="fa fa-circle"></i>By Results</a></li>
                <li class="{{ request()->is('admin-statistics/countries') ? 'active' : '' }}"><a href="{{ request()->is('admin-statistics/countries') ? '#' : route('admin.stats','countries') }}"><i class="fa fa-circle"></i>By Countries</a></li>
                <li class="{{ request()->is('admin-statistics/factories') ? 'active' : '' }}"><a href="{{ request()->is('admin-statistics/factories') ? '#' : route('admin.stats','factories') }}"><i class="fa fa-circle"></i>By Factories</a></li>
                <li class="{{ request()->is('admin-statistics/suppliers') ? 'active' : '' }}"><a href="{{ request()->is('admin-statistics/suppliers') ? '#' : route('admin.stats','suppliers') }}"><i class="fa fa-circle"></i>By Suppliers</a></li>
                <li class="{{ request()->is('admin-statistics/products') ? 'active' : '' }}"><a href="{{ request()->is('admin-statistics/products') ? '#' : route('admin.stats','products') }}"><i class="fa fa-circle"></i>By Products Cost/Pieces</a></li>
                <li class="{{ request()->is('admin-statistics/cost') ? 'active' : '' }}"><a href="{{ request()->is('admin-statistics/cost') ? '#' : route('admin.stats','cost') }}"><i class="fa fa-circle"></i>MD and Basic Cost</a></li>--}}
                
                <li class="{{ request()->is('admin-statistics/jobs') ? 'active' : '' }}"><a href="{{ request()->is('admin-statistics/jobs') ? '#' : route('admin.stats','jobs') }}"><i class="fa fa-circle"></i>Jobs</a></li>
                <li class="{{ request()->is('admin-statistics/inspectors') ? 'active' : '' }}"><a href="{{ request()->is('admin-statistics/inspectors') ? '#' : route('admin.stats','inspectors') }}"><i class="fa fa-circle"></i>Inspectors</a></li>
                <li class="{{ request()->is('admin-statistics/reports') ? 'active' : '' }}"><a href="{{ request()->is('admin-statistics/reports') ? '#' : route('admin.stats','reports') }}"><i class="fa fa-circle"></i>Reports</a></li>
                
            </ul>
        </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-text"></i>
                    <span>New Project</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{route('project')}}">
                            <i class="fa fa-file-text"></i> <span>New Project</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('project-mrn')}}">
                            <i class="fa fa-copy"></i> <span>Multiple Report Number</span>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- <li>
        <a href="{{route('getBookingPanel')}}">
            <i class="fa fa-book"></i> <span>Inspection Booked</span>
            </a>
            </li> --}}
            {{-- <li>
                <a href="{{route('project')}}">
            <i class="fa fa-file-text"></i> <span>New Project</span>
            </a>
            </li> --}}
            {{-- <li>
                <a href="{{route('project')}}">
            <i class="fa fa-file-text"></i> <span>New Project</span>
            </a>
            </li> --}}
            @if($user_info->designation == "super_admin" || $user_info->designation == "administrator")
            <li>
                <a href="{{route('template')}}">
                    <i class="fa fa-bookmark"></i> <span>Project Templates</span>
                </a>
            </li>
            @endif
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Client Management</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                    @if(!empty($new_client_count))
                    @if($new_client_count!='' || $new_client_count>0)
                    &nbsp; <i class="fa fa-circle fa-xs" style="color:orangered; font-size:10px;"></i>
                    @endif
                    @endif
                </a>

                <ul class="treeview-menu">
                    <li>
                        <a href="{{route('newclients')}}">
                            <i class="fa fa-user"></i>New Registered Client
                            @if(!empty($new_client_count))
                            @if($new_client_count!='' || $new_client_count>0)
                            &nbsp; <i class="fa fa-circle fa-xs" style="color:orangered; font-size:10px;"></i>
                            @endif
                            @endif
                        </a>

                    </li>
                    <li><a href="{{route('clients')}}"><i class="fa fa-users"></i>Registered Client</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bookmark"></i>
                    <span>Client Booked</span>
                    @if(!empty($new_post_client) || !empty($new_post_client_sera))
                    @if($new_post_client!='' || $new_post_client>0 || $new_post_client_sera>0)
                    &nbsp;<i class="fa fa-circle fa-xs" style="color:orangered; font-size:10px;"></i> {{-- {!!$new_post_client!!} --}}
                    @endif
                    @endif
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{route('client-booking')}}">
                            <i class="fa fa-user-circle-o"></i>
                            Client TIC
                            @if(!empty($new_post_client))
                            @if($new_post_client!='' || $new_post_client>0)
                            &nbsp;<i class="fa fa-circle fa-xs" style="color:orangered; font-size:10px;"></i>
                            @endif
                            @endif
                        </a>

                    </li>
                    <li>
                        <a href="{{route('client-booking-ticsera')}}">
                            <i class="fa fa-user"></i>
                            Client TIC-SERA
                            @if(!empty($new_post_client_sera))
                            @if($new_post_client_sera!='' || $new_post_client_sera>0)
                            &nbsp;<i class="fa fa-circle fa-xs" style="color:orangered; font-size:10px;"></i>
                            @endif
                            @endif
                        </a>

                    </li>
                </ul>
            </li>
            {{-- <li>
				<a href="{{route('client-cost')}}"><i class="fa fa-money"></i>Inspection Cost / Invoice</a>
            </li> --}}
            {{-- <li class="treeview">
				<a href="#">
					<i class="fa fa-money"></i>
					<span>Inspection Cost / Invoice</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="{{route('client-cost')}}"><i class="fa fa-user-circle-o"></i>Client Invoice</a></li>
            <li><a href="{{route('inspector-cost')}}"><i class="fa fa-user"></i>Inspector Invoice</a></li>
        </ul>
        </li> --}}
        <li>
            <a href="{{route('factorylist')}}">
                <i class="fa fa-industry"></i> <span>Factory Management</span>
            </a>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-address-card-o"></i>
                <span>User Management</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                @if($user_info->designation == "super_admin" || $user_info->designation == "administrator")
                <li><a href="{{route('accounts')}}"><i class="fa fa-circle-o"></i>User Accounts</a></li>
                @endif
                <li><a href="{{route('inspectors')}}"><i class="fa fa-circle-o"></i> Inspectors</a></li>
                @if($user_info->designation == "super_admin" || $user_info->designation == "administrator")
                <li><a href="{{route('sales-manager')}}"><i class="fa fa-circle-o"></i>Sales Manager</a></li>
                @endif
            </ul>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-download"></i>
                <span>Downloads</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li style="position:relative; bottom:0; width:100%;" data-toggle="tooltip" title="TIC Geo Tracking Word Report Manual.pdf">
                    <a href="/uploads/manual/TIC Geo Tracking Word Report Manual.pdf" download><i class="fa fa-file"></i><span>Geo Tracking Manual</span></a>
                </li>
                <li style="position:relative; bottom:0; width:100%;" data-toggle="tooltip" title="TIC APP USER GUIDE.pdf">
                    <a href="/uploads/manual/TIC APP USER GUIDE - Updated V35.pdf" download><i class="fa fa-file"></i><span>Mobile app Inspection Manual</span></a>
                </li>
                <li style="position:relative; bottom:0; width:100%;" data-toggle="tooltip" title="TIC Inspector app v1.0.35.apk">
                    <a href="/updated-app/TIC-Inspector-app-v1.0.37.apk" download><i class="fa fa-android"></i><span>Android Mobile App v1.0.37</span></a>
                </li>

                <li style="position:relative; bottom:0; width:100%;" data-toggle="tooltip" title="TIC Client app v1.0.3.apk">
                    <a href="/updated-app/client/TIC-client-v1.0.3.apk" download><i class="fa fa-android"></i><span>Android CLient Mobile App</span></a>
                </li>

                <li style="position:relative; bottom:0; width:100%;" data-toggle="tooltip" title="TIC - MOBILE  BOOKING APPLICATION MANUAL.pdf">
                    <a href="/uploads/manual/TIC - MOBILE  BOOKING APPLICATION MANUAL.pdf" download><i class="fa fa-file"></i><span>TIC - Mobile Booking Application Manual</span></a>
                </li>

            </ul>
        </li>
        <li>
            <a href="{{route('logout')}}">
                <i class="fa fa-sign-out"></i> <span>Sign out</span>
            </a>
        </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
