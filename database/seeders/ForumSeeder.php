<?php

namespace Database\Seeders;

use App\Models\Forum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Forum::query()->create([
            'NIP' => '0543',
            'message' => 'Ada pakaian hilang di laundry femme',
            'created_at' => '2023-12-01 06:20:10'
        ]);
    }
}
