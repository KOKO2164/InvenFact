<div class="col-md-{{ $columnSize }}">
    <form action="{{ route($routes[0]) }}" method="GET">
        <div class="input-group">
            <input type="text" name="{{ $filter }}" class="form-control"
                placeholder="{{ $placeholder }}" value="{{ request($filter) }}">
            <div class="input-group-append">
                <button class="btn btn-secondary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</div>
<div class="col-1">
    <a href="{{ route($routes[0]) }}" class="btn btn-danger">
        <i class="fas fa-sync"></i>
    </a>
</div>
<div class="col d-flex justify-content-end">
    <a href="{{ route($routes[1]) }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Registrar {{ $module }}
    </a>
</div>