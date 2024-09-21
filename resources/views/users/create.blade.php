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
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ingrese el nombre del trabajador">
                </div>
                @error('nombre')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Ingrese el correo del trabajador">
                </div>
                @error('email')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese la contraseña del trabajador">
                </div>
                @error('password')
                    <div class="alert alert-danger">
                        <strong>{{ $message }}</strong>
                    </div>
                @enderror
            </form>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" form="trabajadorStoreForm">Registrar Trabajador</button>
        </div>
    </div>
@stop
