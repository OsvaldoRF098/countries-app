{!! html()->form($method ?? 'POST', $route)->attribute('class', 'needs-validation')->open() !!}

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! html()->label('Nombre del país')->for('name') !!}
            {!! html()->text('name')
                ->class('form-control')
                ->placeholder('Ej: México')
                ->attribute('required')
                ->value(old('name', $country->name ?? '')) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            {!! html()->label('Capital')->for('capital') !!}
            {!! html()->text('capital')
                ->class('form-control')
                ->placeholder('Ej: Ciudad de México')
                ->value(old('capital', $country->capital ?? '')) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            {!! html()->label('Población')->for('population') !!}
            {!! html()->number('population')
                ->class('form-control')
                ->placeholder('Ej: 126000000')
                ->value(old('population', $country->population ?? '')) !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!! html()->label('Región')->for('region') !!}
            {!! html()->text('region')
                ->class('form-control')
                ->placeholder('Ej: Americas')
                ->value(old('region', $country->region ?? '')) !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            {!! html()->label('URL de la bandera')->for('flag_url') !!}
            {!! html()->url('flag_url')
                ->class('form-control')
                ->placeholder('https://...')
                ->value(old('flag_url', $country->flag_url ?? '')) !!}
        </div>
    </div>
</div>

<div class="text-center mt-4">
    <button type="submit" class="btn btn-success btn-lg">
        <i class="fas fa-save"></i> {{ $buttonText ?? 'Guardar País' }}
    </button>
    <a href="{{ route('countries.index') }}" class="btn btn-secondary btn-lg">
        Cancelar
    </a>
</div>

{!! html()->form()->close() !!}