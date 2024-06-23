@extends('layouts.app')
@section('content')
<section class="tags">

    <div class="container">
        <x-breadcrumb currentURL="{{ request()->route()->uri }}" />
        <x-pricing view="tags.create" />

        <div class="container py-4">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-8 col-xl-6 shadow rounded ">
                    <h2 class="fw-bold p-3 text-primary text-center">Criar Tag</h2>
                    <form method="POST" action="{{ route('tags.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group p-3">
                            <label for="name">Nome da tag</label>
                            <input type="text" class="form-control" id="tag_name" name="tag_name">
                        </div>

                        <div class="form-group text-center p-3">
                            <button type="submit" name="submit" class="btn btn-primary">Criar Tag</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection