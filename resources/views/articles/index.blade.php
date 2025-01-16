@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Lista de Artículos</h1>

    {{-- Filtros --}}
    <form method="GET" action="{{ route('public.articles.index') }}" class="mb-4">
        <div class="row">
            {{-- Búsqueda por título --}}
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Buscar por título" value="{{ request('search') }}">
            </div>

            {{-- Filtrar por categoría --}}
            <div class="col-md-4">
                <select name="category" class="form-control">
                    <option value="">Todas las categorías</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botón de búsqueda --}}
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    {{-- Lista de artículos --}}
    <div class="row">
        @foreach($articles as $article)
            <div class="col-md-4 mb-4">
                <div class="card">
                    {{-- Imagen del artículo --}}
                    @if($article->image)
                        <img src="{{ asset('storage/' . $article->image) }}" class="card-img-top" alt="Imagen del artículo">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $article->title }}</h5>
                        <p class="card-text">{{ Str::limit($article->content, 100) }}</p>

                        {{-- Mostrar categoría --}}
                        <p><strong>Categoría:</strong> {{ $article->category->name ?? 'Sin categoría' }}</p>

                        {{-- Botón para ver detalles --}}
                        <a href="{{ route('articles.show', $article->id) }}" class="btn btn-secondary">Ver más</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Paginación --}}
    <div class="d-flex justify-content-center">
        {{ $articles->appends(request()->query())->links() }}
    </div>
</div>
@endsection
