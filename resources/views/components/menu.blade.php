<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">PX Forum</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('forums') ? 'active' : '' }}" href="{{ route('forums') }}">Forums</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('popular') ? 'active' : '' }}" href="{{ route('popular') }}">Popular</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('topics') ? 'active' : '' }}" href="{{ route('topics') }}">All Topics</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @if (Auth::check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ cookie('avatar') }}" alt="User Avatar" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                            {{ Auth::user()->login }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">My Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('settings') }}">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                        </ul>
                    </li>
                @else  <!-- Если пользователь не авторизован -->
                    <li class="nav-item">
                        <a class="btn btn-outline-light rounded-pill me-2" href="{{ route('register') }}">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light rounded-pill" href="{{ route('login') }}">Sign in</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>