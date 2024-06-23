@props(['title', 'tags' => null])
<div class="bg-white shadow-lg rounded-lg m-4  overflow-hidden text-center">
    <div class="px-6 py-4 bg-sky-100 ">
        <span class="text-2xl  font-semibold">{{ $title }}</span>
    </div>
    <div class="p-6 flex justify-center flex-col">
        {{ $slot }}
    </div>
</div>
