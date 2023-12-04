<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
            "NIP" => '0543',
            "password" => Hash::make('satmika'),
            "name" => "Satmika Antargata Ozora",
            "class" => 'PPTI 16',
            "gender" => 'Male',
            "room_number" => 'B516',
            "phone_number" => '123456789',
            "photo" => "photo1.jpg"
        ]);
        User::query()->create([
            "NIP" => '9999',
            "password" => Hash::make('admin'),
            "name" => "admin",
            "class" => 'PPTI 0',
            "gender" => 'Male',
            "room_number" => 'A111',
            "phone_number" => '2345678',
            "photo" => "photo2.jpg"
        ]);
    }
}
