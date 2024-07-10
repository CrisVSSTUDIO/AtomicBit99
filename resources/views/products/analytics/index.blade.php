<x-app-layout>

        <x-header-section title=" Analytics" >

        </x-header-section>
        <div class=" mx-auto px-4">
            <div class="flex flex-wrap flex-col md:grid gap-4 grid-cols-2 ">
                <div >
                    <x-card title="Average of:">
                        <p><mark>{{ $averageProductsPerDay }}</mark>
                            {{ $averageProductsPerDay > 1 ? 'products' : 'product' }} created
                            per day</p>
                    </x-card>
                </div>
                <div >
                    <x-card title="Your most popular filetypes are:">
                        <ul>
                            @forelse($mostPopular as $popular)
                                <li>
                                    <span>{{ $popular }}</span>
                                </li>

                                @empty
                                    <span>No assets!</span>
                            @endforelse
                        </ul>
                    </x-card>
                </div>
                <div>
                    <x-card-generic>
                        <Scatter :clusterKeys="{{ $clusterKeys }}" :clusterValues="{{ $clusterValues }}">
                        </Scatter>
                    </x-card-generic>
                </div>
                <div >
                    <x-card-generic >
                        <LineChart :perYear="{{ $perYear }}" :yearCount="{{ $yearCount }}">
                        </LineChart>
                    </x-card-generic>
                </div>

            </div>

        </div>


</x-app-layout>
