@extends('layouts.index-base')
@section('title', 'Gestión de Usuarios')
@section('content_header')
    <h1>Lista de Usuarios</h1>
@stop
@section('header')
    <x-column-filter :routes="['trabajadores.index', 'trabajadores.create']" filter="name" placeholder="Ingrese el nombre del usuario" columnSize="4"
        module="Usuario" />
@stop
@section('table')
    <x-data-table :data="$users" :titles="['DNI', 'Nombre', 'Correo', 'Fecha de Nacimiento', 'Rol', 'Acciones']" :columns="[
        ['key' => 'dni'],
        ['key' => 'name'],
        ['key' => 'email'],
        ['key' => 'fecha_nacimiento'],
        ['key' => 'rol', 'relationship' => true, 'attribute' => 'nombre'],
    ]" :routes="[
        'edit' => 'trabajadores.edit',
        'disable' => 'trabajadores.disable',
        'enable' => 'trabajadores.enable',
    ]" />
@stop
@section('footer-1', $users->links())

