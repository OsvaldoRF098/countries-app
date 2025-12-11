<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Lista de Países ({{ $countries->total() }})</h4>
                    <div>
                        <a href="{{ route('countries.pdf') }}" class="btn btn-danger btn-sm mr-2">PDF</a>
                        <a href="{{ route('countries.create') }}" class="btn btn-light btn-sm">Nuevo País</a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Buscador simple (sin Livewire por ahora) -->
                    <form method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Buscar país, capital o región..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </div>
                        </div>
                    </form>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
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
                                        <a href="{{ route('countries.edit', $country) }}" class="btn btn-warning btn-sm">Editar</a>
                                        <form action="{{ route('countries.destroy', $country) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="6" class="text-center">No hay países registrados</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $countries->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>