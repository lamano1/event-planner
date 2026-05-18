<nav x-data="{ open: false }" class="bg-gradient-to-r from-slate-950 via-purple-950 to-slate-950 border-b border-purple-500 border-opacity-30 backdrop-blur-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('events.index') }}" class="text-2xl font-black glow-cyan" style="font-family: 'Orbitron', sans-serif;">
                        ◆ EVENTS
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('events.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('events.*') ? 'text-purple-400 border-b-2 border-purple-400' : 'text-purple-300 hover:text-purple-200' }}">
                        Mes Événements
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-purple-500 border-opacity-30 text-sm leading-4 font-medium rounded-lg text-purple-300 bg-slate-900 bg-opacity-50 hover:text-purple-200 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-purple-400 hover:text-purple-300 hover:bg-purple-900 hover:bg-opacity-20 focus:outline-none focus:bg-purple-900 focus:text-purple-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('events.index') }}" class="text-purple-300 hover:text-purple-200 block px-3 py-2 rounded-md text-base font-medium">
                Mes Événements
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-purple-500 border-opacity-20">
            <div class="px-4">
                <div class="font-medium text-base text-purple-300">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-purple-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="text-purple-300 hover:text-purple-200 block px-3 py-2 rounded-md text-base font-medium">
                    {{ __('Profil') }}
                </a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="text-purple-300 hover:text-purple-200 block w-full text-left px-3 py-2 rounded-md text-base font-medium">
                        {{ __('Déconnexion') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>