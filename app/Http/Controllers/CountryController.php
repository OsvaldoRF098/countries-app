<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $countries = Country::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'ilike', "%{$search}%")
                             ->orWhere('capital', 'ilike', "%{$search}%")
                             ->orWhere('region', 'ilike', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(15);

        return view('countries.index', compact('countries', 'search'));
    }

    public function create()
    {
        return view('countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255|unique:countries,name',
            'capital'    => 'nullable|string|max:255',
            'population' => 'nullable|integer',
            'region'     => 'nullable|string|max:255',
            'flag_url'   => 'nullable|url',
        ]);

        Country::create($request->all());

        return redirect()->route('countries.index')
                         ->with('success', 'País creado correctamente');
    }

    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }

    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name'       => 'required|string|max:255|unique:countries,name,' . $country->id,
            'capital'    => 'nullable|string|max:255',
            'population' => 'nullable|integer',
            'region'     => 'nullable|string|max:255',
            'flag_url'   => 'nullable|url',
        ]);

        $country->update($request->all());

        return redirect()->route('countries.index')
                         ->with('success', 'País actualizado correctamente');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')
                         ->with('success', 'País eliminado correctamente');
    }

    // GENERAR PDF
    public function pdf()
    {
        $countries = Country::orderBy('name')->get();
        
        $pdf = Pdf::loadView('countries.pdf', compact('countries'))
                ->setPaper('a4', 'landscape'); // opcional: horizontal para más columnas

        return $pdf->download('lista-paises-' . now()->format('Y-m-d') . '.pdf');
    }
}