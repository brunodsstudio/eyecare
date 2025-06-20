<?php

namespace App\Services;

use App\Repositories\PacotesRepository;
use App\Models\Pacotes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PacotesService
{
    /**
     *
     * @var $PacotesRepository
     */
    protected $PacotesRepository;

    /**
     * MateriaService constructor.
     *
     * @param PacotesRepository $PacotesRepository
     *
     */
    public function __construct(PacotesRepository $PacotesRepository)
    {
        $this->PacotesRepository= $PacotesRepository;
    }

     public function all()
    {
        return $this->PacotesRepository->all();
    }

    public function get(int $id)
    {
        return $this->PacotesRepository->get($id);
    }        
    
    public function store(array $info)
    {
        return $this->PacotesRepository->store($info);
    }

     public function storePacoteExameAvulso(array $info)
    {
        return $this->PacotesRepository->storePacoteExameAvulso($info);
    }


    public function update(int $id, array $info)
    {
        return $this->PacotesRepository->update($id, $info);
    }
    public function remove(int $id)
    {
        return $this->PacotesRepository->remove($id);
    }

    public function storePacoteExame($info)
    {
        return $this->PacotesRepository->storePacoteExame($info);
    }

    public function removePacoteExame($info)
    {
        return $this->PacotesRepository->removePacoteExame($info);
    }

    public function printPacoteExame(int $id){

        return $this->PacotesRepository->printPacoteExame($id);
    }



}
