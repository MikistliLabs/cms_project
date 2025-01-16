@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4">Artículos</h1>
        <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $articles->image) }}" class="card-img-top" alt="{{ $articles->title }}">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route('articles.show', $articles->id) }}">{{ $articles->title }}</a></h5>
                            <p class="card-text">{{ Str::limit($articles->content, 100) }}</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
