<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Country;

class CountrySearch extends Component
{
    public $search = '';

    public function render()
    {
        $countries = $this->search === ''
            ? Country::orderBy('name')->paginate(15)
            : Country::search($this->search)->get();

        return view('livewire.country-search', [
            'countries' => $countries
        ]);
    }
}