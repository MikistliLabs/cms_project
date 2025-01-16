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
    <form action="{{ route('categorias.update', $category   ->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
        <button type="submit" class="btn btn-warning">Actualizar Categoría</button>
    </form>
@endsection
