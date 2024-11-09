@extends('adminlte::page')
@section('content')
    <div class="card">
        <div class="card-header">
            <div class="row">
                @yield('header')
            </div>
        </div>
        <div class="p-0 card-body table-responsive">
            @yield('table')
        </div>
        <div class="card-footer d-flex justify-content-center">
            @yield('footer-1')
        </div>
    </div>
@stop
@section('js')
    <script>
        window.onload = function() {
            @if (session('success'))
                sessionStorage.setItem('success', '{{ session('success') }}');
            @endif
            @if (session('error'))
                sessionStorage.setItem('error', '{{ session('error') }}');
            @endif
            @if (session('warning'))
                sessionStorage.setItem('warning', '{{ session('warning') }}');
            @endif

            if (sessionStorage.getItem('success')) {
                Swal.fire({
                    icon: 'success',
                    title: 'Correcto',
                    text: sessionStorage.getItem('success'),
                    showConfirmButton: false,
                    timer: 3000
                });
                sessionStorage.removeItem('success');
            }
            if (sessionStorage.getItem('error')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: sessionStorage.getItem('error'),
                    showConfirmButton: false,
                    timer: 3000
                });
                sessionStorage.removeItem('error');
            }
            if (sessionStorage.getItem('warning')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: sessionStorage.getItem('warning'),
                    showConfirmButton: false,
                    timer: 3000
                });
                sessionStorage.removeItem('warning');
            }
        };
    </script>
@stop
