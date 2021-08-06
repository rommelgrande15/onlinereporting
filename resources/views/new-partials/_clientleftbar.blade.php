<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    
    <div class="user-panel">
      <div class="pull-left image">
      {{--   <img src="{{asset($user_info->client_name)}}" class="img-circle" alt="User Image"> --}}
      <br>
      <br>
      </div>
      <div class="pull-left info">
        <p>{{ $user_info->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
 

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      
      <li>
        <a href="{{route('panel',Auth::id())}}">
          <i class="fa fa-cubes"></i> <span>Project Management</span>
        </a>
      </li>
      <li>
        <a href="{{route('project')}}">
          <i class="fa fa-cogs"></i> <span>Account Settings</span>
        </a>
      </li>
      <li>
        <a href="{{route('client.logout')}}">
          <i class="fa fa-sign-out"></i> <span>Logout</span>
        </a>
      </li>



     
{{--       <li class="header">LABELS</li>
      <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
      <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li> --}}
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
