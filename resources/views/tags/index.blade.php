@extends('layouts.app')
@section('content')


@if (isset($tags))
<section class="tags">
<x-pricing view="tags.index" />

    <div class="container">
        <x-breadcrumb currentURL="{{ request()->route()->uri }}" />
        <x-alert-success />
        <x-alert-error />
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-2">
            @forelse ($tags as $tag)
            <div class="col">
                <x-card title="{{ $tag->tag_name ?? 'Sem nome' }}">

                    <h3>{{ $tag->tag_name ?? 'Sem nome' }}</h3>

                    <div class="card-footer">

                    <a class="btn btn-primary  rounded-pill px-3  mt-2" href="{{route('tags.show',$tag->id)}}" role="button">Visualizar {{ $tag->tag_name ?? '-' }}</a>
                    </div>
                </x-card>
            </div>
            @empty
            <x-nodata />
            @endforelse
        </div>
        <div class="container d-flex justify-content-center">{{ $tags->links() }}</div>

    </div>
</section>
@elseif (isset($tagsearch))
<section class="tags-search">

    <div class="alert " role="alert" id="alert_info">
        <b> Temos <u class="text-info"><?php echo htmlspecialchars($rowcount ?? ''); ?></u>
            {{ $rowcount > 1 ? 'categorias' : 'categoria' }}</b>
    </div>
    <div class="main-container " id="main-container">

        @forelse ($tagsearch as $tag)
        <div class="card-body-mine shadow p-3 mb-5 bg-body rounded slide-in">

            <hr>
            <div class="card-body-info">

                <h3 class="card-title mt-2">{{ $tag->tag_name ?? 'Sem informação' }}</h3>
                <span class="card-description mt-2">{{ $tag->tag_description ?? 'Sem informação' }}</span>

                <div class="button-area">
                    <a class="btn btn-primary  rounded-pill px-3  mt-2" href="{{ route('tags.show', $tag) }}" role="button">Visualizar
                        {{ $tag->tag_name ?? 'Asset' }}</a>
                </div>
            </div>
        </div>
        @empty

        <x-nodata />
        @endforelse

</section>
@endif
@endsection