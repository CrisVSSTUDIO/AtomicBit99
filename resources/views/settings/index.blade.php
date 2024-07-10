<x-app-layout>
    <x-splade-modal>
              <x-splade-form confirm require-password submit-on-change="use_prediction"
            action="{{ route('change-prediction-settings') }}" method="post">
            @csrf
            <x-splade-group name="use_prediction" label="Enable/Disable Machine Learning file classification ">
                <x-splade-radio name="use_prediction" value="1"
                    label="Enable. It will use the NaiveBayes classifier" />
                <x-splade-radio name="use_prediction" value="0"
                    label="Disable. It will use the standard MIME type file detection" />
            </x-splade-group> </x-splade-form>
    </x-splade-modal>
</x-app-layout>
