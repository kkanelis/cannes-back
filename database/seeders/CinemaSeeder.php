<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cinema;

class CinemaSeeder extends Seeder
{
    public function run(): void
    {
        $cinemas = [
            [
                'name' => 'Kino Lora',
                'address' => 'Strēlnieku iela 2',
                'city' => 'Silguda',
                'postal_code' => 'LV-2150',
                'phone' => '67973972',
                'email' => 'birojs@kinolora.lv',
                'website' => 'https://www.kinolora.lv/lv',
            ],
            [
                'name' => 'Kino Cēsis',
                'address' => 'Raunas iela 12',
                'city' => 'Cēsis',
                'postal_code' => 'LV-4101',
                'phone' => '64119922',
                'email' => 'info@cesukoncertzale.lv',
                'website' => 'https://www.cesukoncertzale.lv/kino-cesis',
            ],
            [
                'name' => 'Gaisma',
                'address' => 'Rīgas iela 10',
                'city' => 'Valmiera',
                'postal_code' => 'LV-4201',
                'phone' => '64222641',
                'email' => 'info@3dcinema.lv',
                'website' => 'https://www.3dcinema.lv/',
            ],
        ];

        foreach ($cinemas as $data) {
            Cinema::create($data);
        }
    }
}
