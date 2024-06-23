<x-splade-modal>
    <x-splade-form :default="$category" action="{{ route('categories.update', $category) }}" method="PUT" confirm>
        @csrf

        <x-splade-input name="category_name" :label="__('Category name')" />
        <x-splade-input name="category_description" :label="__('Category description')" />
        <x-splade-submit class="mt-3" :label="__('Submit')" />
    </x-splade-form>
</x-splade-modal>