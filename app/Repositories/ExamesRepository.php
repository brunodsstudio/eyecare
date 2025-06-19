<?php 

namespace App\Repositories;

use App\Interfaces\ExamesRepositoryInterface;
use App\Models\Exame;
use Illuminate\Support\Facades\DB;

class ExamesRepository implements ExamesRepositoryInterface
{
  
 public function get(int $id)
 {
     return Exame::where('id', $id)->get() ;
 }

 public function all()
 {
      return DB::table('exames')->get();
 }

  public function examesAvulsos(){
    return DB::table('exames')->where("group", "=", "Individual")->get();
  }

 public function store(array $newExames)
 {
     return Exame::create($newExames);
 }

 public function update(int $ExamesId, array $newExames)
 {
     return Exame::whereId($ExamesId)->update($newExames);
 }

 public function remove(int $ExamesId)
 {
        
     Exame::destroy($ExamesId);
     return response()->noContent();
 }
}