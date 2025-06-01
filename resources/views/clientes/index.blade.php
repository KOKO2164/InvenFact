@extends('layouts.index-base')
@section('title', 'Gestión de Clientes')
@section('content_header')
    <h1>Lista de Clientes</h1>
@stop
@section('header')
    <x-column-filter :routes="['clientes.index', 'clientes.create']" filter="nombre" placeholder="Ingrese el nombre del cliente" columnSize="5"
        module="Cliente" />
@stop
@section('table')
    <x-data-table :info="$items" :titles="['Nombre', 'DNI', 'Correo', 'Teléfono', 'Dirección', 'Estado', 'Acciones']" :columns="[
        ['key' => 'nombre'],
        ['key' => 'dni'],
        ['key' => 'email'],
        ['key' => 'telefono'],
        ['key' => 'direccion'],
        ['key' => 'estado'],
    ]" :routes="[
        'edit' => 'clientes.edit',
        'disable' => 'clientes.disable',
        'enable' => 'clientes.enable',
    ]" />
@stop
@section('footer-1', $items->links())
