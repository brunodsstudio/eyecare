<?php

namespace App\Services;

use App\Repositories\PacotesRepository;
use App\Models\Pacotes;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

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
