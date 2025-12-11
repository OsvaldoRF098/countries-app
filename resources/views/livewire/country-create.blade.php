<x-app-layout>
    <div class="container py-8 mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="card shadow-lg">
                <div class="card-header bg-success text-white">
                    <h4>Nuevo País</h4>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        @include('livewire.country-form')
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Crear País</button>
                            <a href="{{ route('countries.index') }}" class="btn btn-secondary btn-lg">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>