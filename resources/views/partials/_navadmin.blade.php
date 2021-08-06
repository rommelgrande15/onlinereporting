<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img alt="Brand" src="{{URL::asset('/images/tic_white.png')}}" width="150">
      </a>
    </div>

    	@if(Auth::check())
    	<!-- Collect the nav links, forms, and other content for toggling -->
	    {{-- <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	          	<i class="fa fa-user fa-2x"></i>  {{$role->username}}<span class="caret"></span>
	          </a>
	          <ul class="dropdown-menu">
	            <li><a href="#"><i class="fa fa-user"></i> View Profile</a></li>
	            <li><a href="#"><i class="fa fa-gears"></i> Account Settings</a></li>
	            <li role="separator" class="divider"></li>
	            <li><a href="#"><i class="fa fa-sign-out"></i> Logout</a></li>
	          </ul>
	        </li>
	      </ul>
	    </div><!-- /.navbar-collapse -->   --}}
	    @endif
	   
  </div><!-- /.container-fluid -->
</nav>
