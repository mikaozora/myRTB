<?php

namespace Database\Seeders;

use App\Models\BookKitchen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookKitchenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookKitchen::query()->create([
            'stuff_id' => '9ac4c8b6-d14c-42ab-9a5b-b00bbc8bb356',
            'NIP' => '0543',
            'start_time' => '2023-12-01 06:00:00',
            'end_time' => '2023-12-01 08:00:00',
            'photo' => null,
            'status_id' => '9ac4c529-54df-40bd-b4ad-5db3381d714b'
        ]);
    }
}
