<?php

namespace Database\Seeders;

ini_set('memory_limit', '2048M');

use App\Models\Book;
use App\Models\Author;
use App\Models\Rating;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
  public function run()
{
  
    \Illuminate\Support\Facades\DB::disableQueryLog();
    
    
    $this->seedInChunks(Author::class, 1000, 100);

    
    $this->seedInChunks(Category::class, 3000, 200);

 
    $authorIds = Author::pluck('id');
    $categoryIds = Category::pluck('id');
    
    for ($i = 0; $i < 100000; $i += 5000) {
        Book::factory(5000)->create([
            'author_id' => fn() => $authorIds->random(),
            'category_id' => fn() => $categoryIds->random()
        ]);
        $this->command->info("Created ".min($i+5000, 100000)." books");
    }

    // 4. Seed Ratings (500,000 records)
    $bookIds = Book::pluck('id');
    for ($i = 0; $i < 500000; $i += 10000) {
        $ratings = [];
        for ($j = 0; $j < 10000; $j++) {
            $ratings[] = [
                'book_id' => $bookIds->random(),
                'rating' => rand(1, 10),
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        \Illuminate\Support\Facades\DB::table('ratings')->insert($ratings);
        $this->command->info("Created ".min($i+10000, 500000)." ratings");
    }
}

protected function seedInChunks($model, $total, $chunkSize)
{
    for ($i = 0; $i < $total; $i += $chunkSize) {
        $model::factory(min($chunkSize, $total-$i))->create();
        $this->command->info("Created ".min($i+$chunkSize, $total)." {$model} records");
    }
}
}
