

<x-splade-toggle>

    <nav class="bg-white  md:text-sm border dark:bg-gray-900">
        <div class="gap-x-14 items-center max-w-screen-xl mx-auto px-4 md:flex md:px-8">
            <div class="flex items-center justify-between py-5 md:block"><a href="/" rel="nofollow"> <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
                <div class="md:hidden">
                    <button class="menu-btn text-gray-500 hover:text-gray-800"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                        </svg></button>
                </div>
            </div>
            <div class="flex-1 items-center mt-8 md:mt-0 md:flex hidden ">
                <ul class="justify-center items-center space-y-6 md:flex md:space-x-6 md:space-y-0">
                    <li class="text-gray-700 hover:text-gray-900"><a href="javascript:void(0)" class="block" rel="nofollow">Help</a></li>
                    <li class="text-gray-700 hover:text-gray-900"><a href="route({{'contact-us'}})" class="block" rel="nofollow">About us</a></li>
                    <li class="text-gray-700 hover:text-gray-900"><a href="javascript:void(0)" class="block" rel="nofollow">Contact us</a></li>
                </ul>
    
                @if (Route::has('login'))
    
                <div class="flex-1 gap-x-6 items-center justify-end mt-6 space-y-6 md:flex md:space-y-0 md:mt-0">
                    @auth
                    <a href="{{ route('assets.index') }}" class="block text-gray-700 hover:text-gray-900" rel="nofollow">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="block text-gray-700 hover:text-gray-900" rel="nofollow">Log in</a>
                    @if (Route::has('register'))
    
                    <a href="{{ route('register') }}" class="flex items-center justify-center gap-x-1 py-2 px-4 text-white font-medium bg-gray-800 hover:bg-gray-700 active:bg-gray-900 rounded-full md:inline-flex" rel="nofollow">Sign in<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    @endif
    
                    @endauth
    
                </div>
                @endif
    
            </div>
        </div>
    </nav>
    </x-splade-toggle>