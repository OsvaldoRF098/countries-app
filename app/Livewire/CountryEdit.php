<?php

namespace App\Livewire;

use App\Models\Country;
use Livewire\Component;

class CountryEdit extends Component
{
    public $country;
    public $name, $capital, $population, $region, $flag_url;

    public function mount(Country $country)
    {
        $this->country = $country;
        $this->name = $country->name;
        $this->capital = $country->capital;
        $this->population = $country->population;
        $this->region = $country->region;
        $this->flag_url = $country->flag_url;
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:countries,name,' . $this->country->id,
            'capital' => 'nullable|string|max:255',
            'population' => 'nullable|integer',
            'region' => 'nullable|string|max:255',
            'flag_url' => 'nullable|url',
        ];
    }

    public function update()
    {
        $this->validate();

        $this->country->update([
            'name'       => $this->name,
            'capital'    => $this->capital,
            'population' => $this->population ?: null,
            'region'     => $this->region,
            'flag_url'   => $this->flag_url,
        ]);

        session()->flash('success', 'País actualizado correctamente');
        return redirect()->route('countries.index');
    }

    public function render()
    {
        return view('livewire.country-edit');
    }
}