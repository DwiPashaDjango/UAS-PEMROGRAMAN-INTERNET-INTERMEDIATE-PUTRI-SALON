    <nav class="container navbar navbar-expand-lg main-navbar">
        <a href="{{route('dashboard')}}" class="navbar-brand sidebar-gone-hide">
            <img src="{{asset('1.png')}}" width="150" alt="">
        </a>
        <a href="#" class="nav-link sidebar-gone-show" style="margin-top: 35px;" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
        <div class="form-inline ml-auto">
        </div>
        <ul class="navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="{{asset('admin')}}/img/avatar-2.png" class="rounded-circle mr-1">
                    <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::user()->name}}</div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-title">{{Auth::user()->email}}</div>
                    <a href="features-profile.html" class="dropdown-item has-icon">
                        <i class="far fa-user"></i> Profile
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('logout')}}" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>