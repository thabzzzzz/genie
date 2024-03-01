<x-splade-toggle>
    <nav class="bg-maintheme border-b border-solid border-black">
        <!-- Primary Navigation Menu -->
        <div class="w-full mx-5">
            <div class="flex justify-between h-24">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex items-center home-navgroup">
                        <Link href="{{ route('home') }}" class="flex items-center">
                            <img src="{{ asset('gallery/logo.png') }}" alt="Your Custom Logo" class="block h-24 w-auto">
                            <h1 class="mr-4 text-4xl">genie</h1>
                        </Link>
                    </div>
                    
                    

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="heading1 navlink text-orange-500 text-4xl">
                            {{ __('home') }}
                        </x-nav-link>
                        <x-nav-link :href="route('browse')" :active="request()->routeIs('browse')" class="heading1 text-5xl">
                            {{ __('browse') }}
                        </x-nav-link>
                        <x-nav-link :href="route('create')" :active="request()->routeIs('create')" class="heading1 text-5xl">
                            {{ __('create') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center ml-14 mr-14   ">
                    <x-dropdown placement="bottom-end" >
                        <x-slot name="trigger">
                            <button class="flex items-center text-base profile-name ">
                                <div class="home-link text-3xl">{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="bg-maintheme shadow rounded-md overflow-hidden">
                              <x-dropdown-link :href="route('profile.edit')" class="drop-text mt-0 pt-0 heading1">
                                {{ __('Profile') }}
                              </x-dropdown-link>
              
                              <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <x-dropdown-link class="heading1" as="a" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                  {{ __('Log Out') }}
                                </x-dropdown-link>
                              </form>
                            </div>
                          </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="mr-14 flex items-center sm:hidden ">
                    <button @click="toggle" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path v-bind:class="{ hidden: toggled, 'inline-flex': !toggled }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path v-bind:class="{ hidden: !toggled, 'inline-flex': toggled }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div v-bind:class="{ block: toggled, hidden: !toggled }" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link as="a" :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</x-splade-toggle>
