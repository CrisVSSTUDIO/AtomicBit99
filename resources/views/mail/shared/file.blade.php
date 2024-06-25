<x-mail::message>
    # Introduction

    The user {{ $user }},
    Has shared with the file, {{ $assetName }}
    <x-mail::button :url="'http://127.0.0.1:8000/pt/asset-manager/assets/shared-assets/'">
        Check file
    </x-mail::button>

    Thanks,
    {{ config('app.name') }}
</x-mail::message>
