<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container-fluid px-4">

        <a class="navbar-brand d-flex align-items-center gap-2"
           href="{{ url('/redirect-after-login') }}">
            <img src="{{ asset('images/mda-logo.png') }}" height="28">
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarDashboard">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarDashboard">
            <ul class="navbar-nav me-auto mb-2 mb-md-0 gap-md-3">
                @if (Auth::user()->role === 'hrd')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('hrd/dashboard') ? 'active fw-semibold' : '' }}"
                           href="{{ route('hrd.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('hrd/lowongan*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('hrd.lowongan.index') }}">
                            Lowongan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('hrd/report*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('hrd.report.index') }}">
                            Report
                        </a>
                    </li>

                @endif

                {{-- ================= ADMIN ================= --}}
                @if (Auth::user()->role === 'admin')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active fw-semibold' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/monitoring') ? 'active fw-semibold' : '' }}"
                           href="{{ route('admin.monitoring') }}">
                            Monitoring Kandidat
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link
                           {{ request()->is('admin/monitoring/lowongan*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('admin.monitoring.lowongan') }}">
                            Monitoring Lowongan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/manajemen-akun*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('admin.akun.index') }}">
                            Manajemen Akun
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/report*') ? 'active fw-semibold' : '' }}"
                           href="{{ route('admin.report.index') }}">
                            Report
                        </a>
                    </li>

                @endif

            </ul>

            {{-- ================= USER DROPDOWN ================= --}}
            <ul class="navbar-nav">
                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center gap-2"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                        <li>
                            <a class="dropdown-item"
                               href="{{ route('account.settings') }}">
                                <i class="bi bi-gear me-2"></i>
                                Pengaturan Akun
                            </a>
                        </li>

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
