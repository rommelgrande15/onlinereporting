<header class="main-header">

  <!-- Logo -->
  <a href="#" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    
    <!-- logo for regular state and mobile devices -->
    @if(strpos(Request::url(''), 'tic-sera') !== false)
      <span class="logo-mini"><b>SERA</b></span>
      <span class="logo-lg"><img src="{{asset('images/ticsera-logo.png')}}" width="100px" style="margin-top:5px;"></span>
    @else
      <span class="logo-mini"><b>TIC</b></span>
      <span class="logo-lg"><img src="{{asset('images/tic_white.png')}}" width="100px"></span>
    @endif




    <!--<img src="{{asset('images/tic.png')}}" width="100px">-->
    
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
        
      <ul class="nav navbar-nav">
          
        <!-- Messages: style can be found in dropdown.less-->
        {{-- <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success">4</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 4 messages</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
                <li><!-- start message -->
                  <a href="#">
                    <div class="pull-left">
                      <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Support Team
                      <small><i class="fa fa-clock-o"></i> 5 mins</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <!-- end message -->
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      AdminLTE Design Team
                      <small><i class="fa fa-clock-o"></i> 2 hours</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Developers
                      <small><i class="fa fa-clock-o"></i> Today</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Sales Department
                      <small><i class="fa fa-clock-o"></i> Yesterday</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Reviewers
                      <small><i class="fa fa-clock-o"></i> 2 days</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="footer"><a href="#">See All Messages</a></li>
          </ul>
        </li> --}}
        
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="{{asset($user_info->photo)}}" class="user-image" alt="User Image">
            <span class="hidden-xs">{{$user_info->name}}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="{{asset($user_info->photo)}}" class="img-circle" alt="User Image">

              <p>
                {{$user_info->name}}
                <small>Member since {{date('M. Y',strtotime($user_info->created_at))}}</small>
              </p>
            </li>
            <!-- Menu Body -->
          
            <!-- Menu Footer-->
            <li class="user-footer">
              @if(strpos(Request::url(''), 'tic-sera') !== false)
                <a href="{{route('logout-tic-sera')}}" class="btn btn-block btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
              @else
                <a href="{{route('logout')}}" class="btn btn-block btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
              @endif
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        {{-- <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li> --}}
      </ul>
    </div>
  </nav>
</header>