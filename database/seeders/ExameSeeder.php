<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use app\Models\Exame;
use app\Models\ExamePacote;
use app\Models\Pacote;

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
        \App\Models\Exame::create([
            'name' => 'Fundo de Olho',
            'laterality' => 'OD',
            'comment' => 'Exame de rotina',
            'group' => 'Grupo 1'
        ]);
        \App\Models\Exame::create([
            'name' => 'Campimetria',
            'laterality' => 'OD',
            'comment' => 'Campimetria',
            'group' => 'Individual'
        ]);
        \App\Models\Exame::create([
            'name' => 'Paquimetria',
            'laterality' => 'OD',
            'comment' => 'Paquimetria',
            'group' => 'Grupo 1'
        ]);
        \App\Models\Exame::create([
            'name' => 'Gionoscopia',
            'laterality' => 'OD',
            'comment' => 'Gionoscopia',
            'group' => 'Individual'
        ]);
        \App\Models\Exame::create([
            'name' => 'Tomografia de Coerencia Optica',
            'laterality' => 'OD',
            'comment' => 'Tomografia de Coerencia Optica',
            'group' => 'Grupo 1'
        ]);
         \App\Models\Exame::create([
            'name' => 'Mapeamento de retina',
            'laterality' => 'OD',
            'comment' => 'Mapeamento de retina',
            'group' => 'Individual'
        ]);
         \App\Models\Exame::create([
            'name' => 'Curva Tensional',
            'laterality' => 'OD',
            'comment' => 'Curva Tensional',
            'group' => 'Grupo 1'
        ]);

        

        \App\Models\Pacote::create([
            'name' => "Pacote Simples",
            'observations' => "Pacote Simples",
        ]);

        \App\Models\Pacote::create([
            'name' => "Pacote Simples 2",
            'observations' => "Pacote Simples 2",
        ]);

         \App\Models\Pacote::create([
            'name' => "Avulso",
            'observations' => "Avulso",
        ]);

        \App\Models\ExamePacote::create([
            'idExame' => 3,
            'idPacote' => 1,
        ]);
         \App\Models\ExamePacote::create([
            'idExame' => 4,
            'idPacote' => 1,
        ]);
        \App\Models\ExamePacote::create([
            'idExame' => 1,
            'idPacote' => 2,
        ]);
        \App\Models\ExamePacote::create([
            'idExame' => 3,
            'idPacote' => 2,
        ]);
    }
}
