
<footer class="pt-10 z-10 sticky">
    <div class="w-screen mx-auto px-4 bg-white text-gray-600 p-8 md:px-8">
        <div class=" sm:flex">
            <div class="space-y-6">                <x-application-logo class="block h-16 w-auto" />

                <p class="max-w-md">A Machine Learning file vault built with Laravel!</p>

            </div>

        </div>
        <div class="mt-10 py-10 border-t md:text-center">
            <p>@<?php echo date('Y'); ?>-{{ config('app.name', 'Laravel') }}. All rights reserved.</p>
        </div>
    </div>
</footer>
