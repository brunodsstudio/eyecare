<?php

namespace App\Http\Controllers;

use App\Models\Pacote;
use Illuminate\Http\Request;
use App\Services\PacotesService;

class PacoteController extends Controller
{

     /**
     *
     * @var $PacotesService
     */
    protected $PacotesService;

    /**
     * PacotesService constructor.
     *
     * @param PacotesService $PacotesService
     *
     */
    public function __construct(PacotesService $PacotesService)
    {
        $this->PacotesService = $PacotesService;
        
    }


    public function index()
    {
       // return Pacote::with('exames')->get();
        return $this->PacotesService->all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'observations' => 'nullable|string',
        ]);

        return $this->PacotesService->store($validated);
    }

     public function storePacoteExameAvulso(Request $request)
    {
        $validated = $request->validate([
            'idExame' => 'required|string', 
        ]);
         $res  = $this->PacotesService->storePacoteExameAvulso($validated);

         if($res){
            return response()->json(['message' => 'Criado'], 204);
         } else {
            return response()->json(['message' => 'erro exame nao existe no pacote'], 500);
         }

    }

    public function show(Request $request)
    {
    
         return $this->PacotesService->get($request->pacote);
    }

    public function update(Request $request)
    {
       // dd($request->id);
        $validated = $request->validate([
            'id' => 'sometimes|string',
            'name' => 'sometimes|string',
            'observations' => 'nullable|string',
        ]);

        return $this->PacotesService->update($request->id , $validated);
        
    }

    public function destroy(Request $request)
    {

       $res =  $this->PacotesService->remove($request->idPacote);

        if($res){
            return response()->json(['message' => 'Created'], 201);
         } else {
            return response()->json(['message' => 'erro excluir'], 500);
         }

    }

    public function attachExame(Request $request)
    {

         $res = $this->PacotesService->storePacoteExame($request);

         if($res){
            return response()->json(['message' => 'Created'], 201);
         } else {
            return response()->json(['message' => 'erro exame ja existe no pacote'], 500);
         }
         
       
    }

     public function removePacoteExame(Request $request)
    {

       $res = $this->PacotesService->removePacoteExame($request);

       if($res){
            return response()->json(['message' => 'Removido'], 200);
         } else {
            return response()->json(['message' => 'erro exame nao existe no pacote'], 500);
         }
       
    }

     public function printPacote(Request $request)
    {
        $pacotes =  $this->PacotesService->printPacoteExame($request->id);
        return response()->json($pacotes);
       
    }
}
