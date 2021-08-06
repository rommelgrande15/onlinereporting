<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{asset($user_info->photo)}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{$user_info->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
{{-- <h1>{{$user_info->designation}}</h1> --}}
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>       
    
      <li>
        <a href="#" style="cursor:not-allowed" title="Please Complete Your Details First.">
          <i class="fa fa-file-text"></i> <span>New Order</span>
        </a>
      </li>
      <li>
        <a href="#" style="cursor:not-allowed" title="Please Complete Your Details First.">
          <i class="fa fa-cubes"></i> <span>My Orders</span>
        </a>
      </li>
      <li>
        <a href="#" style="cursor:not-allowed" title="Please Complete Your Details First.">
          <i class="fa fa-handshake-o"></i> <span>Supplier Management</span>
        </a>
      </li>



      <li>
        <a href="#" style="cursor:not-allowed" title="Please Complete Your Details First.">
          <i class="fa fa-folder"></i> <span>Product Management</span>
        </a>
      </li>


      <li>
        <a href="#">
          <i class="fa fa-cog"></i> <span>Account Settings</span>
        </a>
      </li>

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
