<?php 

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ExamesRepositoryInterface
{
    public function all();
    public function get(int $id);
    public function store(array $aStore);
    public function update(int $id, array $aUpdate);
    public function remove(int $id);
}