<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->createNewCategory();

    }

    private function createNewCategory(): void
    {
        $categories = ['Electronics','Phones','Tablets','Phone Accessories'];

        foreach ($categories as $category) {
            $category = new \App\Category(['name'=>$category]);
            $category->save();
        }
        }
}
