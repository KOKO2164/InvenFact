@extends('adminlte::page')

@section('title', 'Crear Nuevo Rol')

@section('content_header')
    <h1>Crear Nuevo Rol</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Nuevo Rol</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre del Rol</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Permisos</label>
                    <div class="row">
                        @foreach($groupedPermissions as $module => $permissions)
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h3 class="card-title">{{ ucfirst($module) }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            @foreach($permissions as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input" id="permission_{{ $permission->id }}">
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Crear Rol</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // Select/Deselect all checkboxes per module
            $('.select-all').click(function() {
                var checked = $(this).prop('checked');
                var moduleCard = $(this).closest('.card');
                moduleCard.find('input[type="checkbox"]').prop('checked', checked);
            });
        });
    </script>
@stop