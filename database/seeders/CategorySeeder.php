<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $data = [];

        for ($i = 0; $i < 3000; $i++) {
            $data[] = [
                'name' => $faker->word
            ];
        }

        foreach(array_chunk($data, 3000) as $chunk){
            DB::table('categories')->insert($chunk);
        }
    }
}
