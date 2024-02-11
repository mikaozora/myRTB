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
            'stuff_id' => '9b3eba7f-8c14-4a2a-a31d-d3fb9957f3e9',
            'NIP' => '0543',
            'start_time' => '2023-12-01 06:00:00',
            'end_time' => '2023-12-01 08:00:00',
            'photo' => null,
            'status_id' => '9b3eba04-5b0a-4f60-be96-868f1db402ed'
        ]);
    }
}
