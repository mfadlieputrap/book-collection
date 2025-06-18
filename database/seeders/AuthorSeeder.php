<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Author;
use Faker\Factory as Faker;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 0; $i < 1000; $i++) {
            $data[] = [
                'name' => $faker->name,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        foreach(array_chunk($data, 1000) as $chunk){
            DB::table('authors')->insert($chunk);
        }
    }
}
