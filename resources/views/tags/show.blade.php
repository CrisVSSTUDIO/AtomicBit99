@extends('layouts.app')
@section('content')

<section class="category">
    <x-pricing view="tags.show" />

    <div class="container">
        <x-breadcrumb currentURL="{{ request()->route()->uri }}" />

        <x-alert-success />

        <x-alert-error />
        <div class="row justify-content-center">
            <div class="col-6">
                <!-- Modal editar -->
                <div class="modal fade" id="modal_editar{{ $tag->id }}" tabindex="-1" aria-labelledby="{{ $tag->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Editar: <b>{{ $tag->tag_name ?? 'Sem informação' }}</b></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="POST" action="{{ route('tags.update', $tag) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group p-2">
                                        <label for="name">Nome</label>
                                        <input type="text" class="form-control" value="{{ $tag->tag_name ?? 'Sem informação' }}" id="tag_name" name="tag_name">
                                    </div>

                                    <div class="form-group p-2 text-center">
                                        <button type="submit" class="btn btn-primary ">Atualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal remover -->
                <div class="modal fade" id="modal_remover{{$tag->id }}" tabindex="-1" aria-labelledby="{{ $tag->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Remover: {{ $tag->tag_name ?? 'Sem informação' }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h5>Deseja mesmo <b class="text-danger">remover</b> <u>
                                        {{ $tag->tag_name ?? 'Sem informação' }}?</u> </h5>
                                <form method="POST" action="{{ route('tags.destroy', $tag) }}">
                                    @csrf
                                    @method('DELETE')
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary " data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger" value="Submit" name="submit">Remover</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <x-card title="{{ $tag->tag_name?? 'Sem nome' }}">

                    <h3>{{ $tag->tag_name?? 'Sem nome' }}</h3>

                    <div class="card-footer">

                        <button class="btn btn-primary rounded-pill px-3 mt-4 " type="button" data-bs-toggle="collapse" data-bs-target="#f{{ $tag->id }}" aria-expanded="false" aria-controls="collapseExample">
                            Expandir ações <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <div class="collapse" id="f{{ $tag->id }}">

                            <button type="button" class="btn btn-primary  rounded-pill px-3  mt-2" data-bs-toggle="modal" data-bs-target="#modal_editar{{ $tag->id }}" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                                Editar
                            </button>
                            <button type="button" class="btn btn-danger  rounded-pill px-3  mt-2" data-bs-toggle="modal" data-bs-target="#modal_remover{{ $tag->id }}" title="Remover">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                </svg>
                                Remover
                            </button>


                        </div>
                    </div>
                </x-card>
            </div>
        </div>
    </div>


</section>
@endsection