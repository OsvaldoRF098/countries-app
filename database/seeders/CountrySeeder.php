<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;
use GuzzleHttp\Client;
class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $client = new Client();
        $response = $client->get('https://restcountries.com/v3.1/all?fields=name,capital,population,region,flags');
        $countries = json_decode($response->getBody(), true);

        foreach ($countries as $country) {
            Country::create([
                'name' => $country['name']['common'],
                'capital' => $country['capital'][0] ?? null,
                'population' => $country['population'] ?? null,
                'region' => $country['region'] ?? null,
                'flag_url' => $country['flags']['png'] ?? null,
            ]);
        }
    }
}
