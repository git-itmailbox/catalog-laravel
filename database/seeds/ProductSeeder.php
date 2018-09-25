<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
        // создаем фейкер(который будет генерить данные) с укр регионом, чтобы имена и телефоны были укр формата
        $this->faker = Faker::create('uk_UA');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = \App\Category::all(['id'])->pluck('id')->toArray();

        $quantity = 20;
        $products = [];

        for($i=0; $i<$quantity; $i++)
        {
            $products[] = [
                'name' => $this->faker->word,
                'description' => $this->faker->sentence,
                'price' => $this->faker->numberBetween(100,999999),
            ];
        }
        \App\Product::insert($products);

    }
}
