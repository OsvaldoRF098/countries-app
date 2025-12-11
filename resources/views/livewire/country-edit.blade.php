<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h4>Editar: {{ $country->name }}</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="update">
                        @include('livewire.country-form')
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">Actualizar</button>
                            <a href="{{ route('countries.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>