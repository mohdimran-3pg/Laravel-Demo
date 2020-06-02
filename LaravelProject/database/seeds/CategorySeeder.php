<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new \App\Category([
            "name" => "ASP.NET"
        ]);
        $category->save();

        $category = new \App\Category([
            "name" => "Laravel"
        ]);
        $category->save();

        $category = new \App\Category([
            "name" => "iOS"
        ]);
        $category->save();

        $category = new \App\Category([
            "name" => "Android"
        ]);
        $category->save();
    }
}
