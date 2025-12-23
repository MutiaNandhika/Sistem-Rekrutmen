<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- LOGO --}}
            <div class="flex items-center">
                <a href="{{ Auth::user()->role === 'pelamar'
                        ? route('pelamar.profile')
                        : (Auth::user()->role === 'hrd'
                            ? route('hrd.dashboard')
                            : route('admin.dashboard')) }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            {{-- DESKTOP MENU --}}
            <div class="hidden sm:flex sm:items-center sm:gap-8">

                {{-- HRD & ADMIN --}}
                @if(Auth::user()->role !== 'pelamar')
                    <a href="{{ Auth::user()->role === 'hrd'
                            ? route('hrd.dashboard')
                            : route('admin.dashboard') }}"
                       class="text-sm font-medium text-gray-700 hover:text-gray-900">
                        Dashboard
                    </a>
                @endif

                {{-- USER DROPDOWN --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-800">
                            {{ Auth::user()->name }}
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link
                            :href="Auth::user()->role === 'pelamar'
                                ? route('pelamar.profile')
                                : route('profile.edit')">
                            Profile Saya
                        </x-dropdown-link>

                        @if(Auth::user()->role === 'pelamar')
                            <x-dropdown-link :href="route('pelamar.lamaran')">
                                Lamaran Saya
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- HAMBURGER --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-500 hover:text-gray-700">
                    ☰
                </button>
            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div x-show="open" class="sm:hidden border-t">

        @if(Auth::user()->role !== 'pelamar')
            <a href="{{ Auth::user()->role === 'hrd'
                    ? route('hrd.dashboard')
                    : route('admin.dashboard') }}"
               class="block px-4 py-2 text-sm text-gray-700">
                Dashboard
            </a>
        @endif

        <a href="{{ Auth::user()->role === 'pelamar'
                ? route('pelamar.profile')
                : route('profile.edit') }}"
           class="block px-4 py-2 text-sm text-gray-700">
            Profile Saya
        </a>

        @if(Auth::user()->role === 'pelamar')
            <a href="{{ route('pelamar.lamaran') }}"
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
