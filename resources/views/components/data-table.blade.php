<table class="table table-head-fixed table-hover text-nowrap">
    <thead>
        <tr>
            @foreach ($titles as $title)
                <th>{{ $title }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                @foreach ($columns as $column)
                    @if (isset($column['relationship']) && $column['relationship'])
                        @if ($column['key'] === 'rol')
                            <td>
                                <span class="badge badge-primary">
                                    {{ $item->{$column['key']}->{$column['attribute']} }}
                                </span>
                            </td>
                        @else
                            <td>{{ $item->{$column['key']}->{$column['attribute']} }}</td>
                        @endif
                    @elseif (DateTime::createFromFormat('Y-m-d', $item->{$column['key']}) !== false)
                        <td>{{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y') }}</td>
                    @elseif ($column['key'] === 'estado')
                        <td>
                            <span class="badge {{ $item->{$column['key']} ? 'badge-success' : 'badge-danger' }}">
                                {{ $item->{$column['key']} ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                    @else
                        <td>{{ $item->{$column['key']} }}</td>
                    @endif
                @endforeach
                <td>
                    <a href="{{ route($routes['edit'], $item) }}" class="btn btn-warning">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    @if ($item->estado)
                        @if ($item->id === auth()->user()->id)
                            <button class="btn btn-danger" disabled>
                                <i class="fas fa-lock"></i>
                            </button>
                        @else
                            <form action="{{ route($routes['disable'], $item) }}" method="POST" class="d-inline">
                                @csrf
                                @method('patch')
                                <button class="btn btn-danger" type="submit">
                                    <i class="fas fa-lock"></i>
                                </button>
                            </form>
                        @endif
                    @else
                        <form action="{{ route($routes['enable'], $item) }}" method="POST" class="d-inline">
                            @csrf
                            @method('patch')
                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-unlock"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
