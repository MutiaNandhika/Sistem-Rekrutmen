<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid px-4">

        {{-- LOGO --}}
        <a class="navbar-brand d-flex align-items-center gap-2"
           href="{{ url('/redirect-after-login') }}">
            <img src="{{ asset('images/mda-logo.png') }}" height="28">
        </a>

        {{-- TOGGLER --}}
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarDashboard">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarDashboard">

            {{-- MENU KIRI --}}
            <ul class="navbar-nav me-auto mb-2 mb-md-0 gap-md-3">

                {{-- HRD --}}
                @if (Auth::user()->role === 'hrd')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('hrd/dashboard') ? 'active fw-semibold' : '' }}"
                           href="{{ url('/hrd/dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('hrd/lowongan*') ? 'active fw-semibold' : '' }}"
                           href="#">
                            Lowongan
                        </a>
                    </li>
                @endif

                {{-- ADMIN --}}
                @if (Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active fw-semibold' : '' }}"
                           href="{{ url('/admin/dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/users*') ? 'active fw-semibold' : '' }}"
                           href="#">
                            Manajemen Akun
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/monitoring*') ? 'active fw-semibold' : '' }}"
                           href="#">
                            Monitoring
                        </a>
                    </li>
                @endif
            </ul>

            {{-- USER DROPDOWN --}}
            <ul class="navbar-nav">
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center gap-2"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <i class="bi bi-person-circle fs-5"></i>
                        {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                        {{-- PROFILE SINGKAT --}}
                        <li>
                            <a class="dropdown-item"
                               href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2"></i>
                                Profile
                            </a>
                        </li>

                        {{-- BERANDA (PUBLIC) --}}
                        <li>
                            <a class="dropdown-item"
                               href="{{ route('public.home') }}">
                                <i class="bi bi-house-door me-2"></i>
                                Beranda
                            </a>
                        </li>

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
