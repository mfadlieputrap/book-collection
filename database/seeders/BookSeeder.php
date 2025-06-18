<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Faker\Factory as Faker;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $authorIds = Author::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();
        $data = [];

        for ($i = 0; $i < 100000; $i++) {
            $data[] = [
                'title' => $faker->sentence(3),
                'author_id' => $faker->randomElement($authorIds),
                'category_id' => $faker->randomElement($categoryIds),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        foreach(array_chunk($data, 1000) as $chunk){
            DB::table('books')->insert($chunk);
        }
    }
}
