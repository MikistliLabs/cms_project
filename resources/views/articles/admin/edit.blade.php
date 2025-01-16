@extends('layouts.app')

@section('title', 'Editar Artículo')

@section('content')
    <h1>Editar Artículo</h1>

    {{-- Mostrar mensajes de éxito o error --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Formulario de edición --}}
    <form action="{{ route('articles.update', $article->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $article->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenido</label>
            <textarea name="content" class="form-control" rows="4" required>{{ old('content', $article->content) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" name="image" class="form-control">
            @if($article->image)
                <img src="{{ asset('storage/' . $article->image) }}" alt="Imagen" class="mt-2" width="100">
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="status" class="form-control" required>
                <option value="1" {{ $article->status == 1 ? 'selected' : '' }}>No Publicado</option>
                <option value="2" {{ $article->status == 2 ? 'selected' : '' }}>Publicado</option>
            </select>
        </div>

        {{-- Campo de categoría --}}
        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $article->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Actualizar Artículo</button>
    </form>
@endsection
