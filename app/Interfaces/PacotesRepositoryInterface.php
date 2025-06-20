<?php 

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PacotesRepositoryInterface
{
    public function all();
    public function get(int $id);
    public function store(array $aStore);
    public function update(int $id, array $aUpdate);
    public function remove(int $id);

    public function storePacoteExame(array $info);
    public function removePacoteExame(int $id);
}