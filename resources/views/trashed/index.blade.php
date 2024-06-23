<x-app-layout>
    <x-assest-side-bar-layout>

        <section class="assets trashed">
            <x-header-section title="Trashed assets" >
              
            </x-header-section>
            <div class="mx-auto px-4 mt-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap -mx-4">
                    <div class="w-full px-4">
                    <!-- Your content here -->
                    <x-slot name="header">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                            {{ __('Trashed Assets') }}
                        </h2>
                    </x-slot>
                    <x-splade-flash>
                        <p v-if="flash.has('message')" v-text="flash.message" />
                    </x-splade-flash>
                 
                    <x-splade-table :for="$trashed">
                        <x-splade-cell actions>
                            <Link href="{{ route('restore-asset', $item->id) }}" method="POST" confirm class="px-4 py-1 bg-indigo-100 border border-indigo-400 rounded-md text-indigo-600 hover:bg-indigo-200 mr-4"> Restore </Link>

                         
                            <Link href="{{ route('delete-asset', $item) }}" method="DELETE" confirm class="px-4 py-1 bg-red-100 border border-red-400 rounded-md text-red-600 hover:bg-red-200"> Delete </Link>
                        </x-splade-cell>

                    </x-splade-table>
                </div>
            </div>
        </div>
    </section>
    </x-assest-side-bar-layout>
</x-app-layout>