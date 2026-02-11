<nav class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <div class="flex items-center">
                <a href="{{ Auth::user()->role === 'pelamar'
                        ? route('pelamar.profile')
                        : (Auth::user()->role === 'hrd'
                            ? route('hrd.dashboard')
                            : route('admin.dashboard')) }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            {{-- Desktop Menu --}}
            <div class="hidden sm:flex sm:items-center sm:gap-8">

                @if(Auth::user()->role !== 'pelamar')
                    <a
                        href="{{ Auth::user()->role === 'hrd'
                                ? route('hrd.dashboard')
                                : route('admin.dashboard') }}"
                        class="text-sm font-medium text-gray-700 hover:text-gray-900">
                        Dashboard
                    </a>
                @endif

                {{-- User Dropdown --}}
                <div class="dropdown">
                    <button
                        class="btn btn-link text-sm font-medium text-gray-600 hover:text-gray-800 d-flex align-items-center gap-2"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ Auth::user()->name }}
                        <i class="bi bi-chevron-down"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <a
                                class="dropdown-item"
                                href="{{ Auth::user()->role === 'pelamar'
                                        ? route('pelamar.profile')
                                        : route('profile.edit') }}">
                                Profile Saya
                            </a>
                        </li>

                        @if(Auth::user()->role === 'pelamar')
                            <li>
                                <a
                                    class="dropdown-item"
                                    href="{{ route('pelamar.lamaran') }}">
                                    Lamaran Saya
                                </a>
                            </li>
                        @endif

                        <li><hr class="dropdown-divider"></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="dropdown-item text-danger">
                                    Log Out
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>

            {{-- Mobile Toggle --}}
            <button
                class="sm:hidden p-2 text-gray-500 hover:text-gray-700"
                data-bs-toggle="collapse"
                data-bs-target="#mobileMenu">
                ☰
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobileMenu" class="collapse sm:hidden border-t">

        @if(Auth::user()->role !== 'pelamar')
            <a
                href="{{ Auth::user()->role === 'hrd'
                        ? route('hrd.dashboard')
                        : route('admin.dashboard') }}"
                class="block px-4 py-2 text-sm text-gray-700">
                Dashboard
            </a>
        @endif

        <a
            href="{{ Auth::user()->role === 'pelamar'
                    ? route('pelamar.profile')
                    : route('profile.edit') }}"
            class="block px-4 py-2 text-sm text-gray-700">
            Profile Saya
        </a>

        @if(Auth::user()->role === 'pelamar')
            <a
                href="{{ route('pelamar.lamaran') }}"
                class="block px-4 py-2 text-sm text-gray-700">
                Lamaran Saya
            </a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left px-4 py-2 text-sm text-red-600">
                Log Out
            </button>
        </form>
    </div>
</nav>
