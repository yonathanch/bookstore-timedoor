<?php
//category tidak bisa memakai unik karna jumlah sangat banyak
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    private static $counter = 1;

    public function definition(): array
    {
        return [
            'name' => 'Category ' . self::$counter++,
        ];
    }
}
