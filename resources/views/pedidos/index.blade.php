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
    <x-data-table :info="$items" :titles="['Código', 'Trabajador', 'Fecha de Emisión', 'Fecha Límite', 'Cliente', 'Total', 'Estado', 'Acciones']" :columns="[
        ['key' => 'codigo'],
        ['key' => 'trabajador', 'relationship' => true, 'attribute' => 'name'],
        ['key' => 'fecha', 'fecha' => true],
        ['key' => 'plazo', 'calculate' => true],
        ['key' => 'cliente', 'relationship' => true, 'attribute' => 'nombre'],
        ['key' => 'total'],
        ['key' => 'estado', 'relationship' => true, 'attribute' => 'nombre'],
    ]" :routes="[
        'edit' => 'pedidos.edit',
        'update-estado' => 'pedidos.update-estado',
    ]" :otherModels="$otherModels" />
@stop
