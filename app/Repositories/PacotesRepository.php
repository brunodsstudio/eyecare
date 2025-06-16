<?php 

namespace App\Repositories;

use App\Interfaces\PacotesRepositoryInterface;
use App\Models\Pacotes;
use Illuminate\Support\Collection;

class PacotesRepository implements PacotesRepositoryInterface
{
  
 public function getPacotess(int|null $id): Collection
 {
     return isset($id) ?  Pacotes::where('id', $id)->get() : Pacotes::where('menu', 1)->get() ;
 }

 public function  getAllPacotesMateria(): Collection
 {
     return Pacotes::where('menu', '>=' , 0)->get();
 }



 public function getPacotessCategoria(int|null $id): Collection
 {
     //return isset($id) ?  Pacotes::where('id', $id)->get() : Pacotes::all();
 }

 public function createPacotes(array $newPacotes): Pacotes
 {
     return Pacotes::create($newPacotes);
 }

 public function updatePacotes($PacotesId, array $newPacotes): void
 {
     Pacotes::whereId($PacotesId)->update($newPacotes);
 }

 public function removePacotes($PacotesId): void
 {
     Pacotes::destroy($PacotesId);
 }
}