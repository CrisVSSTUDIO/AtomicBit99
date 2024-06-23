<x-app-layout>

    <x-splade-modal>
        <x-splade-form :default="$asset" action="{{ route('assets.update', $asset) }}" method="PUT"
            enctype="multipart/form-data">
            @csrf
            @method('put')
            <x-font-h1 title="Edit the {{ $asset->name }}" />
            <x-splade-input name="name" :label="__('Asset name')" value="{{ $asset->name }}" />
            <x-splade-textarea name="description" :label="__('Asset description')"
                value="{{ $asset->description }}">{{ $asset->description }}</x-splade-textarea>
            <x-splade-file name="upload" :label="__('File upload')" />
            <x-splade-submit class="mt-3" :label="__('Update asset')" />
        </x-splade-form>
    </x-splade-modal>

</x-app-layout>
