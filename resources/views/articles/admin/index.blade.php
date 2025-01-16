@extends('layouts.app')

@section('title', 'Lista de Artículos')

@section('content')
    <h1 class="mb-4">Lista de Artículos</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botón para agregar nuevo artículo -->
    <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Agregar Artículo</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->title }}</td>
                        <td>
                            @if($article->image)
                                <img src="{{ asset('storage/' . $article->image) }}" alt="Imagen" width="100">
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td>
                            @if ($article->status === 3)
                                {{ $article->publish }}
                            @else
                                {{ 'No publicado' }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-warning">Editar</a>

                            <!-- Formulario para eliminar artículo -->
                            <form action="{{ route('articles.destroy', $article->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDeletion();">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $articles->links() }}
@endsection

@section('scripts')
    <script>
        // Función de confirmación para la eliminación
        function confirmDeletion() {
            return confirm("¿Estás seguro de que quieres eliminar este artículo?");
        }
    </script>
@endsection
