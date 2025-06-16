<?php 

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PacotesRepositoryInterface
{
    public function getPacotes(int|null $id): Collection;
    public function createPacotes(array $newPacotes): Model;
    public function updatePacotes($PacotesId, array $newPacotes): void;
    public function removePacotes($PacotesId): void;

}