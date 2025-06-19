<?php

namespace App\Http\Controllers;

use App\Models\Exame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ExamesService;                                                                                                                                                                                                                                                             

class ExameController extends Controller

{

    /**
     * PacotesService constructor.
     *
     * @param ExamesService $ExamesService
     *
     */
    public function __construct(ExamesService $ExamesService)
    {
        $this->ExamesService = $ExamesService;
    }


    public function index()
    {
        //return Exame::with('pacotes')->get();

      // return DB::table('exames')->get();

        return $this->ExamesService->all();

 
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'laterality' => 'nullable|in:OD,OE,AO',
            'comment' => 'required|string',
            'group' => 'required|in:Individual,Grupo 1,Grupo 2,Grupo 3,Grupo 4,Grupo 5',
        ]);

         return $this->ExamesService->store($validated);

        //return Exame::create($validated);
    }

    

    public function show(Exame $exame)
    {
        return $exame->load('pacotes');
    }

     public function examesAvulsos(Exame $exame)
    {
       return $this->ExamesService->examesAvulsos();
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

    public function destroy(Request $request, Exame $exame)
    {

        //dd($request->all());
        $this->ExamesService->remove($request->id);
        return response()->noContent();
    }
}
