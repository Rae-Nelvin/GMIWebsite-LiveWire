<nav x-data="{ open: false }" class="bg-gray-800 border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center md:ml-6">
                    <!-- Hamburger Icon -->
                        <button
                        class="block md:hidden h-8 mr-3 text-gray-400 items-center hover:text-gray-200 focus:text-gray-200 focus:outline-none">
                            <svg class="w-8 fill-current" viewBox="0 0 24 24">                            
                                <path x-show="!show" fill-rule="evenodd" d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"/>
                                <!-- <path x-show="show" fill-rule="evenodd" d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"/> -->
                            </svg>
                        </button>
                    <!-- Logo -->
                        <a href="{{ route('admin.dashboard') }}">
                            <h1 class="font-bold text-white md:text-4xl"><span class="text-red-500">GARRY'S MOD</span> INDONESIA</h1>
                        </a>
                    </div>
                </div>
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <!-- Settings Dropdown -->
                    <div class="ml-3 relative">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-800 hover:text-gray-200 focus:outline-none transition">
                                            {{ Auth::user()->name }}
                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>
                            <x-slot name="content">
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <x-jet-dropdown-link href="{{ route('admin.logout') }}"
                                            onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-jet-dropdown-link>
                                </form>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-jet-responsive-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-jet-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="flex items-center px-4">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <div class="flex-shrink-0 mr-3">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                        </div>
                    @endif

                    <div>
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        {{ __('Profile') }}
                    </x-jet-responsive-nav-link>

                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                            {{ __('API Tokens') }}
                        </x-jet-responsive-nav-link>
                    @endif

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf

                        <x-jet-responsive-nav-link href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-jet-responsive-nav-link>
                    </form>

                </div>
            </div>
        </div>
</nav>
<div class="flex min-w-full">
    <aside class="md:flex flex-col md:flex-row md:h-screen absolute">
            <div @click.away="open = false" class="flex flex-col w-full md:w-40 text-gray-700 bg-gray-700 flex-shrink-0" x-data="{ open: false }">
                <div class="flex-shrink-0 px-8 py-4 flex flex-row items-center justify-between">
                <!-- <a href="#" class="text-lg font-semibold tracking-widest text-gray-900 uppercase rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">Garry's Mod Indonesia</a> -->
                <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                    <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
                </div>
                <nav :class="{'block': open, 'hidden': !open}" class="flex-grow md:block px-4 pb-4 md:pb-0 md:overflow-y-auto">
                    <x-jet-nav-link class="block px-4 py-2 mt-2 text-sm font-semibold text-white bg-transparent rounded-lg hover:text-gray-900 focus:text-gray-900 hover:bg-gray-600 focus:bg-gray-500 focus:outline-none focus:shadow-outline" href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">Dashboard</x-jet-nav-link><br />
                    <x-jet-nav-link class="block px-4 py-2 mt-2 text-sm font-semibold text-white bg-transparent rounded-lg hover:text-gray-900 focus:text-gray-900 hover:bg-gray-600 focus:bg-gray-500 focus:outline-none focus:shadow-outline" href="{{ route('admin.galleries') }}" :active="request()->routeIs('admin.galleries')">Galleries</x-jet-nav-link><br />
                    <x-jet-nav-link class="block px-4 py-2 mt-2 text-sm font-semibold text-white bg-transparent rounded-lg hover:text-gray-900 focus:text-gray-900 hover:bg-gray-600 focus:bg-gray-500 focus:outline-none focus:shadow-outline" href="{{ route('admin.news') }}" :active="request()->routeIs('admin.news')">News</x-jet-nav-link><br />
                    <x-jet-nav-link class="block px-4 py-2 mt-2 text-sm font-semibold text-white bg-transparent rounded-lg hover:text-gray-900 focus:text-gray-900 hover:bg-gray-600 focus:bg-gray-500 focus:outline-none focus:shadow-outline" href="{{ route('admin.admins') }}" :active="request()->routeIs('admin.admins')">Admin & Staff</x-jet-nav-link><br />
                    <x-jet-nav-link class="block px-4 py-2 mt-2 text-sm font-semibold text-white bg-transparent rounded-lg hover:text-gray-900 focus:text-gray-900 hover:bg-gray-600 focus:bg-gray-500 focus:outline-none focus:shadow-outline" href="{{ route('admin.links') }}" :active="request()->routeIs('admin.links')">Links & IP</x-jet-nav-link><br />
                    <x-jet-nav-link class="block px-4 py-2 mt-2 text-sm font-semibold text-white bg-transparent rounded-lg hover:text-gray-900 focus:text-gray-900 hover:bg-gray-600 focus:bg-gray-500 focus:outline-none focus:shadow-outline" href="{{ route('admin.TTTRoles') }}" :active="request()->routeIs('admin.TTTRoles')">TTT V2 Roles</x-jet-nav-link><br />
                </nav>
            </div>
    </aside>