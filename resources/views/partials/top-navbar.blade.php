<nav class="top-navbar">
    <div class="d-flex align-items-center">
        <button class="btn btn-light d-lg-none mr-2" id="mobileSidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="m-0">@yield('title', 'Dashboard')</h5>
    </div>
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" class="form-control" placeholder="Search...">
    </div>
    <div class="user-menu">
        <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown">
                <img src="https://via.placeholder.com/40" alt="User"> <span class="d-none d-md-inline">{{ Auth::user()->name ?? null}}</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i> Profile</a>
                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i> Settings</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>