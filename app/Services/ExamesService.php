<?php

namespace App\Services;

use App\Repositories\ExamesRepository;
use App\Models\Exames;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ExamesService
{
    /**
     *
     * @var $ExamesRepository
     */
    protected $ExamesRepository;

    /**
     * MateriaService constructor.
     *
     * @param ExamesRepository $ExamesRepository
     *
     */
    public function __construct(ExamesRepository $ExamesRepository)
    {
        $this->ExamesRepository= $ExamesRepository;
    }
   
    public function all()
    {
        return $this->ExamesRepository->all();
    }

    public function get(int $id)
    {
        return $this->ExamesRepository->all($id);
    }  
    
    public function examesAvulsos()
    {
        return $this->ExamesRepository->examesAvulsos();
    }
    
    public function store(array $info)
    {
        return $this->ExamesRepository->store($info);
    }
    public function update(int $id, array $info)
    {
        return $this->ExamesRepository->update($id, $info);
    }
    public function remove(int $id)
    {
        return $this->ExamesRepository->remove($id);
    }


}
