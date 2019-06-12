<header class="main-header">
    <!-- Logo -->
<a href="{{ URL::route('user.dashboard') }}" class="logo hidden-xs">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
      <img style="max-width: 50px; max-height: 50px;" src="@if(isset($appSettings['institute_settings']['logo_small'])) {{asset('storage/logo/'.$appSettings['institute_settings']['logo_small'])}} @else {{ asset('images/logo-xs.png') }} @endif" alt="logo-mini">
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
        <img style="max-width: 230px; max-height: 50px;" src="@if(isset($appSettings['institute_settings']['logo'])) {{asset('storage/logo/'.$appSettings['institute_settings']['logo'])}} @else {{ asset('images/logo-md.png') }} @endif" alt="logo-md">
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">    
          <li class="clock-menu hidden-xs tablet-hidden">
            <a href="#0">
                <p class="smsclock"><span id="date"></span> || <span id="clock"></span></p>
            </a>
          </li>     

     
<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-user"></i>
        <span class="hidden-xs">{{auth()->user()->name}}</span><i class="caret"></i>
    </a>

    <ul class="dropdown-menu">
        <!-- Menu Body -->
        <li class="user-body">
            <div class="col-xs-6 text-center">
                <a href="{{ URL::route('profile') }}">
                    <div><i class="fa fa-briefcase"></i></div>
                    Profile
                </a>
            </div>
            <div class="col-xs-6 text-center password">
                <a href="{{ URL::route('change_password') }}">
                    <div><i class="fa fa-lock"></i></div>
                   Password
                </a>
            </div>
        </li>

        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="col-xs-6 text-center">
                <a href="{{ URL::route('logout') }}">
                    <div><i class="fa fa-power-off"></i></div>
                    Log out
                </a>
            </div>
        </li>
    </ul>
</li>         
        
        </ul>
      </div>
    </nav>
  </header>