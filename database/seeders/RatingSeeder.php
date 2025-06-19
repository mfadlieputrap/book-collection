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

        // Generate 500K rating
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

        // Insert ratings in chunks
        foreach (array_chunk($data, 1000) as $chunk) {
            DB::table('ratings')->insert($chunk);
        }

        // Hitung top 10 book_id berdasarkan 5-star ratings
        $topBooks = DB::table('ratings')
            ->where('rating', '>=', 5)
            ->select('book_id', DB::raw('COUNT(*) as vote_count'))
            ->groupBy('book_id')
            ->orderByDesc('vote_count')
            ->limit(10)
            ->get();

        // Ambil semua book dengan author-nya sekali query
        $bookIds = $topBooks->pluck('book_id');
        $books = Book::whereIn('id', $bookIds)->get()->keyBy('id');

        // Siapkan data untuk top_rated_books
        $data = [];
        foreach ($topBooks as $item) {
            $book = $books[$item->book_id] ?? null;
            if (!$book) continue;

            $data[] = [
                'book_id' => $book->id,
                'author_id' => $book->author_id,
                'five_star_count' => $item->vote_count,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('top_rated_books')->insert($data);


    }
}
