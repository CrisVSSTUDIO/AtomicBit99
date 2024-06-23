<x-app-layout>

    <section class="categories">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full px-4">
                    <!-- Your content here -->
                    <x-slot name="header">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Categories') }}
                        </h2>
                    </x-slot>
                    <x-splade-flash>
                        <p v-if="flash.has('message')" v-text="flash.message" />
                    </x-splade-flash>
                    <div>
                        <div class="m-2">
                            <div class="p-2">
                                <Link modal href="{{ route('categories.create') }}" class="px-4 py-1 bg-green-500  rounded-md text-white hover:bg-gray-200">New Category</Link>
                            </div>
                        </div>
                    </div>
                    <x-splade-table :for="$categories">
                        <x-splade-cell actions>
                            <Link modal href="{{ route('categories.edit', $item) }}" class="px-4 py-1 bg-indigo-100 border border-indigo-400 rounded-md text-indigo-600 hover:bg-indigo-200 mr-4"> Edit </Link>
                            <Link href="{{ route('categories.destroy', $item) }}" method="DELETE" class="px-4 py-1 bg-red-100 border border-red-400 rounded-md text-red-600 hover:bg-red-200" confirm> Delete </Link>
                        </x-splade-cell>
                    </x-splade-table>
                </div>
            </div>
        </div>
    </section>
   

</x-app-layout>