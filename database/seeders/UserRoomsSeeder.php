<?php

namespace Database\Seeders;

use App\Models\UserRooms;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            for ($i = 1; $i <= 32; $i++) {
                $code_numberAG = 'AG' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $code_numberA1 = 'A1' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $code_numberB1 = 'B1' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $code_numberA2 = 'A2' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $code_numberB2 = 'B2' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $code_numberA3 = 'A3' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $code_numberB3 = 'B3' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $code_numberB5 = 'B5' . str_pad($i, 2, '0', STR_PAD_LEFT);
                $capacity = ($i == 28) ? 1 : 2;
            
            UserRooms::create([
            "room_number" => $code_numberAG,
            "capacity" => $capacity
            ]);
        
            UserRooms::create([
            "room_number" => $code_numberA1,
            "capacity" => $capacity
            ]);

            UserRooms::create([
                "room_number" => $code_numberB1,
                "capacity" => $capacity
                ]);
                
            UserRooms::create([
            "room_number" => $code_numberA2,
            "capacity" => $capacity
            ]);

            UserRooms::create([
                "room_number" => $code_numberB2,
                "capacity" => $capacity
                ]);

            UserRooms::create([
                "room_number" => $code_numberA3,
                "capacity" => $capacity
                ]);

            UserRooms::create([
                "room_number" => $code_numberB3,
                "capacity" => $capacity
                ]);

            UserRooms::create([
                 "room_number" => $code_numberB5,
                 "capacity" => $capacity
                 ]);
        }
    }
}
