<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Media::insert([
            [
                'name' => 'Pantalla Reforma 2000',
                'location_id' => 1,
                'type_id' => 2,
                'price_day' => 1500.00,
            ],
            [
                'name' => 'Espectacular Periférico Sur',
                'location_id' => 1,
                'type_id' => 1,
                'price_day' => 2000.00,
            ],
        ]);
    }
}
