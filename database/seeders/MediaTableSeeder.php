<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Media;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Log;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Asumiendo que tienes algunas ubicaciones y tipos en tu base de datos
        $locationIds = \App\Models\Location::pluck('id')->toArray();
        $typeIds = \App\Models\TypeMedia::pluck('id')->toArray();

        // Crear 10 registros de medios de ejemplo
        foreach (range(1, 10) as $index) {
            $name = $faker->word;

            $imageName = $name . '.jpg';

            // Generar la ruta de la imagen
            $imagePath = $faker->image(storage_path('app/public/images'), 640, 480, null, false);

            // Verificar si Faker generó una imagen
            if ($imagePath) {
                // Ruta completa del archivo generado
                $sourcePath = storage_path('app/public/images') . DIRECTORY_SEPARATOR . $imagePath;
                $destinationPath = storage_path('app/public/images') . DIRECTORY_SEPARATOR . $imageName;

                // Verificar si el archivo realmente existe
                if (file_exists($sourcePath)) {
                    // Renombrar la imagen si existe
                    if (rename($sourcePath, $destinationPath)) {
                        Log::info("Imagen renombrada correctamente: $sourcePath a $destinationPath");
                    } else {
                        Log::error("No se pudo renombrar el archivo: $sourcePath a $destinationPath");
                    }
                } else {
                    Log::error("El archivo de imagen no existe: $sourcePath");
                }
            } else {
                // Si Faker no pudo generar la imagen, registrar un mensaje de error
                Log::error("Faker no pudo generar la imagen para el nombre: $name");
            }

            // Crear el registro en la base de datos con la ruta de la imagen renombrada (si existió)
            Media::create([
                'name' => $name,
                'location_id' => $faker->randomElement($locationIds),
                'type_id' => $faker->randomElement($typeIds),
                'image' => isset($imagePath) ? 'storage/images/' . $imageName : null,
                'price_day' => $faker->randomFloat(2, 50, 500),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        /*
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
        */
    }
}
