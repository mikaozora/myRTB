<?php

namespace Database\Seeders;

use App\Models\KitchenStuff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KitchenStuffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KitchenStuff::query()->create([
            'name' => 'Rice Cooker 1'
        ]);
        KitchenStuff::query()->create([
            'name' => 'Rice Cooker 2'
        ]);
        KitchenStuff::query()->create([
            'name' => 'Rice Cooker 3'
        ]);
        KitchenStuff::query()->create([
            'name' => 'Air Fryer 1'
        ]);
        KitchenStuff::query()->create([
            'name' => 'Air Fryer 2'
        ]);
        KitchenStuff::query()->create([
            'name' => 'Air Fryer 3'
        ]);
        KitchenStuff::query()->create([
            'name' => 'Stove 1'
        ]);
        KitchenStuff::query()->create([
            'name' => 'Stove 2'
        ]);
        KitchenStuff::query()->create([
            'name' => 'Stove 3'
        ]);
        KitchenStuff::query()->create([
            'name' => 'Stove 4'
        ]);
    }
}
