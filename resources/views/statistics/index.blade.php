<x-app-layout>
    <!-- i CAN pass multiple vatiable and then in the component, place them in the layout
 -->

    <div class="p-4">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap -mx-4">

                <div class="w-full md:w-1/2 px-4">
                    <div class="p-4">
                        <x-card-generic title="Nº of virtual assets per year">

                            <LineChart :perYear="{{ $perYear }}"
                                :yearCount="{{ $yearCount }}"></LineChart>
                        </x-card-generic>
                    </div>
                </div>


                <div class="w-full md:w-1/2 px-4">
                    <div class="p-4">

                        <x-card-generic title="Average of">
                            <p><mark>{{ $averageProductsPerDay }}</mark>
                                {{ $averageProductsPerDay > 1 ? 'products' : 'product' }} created per day</p>

                        </x-card-generic>
                    </div>
                </div>

                <!--  -->
            </div>
        </div>
    </div>

</x-app-layout>
