<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeMedia;

class TypesMediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeMedia::insert([
            ['name' => 'Espectacular'],
            ['name' => 'Pantalla LED'],
            ['name' => 'Publicidad en transporte'],
        ]);
    }
}
