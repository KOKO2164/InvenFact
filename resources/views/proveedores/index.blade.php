@extends('layouts.index-base')
@section('title', 'Gestión de Proveedores')
@section('content_header')
    <h1>Lista de Proveedores</h1>
@stop
@section('header')
    <x-column-filter :routes="['proveedores.index', 'proveedores.create']" filter="nombre" placeholder="Ingrese el nombre del proveedor" columnSize="5"
        module="Proveedor" />
@stop
@section('table')
    <x-data-table :info="$items" :titles="['Nombre', 'RUC', 'Correo', 'Teléfono', 'Dirección', 'Estado', 'Acciones']"
        :columns="[
            ['key' => 'nombre'],
            ['key' => 'ruc'],
            ['key' => 'email'],
            ['key' => 'telefono'],
            ['key' => 'direccion'],
            ['key' => 'estado'],
        ]" :routes="[
            'edit' => 'proveedores.edit',
            'disable' => 'proveedores.disable',
            'enable' => 'proveedores.enable',
        ]" />
@stop
@section('footer-1', $items->links())