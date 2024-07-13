<x-splade-data default="{ open: false }">
    <nav class=" shadow-xl  relative z-10 bg-white dark:bg-gray-900">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="/">
                            <x-application-logo class="block h-9 w-auto" />
                        </a>
                    </div>




                </div>


                @if (Route::has('login'))

                    <div
                        class="flex-1 gap-x-6 hidden items-center justify-end mt-6 space-y-6 md:flex md:space-y-0 md:mt-0">
                        @auth
                            <a href="{{ route('assets.index') }}" class="block text-gray-700 hover:text-gray-900"
                                rel="nofollow">My files</a>
                        @else
                            <a href="{{ route('login') }}" class="block text-gray-700 hover:text-gray-900"
                                rel="nofollow">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="flex items-center justify-center gap-x-1 py-2 px-4 text-white font-medium bg-gray-800 hover:bg-gray-700 active:bg-gray-900 rounded-full md:inline-flex"
                                    rel="nofollow">Sign in<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd"
                                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @endif

                        @endauth

                    </div>
                @endif
                <div class="p-4"> <x-language-switcher />
                </div>

                <!-- Hamburger -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="data.open = ! data.open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path v-bind:class="{'hidden': data.open, 'inline-flex': ! data.open }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path v-bind:class="{'hidden': ! data.open, 'inline-flex': data.open }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div v-bind:class="{'block': data.open, 'hidden': ! data.open }" class="sm:hidden">
            <div class="pt-2 pb-3 space-y-1">

                <div class="flex items-end">

                    @if (Route::has('login'))

                        @auth
                            <x-responsive-nav-link href="{{ route('assets.index') }}">My files</x-responsive-nav-link>
                        @else
                            <x-responsive-nav-link href="{{ route('login') }}">Log in </x-responsive-nav-link>

                            @if (Route::has('register'))
                                <x-responsive-nav-link href="{{ route('register') }}">Register</x-responsive-nav-link>
                            @endif
                        @endauth
                    @endif
                </div>

            </div>
        </div>
    </nav>
</x-splade-data>