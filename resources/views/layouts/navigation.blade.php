<nav x-data="{ open: false }" class="bg-green-800">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-12">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center text-white hover:text-red-800">
                    <a href="{{ route('menu') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-6 sm:flex">
                    <x-nav-link :href="route('menu')" :active="request()->routeIs('dashboard')">
                        休暇申請アプリ
                    </x-nav-link>
                </div>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <p class="text-sm text-white">
                        {{ Auth::user()->affiliation_name }}
                        &emsp;/&emsp;
                    </p>
                @endauth

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button 
                            class="flex items-center text-sm font-medium text-white transition duration-150 ease-in-out hover:text-red-800">
                            @auth
                                <div>{{ Auth::user()->employee }}&ensp;{{ Auth::user()->name }}</div>
                            @else
                                <div>ゲスト</div>
                            @endauth

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                            <form method="GET" action="{{ route('profile.edit') }}">
                                <x-dropdown-link :href="route('profile.edit')"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    {{ __('アカウント管理') }}
                                </x-dropdown-link>
                            </form>
                            <form method="GET" action="{{ route('explanations') }}">
                                <x-dropdown-link :href="route('explanations')"
                                    onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    {{ __('操作説明') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            {{-- <x-dropdown-link :href="route('register')">
                                {{ __('Sign Up') }}
                            </x-dropdown-link> --}}
                            <x-dropdown-link :href="route('login')">
                                {{ __('Log In') }}
                            </x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-red-800 focus:outline-none focus:text-red-800 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        {{-- <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div> --}}

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
                </div>
            @endauth

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>

            <div class="mt-1 space-y-1">
                <!-- Exsplanations -->
                <form method="GET" action="{{ route('explanations') }}">
                    <x-responsive-nav-link :href="route('explanations')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('操作説明') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
