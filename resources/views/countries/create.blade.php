<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Nuevo País</h4>
                </div>
                <div class="card-body">
                    @include('countries._form', [
                        'method' => 'POST',
                        'route' => route('countries.store'),
                        'buttonText' => 'Crear País'
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>