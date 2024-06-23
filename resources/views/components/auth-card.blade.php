<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">


    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <div class="pb-8">
            @isset($logo)
            {{ $logo }}
            @else
            <Link href="/">
            <x-application-logo class="mx-auto  fill-current text-gray-500" />
            </Link>
            @endisset
        </div>
        

        {{ $slot }}

    </div>
</div>