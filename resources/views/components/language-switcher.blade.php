@php
    $item = \Illuminate\Support\Facades\Request::segment(count(\Illuminate\Support\Facades\Request::segments()));

@endphp



@foreach (config('app.available_locales') as $locale)
    @if (Route::is('assets.*'))
        <x-nav-link :href="route(Route::currentRouteName(), ['locale' => $locale, 'asset' => $item])" :active="app()->getLocale() == $locale">
            {{ strtoupper($locale) }}
        </x-nav-link>
    @else
        <x-nav-link :href="route(Route::currentRouteName(), ['locale' => $locale])" :active="app()->getLocale() == $locale">
            {{ strtoupper($locale) }}
        </x-nav-link>
    @endif
@endforeach
