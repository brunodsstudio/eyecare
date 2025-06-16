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
        $this->EventoRepository= $EventoRepository;
    }

    /**
     * Get all Materias.
     *
     * @return Collection
     *
     */
    /*public function getAll(): Collection
    {
        return $this->EventoRepository->getAllEventos(null);
    }

    public function getId(int $id): Collection
    {

    }
    public function getName(string $name): Collection
    {
        
    }
    public function setEvento(array $info):bool
    {

    }
    public function updateEvento(array $info):bool
    {

    }
    public function deleteEvento(array $info):bool
    {

    }*/


}
