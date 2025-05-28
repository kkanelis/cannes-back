<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OperatingHour;
use App\Models\Cinema;

class OperatingHourSeeder extends Seeder
{
    public function run(): void
    {   
        $loraID = Cinema::where('name', 'Kino Lora')->value('id');
        OperatingHour::create([
            'cinema_id' => $loraID,
            'day_of_week' => 'Pirmdiena',
            'opens_at' => null,
            'closes_at' => null,
        ]);
        OperatingHour::create([
            'cinema_id' => $loraID,
            'day_of_week' => 'Otrdiena',
            'opens_at' => null,
            'closes_at' => null,
        ]);
        OperatingHour::create([
            'cinema_id' => $loraID,
            'day_of_week' => 'Trešdiena',
            'opens_at' => null,
            'closes_at' => null,
        ]);
        OperatingHour::create([
            'cinema_id' => $loraID,
            'day_of_week' => 'Ceturtdiena',
            'opens_at' => '14:00',
            'closes_at' => '21:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $loraID,
            'day_of_week' => 'Piektdiena',
            'opens_at' => '14:00',
            'closes_at' => '21:30',
        ]);
        OperatingHour::create([
            'cinema_id' => $loraID,
            'day_of_week' => 'Sestdiena',
            'opens_at' => '10:00',
            'closes_at' => '21:30',
        ]);
        OperatingHour::create([
            'cinema_id' => $loraID,
            'day_of_week' => 'Svētdiena',
            'opens_at' => '10:00',
            'closes_at' => '21:00',
        ]);

        $cesisID = Cinema::where('name', 'Kino Cēsis')->value('id');
        OperatingHour::create([
            'cinema_id' => $cesisID,
            'day_of_week' => 'Pirmdiena',
            'opens_at' => '15:00',
            'closes_at' => '22:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $cesisID,
            'day_of_week' => 'Otrdiena',
            'opens_at' => '15:00',
            'closes_at' => '22:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $cesisID,
            'day_of_week' => 'Trešdiena',
            'opens_at' => null,
            'closes_at' => null,
        ]);
        OperatingHour::create([
            'cinema_id' => $cesisID,
            'day_of_week' => 'Ceturtdiena',
            'opens_at' => '15:00',
            'closes_at' => '22:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $cesisID,
            'day_of_week' => 'Piektdiena',
            'opens_at' => '15:00',
            'closes_at' => '22:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $cesisID,
            'day_of_week' => 'Sestdiena',
            'opens_at' => '10:00',
            'closes_at' => '22:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $cesisID,
            'day_of_week' => 'Svētdiena',
            'opens_at' => '10:00',
            'closes_at' => '20:00',
        ]);

        $gaismaID = Cinema::where('name', 'Gaisma')->value('id');
        OperatingHour::create([
            'cinema_id' => $gaismaID,
            'day_of_week' => 'Pirmdiena',
            'opens_at' => '16:00',
            'closes_at' => '22:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $gaismaID,
            'day_of_week' => 'Otrdiena',
            'opens_at' => '16:00',
            'closes_at' => '22:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $gaismaID,
            'day_of_week' => 'Trešdiena',
            'opens_at' => '16:00',
            'closes_at' => '22:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $gaismaID,
            'day_of_week' => 'Ceturtdiena',
            'opens_at' => '16:00',
            'closes_at' => '22:00',
        ]);
        OperatingHour::create([
            'cinema_id' => $gaismaID,
            'day_of_week' => 'Piektdiena',
            'opens_at' => '16:00',
            'closes_at' => '22:30',
        ]);
        OperatingHour::create([
            'cinema_id' => $gaismaID,
            'day_of_week' => 'Sestdiena',
            'opens_at' => '10:00',
            'closes_at' => '22:30',
        ]);
        OperatingHour::create([
            'cinema_id' => $gaismaID,
            'day_of_week' => 'Svētdiena',
            'opens_at' => '11:00',
            'closes_at' => '21:00',
        ]);
    }
}
