<?php 

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ExamesRepositoryInterface
{
    public function getExames(int|null $id): Collection;
    public function createExames(array $newExames): Model;
    public function updateExames($ExamesId, array $newExames): void;
    public function removeExames($ExamesId): void;

}