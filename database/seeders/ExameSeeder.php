<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use app\Models\Exame;

class ExameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

       /* DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@example.com',
            'password' => Hash::make('password'),
        ]);*/

        \App\Models\Exame::create([
            'name' => 'Fundo de Olho',
            'laterality' => 'OD',
            'comment' => 'Exame de rotina',
            'group' => 'Grupo 1'
        ]);
    }
}
