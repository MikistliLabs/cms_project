@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
    <h1>Editar un usuario</h1>

    <form action="{{ route('users.update', $usr->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $usr->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $usr->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="role_id" class="form-control @error('role_id') is-invalid @enderror" required>
                <option value="" disabled {{ old('role_id') ? '' : 'selected' }}>Selecciona un rol</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}" {{ old('role_id', $usr->role_id) == $rol->id ? 'selected' : '' }}>
                        {{ $rol->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-100 w-sm-auto">Editar Usuario</button>
    </form>
@endsection

