<x-app-layout>
    <x-app-layout>

        <x-splade-modal>
            <h1>Category</h1>
            <x-splade-form>
                @csrf
                <x-splade-input name="category_name" placeholder="category_name" :label="__('category_name')" />
                <x-splade-input name="category_description" placeholder="type here" :label="__('category_description')" />
                <x-splade-submit class="mt-3" :label="__('Add Category')" />
            </x-splade-form>
        </x-splade-modal>
    </x-app-layout>
</x-app-layout>
