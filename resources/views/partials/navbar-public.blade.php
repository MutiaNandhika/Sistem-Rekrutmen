<nav class="navbar navbar-expand-md navbar-light bg-white sticky-top shadow-sm">
    <div class="container">

        <a class="navbar-brand" href="{{ route('public.home') }}">
            <img src="{{ asset('images/mda-logo.png') }}" height="32">
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarPublic">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarPublic">

            {{-- MENU TENGAH --}}
            <ul class="navbar-nav mx-auto gap-md-4">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('public.home') ? 'active fw-semibold' : '' }}"
                       href="{{ route('public.home') }}">
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('jobs.*') ? 'active fw-semibold' : '' }}"
                       href="{{ route('jobs.index') }}">
                        Lowongan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active fw-semibold' : '' }}"
                       href="{{ route('about') }}">
                        Tentang Kami
                    </a>
                </li>
            </ul>

            {{-- AUTH --}}
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item me-2">
                        <a class="btn btn-orange btn-sm" href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-orange btn-sm" href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center gap-2"
                           data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5"></i>
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">

                            {{-- ================= PELAMAR ================= --}}
                            @if (Auth::user()->role === 'pelamar')

                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('pelamar.profile') }}">
                                        <i class="bi bi-person me-2"></i>
                                        Profile Saya
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('pelamar.lamaran') }}">
                                        <i class="bi bi-briefcase me-2"></i>
                                        Lamaran Saya
                                    </a>
                                </li>

                            {{-- ================= HRD & ADMIN ================= --}}
                            @else
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ url('/redirect-after-login') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>
                                        Dashboard
                                    </a>
                                </li>
                            @endif

                            {{-- ===== PENGATURAN AKUN (SEMUA ROLE) ===== --}}
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('account.settings') }}">
                                    <i class="bi bi-gear me-2"></i>
                                    Pengaturan Akun
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </li>
                @endguest
            </ul>

        </div>
    </div>
</nav>
