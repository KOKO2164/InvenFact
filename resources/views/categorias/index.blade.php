@extends('adminlte::page')

@section('title', 'Gestión de Categorias')

@section('content_header')
    <div class="col d-flex justify-content-start">
        <h1 class="mr-2">Lista de Categorias</h1>
        <a href="{{ route('categorias.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Categoria
        </a>
    </div>
@stop

@section('content')
    @if (isset($mensaje))
        <div class="alert {{ $categorias->isEmpty() ? 'alert-danger' : 'alert-success' }}">
            <strong>{{ $mensaje }}</strong>
        </div>
    @endif


    <div class="card">
        <div class="card-header">
            <div class="row">
                <form action="{{ route('categorias.index') }}" method="GET" class="flex d-flex">
                    <div class="btn-group">
                        <input type="text" name="busqueda" value="{{ request('busqueda') }}" class="w-full form-control"
                            placeholder="Buscar Categoria">
                        <input type="submit" value="Buscar" class="btn btn-success">
                    </div>
                </form>

            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif
    <div class="container-fluid">
        <div class="row" style="gap: 10px;">
            @foreach ($categorias as $categoria)
                <div class="mb-4"
                    style="background: #343A40; border-radius: 10px; width: 300px; height: auto; border: solid #343A40 2px ">
                    <div style="position: relative; border-radius: 10px; overflow: hidden;">
                        <img style="width: 100%; height: auto; opacity: 70%;" src="{{ $categoria->imagen }}"
                            alt="{{ $categoria->nombre }}" />
                        <span
                            style="color:white; border-radius: 8px; padding: 3px; position: absolute; top: 6px; right:6px; font-weight: 600; background:{{ $categoria->estado ? 'green' : 'red' }};">
                            {{ $categoria->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                        <div class="p-2">
                            <h3 class="font-bold text-white dark:text-gray-900"
                                style="margin: 0; margin-top: 5px; font-weight: 700;">
                                {{ $categoria->nombre }}
                            </h3>
                            <p class="text-white dark:text-gray-900">
                                {{ $categoria->descripcion }}
                            </p>
                            <div class="flex justify-end buttons" style="display: flex; justify-content: end; gap: 6px;">
                                <a href="{{ route('categorias.edit', $categoria) }}" class="justify-end btn btn-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                @if ($categoria->estado)
                                    <form action="{{ route('categorias.disable', $categoria) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-danger" type="submit">
                                            <i class="fas fa-user-slash"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('categorias.enable', $categoria) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-success" type="submit">
                                            <i class="fas fa-user-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    {{ $categorias->links() }}
@stop
