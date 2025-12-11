<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nombre del país *</label>
            <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Capital</label>
            <input type="text" wire:model="capital" class="form-control">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Población</label>
            <input type="number" wire:model="population" class="form-control">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Región</label>
            <input type="text" wire:model="region" class="form-control">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>URL Bandera</label>
            <input type="url" wire:model="flag_url" class="form-control" placeholder="https://...">
        </div>
    </div>
</div>