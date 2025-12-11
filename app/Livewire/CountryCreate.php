<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;

class CountryCreate extends Component
{
    public $name = '';
    public $capital = '';
    public $population = '';
    public $region = '';
    public $flag_url = '';

    protected $rules = [
        'name'       => 'required|string|max:255|unique:countries,name',
        'capital'    => 'nullable|string|max:255',
        'population' => 'nullable|integer',
        'region'     => 'nullable|string|max:255',
        'flag_url'   => 'nullable|url',
    ];

    public function store()
    {
        $this->validate();

        Country::create([
            'name'       => $this->name,
            'capital'    => $this->capital,
            'population' => $this->population ?: null,
            'region'     => $this->region,
            'flag_url'   => $this->flag_url,
        ]);

        session()->flash('success', 'País creado correctamente');
        return redirect()->route('countries.index');
    }

    public function render()
    {
        return view('livewire.country-create');
    }
}