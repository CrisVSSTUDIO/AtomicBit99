<x-app-layout>

    <x-header-section title="{{__('Tensorflow.js image classification (Machine Learning) ')}}">
      
            <span class="text-gray-600 ">{{__('Click on the images to classify them!')}}</span>

    </x-header-section>
    <MLTest :imgFiles="@js($imgFiles)">
      
    </MLTest>
</x-app-layout>
