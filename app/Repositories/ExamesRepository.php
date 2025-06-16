<?php 

namespace App\Repositories;

use App\Interfaces\ExamesRepositoryInterface;
use App\Models\Exames;
use Illuminate\Support\Collection;

class ExamesRepository implements ExamesRepositoryInterface
{
  
 public function getExamess(int|null $id): Collection
 {
     return isset($id) ?  Exames::where('id', $id)->get() : Exames::where('menu', 1)->get() ;
 }

 public function  getAllExamesMateria(): Collection
 {
     return Exames::where('menu', '>=' , 0)->get();
 }



 public function getExamessCategoria(int|null $id): Collection
 {
     //return isset($id) ?  Exames::where('id', $id)->get() : Exames::all();
 }

 public function createExames(array $newExames): Exames
 {
     return Exames::create($newExames);
 }

 public function updateExames($ExamesId, array $newExames): void
 {
     Exames::whereId($ExamesId)->update($newExames);
 }

 public function removeExames($ExamesId): void
 {
     Exames::destroy($ExamesId);
 }
}