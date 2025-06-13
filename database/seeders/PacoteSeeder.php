<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use app\Models\Pacote;

class PacoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Pacote::create([
            'name' => 'Pacote Completo 1',
            'observations' => 'Inclui todos os exames básicos.'
        ]);
    }
}
