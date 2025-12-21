<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <a href="{{ route('welcome') }}" class="flex items-center">
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ __('layouts.navigation.home') }}</span>
            </a>
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('task_status.index')" :active="request()->routeIs('task_status.index')">
                        {{ __('layouts.navigation.task_status') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.index')">
                        {{ __('layouts.navigation.task') }}
                    </x-nav-link>
                    <x-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.index')">
                        {{ __('layouts.navigation.label') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="sm:flex sm:items-center sm:ms-6">
                
                @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('layouts.navigation.buttons.logout') }}
                    </a>
                </form>
                @endauth
                @guest
                    <a href="{{ route('login') }}">{{ __('layouts.navigation.buttons.login') }}</a>
                    <a href="{{ route('register') }}">{{ __('layouts.navigation.buttons.register') }}</a>
                @endguest
            </div>
        </div>
    </div>
</nav>
