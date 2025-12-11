<?php
<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Country;

class CountrySearch extends Component
{
    public $search = '';

    public function render()
    {
        // SIEMPRE carga de la base de datos (249 países)
        $query = Country::query();

        if (filled($this->search)) {
            // Solo si hay texto → filtra en DB (o puedes usar Algolia si quieres)
            $query->where('name', 'ilike', "%{$this->search}%")
                  ->orWhere('capital', 'ilike', "%{$this->search}%")
                  ->orWhere('region', 'ilike', "%{$this->search}%");
        }

        $countries = $query->orderBy('name')->paginate(20);

        return view('livewire.country-search', compact('countries'));
    }
}