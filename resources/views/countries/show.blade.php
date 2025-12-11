<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="card shadow-lg text-center">
                <div class="card-header bg-info text-white">
                    <h4>Detalle del País</h4>
                </div>
                <div class="card-body">
                    @if($country->flag_url)
                        <img src="{{ $country->flag_url }}" class="img-fluid mb-4" style="max-height: 250px;">
                    @endif
                    <h2 class="display-4">{{ $country->name }}</h2>
                    <p><strong>Capital:</strong> {{ $country->capital ?? 'Sin capital' }}</p>
                    <p><strong>Población:</strong> {{ number_format($country->population ?? 0) }}</p>
                    <p><strong>Región:</strong> {{ $country->region ?? 'N/A' }}</p>

                    <hr class="my-5">
                    <a href="{{ route('countries.edit', $country) }}" class="btn btn-warning btn-lg">Editar</a>
                    <a href="{{ route('countries.index') }}" class="btn btn-primary btn-lg">Volver</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>