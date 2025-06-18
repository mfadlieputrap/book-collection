<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Rating;
use App\Models\Book;
use Faker\Factory as Faker;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $bookIds = Book::pluck('id')->toArray();
        $popularBooks = Book::inRandomOrder()->limit(1000)->pluck('id')->toArray();
        $data = [];

        for ($i = 0; $i < 500000; $i++) {
            $bookId = $faker->randomElement(
                rand(0,100) < 70 ? $popularBooks : $bookIds
            );

            $data[] = [
                'book_id' => $bookId,
                'rating' => $faker->numberBetween(1, 10),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        foreach(array_chunk($data, 1000) as $chunk){
            DB::table('ratings')->insert($chunk);
        }
    }
}
