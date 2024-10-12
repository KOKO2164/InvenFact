@extends('adminlte::page')

@section('title', 'Gestión de Productos')

@section('content_header')
    <div class="col d-flex justify-content-start">
        <h1 class="mr-2">Lista de Productos</h1>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Producto
        </a>
    </div> 
@stop

@section('content')
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

    <div class="card">
        <div class="card-header">
            <div class="row">
                <form action="{{ route('productos.index') }}" method="GET" class="flex d-flex">
                    <div class="btn-group">
                        <input type="text" name="busqueda" value="{{ request('busqueda') }}" class="form-control w-full" placeholder="Buscar Producto">
                        <input type="submit" value="Buscar" class="btn btn-success">
                    </div>
                </form>                
               
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            @foreach ($productos as $producto)
                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12 col-custom-5" style="margin-bottom: 20px;">
                    <div class="producto" style="background: #343a4054; border-radius: 5px; transition: transform 0.3s ease; height: auto; position: relative; display: flex; flex-direction: column;">
                        <div style="height: 150px; background: black;">
                            <img src="{{ $producto->imagen }}" alt="{{ $producto->imagen }}" style="width: 100%; height: 150px; object-fit: cover;">
                        </div>
    
                        <span class="badge {{ $producto->estado ? 'badge-success' : 'badge-danger' }}" style="position: absolute; top: 4px; right: 4px;">
                            {{ $producto->estado ? 'Activo' : 'Inactivo' }}
                        </span>
                        <span style="font-size: 14px; position: absolute; top: 8px; left: 8px; background: white; color: black; border-radius: 6px; font-weight: 600;" class="px-2">
                            {{ $producto->categoria->nombre }}
                        </span>
                        <span style="font-size: 14px; position: absolute; top: 39px; left: 8px; background: white; color: black; border-radius: 6px; font-weight: 600;" class="px-2">
                            Stock: {{ $producto->stock }}
                        </span>
                        <span style="font-size: 14px; position: absolute; top: 69px; left: 8px; background: white; color: black; border-radius: 6px; font-weight: 600;" class="px-2">
                            Ubicación: {{ $producto->codigoUbicacion }}
                        </span>
    
                        <span style="font-size: 14px; position: absolute; top: 120px; right: 8px; background: rgb(241, 137, 0); color: rgb(255, 255, 255); border-radius: 6px; font-weight: 600;" class="px-2">
                            s/.{{ $producto->precio }}
                        </span>
    
                        <div style="padding: 5px; color: rgb(0, 0, 0); height: 100px; margin-bottom: 20px;">
                            <h5>{{ $producto->nombre }}</h5>
                            <p style="text-overflow: ellipsis;">
                                {{ Str::limit($producto->descripcion, 50, '...') }}
                            </p>
                        </div>
    
                        <div style="display: flex; border-radius: 10px;">
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning" style="flex: 1;">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            @if ($producto->estado)
                                <form action="{{ route('productos.disable', $producto) }}" method="POST" style="flex: 1;" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger" type="submit" style="width: 100%;">
                                        <i class="fas fa-user-slash"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('productos.enable', $producto) }}" method="POST" style="flex: 1;" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-success" type="submit" style="width: 100%; border-radius: 0;">
                                        <i class="fas fa-user-check"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {!! $productos->links('pagination::bootstrap-4') !!}
    </div>
    
    
    
@stop
@section('css')
    <style>
        .producto:hover {
            transform: scale(1.05); /* Efecto zoom */
        }
        @media (max-width: 1559px) and (min-width: 1200px) {
            .col-custom-5 {
                flex: 0 0 25%; /* 100% / 5 = 20% */
                max-width: 25%;
            }
        }
    </style>
@stop

