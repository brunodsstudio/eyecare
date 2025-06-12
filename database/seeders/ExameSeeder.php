<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Exame::create([
            'name' => 'Fundo de Olho',
            'laterality' => 'OD',
            'comment' => 'Exame de rotina',
            'group' => 'Grupo 1'
        ]);
    }
}
