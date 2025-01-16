@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('content')
    <div class="container">
        <h1 class="mb-4">Panel de Administración</h1>

        <!-- Mensajes de éxito -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Navegación -->
        <ul class="nav nav-tabs mb-3" id="adminTabs">
            <li class="nav-item">
                <a class="nav-link {{ request('tab') == 'users' || !request('tab') ? 'active' : '' }}" data-bs-toggle="tab" href="#users">Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('tab') == 'categories' ? 'active' : '' }}" data-bs-toggle="tab" href="#categories">Categorías</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('tab') == 'articles' ? 'active' : '' }}" data-bs-toggle="tab" href="#articles">Artículos</a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Usuarios -->
            <div class="tab-pane fade {{ request('tab') == 'users' || !request('tab') ? 'show active' : '' }}" id="users">
                <h2>Usuarios</h2>
                <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Agregar Usuario</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Paginación Usuarios -->
                <div class="pagination-container">
                    {{ $users->appends(['tab' => 'users'])->links() }}
                </div>
            </div>

            <!-- Categorías -->
            <div class="tab-pane fade {{ request('tab') == 'categories' ? 'show active' : '' }}" id="categories">
                <h2>Categorías</h2>
                <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Agregar Categoría</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    <a href="{{ route('categorias.edit', $category->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('categorias.destroy', $category->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Paginación Categorías -->
                <div class="pagination-container">
                    {{ $categories->appends(['tab' => 'categories'])->links() }}
                </div>
            </div>

            <!-- Artículos -->
            <div class="tab-pane fade {{ request('tab') == 'articles' ? 'show active' : '' }}" id="articles">
                <h2>Artículos</h2>
                <a href="{{ route('articles.create') }}" class="btn btn-primary mb-3">Agregar Artículo</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Imagen</th>
                            <th>Estado</th>
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
                                <td>{{ $article->status === 2 ? 'Publicado' : 'No publicado' }}</td>
                                <td>
                                    <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <form action="{{ route('articles.destroy', $article->id) }}" method="POST" class="delete-form d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Paginación Artículos -->
                <div class="pagination-container">
                    {{ $articles->appends(['tab' => 'articles'])->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .pagination-container {
    display: flex !important;
    justify-content: center !important;
    margin-top: 20px !important;
    flex-wrap: nowrap !important; /* Evita que los elementos salten de línea */
}

.pagination {
    display: flex !important;
    gap: 5px !important;
    align-items: center !important;
    justify-content: center !important;
}

.pagination .page-item {
    display: flex !important;
    align-items: center !important;
}

.pagination .page-item .page-link {
    font-size: 14px !important;
    padding: 6px 12px !important;
    min-width: 40px !important;
    text-align: center !important;
    border-radius: 4px !important;
    border: 1px solid #ddd !important;
    transition: all 0.3s ease !important;
}

.pagination .page-item .page-link:hover {
    background-color: #f8f9fa !important;
}

.pagination .page-item.active .page-link {
    background-color: #007bff !important;
    border-color: #007bff !important;
    color: white !important;
}

.pagination .page-item.disabled .page-link {
    color: #ccc !important;
    pointer-events: none !important;
    background-color: #f8f9fa !important;
}
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let params = new URLSearchParams(window.location.search);
        let activeTab = params.get("tab") || 'users';

        // Activa la pestaña correcta según el parámetro 'tab' en la URL
        let tabElement = document.querySelector(`a[href="#${activeTab}"]`);
        if (tabElement) {
            new bootstrap.Tab(tabElement).show();
        }

        // Al hacer clic en una pestaña, actualizamos la URL sin recargar la página
        document.querySelectorAll('.nav-link').forEach(tab => {
            tab.addEventListener('click', function(event) {
                event.preventDefault();
                let newTab = this.getAttribute('href').substring(1);
                let newUrl = new URL(window.location);
                newUrl.searchParams.set('tab', newTab);
                history.replaceState(null, null, newUrl);
                new bootstrap.Tab(this).show();
            });
        });

        // Ajustar los enlaces de paginación para mantener la pestaña activa
        document.querySelectorAll('.pagination a').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                let url = new URL(this.href);
                url.searchParams.set('tab', activeTab);
                window.location.href = url.toString();
            });
        });
    });
</script>
@endsection
