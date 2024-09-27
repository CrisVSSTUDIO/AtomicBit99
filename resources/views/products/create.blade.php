<x-app-layout>
    <x-splade-modal>
        <x-splade-form>
            @csrf
            <x-font-h1 title="Submit files" />
            {{-- <x-splade-input name="name" :label="__('Asset name')" />
            <x-splade-textarea name="description" :label="__('Asset description')" /> --}}
            <x-splade-file name="upload[]" :label="__('File upload')" multiple filepond />
            <x-splade-submit class="mt-3" :label="__('Submit')" />
        </x-splade-form>
    </x-splade-modal>
</x-app-layout>