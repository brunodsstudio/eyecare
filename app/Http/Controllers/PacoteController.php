<?php

namespace App\Http\Controllers;

use App\Models\Pacote;
use Illuminate\Http\Request;

class PacoteController extends Controller
{
    public function index()
    {
        return Pacote::with('exames')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'observations' => 'nullable|string',
        ]);

        return Pacote::create($validated);
    }

    public function show(Pacote $pacote)
    {
        return $pacote->load('exames');
    }

    public function update(Request $request, Pacote $pacote)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'observations' => 'nullable|string',
        ]);

        $pacote->update($validated);
        return $pacote;
    }

    public function destroy(Pacote $pacote)
    {
        $pacote->delete();
        return response()->noContent();
    }

    public function attachExame(Request $request, $pacoteId)
    {
        $request->validate([
            'exame_id' => 'required|exists:exames,id',
        ]);

        $pacote = Pacote::findOrFail($pacoteId);
        $pacote->exames()->syncWithoutDetaching([$request->exame_id]);

        return $pacote->load('exames');
    }
}
