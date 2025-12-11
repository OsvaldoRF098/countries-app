<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Country extends Model
{
    use Searchable;   // ← y este trait

    protected $fillable = ['name', 'capital', 'population', 'region', 'flag_url'];

    // Define qué campos se indexan en Algolia
    public function toSearchableArray()
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'capital'    => $this->capital,
            'region'     => $this->region,
            'population' => $this->population,
            'flag_url'   => $this->flag_url,
        ];
    }
}
