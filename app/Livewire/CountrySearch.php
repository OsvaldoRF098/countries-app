<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Country;

class CountrySearch extends Component
{
    public $search = '';

    public function render()
    {
        if ($this->search !== '') {
            // Usa Algolia solo si hay texto
            $countries = Country::search($this->search)->get();
        } else {
            // Si no hay búsqueda → carga directo de la base de datos
            $countries = Country::orderBy('name')->paginate(20);
        }

        return view('livewire.country-search', [
            'countries' => $countries
        ]);
    }
}