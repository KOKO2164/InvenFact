@extends('adminlte::page')
@section('title', 'Registrar Trabajador')
@section('content_header')
    <div class="row">
        <div class="col">
            <h1>Registrar Trabajador</h1>
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
            <form action="{{ route('trabajadores.store') }}" method="POST" id="trabajadorStoreForm">
                @csrf
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni"
                        class="form-control @error('dni') is-invalid @enderror"
                        placeholder="Ingrese el DNI del trabajador" value="{{ old('dni') }}" minlength="8" maxlength="8">
                    @error('dni')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                        class="form-control @error('nombre') is-invalid @enderror"
                        placeholder="Ingrese el nombre del trabajador" value="{{ old('nombre') }}">
                    @error('nombre')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Ingrese el correo del trabajador" value="{{ old('email') }}">
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
                        value="{{ old('fecha_nacimiento') }}" max="{{ \Carbon\Carbon::now()->subYears(18)->format('Y-m-d') }}"
                        min="{{ \Carbon\Carbon::now()->subYears(65)->format('Y-m-d') }}">
                    @error('fecha_nacimiento')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Ingrese la contraseña del trabajador" minlength="8">
                    @error('password')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                    @enderror
                </div>
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="trabajadorStoreForm">Registrar Trabajador</button>
        </div>
    </div>
@stop
