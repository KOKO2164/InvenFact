@if (session('error'))
    <div class="alert alert-danger">
        <strong>{{ session('error') }}</strong>
    </div>
@endif