<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::insert([
            [
                'name' => 'Ubicación CDMX - Centro',
                'street' => 'Av. Reforma',
                'colony' => 'Centro',
                'zip_code' => '06000',
                'city' => 'Ciudad de México',
            ],
            [
                'name' => 'Ubicación GDL - Plaza',
                'street' => 'Av. Vallarta',
                'colony' => 'Arcos Vallarta',
                'zip_code' => '44100',
                'city' => 'Guadalajara',
            ],
            [
                'name' => 'Ubicación MTY - Cumbres',
                'street' => 'Av. Leones',
                'colony' => 'Cumbres',
                'zip_code' => '64610',
                'city' => 'Monterrey',
            ],
        ]);
    }
}
