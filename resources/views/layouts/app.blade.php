<div class="min-h-screen bg-zinc-50">
    @include('layouts.navigation')

    @hasSection('header')
        <header class="bg-white shadow z-50">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('header')
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        <div id="app"
           class="max-w-screen  mx-auto a z-10">
            {{ $slot }}
        </div>
    </main>
</div>
