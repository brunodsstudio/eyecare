<?php

namespace App\Http\Controllers;

use App\Models\Exame;
use Illuminate\Http\Request;

class ExameController extends Controller
{
    public function index()
    {
        return Exame::with('pacotes')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'laterality' => 'nullable|in:OD,OE,AO',
            'comment' => 'required|string',
            'group' => 'required|in:Individual,Grupo 1,Grupo 2,Grupo 3,Grupo 4,Grupo 5',
        ]);

        return Exame::create($validated);
    }

    public function show(Exame $exame)
    {
        return $exame->load('pacotes');
    }

    public function update(Request $request, Exame $exame)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'laterality' => 'nullable|in:OD,OE,AO',
            'comment' => 'sometimes|string',
            'group' => 'sometimes|in:Individual,Grupo 1,Grupo 2,Grupo 3,Grupo 4,Grupo 5',
        ]);

        $exame->update($validated);
        return $exame;
    }

    public function destroy(Exame $exame)
    {
        $exame->delete();
        return response()->noContent();
    }
}
