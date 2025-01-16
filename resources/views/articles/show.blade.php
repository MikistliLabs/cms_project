@extends('layouts.app')
@section('content')
    <div class="container">
        <h1 class="mb-4">Artículos</h1>
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="{{ $article->title }}">
                        <div class="card-body">
                            <h5 class="card-title"><a href="{{ route('articles.show', $article->id) }}">{{ $article->title }}</a></h5>
                            <p class="card-text">{{ Str::limit($article->content, 100) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $articles->links() }}
    </div>
@endsection
