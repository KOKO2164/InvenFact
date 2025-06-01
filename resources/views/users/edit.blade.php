@extends('adminlte::page')
@section('title', 'Editar Trabajador')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Editar Trabajador</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-reply"></i> Volver
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $item->id) }}" method="POST" id="trabajadorUpdateForm">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni"
                        class="form-control @error('dni') is-invalid @enderror" placeholder="Ingrese el DNI del trabajador"
                        value="{{ old('dni', $item->dni) }}">
                    @error('dni')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="name" id="nombre"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Ingrese el nombre del trabajador" value="{{ old('name', $item->name) }}">
                    @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Ingrese el correo del trabajador" value="{{ $item->email }}">
                    @error('email')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                        class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                        value="{{ $item->fecha_nacimiento }}"
                        max="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}"
                        min="{{ \Carbon\Carbon::now()->subYears(65)->format('Y-m-d') }}">
                    @error('fecha_nacimiento')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="roles">Rol</label>
                    <select name="roles[]" id="roles" class="form-control @error('roles') is-invalid @enderror">
                        <option value="">Seleccione un rol</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $item->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('roles')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="trabajadorUpdateForm">Editar Trabajador</button>
        </div>
    </div>
@stop
