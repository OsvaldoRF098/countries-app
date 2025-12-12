<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        <div class="max-w-7xl mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        Lista de Países
                    </h4>
                    <div>
                        <a href="{{ route('countries.pdf') }}" class="btn btn-danger btn-sm mr-2">
                            PDF
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @livewire('country-search')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>