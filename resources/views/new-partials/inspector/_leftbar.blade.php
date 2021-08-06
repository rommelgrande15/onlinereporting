<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset($user_info->photo)}}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p style="word-break : break-all; white-space: normal">{{$user_info->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        {{-- <h1>{{$user_info->designation}}</h1> --}}
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ request()->is('inspector-reports-general') ? 'active' : '' }}">
                <a href="{{route('inspector-reports-general',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Online Reporting Form</span>
                </a>
            </li>
             {{-- <li class="{{ request()->is('inspector-summary-result') ? 'active' : '' }}">
                <a href="{{route('inspector-summary-result',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Online Reporting Form V2</span>
                </a>
            </li> --}}
            {{--<li class="{{ request()->is('inspector-remarks-report') ? 'active' : '' }}">
                <a href="{{route('inspector-remarks-report',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Remarks&Addition'l Informat'n</span>
                </a>
            </li>
            <li class="{{ request()->is('inspector-export-carton') ? 'active' : '' }}">
                <a href="{{route('inspector-export-carton',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Export Carton Packing</span>
                </a>
            </li>
            <li class="{{ request()->is('inspector-packing-products') ? 'active' : '' }}">
                <a href="{{route('inspector-packing-products',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Packing Of Products</span>
                </a>
            </li>
            <li class="{{ request()->is('inspector-product-details') ? 'active' : '' }}">
                <a href="{{route('inspector-product-details',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Product Details</span>
                </a>
            </li>
            <li class="{{ request()->is('inspector-funtion-checking') ? 'active' : '' }}">
                <a href="{{route('inspector-funtion-checking',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Function Checking & Test Photo</span>
                </a>
            </li>
            <li class="{{ request()->is('inspector-defect-failures') ? 'active' : '' }}">
                <a href="{{route('inspector-defect-failures',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Defects Failures</span>
                </a>
            </li>
            <li class="{{ request()->is('inspector-summary-measurements') ? 'active' : '' }}">
                <a href="{{route('inspector-summary-measurements',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Summary Measurements</span>
                </a>
            </li>
            <li class="{{ request()->is('inspector-ab-or') ? 'active' : '' }}">
                <a href="{{route('inspector-ab-or',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>AB & OR Photo</span>
                </a>
            </li>
            <li class="{{ request()->is('inspector-additional-information') ? 'active' : '' }}">
                <a href="{{route('inspector-additional-information',$report->id)}}">
                    <i class="fa fa-wpforms"></i> <span>Additional Header Information</span>
                </a>
            </li> --}}
       

        <li>
            @if(strpos(Request::url(''), 'tic-sera') !== false)
            <a href="{{route('logout-tic-sera')}}">
                <i class="fa fa-sign-out"></i> <span>Sign out</span>
            </a>
            @else
            <a href="{{route('logout')}}">
                <i class="fa fa-sign-out"></i> <span>Sign out</span>
            </a>
            @endif
        </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
