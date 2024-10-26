@extends('layouts.index-base')
@section('title', 'Pedidos')
@section('content_header')
    <h1>Lista de Pedidos</h1>
@stop
@section('header')
    <x-column-filter :routes="['pedidos.index', 'pedidos.create']" filter="codigo" placeholder="Ingrese el código del pedido" columnSize="4"
        module="Pedido" />
@stop
@section('table')
    <x-data-table :data="$pedidos" :titles="['Código', 'Fecha', 'Cliente', 'Total', 'Estado', 'Acciones']" :columns="[
        ['key' => 'codigo'],
        ['key' => 'fecha'],
        ['key' => 'cliente', 'relationship' => true, 'attribute' => 'nombre'],
        ['key' => 'total'],
        ['key' => 'estado', 'relationship' => true, 'attribute' => 'nombre'],
    ]" :routes="[
        'edit' => 'pedidos.edit'
    ]" />
@stop
