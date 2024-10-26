@extends('layouts.index-base')
@section('title', 'Gestión de Categorias')
@section('content_header')
    <h1>Lista de Categorias</h1>
@stop
@section('header')
    <x-column-filter :routes="['categorias.index', 'categorias.create']" filter="nombre" placeholder="Ingrese el nombre de la categoria" columnSize="5"
        module="Categoria" />
@stop
@section('table')
    <x-data-table :data="$categorias" :titles="['Nombre', 'Descripción', 'Estado', 'Acciones']" :columns="[
        ['key' => 'nombre'],
        ['key' => 'descripcion'],
        ['key' => 'estado'],
    ]" :routes="[
        'edit' => 'categorias.edit',
        'disable' => 'categorias.disable',
        'enable' => 'categorias.enable',
    ]" />
@stop
@section('footer-1', $categorias->links())