<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Lista de Países (250)</h4>
                    <div>
                        <a href="{{ url('/countries') }}" class="btn btn-light btn-sm">Recargar</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Bandera</th>
                                    <th>País</th>
                                    <th>Capital</th>
                                    <th>Población</th>
                                    <th>Región</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $paises = DB::table('countries')->orderBy('name')->get();
                                @endphp

                                @foreach($paises as $p)
                                <tr>
                                    <td>
                                        @if($p->flag_url)
                                            <img src="{{ $p->flag_url }}" width="60" class="rounded shadow-sm">
                                        @endif
                                    </td>
                                    <td><strong>{{ $p->name }}</strong></td>
                                    <td>{{ $p->capital ?? 'N/A' }}</td>
                                    <td>{{ number_format($p->population) }}</td>
                                    <td>{{ $p->region }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="text-center mt-4">
                            <strong>Total: {{ $paises->count() }} países cargados correctamente</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>