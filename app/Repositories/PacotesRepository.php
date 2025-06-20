<?php 

namespace App\Repositories;

use App\Interfaces\PacotesRepositoryInterface;
use App\Models\Pacote;
use App\Models\Exame;
use App\Models\ExamePacote;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PacotesRepository implements PacotesRepositoryInterface
{
  
 public function get(int $id)
 {
     return Pacote::with('exames')->where('id', $id)->get() ;
 }

 public function all()
 {
     return Pacote::with('exames')->orderBy("pacotes.name")->get() ;
    //  return DB::table('pacotes')->get();
 }

 public function store(array $newPacotes)
 {
     return Pacote::create($newPacotes);
 }

 public function update(int $PacotesId, array $newPacotes)
 {
     return Pacote::whereId($PacotesId)->update($newPacotes);
 }

 public function remove(int $PacotesId)
 {
    $status = false;
     if(ExamePacote::where("idPacote" ,"=", $PacotesId)->delete()){
        Pacote::destroy($PacotesId);
        $status = true;
        return $status; 
     } else {
        Pacote::destroy($PacotesId);
        $status = true;
        return $status; 
     }  
      return $status; 
    
     
 }
      
 public function storePacoteExame($info)
 {
    
       $groups =  DB::select( "select * FROM exame_pacote where idPacote = '$info->idPacote' and idExame = '$info->idExame'");

       $in = array(
        "idPacote"=> $info->idPacote,
        "idExame"=> $info->idExame
       );
        
         if(empty($groups)){
            $res =  ExamePacote::create($in);
         } else {
            $res = false;
         }

       return $res;
 }

 public function storePacoteExameAvulso($info)
 {
   
        $pv = array(
        "name"=> "Avulso",
        "observations"=> "Avulso"
       );
        
       $res  =  Pacote::create($pv);

      

        $in = array(
        "idPacote"=>  $res->id,
        "idExame"=> $info['idExame']
       );

        
        
         if(empty($groups)){
            $res =  ExamePacote::create($in);
         } else {
            $res = false;
         }

       return $res;
 }

public function removePacoteExame($info)

 {
      return  ExamePacote::destroy($info->id);
 }

 public function printPacoteExame(int $id){

    $groups =  DB::select( "SELECT distinct(exames.`group`) FROM exames");
    

     $examesPacote =  DB::select( "SELECT p.name as exameNome, p.observations, p.created_at, e.* FROM exame_pacote ep 
        LEFT JOIN exames e 
        ON e.id = ep.idExame
        LEFT JOIN pacotes p
        on p.id = ep.idPacote
        WHERE ep.idPacote =" . $id);

      

        $pacotes = [];
         $pacotes['header']['name'] = $examesPacote[0]->exameNome;
         $pacotes['header']['observations'] = $examesPacote[0]->observations;
        $pacotes['header']['created_at'] = $examesPacote[0]->created_at;
        foreach($groups as $g){
            foreach($examesPacote as $pe){
                if($pe->group == $pe->group){
                     $info = array(
                        "id" => $pe->name,
                        "laterality"=> $pe->laterality,
                        "comment" => $pe->comment,
                     );
                    if($pe->group == "Individual"){
                        $pacotes["Exames Avulsos"][$pe->id] = $info ;
                    } else {
                        $pacotes[$pe->group][$pe->id]= $info ;
                    }
                }
            }
        }

        
    return $pacotes;


}
}
