@extends('layouts.index-base')
@section('title', 'Gestión de Usuarios')
@section('content_header')
    <h1>Lista de Usuarios</h1>
@stop
@section('header')
    <x-column-filter :routes="['users.index', 'users.create']" filter="name" placeholder="Ingrese el nombre del usuario" columnSize="4"
        module="Usuario" />
@stop
@section('table')
    <x-data-table :info="$items" :titles="['DNI', 'Nombre', 'Correo', 'Fecha de Nacimiento', 'Acciones']" :columns="[
        ['key' => 'dni'],
        ['key' => 'name'],
        ['key' => 'email'],
        ['key' => 'fecha_nacimiento'],
    ]" :routes="[
        'edit' => 'users.edit',
        'disable' => 'users.disable',
        'enable' => 'users.enable',
    ]" />
@stop
@section('footer-1', $items->links())
