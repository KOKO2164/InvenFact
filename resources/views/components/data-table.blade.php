<table class="table table-head-fixed table-hover text-nowrap">
    <thead>
        <tr>
            @foreach ($titles as $title)
                <th>{{ $title }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($info as $item)
            <tr>
                @foreach ($columns as $column)
                    @if (isset($column['relationship']) && $column['relationship'])
                        @if ($column['key'] === 'rol')
                            <td>
                                <span class="badge badge-primary">
                                    {{ $item->{$column['key']}->{$column['attribute']} }}
                                </span>
                            </td>
                        @elseif ($column['key'] === 'estado')
                            <form action="{{ route($routes['update-estado'], $item) }}" method="POST">
                                @csrf
                                @method('patch')
                                <td>
                                    <select name="estado_id" id="estado" class="form-control"
                                        onchange="this.form.submit()">
                                        @foreach ($otherModels['estados'] as $estado)
                                            <option value="{{ $estado->id }}"
                                                {{ $item->{$column['key']}->id === $estado->id ? 'selected' : '' }}>
                                                {{ $estado->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                            </form>
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
                    @if (isset($routes['disable']) && isset($routes['enable']))
                        @if ($item->estado)
                            @if ($item->id === auth()->user()->id && $item instanceof App\Models\User)
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
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
