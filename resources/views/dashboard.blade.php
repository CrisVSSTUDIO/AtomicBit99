<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-500 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

        <x-header-section title="Quick stats" >
          
        </x-header-section>
        <div class="p-4">
            <div class="container mx-auto px-4">
                <div class="grid gap-4 grid-cols-2">
                    <div>
                        <x-card-generic>
                        </x-card-generic>
                    </div>

                    <div>

                        <x-card-generic title="Nº of virtual assets per year">
                        </x-card-generic>

                    </div>
                    <div>


                        <x-card-generic title="Nº of virtual assets per year">
                        </x-card-generic>

                    </div>
                    <div>

                        <x-card-generic title="Nº of virtual assets per year">
                       </x-card-generic>
                    </div>
                    <!--  -->
                </div>
            </div>
        </div>


</x-app-layout>
