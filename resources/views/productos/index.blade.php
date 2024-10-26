@extends('layouts.index-base')
@section('title', 'Gestión de Productos')
@section('content_header')
    <h1>Lista de Productos</h1>
@stop
@section('header')
    <x-column-filter :routes="['productos.index', 'productos.create']" filter="nombre" placeholder="Ingrese el nombre del producto" columnSize="4"
        module="Producto" />
@stop
@section('table')
    <x-data-table :data="$productos" :titles="['Nombre', 'Categoría', 'Descripción', 'Precio', 'Stock', 'Ubicación', 'Estado', 'Acciones']" 
    :columns="[
        ['key' => 'nombre'], 
        ['key' => 'categoria', 'relationship' => true, 'attribute' => 'nombre'],
        ['key' => 'descripcion'], 
        ['key' => 'precio'], 
        ['key' => 'stock'], 
        ['key' => 'codigoUbicacion'],
        ['key' => 'estado']
    ]" 
    :routes="[
        'edit' => 'productos.edit',
        'disable' => 'productos.disable',
        'enable' => 'productos.enable',
    ]" />
@stop
@section('footer-1', $productos->links())