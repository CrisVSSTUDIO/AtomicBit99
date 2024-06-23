<x-app-layout>

    <x-splade-modal>
        <x-splade-form action="{{ route('assets.share', $asset) }}" method="POST" enctype="multipart/form-data">

            <x-font-h1 title="Share file" />
            @csrf
            @method('post')
            <x-splade-select name="users" :options="$users" option-label="name" option-value="id" multiple />
            <x-splade-submit class="mt-3" :label="__('Share')" />
        </x-splade-form>
    </x-splade-modal>

</x-app-layout>
