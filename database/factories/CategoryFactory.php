<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       // $title =$faker->sentence();
        $title = $this->faker->name();
        return [
           "title"=>$title,
           "slug"=> Str::slug($title),
        ];
    }
}
