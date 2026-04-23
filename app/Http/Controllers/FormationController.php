<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::latest()->get();
        return view('formations.index', compact('formations'));
    }

    public function create()
    {
        return view('formations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'formateur' => 'required|string|max:255',
            'duree' => 'required|string|max:255',
            'date_debut' => 'required|date',
        ]);

        Formation::create($validated);

        return redirect()->route('formations.index')
            ->with('success', 'Formation ajoutée avec succès.');
    }

    public function show($id)
    {
        $formation = Formation::findOrFail($id);
        return view('formations.show', compact('formation'));
    }

    public function edit($id)
    {
        $formation = Formation::findOrFail($id);
        return view('formations.edit', compact('formation'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'formateur' => 'required|string|max:255',
            'duree' => 'required|string|max:255',
            'date_debut' => 'required|date',
        ]);

        $formation = Formation::findOrFail($id);
        $formation->update($validated);

        return redirect()->route('formations.index')
            ->with('success', 'Formation modifiée avec succès.');
    }

    public function destroy($id)
    {
        $formation = Formation::findOrFail($id);
        $formation->delete();

        return redirect()->route('formations.index')
            ->with('success', 'Formation supprimée avec succès.');
    }
}
