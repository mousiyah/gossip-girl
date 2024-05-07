<nav x-data="{ open: false }" class="bg-white z-40 dark:bg-gray-800 h-screen w-max sticky top-0 left-0 overflow-y-auto">
    <!-- Primary Navigation Menu -->
    <div class="px-8 py-8">
        <div class=" justify-between h-16">
            <div class="">
                <!-- Logo -->
                <div class="items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="space-y-2 mt-4">
                @auth

                    @can('manage-users')
                        <div>
                            <x-nav-link :href="route('users')"  :active="request()->routeIs('users')">
                                {{ __('Users') }}
                            </x-nav-link>
                        </div>
                    @endcan

                    <div>
                        <x-nav-link :href="route('userProfile', Auth::user()->name)" :active="request()->route('username') === Auth::user()->name">
                            {{ __('Profile') }}
                        </x-nav-link>
                    </div>

                    <div>
                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                            {{ __('Settings') }}
                        </x-nav-link>
                    </div>

                    <div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log out') }}
                            </x-nav-link>
                        </form>
                    </div>
                @endauth

                
                @guest
                <div>
                    <x-nav-link :href="route('login')" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        {{ __('Log in') }}
                    </x-nav-link>
                </div>
                <div>
                    <x-nav-link :href="route('register')" class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        {{ __('Register') }}
                    </x-nav-link>
                </div>
                @endguest
                    

                </div>
            </div>

        
        </div>
    </div>

</nav>
