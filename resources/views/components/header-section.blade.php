@props(['title', 'description' => null])
<div class="max-w-screen mt-4 mx-auto  bg-sky-100 px-4 md:px-8">
    <div class="justify-between  items-center py-4 border-b md:flex">
        <div>
            <h3 class="text-gray-800 text-2xl font-bold break-words">
                {{ $title }} </h3>
        </div>
        <div class="flex items-start sm:items-center flex-wrap flex-col sm:flex-row space-y-4 sm:space-x-4 sm:space-y-0 mt-6 md:mt-0 ">
            {{ $slot }}

        </div>
    </div>
</div>
