@extends('layouts.app')

@section('title', 'Lista de categorías')

@section('content')
    <h1 class="mb-4">Lista de categorías</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Botón para agregar nuevo categoría -->
    <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Agregar Categoría</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->name }}</td>

                        <td>
                            <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-sm btn-warning">Editar</a>

                            <!-- Formulario para eliminar artículo -->
                            <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDeletion();">
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

    {{ $categorias->links() }}
@endsection

@section('scripts')
    <script>
        // Función de confirmación para la eliminación
        function confirmDeletion() {
            return confirm("¿Estás seguro de que quieres eliminar este artículo?");
        }
    </script>
@endsection
