@extends('adminlte::page')
@section('title', 'Editar Trabajador')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Editar Trabajador</h1>
        </div>
        <div class="col d-flex justify-content-end">
            <a href="{{ route('trabajadores.index') }}" class="btn btn-secondary">
                <i class="fas fa-reply"></i> Volver
            </a>
        </div>
    </div>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('trabajadores.update', $trabajador->id) }}" method="POST" id="trabajadorUpdateForm">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" class="form-control" placeholder="Ingrese el DNI del trabajador"
                        value="{{ $trabajador->dni }}">
                    @error('dni')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control"
                        placeholder="Ingrese el nombre del trabajador" value="{{ $trabajador->name }}">
                    @error('nombre')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" name="email" id="email" class="form-control"
                        placeholder="Ingrese el correo del trabajador" value="{{ $trabajador->email }}">
                    @error('email')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control"
                        value="{{ $trabajador->fecha_nacimiento }}" max="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}"
                        min="{{ \Carbon\Carbon::now()->subYears(65)->format('Y-m-d') }}">
                    @error('fecha_nacimiento')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese la contraseña del trabajador">
                </div>
                @error('password')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror --}}
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="trabajadorUpdateForm">Editar Trabajador</button>
        </div>
    </div>
@stop
