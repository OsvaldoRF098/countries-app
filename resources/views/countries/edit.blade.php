<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Editar País: {{ $country->name }}</h4>
                </div>
                <div class="card-body">
                    @include('countries._form', [
                        'method' => 'PUT',
                        'route' => route('countries.update', $country),
                        'buttonText' => 'Actualizar País',
                        'country' => $country
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>