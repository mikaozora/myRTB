<?php

namespace Database\Seeders;

use App\Models\WashingMachine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WashingMachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WashingMachine::query()->create([
            'name' => 'Machine 1'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 2'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 3'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 4'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 5'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 6'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 7'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 8'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 9'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 10'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 11'
        ]);
        WashingMachine::query()->create([
            'name' => 'Machine 12'
        ]);
    }
}
