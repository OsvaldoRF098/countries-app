<div>
    <!-- Buscador instantáneo con Algolia -->
    <div class="mb-4">
        <input 
            type="text" 
            wire:model.live.debounce.500ms="search"
            class="form-control form-control-lg shadow-sm"
            placeholder="Busca países, capitales o regiones (instantáneo con Algolia)..."
            autofocus>
    </div>

    @if($search !== '')
        <div class="alert alert-info">
            Mostrando resultados para: <strong>"{{ $search }}"</strong>
            <small class="float-right">{{ $countries->count() }} países encontrados</small>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="thead-light">
                <tr>
                    <th>Bandera</th>
                    <th>País</th>
                    <th>Capital</th>
                    <th>Población</th>
                    <th>Región</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($countries as $country)
                    <tr>
                        <td>
                            @if($country->flag_url)
                                <img src="{{ $country->flag_url }}" width="60" class="img-fluid rounded shadow-sm">
                            @endif
                        </td>
                        <td><strong>{{ $country->name }}</strong></td>
                        <td>{{ $country->capital ?? 'N/A' }}</td>
                        <td>{{ number_format($country->population ?? 0) }}</td>
                        <td>{{ $country->region ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('countries.show', $country) }}" class="btn btn-info btn-sm">Ver</a>
                            <form action="{{ route('countries.destroy', $country) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Eliminar este país?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <h5 class="text-muted">No se encontraron países con "{{ $search }}"</h5>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación solo cuando no hay búsqueda -->
    @if($search === '')
        <div class="mt-4">
            {{ $countries->links() }}
        </div>
    @endif
</div>