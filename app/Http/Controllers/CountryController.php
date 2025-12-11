<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CountryController extends Controller
{
public function index(Request $request)
{
    $query = Country::query();

    // ← SOLO aplica filtro si realmente hay texto
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('name', 'LIKE', "%{$search}%")
              ->orWhere('capital', 'LIKE', "%{$search}%")
              ->orWhere('region', 'LIKE', "%{$search}%");
    }

    $countries = $query->paginate(15); // o 10, 25, el número que prefieras

    return view('countries.index', compact('countries'));
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