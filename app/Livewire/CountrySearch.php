<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Country;

class CountrySearch extends Component
{
    public $search = '';

        public function render()
        {
            $query = Country::query();

            if ($this->search) {
                $query->where('name', 'ilike', "%{$this->search}%")
                    ->orWhere('capital', 'ilike', "%{$this->search}%")
                    ->orWhere('region', 'ilike', "%{$this->search}%");
            }

            $countries = $query->orderBy('name')->paginate(20);

            return view('livewire.country-search', compact('countries'));
        }
}