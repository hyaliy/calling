<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->createMany([
            ['name' => 'にむら'],
            ['name' => 'けんたろ'],
            ['name' => 'たけいし'],
            ['name' => 'me']
        ]);
    }
}
