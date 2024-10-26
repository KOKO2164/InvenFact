@extends('layouts.index-base')
@section('title', 'Compras')
@section('content_header')
    <h1>Lista de Compras</h1>
@stop
@section('header')
    <x-column-filter :routes="['compras.index', 'compras.create']" filter="codigo" placeholder="Ingrese el código de la compra" columnSize="4"
        module="Compra" />
@stop
@section('table')
    <x-data-table :data="$compras" :titles="['Código', 'Fecha', 'Proveedor', 'Total', 'Estado', 'Acciones']" :columns="[
        ['key' => 'codigo'],
        ['key' => 'fecha'],
        ['key' => 'proveedor', 'relationship' => true, 'attribute' => 'nombre'],
        ['key' => 'total'],
        ['key' => 'estado', 'relationship' => true, 'attribute' => 'nombre'],
    ]" :routes="[
        'edit' => 'compras.edit'
    ]" />
@stop
